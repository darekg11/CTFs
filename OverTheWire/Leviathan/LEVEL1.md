# Connection:

ssh leviathan1@leviathan.labs.overthewire.org -p 2223
password: `rioGegei8m`

# Solution:

1. `ls -al`
2. Notice the file: `check`
3. It's an executable
4. Luanch it via: `./check`
5. It's expecting the password.
6. Run it again this time with `ltrace` to trace the calls to functions with params: `ltrace ./check`
7. Notice the required password
8. Use password
9. You are now logged in as `leviathan2`
10. `cat /etc/leviathan_pass/leviathan2`
11. Get flag
