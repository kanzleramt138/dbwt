<?php
/**
 * Diese Datei enthält alle SQL Statements für die Tabelle "gerichte"
 */
function db_gericht_select_all() {
    try {
        $link = connectdb();

        $sql = 'SELECT id, name, beschreibung, preisintern, preisextern, bildname FROM gericht ORDER BY name';
        $result = mysqli_query($link, $sql);

        $data = mysqli_fetch_all($result, MYSQLI_BOTH);

        mysqli_close($link);
    }
    catch (Exception $ex) {
        $data = array(
            'id'=>'-1',
            'error'=>true,
            'name' => 'Datenbankfehler '.$ex->getCode(),
            'beschreibung' => $ex->getMessage());
    }
    finally {
        return $data;
    }

}

function db_gerichte_select_above_price($price) {
    $link = connectdb();

    // Anpassung der SQL-Abfrage an den tatsächlichen Spaltennamen
    $sql = "SELECT name, preisintern AS preis FROM gericht WHERE preisintern > ? ORDER BY name DESC";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'd', $price);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die('Invalid query: ' . mysqli_error($link));
    }

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($link);

    // Debug-Ausgabe der Daten
    error_log(print_r($data, true));

    return $data;
}