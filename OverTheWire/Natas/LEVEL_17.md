# URL: http://natas17.natas.labs.overthewire.org/

# Solution:

It is the same as `NATAS_15` but this time there is no output to let us know if user exists or not.
If we can't rely on that, then we can rely on response time from server by injecting `SLEEP` SQL function in our SQL Injection. If response time will be shorter than value passed to sleep that means our SQL Injection did not found anything but if response time will be equal or greater than value passed to `SLEEP` that means we are onto something.

`natas18" and password LIKE BINARY '%w%' and sleep(5) #"` -> takes more than 5 seconds so this must be a part of password  
`natas18" and password LIKE BINARY '%1%' and sleep(5) #"` -> takes less than 5 seconds so this can't be a part of password
