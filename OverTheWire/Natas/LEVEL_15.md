# URL: http://natas15.natas.labs.overthewire.org/

# Solution:

It's another SQL Injection but this time we need to provide username and guess password as this is not a part of original `SQL Statement`.  
So in order to solve this, we need to actually brute force the password for user `natas16`
It's called `Blind SQL` injection.
How can you test if this really works?

`natas16" and password LIKE BINARY '%1%'"` -> returns that user does not exist  
`natas16" and password LIKE BINARY '%w%'"` -> returns that user does exist  
`BINARY` -> we need to have case sensitive string search  
Additionaly, we know that `password` column is 64 characters long.  
We can make it even less complex by first quering all possible characters that might be part of password by using `LIKE %character%`

Let's write some Python Code that will:

1. Build dictionary of possible used characters (including digits)
2. Use that dictionary to query natas challenge until we get the password
