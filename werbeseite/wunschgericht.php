<!--
- Praktikum DBWT. Autoren:
- Robert, Hormann, 3668591
- Josuel, Arz, 3307282
-->

<?php
// Verbindung zur Datenbank herstellen
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $beschreibung = $_POST['beschreibung'];
    $erstellt_am = date('Y-m-d');
    $ersteller_name = $_POST['ersteller_name'];
    $ersteller_email = $_POST['ersteller_email'];

    // Überprüfen, ob der Ersteller bereits existiert
    $result = mysqli_query($conn, "SELECT id FROM ersteller WHERE email='$ersteller_email'");
    if (mysqli_num_rows($result) > 0) {
        // Wenn der Ersteller existiert, seine ID erhalten
        $row = mysqli_fetch_assoc($result);
        $ersteller_id = $row['id'];
    } else {
        // Wenn der Ersteller nicht existiert, ihn hinzufügen
        $sql = "INSERT INTO ersteller (name, email) VALUES ('$ersteller_name', '$ersteller_email')";
        if (mysqli_query($conn, $sql)) {
            $ersteller_id = mysqli_insert_id($conn);
        } else {
            echo "Fehler beim Hinzufügen des Erstellers: " . mysqli_error($conn);
            exit;
        }
    }

    // SQL-Abfrage zum Einfügen eines neuen Wunschgerichts
    $sql = "INSERT INTO wunschgericht (name, beschreibung, erstellt_am, ersteller_id) 
            VALUES ('$name', '$beschreibung', '$erstellt_am', '$ersteller_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Neues Wunschgericht erfolgreich hinzugefügt!";
    } else {
        echo "Fehler: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Wunschgericht erfassen</title>
</head>
<body>
    <h1>Wunschgericht erfassen</h1>
    <form action="wunschgericht.php" method="post">
        <label for="name">Name des Gerichts:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        <label for="beschreibung">Beschreibung:</label><br>
        <textarea id="beschreibung" name="beschreibung" required></textarea><br><br>
        <label for="ersteller_name">Name des Erstellers:</label><br>
        <input type="text" id="ersteller_name" name="ersteller_name" required><br><br>
        <label for="ersteller_email">E-Mail des Erstellers:</label><br>
        <input type="email" id="ersteller_email" name="ersteller_email" required><br><br>
        <input type="submit" value="Wunsch abschicken">
    </form>
</body>
</html>
