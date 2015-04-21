<?php
$address = $_POST["address"];
$port = $_POST["port"];
$save = $_POST["save"];
$fp = fsockopen($address, $port, $errno, $errstr);
$handle = fopen($save, "a+");
$request = $_POST["request"];

fwrite($fp, "$request\n");
$log =  fread($fp, 26);
//$backup .= $log."\n";

fwrite($handle, "$log\r\n");
$log = ($log);

echo $log;

fclose($fp);
fclose($handle);
?>