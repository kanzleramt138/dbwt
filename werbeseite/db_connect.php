<?php

$link = mysqli_connect(
    "localhost",            // Host der Datenbank
    "root",                 // Benutzername zur Anmeldung
    "dbwt@emensa2024",      // Passwort
    "emensawerbeseite"      // Auswahl der Datenbanken (bzw. des Schemas)
                            // optional Port der Datenbank
);

if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}

?>