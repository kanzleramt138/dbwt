<!--
- Praktikum DBWT. Autoren:
- Robert, Hormann, 3668591
- Josuel, Arz, 3307282
-->

<?php
include 'db_connect.php';
include 'newsletter_zaehlen.php';
$anzahl_anmeldungen = zaehle_anmeldungen();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Werbeseite</title>
</head>
<body>
<header>
    <nav id="navigation">
        <ul>
            <li><a href="#ankündigungen">Ankündigungen</a></li>
            <li><a href="#speisen">Speisen</a></li>
            <li><a href="#zahlen">Zahlen</a></li>
            <li><a href="#kontakt">Kontakt</a></li>
            <li><a href="#wichtig">Wichtig für uns</a></li>
        </ul>
    </nav>
</header>

<section id="ankündigungen">
    <h1>Willkommen bei der E-Mensa</h1>
    <p>Hier steht ein Text über die E-Mensa...</p>
</section>
<div class="box">
    <section id="speisen">
        <h2>Unsere Speisen</h2>
        <?php
        // Query, um die Gerichte aus der Datenbank zu laden und nach Name aufsteigend zu sortieren
        $sql = "SELECT
            gericht.name, 
            gericht.preisintern, 
            gericht.preisextern, 
            GROUP_CONCAT(allergen.code) AS allergen_codes
        FROM 
            gericht
        LEFT JOIN 
            gericht_hat_allergen ON gericht.id = gericht_hat_allergen.gericht_id
        LEFT JOIN 
            allergen ON gericht_hat_allergen.code = allergen.code
        GROUP BY 
            gericht.id
        ORDER BY 
            gericht.name 
            ASC LIMIT 5;
        ";
    
        $result = mysqli_query($link, $sql); // Führe die Abfrage aus

        // Überprüfe, ob die Abfrage erfolgreich war
        if (!$result) {
            echo "Fehler während der Abfrage: ", mysqli_error($link);
            exit();
            }
        // Zeige die Gerichte in einer Liste an
        echo '<div class="speise">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<h3>'.$row['name'].'</h3>'.'<br>';
            echo '<p>Preis intern: '.$row['preisintern'].'<br>';
            echo 'Preis intern: '.$row['preisextern'].'<br>';
            echo 'Allergene: '.$row['allergen_codes'].'<br>'.'</p>';
        }
        echo '</div>';

        $anzahl_gerichte = mysqli_num_rows($result); // Speichere die Anzahl der Gerichte
        mysqli_free_result($result);
        ?>
    </section>
    
    <?php
    // Besucherzähler
    // Überprüfen, ob das Cookie gesetzt ist
    if (!isset($_COOKIE['besucher'])) {
        // Inkrementiere die Besucherzahl
        $sql = "UPDATE besucher SET count = count + 1 WHERE id = 1";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo "Fehler während der Abfrage: " . mysqli_error($link);
            exit();
        }
        // Setze das Cookie für 24 Stunden
        setcookie('besucher', 'true', time() + 86400);
    }

    // Lade die aktuelle Besucherzahl aus der Datenbank
    $sql = "SELECT count FROM besucher WHERE id = 1";
    $result2 = mysqli_query($link, $sql);
    if (!$result2) {
        echo "Fehler während der Abfrage: " . mysqli_error($link);
        exit();
    }
    
    $row = mysqli_fetch_assoc($result2);
    if ($row) {
        $current_visitor_count = $row['count']; // Speichere die aktuelle Besucherzahl
    } else {
        $current_visitor_count = 0; // Standardwert, falls kein Eintrag gefunden wird
    }
    mysqli_free_result($result2);
    ?>

    <section id="zahlen">
        <h2>E-Mensa in Zahlen</h2>
        <ul>
            <li>Anzahl der Gerichte: <span id="gerichte-anzahl"><?php echo $anzahl_gerichte; ?></span></li>
            <li>Anzahl der Besucher: <span id="besucher-anzahl"><?php echo $current_visitor_count; ?></span></li>
            <li>Anzahl der Newsletter-Anmeldungen: <span id="anmeldungen-anzahl"><?php echo $anzahl_anmeldungen; ?></span></li>
        </ul>
    </section>

    <section id="allergene">
        <h2>Allergene</h2>
        <?php
        // Query, um die Allergene aus der Datenbank zu laden
        $sql = "SELECT code, name FROM allergen";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo "Fehler während der Abfrage: ", mysqli_error($link);
            exit();
            }
        // Zeige die Allergene in einer Liste an
        echo '<ul>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li>'.$row['code'].': '.$row['name'].'</li>';
        }
        echo '</ul>';
        mysqli_free_result($result);
        ?>
        </ul>
    </section>
</div>

<section id="wunschgericht">
    <h2>Wunschgericht einreichen</h2>
    <p><a href="wunschgericht.php">Wunschgericht erfassen</a></p>
</section>

<section id="kontakt">
    <h2>Interesse geweckt? Wir informieren Sie!</h2>
    <form id="newsletterForm" method="post" action="index.php">
        <div class="form-row">
            <div class="form-group">
                <label for="name">Ihr Name</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Ihre E-Mail</label>
                <input type="email" id="email" name="email" required>
                <label for="language">Newsletter bitte in:</label>
                <select id="language" name="language" required>
                    <option value="deutsch" selected>Deutsch</option>
                    <option value="englisch">Englisch</option>
                </select>
            </div>
            <div class="form-group">
                <input type="checkbox" id="privacy" name="privacy" required>
                <label for="privacy">Den Datenschutzbestimmungen stimme ich zu</label>
                <button type="submit">Anmelden</button>
            </div>
        </div>
    </form>

    <?php
    // Überprüfe, ob das Formular abgeschickt wurde
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        // Überprüfe, ob die Datenschutzbestimmung akzeptiert wurde
        $datenschutz = isset($_POST['privacy']) ? $_POST['privacy']: '';

        $errors = [];
        
        // Überprüfe, ob der Name leer ist
        if (empty($name)) {
            $errors[] = 'Der Name darf nicht leer sein.';
        }
        // Überprüfe, ob die E-Mail-Adresse gültig ist
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Die E-Mail-Adresse ist ungültig.';
        }
        // Überprüfe, ob die Datenschutzbestimmung akzeptiert wurde
        if ($datenschutz !== 'on') {
            $errors[] = 'Sie müssen der Datenschutzbestimmung zustimmen.';
        }

        // Überprüfe, ob die E-Mail-Adresse von einem nicht erlaubten Anbieter stammt
        $blacklist = ['rcpt.at', 'damnthespam.at', 'wegwerfmail.de', 'trashmail.com'];
        $domain = substr(strrchr($email, "@"), 1);
        if (in_array($domain, $blacklist)) {
            $errors[] = 'Die E-Mail-Adresse stammt von einem nicht erlaubten Anbieter.';
        }

        if (empty($errors)) {               // Überprüfe, ob es Fehler gibt
            $file = 'newsletter.txt';       // Speichere die Anmeldung in einer Textdatei
            $entry = $name . ';' . $email;
            $anmeldungen = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            $bereitsAngemeldet = false;     // Überprüfe, ob der Benutzer bereits angemeldet ist
            foreach ($anmeldungen as $anmeldung) {
                if ($anmeldung === $entry) {
                    $bereitsAngemeldet = true;
                    break;      
                }
            }

            if ($bereitsAngemeldet) {           
                echo '<p class="error">Sie sind bereits angemeldet.</p>';
            } else {
                $entry .= PHP_EOL;
                // Speichere die Anmeldung in der Textdatei
                if (file_put_contents($file, $entry, FILE_APPEND | LOCK_EX) !== false) {
                    echo '<p class="success">Vielen Dank für Ihre Anmeldung!</p>';
                } else {
                    echo '<p class="error">Es gab einen Fehler beim Speichern Ihrer Anmeldung. Bitte versuchen Sie es später erneut.</p>';
                }
            }
        } else {
            // Zeige die Fehlermeldungen an
            foreach ($errors as $error) {       
                echo '<p class="error">' . htmlspecialchars($error) . '</p>';
            }
        }
    }
    ?>
</section>

<section id="wichtig">
    <h2>Das ist uns wichtig</h2>
    <p>Dass alle unsere Gäste satt und glücklich sind!</p>
</section>

<footer>
    <p>Impressum</p>
</footer>

<?php // Verbindung zur Datenbank schließen
mysqli_close($link);
?>

</body>
</html>