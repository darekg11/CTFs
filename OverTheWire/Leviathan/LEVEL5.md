# Connection:

ssh leviathan5@leviathan.labs.overthewire.org -p 2223
password: `Tith4cokei`

# Solution:

1. Notice the `leviathan5` executable
2. Execute it
3. It tries to open `/tmp/file.log`
4. Create some dummy `file.log` file in `/tmp`
5. Execute again the `leviathan5` executable
6. It basically reads the file and output it to standard stream, you can run `ltrace` to see such output:

```
fopen("/tmp/file.log", "r")                                               = 0x804b008
fgetc(0x804b008)                                                          = 't'
feof(0x804b008)                                                           = 0
putchar(116, 0x8048720, 0xf7e40890, 0x80486eb)                            = 116
fgetc(0x804b008)                                                          = 'e'
feof(0x804b008)                                                           = 0
putchar(101, 0x8048720, 0xf7e40890, 0x80486eb)                            = 101
fgetc(0x804b008)                                                          = 's'
feof(0x804b008)                                                           = 0
putchar(115, 0x8048720, 0xf7e40890, 0x80486eb)                            = 115
fgetc(0x804b008)                                                          = 't'
feof(0x804b008)                                                           = 0
putchar(116, 0x8048720, 0xf7e40890, 0x80486eb)                            = 116
fgetc(0x804b008)                                                          = 't'
feof(0x804b008)                                                           = 0
putchar(116, 0x8048720, 0xf7e40890, 0x80486eb)                            = 116
fgetc(0x804b008)                                                          = 'e'
feof(0x804b008)                                                           = 0
putchar(101, 0x8048720, 0xf7e40890, 0x80486eb)                            = 101
fgetc(0x804b008)                                                          = 's'
feof(0x804b008)                                                           = 0
putchar(115, 0x8048720, 0xf7e40890, 0x80486eb)                            = 115
fgetc(0x804b008)                                                          = 't'
feof(0x804b008)                                                           = 0
putchar(116, 0x8048720, 0xf7e40890, 0x80486eb)                            = 116
fgetc(0x804b008)                                                          = '\n'
feof(0x804b008)                                                           = 0
putchar(10, 0x8048720, 0xf7e40890, 0x80486ebtesttest
)                             = 10
fgetc(0x804b008)                                                          = '\377'
feof(0x804b008)                                                           = 1
fclose(0x804b008)                                                         = 0
getuid()                                                                  = 12005
setuid(12005)                                                             = 0
unlink("/tmp/file.log")
```

It reads one character at the time, check if we hit the EOF and write it to standard out.

7. Let's just create symlink to /etc/leviathan_pass/leviathan6: `ln -s /etc/leviathan_pass/leviathan6 file.log`
8. Execute `./leviathan5`
9. Get flag
