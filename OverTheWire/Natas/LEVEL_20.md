# URL: http://natas20.natas.labs.overthewire.org/

# Solution:

This is some PHP application with custom session management.  
`LEVEL_20_source_code.php` contains cleaned up, reformatted source code of challenge with some comments.  
There are two things that we can control:

1. SESSION_ID by changing Cookie Value
2. `POST` param: `name`

`SESSION_ID` is being checked if this only contains allowed characters by:  
`strspn($sid, "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM-") != strlen($sid))`  
Above line checks if every character that is part of `$sid` is a part of allowed subset of characters  
But there is no checking on `name` param that is being send to server so we can temper with that one.

On top of that PHP script is including custom session handlers mainly for `write` and `read` via:  
`session_set_save_handler` [docs](http://php.net/manual/en/function.session-set-save-handler.php)  
The most intresting pieces are:  
`myread` -> `execued when session_start is called after myopen. Populates global $SESSION object`  
`mywrite` -> `execued when session is closed or when session_write_close is called.`

What is custom `myread` function is actually doing:

1. First it will validate if `SESSION_ID` is correct
2. Then it will try to open file containing session data at: `/mysess_` + `SESSION_ID`
3. Then if file exists, it will read the content of the file
4. Nextly, it will go line by line and parse each line
5. Parsing is based on spliting read line by `" "` so by spaces
6. The first splited string will be used as `key` in `SESSION` object, the second string will be used as `value` in `SESSION` object.
   So we would need to generate such file:

```
name darek_hacks
admin 1
```

In order to make us admins

What is custom `mywrite` function is actually doing:

1. First it will validate if `SESSION_ID` is correct
2. Then it will create a path to session file at: `/mysess_` + `SESSION_ID`
3. Then for every `key` in `SESSION` object, it will write key + value in single line with end line character:

```
foreach($_SESSION as $key => $value) {
    debug("$key => $value");
    $data .= "$key $value\n";
}
```

So we need to somehow make it write name passed in `name` post param and additonaly some extra payload like: `\n admin1 1` because during session creation happening in `myread` it will read line by line and place our injected `admin 1` value in `SESSION` object.

## Following is FireFox solution because it was the quickest for me

**It might be different for Chrome or cURL due to encoding**

1. Open challenge page
2. Use following URL: `http://natas20.natas.labs.overthewire.org/index.php?debug&name=darek11%0Aadmin%201`
3. `darek11%0Aadmin%201` is encoded version of `darek11\nadmin 1` `n` === `%0A` and `` === `%20`
4. Your session has now been created
5. Now just do regular `GET` request to puzzle: `http://natas20.natas.labs.overthewire.org/index.php`
6. Profit

`Natas 21 password: IFekPyrQXftziDEsUr3x21sYuahypdgJ`
