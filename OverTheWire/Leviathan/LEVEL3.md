# Connection:

ssh leviathan3@leviathan.labs.overthewire.org -p 2223
password: `Ahdiemoo1j`

vuH0coox6m

# Solution:

1. Run `./level3` executable
2. Enter any password
3. Does not match
4. Run it again with `ltrace ./level3`
5. Enter any password
6. Notice output:

```
__libc_start_main(0x8048618, 1, 0xffffd774, 0x80486d0 <unfinished ...>
strcmp("h0no33", "kakaka")                                                = -1
printf("Enter the password> ")                                            = 20
fgets(Enter the password> test
"test\n", 256, 0xf7fc55a0)                                          = 0xffffd580
strcmp("test\n", "snlprintf\n")                                           = 1
puts("bzzzzzzzzap. WRONG"bzzzzzzzzap. WRONG
)                                                = 19
+++ exited (status 0) +++
```

7. So it is being compared to `snlprintf`
8. Enter `snlprintf` as password
9. You got shell
10. Get flag
