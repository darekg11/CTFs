<?php
    // cheers and <3 to malvina
    // - morla

    // seems like lang param is our only way in somehow
    function setLanguage(){
        /* language setup */
        if(array_key_exists("lang",$_REQUEST))
            if(safeinclude("language/" . $_REQUEST["lang"] ))
                return 1;
        safeinclude("language/en"); 
    }
    
    function safeinclude($filename){
        // check for directory traversal
        // '../' -> banned
        // but this replacing is wrong
        // '../.../...//../.../...//' -> passing this will generate ../../
        // so in the end we can somehow path traverse this
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
            # we need to somehow make it include our own custom file
            include($filename);
            return 1;
        }
        return 0;
    }
    
    // This most probably can't be an attack vector since it's hardcoded
    // but this can be used as debug method to see content of language dir
    // not sure if useful yet
    // not useful
    function listFiles($path){
        $listoffiles=array();
        if ($handle = opendir($path))
            while (false !== ($file = readdir($handle)))
                if ($file != "." && $file != "..")
                    $listoffiles[]=$file;
        
        closedir($handle);
        return $listoffiles;
    } 
    
    // Here is some kind of attach vector but not idea how to use that one yet
    // $SERVER['HTTP_USER_AGENT'] is an header UserAgent from request so we control that
    // we can write PHP script into HTTP_USER_AGENT
    // and then use lang param to include log file
    // since log file will now have PHP script, it will execute it
    function logRequest($message){
        $log="[". date("d.m.Y H::i:s",time()) ."]";
        $log=$log . " " . $_SERVER['HTTP_USER_AGENT'];
        $log=$log . " \"" . $message ."\"\n";
        // we also control the log file with cookie that we can set to whatever we feel like
        $fd=fopen("/var/www/natas/natas25/logs/natas25_" . session_id() .".log","a");
        fwrite($fd,$log);
        fclose($fd);
    }
?>

<h1>natas25</h1>
<div id="content">
<div align="right">
<form>
<select name='lang' onchange='this.form.submit()'>
<option>language</option>
<?php foreach(listFiles("language/") as $f) echo "<option>$f</option>"; ?>
</select>
</form>
</div>

<?php  
    session_start();
    setLanguage();
    
    echo "<h2>$__GREETING</h2>";
    echo "<p align=\"justify\">$__MSG";
    echo "<div align=\"right\"><h6>$__FOOTER</h6><div>";
?>
