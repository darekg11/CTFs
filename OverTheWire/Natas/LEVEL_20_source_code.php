<?

function debug($msg) {
    if(array_key_exists("debug", $_GET)) {
        print "DEBUG: $msg<br>";
    }
}

function print_credentials() {
    if($_SESSION and array_key_exists("admin", $_SESSION) and $_SESSION["admin"] == 1) {
        print "You are an admin. The credentials for the next level are:<br>";
        print "<pre>Username: natas21\n";
        print "Password: <censored></pre>";
    } else {
        print "You are logged in as a regular user. Login as an admin to retrieve credentials for natas21.";
    }
}

// always true
function myopen($path, $name) { 
    //debug("MYOPEN $path $name"); 
    return true; 
}

// always true
function myclose() { 
    //debug("MYCLOSE"); 
    return true; 
}

// this will be executed when session starts
function myread($sid) { 
    debug("MYREAD $sid"); 
    //session id must contain only those characters
    if(strspn($sid, "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM-") != strlen($sid)) {
        debug("Invalid SID"); 
        return "";
    }
    //it will create a path to file based on session id
    $filename = session_save_path() . "/" . "mysess_" . $sid;
    if(!file_exists($filename)) {
        debug("Session file doesn't exist");
        return "";
    }
    debug("Reading from ". $filename);
    $data = file_get_contents($filename);
    $_SESSION = array();
    // it will read the file line by line
    foreach(explode("\n", $data) as $line) {
        debug("Read [$line]");
        // split by " "
        // $parts[0] will be frist string
        // $parts[1] will be second or the reamaining string if there are more than 2 delimited strings
        $parts = explode(" ", $line, 2);
        if($parts[0] != "")
            $_SESSION[$parts[0]] = $parts[1];
    }
    return session_encode();
}

function mywrite($sid, $data) { 
    // $data contains the serialized version of $_SESSION
    // but our encoding is better
    debug("MYWRITE $sid $data"); 
    // make sure the sid is alnum only!!
    if(strspn($sid, "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM-") != strlen($sid)) {
        debug("Invalid SID"); 
        return;
    }
    $filename = session_save_path() . "/" . "mysess_" . $sid;
    $data = "";
    debug("Saving in ". $filename);
    ksort($_SESSION);
    // it will write each key value to seperate line
    // so if we were able to inject \nadmin 1 in name payload like so:
    // name=darek\nadmin 1
    // it would get written to file like so:
    // name darek
    // admin 1
    // and it would get automaticaly read when creating session and parsed
    foreach($_SESSION as $key => $value) {
        debug("$key => $value");
        $data .= "$key $value\n";
    }
    file_put_contents($filename, $data);
    chmod($filename, 0600);
}

/* we don't need this */
//always true for now
function mydestroy($sid) {
    //debug("MYDESTROY $sid"); 
    return true; 
}
/* we don't need this */
//always true for now
function mygarbage($t) { 
    //debug("MYGARBAGE $t"); 
    return true; 
}

session_set_save_handler(
    "myopen", //always true for now
    "myclose",  //always true for now
    "myread", // execued when session_start is called after myopen. Populates global $SESSION object
    "mywrite",  // execued when session is closed or when session_write_close is called.
    "mydestroy", 
    "mygarbage");

session_start();

if(array_key_exists("name", $_REQUEST)) {
    $_SESSION["name"] = $_REQUEST["name"];
    debug("Name set to " . $_REQUEST["name"]);
}

print_credentials();

$name = "";
if(array_key_exists("name", $_SESSION)) {
    $name = $_SESSION["name"];
}

?>