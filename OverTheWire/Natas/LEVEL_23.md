# URL: http://natas23.natas.labs.overthewire.org/

# Solution:

Following code is execute to decide if flag can be obtained:
`if(strstr($_REQUEST["passwd"],"iloveyou") && ($_REQUEST["passwd"] > 10 )){`

`strstr` returns the string starting at second param in first param and the rest, so for example:  
`strstr('ctfsome1234', 'some') would return 'some1234'`  
So first of all we need to have `iloveyou` substring in our `passwd` form param.  
Now the second condition supposely was put to check length but it is wrong + we can explot PHP type system.  
If you put: `11iloveyou` in box and send it you will get the flag because `11` is greater than `10` and because `iloveyou` is part of payload

`Natas 24 password: OsRmXFguozKpTZZ5X14zNO43379LZveg`
