<?php
include 'index.php';

$isReloaded = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

$visitCounter = 0;
if($isReloaded) {
    $visitCounter++;
}

?>
