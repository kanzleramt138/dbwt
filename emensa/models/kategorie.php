<?php
/**
 * Diese Datei enthält alle SQL Statements für die Tabelle "kategorie"
 */
function db_kategorie_select_all() {
    $link = connectdb();

    $sql = "SELECT * FROM kategorie";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        die('Invalid query: ' . mysqli_error($link));
    }

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($link);

    // Debug-Ausgabe der Daten
    error_log(print_r($data, true));

    return $data;
}
