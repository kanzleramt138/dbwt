<?php
function zaehle_anmeldungen() {
    $datei = 'newsletter.txt';
    if (!file_exists($datei)) {
        return 0;
    }
    $anmeldungen = file($datei, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return count($anmeldungen);
}
?>