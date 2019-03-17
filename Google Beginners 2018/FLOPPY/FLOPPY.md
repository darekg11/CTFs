https://capturetheflag.withgoogle.com/#beginners/misc-floppy

# Solution

Downloaded file looks like regular `.ico` file. After investigation of file under `HexViewer`, you can see that there is more content in that `.ICO` file.  
Something like: `www.com` and `driver.txt`. You can either manually extract HEX into files or just use tool like `binwalk`:  
`binwalk -e foo.ico`, extracted content contains `driver.txt` file which has a falg.  
Flag: `CTF{qeY80sU6Ktko8BJW}`