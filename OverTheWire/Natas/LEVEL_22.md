# URL: http://natas22.natas.labs.overthewire.org/

# Solution:

So in order to get a flag you must pass `revelio` as `GET` param but before even `HTML` part of website, there is a check if `revelio` is set and if so we are checking if `SESSION` contains `admin` flag which it obviosuly don't and if no flag is present, PHP sets `Location` Header to redirect browser back to main website without executing the rest of code.  
And below, there is actual logic to show credentials if we manage to stop redirects.
Just use some tool / script that does not follow redirects, for example: `curl`:  
`curl --user natas22:chG9fbe1Tq2eWVMgjYYD1MsfIvN461kJ http://natas22.natas.labs.overthewire.org\?revelio`

`Natas 23 password: D0vlad33nQF0Hz2EP255TP5wSW9ZsRSE`
