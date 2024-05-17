<?php
$gerichte = [];

if (($handle = fopen('gerichte.csv', 'r')) !== false) {
    // Überspringen der Kopfzeile
    fgetcsv($handle, 1000, ',');

    // Lesen der restlichen Zeilen
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        $gerichte[] = [
            'name' => $data[0],
            'description' => $data[1],
            'price_intern' => (float)$data[2],
            'price_extern' => (float)$data[3],
            'image' => $data[4]
        ];
    }
    fclose($handle);
}
?>