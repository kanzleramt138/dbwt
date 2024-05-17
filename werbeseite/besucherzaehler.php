<?php
function zaehle_besucher() {
    $datei = 'besucherzaehler.txt';
    if (!file_exists($datei)) {
        file_put_contents($datei, '0');
    }
    $zaehler = (int)file_get_contents($datei);
    $zaehler++;
    file_put_contents($datei, (string)$zaehler);
    return $zaehler;
}
?>