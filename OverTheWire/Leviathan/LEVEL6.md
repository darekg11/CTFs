# Connection:

ssh leviathan6@leviathan.labs.overthewire.org -p 2223
password: `UgaoFee4li`

# Solution:

1. Notice the `leviathan6` executable
2. Execute it
3. It wants 4 digits code
4. Enter anything
5. Wrong

## Solution I - brute forcing

If this is just 4 digits, we can write quick bash script that will try everything from `0000` to `9999` and see what happens. Create new directory in `/tmp`, create a new `.sh` file:

```
#!/bin/bash
for i in {0000..9999}
do
    cd ~
    echo $i
    ./leviathan6 $i
done
```

Make sure to set it chmod to exeute with `chmod +x`. Launch it, after some time it will stop at `7123` with shell access. Just cat the `/etc/leviathan_pass/leviathan7`

## Solution II - quick reverse engineering

Well, the executable must at some point compare the entered value with some hardcoded value.  
Execute `objdump -d leviathan6`  
Find `.main` section:

```
0804853b <main>:
 804853b:	8d 4c 24 04          	lea    0x4(%esp),%ecx
 804853f:	83 e4 f0             	and    $0xfffffff0,%esp
 8048542:	ff 71 fc             	pushl  -0x4(%ecx)
 8048545:	55                   	push   %ebp
 8048546:	89 e5                	mov    %esp,%ebp
 8048548:	53                   	push   %ebx
 8048549:	51                   	push   %ecx
 804854a:	83 ec 10             	sub    $0x10,%esp
 804854d:	89 c8                	mov    %ecx,%eax
 804854f:	c7 45 f4 d3 1b 00 00 	movl   $0x1bd3,-0xc(%ebp)
 8048556:	83 38 02             	cmpl   $0x2,(%eax)
 8048559:	74 20                	je     804857b <main+0x40>
 804855b:	8b 40 04             	mov    0x4(%eax),%eax
 804855e:	8b 00                	mov    (%eax),%eax
 8048560:	83 ec 08             	sub    $0x8,%esp
 8048563:	50                   	push   %eax
 8048564:	68 60 86 04 08       	push   $0x8048660
 8048569:	e8 42 fe ff ff       	call   80483b0 <printf@plt>
 804856e:	83 c4 10             	add    $0x10,%esp
 8048571:	83 ec 0c             	sub    $0xc,%esp
 8048574:	6a ff                	push   $0xffffffff
 8048576:	e8 75 fe ff ff       	call   80483f0 <exit@plt>
 804857b:	8b 40 04             	mov    0x4(%eax),%eax
 804857e:	83 c0 04             	add    $0x4,%eax
 8048581:	8b 00                	mov    (%eax),%eax
 8048583:	83 ec 0c             	sub    $0xc,%esp
 8048586:	50                   	push   %eax
 8048587:	e8 94 fe ff ff       	call   8048420 <atoi@plt>
 804858c:	83 c4 10             	add    $0x10,%esp

 NOTICE THIS CMP CALL that compares %eax which is value returned by atoi with -0xc(%ebp)
 Above you can find such call:
 804854f:	c7 45 f4 d3 1b 00 00 	movl   $0x1bd3,-0xc(%ebp)
 So the value stored in `-0xc(%ebp) is 0x1bd3 which is 7123 in dec

 804858f:	3b 45 f4             	cmp    -0xc(%ebp),%eax


 8048592:	75 2b                	jne    80485bf <main+0x84>
 8048594:	e8 27 fe ff ff       	call   80483c0 <geteuid@plt>
 8048599:	89 c3                	mov    %eax,%ebx
 804859b:	e8 20 fe ff ff       	call   80483c0 <geteuid@plt>
 80485a0:	83 ec 08             	sub    $0x8,%esp
 80485a3:	53                   	push   %ebx
 80485a4:	50                   	push   %eax
 80485a5:	e8 56 fe ff ff       	call   8048400 <setreuid@plt>
 80485aa:	83 c4 10             	add    $0x10,%esp
 80485ad:	83 ec 0c             	sub    $0xc,%esp
 80485b0:	68 7a 86 04 08       	push   $0x804867a
 80485b5:	e8 26 fe ff ff       	call   80483e0 <system@plt>
 80485ba:	83 c4 10             	add    $0x10,%esp
 80485bd:	eb 10                	jmp    80485cf <main+0x94>
 80485bf:	83 ec 0c             	sub    $0xc,%esp
 80485c2:	68 82 86 04 08       	push   $0x8048682
 80485c7:	e8 04 fe ff ff       	call   80483d0 <puts@plt>
 80485cc:	83 c4 10             	add    $0x10,%esp
 80485cf:	b8 00 00 00 00       	mov    $0x0,%eax
 80485d4:	8d 65 f8             	lea    -0x8(%ebp),%esp
 80485d7:	59                   	pop    %ecx
 80485d8:	5b                   	pop    %ebx
 80485d9:	5d                   	pop    %ebp
 80485da:	8d 61 fc             	lea    -0x4(%ecx),%esp
 80485dd:	c3                   	ret
 80485de:	66 90                	xchg   %ax,%ax
```
