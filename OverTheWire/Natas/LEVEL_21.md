# URL: http://natas21.natas.labs.overthewire.org/

# Solution:

Okay so the main website is colocated with:  
http://natas21-experimenter.natas.labs.overthewire.org/  
We can only guess that since it's colocated, it will also share the session across so we can hack http://natas21-experimenter.natas.labs.overthewire.org/ in order to get admin on main challenge website.

The most important part of source code is:

```
// if update was submitted, store it
if(array_key_exists("submit", $_REQUEST)) {
    foreach($_REQUEST as $key => $val) {
        $_SESSION[$key] = $val;
    }
}
```

We just need to pass additional query params in GET request like so:  
`http://natas21-experimenter.natas.labs.overthewire.org/index.php?submit&debug=1&admin=1`  
then our session contains `admin` variable set to 1 and we can copy our `PHPSESSID` from cookie in `natas21-experimenter` to regular `natas21` website Cookie and just execute GET to get the password

`Natas 22 password: chG9fbe1Tq2eWVMgjYYD1MsfIvN461kJ`
