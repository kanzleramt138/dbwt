<!--
- Praktikum DBWT. Autoren:
- Robert, Hormann, 3668591
- Josuel, Arz, 3307282
-->

<?php

$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "werbeseiteemensa";



// Verbindung aufbauen
$link = mysqli_connect($servername, $username, $password, $dbname);

// Verbindung überprüfen
if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}

// SQL-Abfrage
$sql = "SELECT * FROM gericht";

// Abfrage ausführen
$result = mysqli_query($link, $sql);

// Überprüfen, ob die Abfrage erfolgreich war
if (!$result) {
    echo "Fehler während der Abfrage: ", mysqli_error($link);
    exit();
}

// Ergebnisse in einer HTML-Tabelle ausgeben
echo "<table border='1'>
<tr>
<th>ID</th>
<th>Name</th>
<th>Beschreibung</th>
<th>Erfasst Am</th>
<th>Vegetarisch</th>
<th>Vegan</th>
<th>Preis Intern</th>
<th>Preis Extern</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['beschreibung'] . "</td>";
    echo "<td>" . $row['erfasst_am'] . "</td>";
    echo "<td>" . ($row['vegetarisch'] ? 'Ja' : 'Nein') . "</td>";
    echo "<td>" . ($row['vegan'] ? 'Ja' : 'Nein') . "</td>";
    echo "<td>" . $row['preisintern'] . "</td>";
    echo "<td>" . $row['preisextern'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Ergebnis freigeben
mysqli_free_result($result);

// Verbindung abbauen
mysqli_close($link);
?>