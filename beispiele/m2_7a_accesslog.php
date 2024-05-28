<!--
- Praktikum DBWT. Autoren:
- Robert, Hormann, 3668591
- Josuel, Arz, 3307282
-->
<?php
//date_default_timezone_set('Europe/Berlin');
$logFile = "acceslog.txt";
if (!file_exists($logFile)) {
    file_put_contents($logFile, '');
}

$ip = $_SERVER['REMOTE_ADDR'];
$dateTime = date('Y-m-d H:i:s');
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$logData = "$dateTime - IP: $ip - Browser: $userAgent".PHP_EOL;

file_put_contents($logFile, $logData, FILE_APPEND);
echo "Zugriffsprotokoll erfolgreich aktualisiert.";
?>