# Connection:

ssh leviathan4@leviathan.labs.overthewire.org -p 2223
password: `vuH0coox6m`

# Solution:

1. `ls` -> prints nothing
2. Try `ls -al`
3. Notice `.trash` directory
4. `cd .trash`
5. `ls -al`
6. Notice `bin` executable
7. Execute it
8. Prints out some binary strings
9. Execute it with `ltrace`, it reads from leviathan5 passwors file
10. Those binary strings are bainary representation of password
11. Copy and paste it to `https://cryptii.com/pipes/binary-to-text`
12. Get flag
