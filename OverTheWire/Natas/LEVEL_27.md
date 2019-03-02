# URL: http://natas27.natas.labs.overthewire.org/

# Solution:

Thanks to `semchapeu` from `OverTheWire` IRC Channel for hints and patience : )  
So we need to get the flag by loggining as `natas28` user.  
Code is actually using `mysql_real_escape_string` for sanitizing the inputs so it might be really hard to do some SQL Injection so let's figure out other way around.

The created table looks like this:

```
CREATE TABLE `users` (
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL
);
```

So we see that there is no Primary Key, Unique Contrain on username and used type for columns is `varchar`.  
And how the website works:

1. If user exists:
   1. Check if username and password match, if so use `dumpData` is used -> important
2. If user does not exists, create that user

Let's break the code, piece by piece:

```
function validUser($link,$usr){

    $user=mysql_real_escape_string($usr);

    $query = "SELECT * from users where username='$user'";
    $res = mysql_query($query, $link);
    if($res) {
        if(mysql_num_rows($res) > 0) {
            return True;
        }
    }
    return False;
}
```

So pretty simple, it will return true if there is an user with provided `username`

```
function checkCredentials($link,$usr,$pass){

    // adds '\' to following characters:
    // \x00, \n, \r, \, ', " and \x1a.
    $user=mysql_real_escape_string($usr);
    $password=mysql_real_escape_string($pass);

    $query = "SELECT username from users where username='$user' and password='$password' ";
    $res = mysql_query($query, $link);
    if(mysql_num_rows($res) > 0){
        return True;
    }
    return False;
}
```

Also pretty simple, it will return True when username and password (both) are correct.

```
function dumpData($link,$usr){

    $user=mysql_real_escape_string($usr);

    $query = "SELECT * from users where username='$user'";
    $res = mysql_query($query, $link);
    if($res) {
        if(mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                // thanks to Gobo for reporting this bug!
                //return print_r($row);
                return print_r($row,true);
            }
        }
    }
    return False;
}
```

This dumps username + password to UI, what is really intresting here is that we use `while` loop used to query through more than 1 result which is kinda strange, because UI does not let you create account with the same name (or does it? :D)

So since there is no `UNIQUE` constrain on `username` column then we need to somehow make UI accept `natas28` as username to create another account with that name because then:  
`$query = "SELECT * from users where username='$user'";` will return also the original `natas28` credentials.  
But how since using `natas28` will try to login instead of creating account?

The most important part is that `VARCHAR` type omits spaces during comparision so if you have:  
`&nbsp;` -> whitespace  
`natas28` and `natas28&nbsp;&nbsp;&nbsp;&nbsp;` it will be equal to each other.

So we need to pass something like:  
`natas28` + 60 spaces with something at the end like: `x`  
Why 60 spaces and why something at the end?  
Because since spaces are not being compared in `VARCHAR` then passing just `natas28` + 60 spaces would make `validUser` to return `TRUE` instead of `FALSE`.

So this is how it is going to work in the end:

1. Pass `natas28` + 60 spaces + `p` and nothing as a password.
2. This will create new user but because `maxlength` is set to 64 then remaining `p` will be trimmed to only `natas28` and spaces.
3. At this point there are mulitple `natas28` users so `dumpData` loop can be used.
4. Now login again passing `natas28` as username and nothing as `password` and it will spit out the password for `natas28`

`Natas 28 password: JWwR438wkgTsNKBbcJoowyysdM82YjeF`
