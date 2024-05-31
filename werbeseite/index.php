<!--
- Praktikum DBWT. Autoren:
- Robert, Hormann, 3668591
- Josuel, Arz, 3307282
-->
<?php
//include 'besucherzaehler.php';
include 'speisen.php';
include 'newsletter_zaehlen.php';
include 'db_connect.php';

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

$besucher = zaehle_besucher();
$anzahl_gerichte = count($speisen);
$anzahl_anmeldungen = zaehle_anmeldungen();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Werbeseite</title>
    <!--
    <style>
        .speise img {
            width: 150px;
            height: auto;
        }
    </style>
    -->
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
        /*
        echo '<div class="speise">';
        foreach ($speisen as $speise) {
            echo '<p>'.$speise.'</p>'.'<br>';
            echo '<img src="img/'.$speise.'.jpg">';
        }
        echo '</div>';
        */
        ?>
        <?php
        // Query, um die Gerichte aus der Datenbank zu laden und nach Name aufsteigend zu sortieren
        //$query = "SELECT name, preisintern, preisextern FROM gericht ORDER BY name ASC LIMIT 5";

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
        if ($result) {
            // Iteriere über die Ergebnisse und zeige die Informationen auf der Werbeseite an
            echo '<div class="speise">';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<h3>'.$row['name'].'</h3>'.'<br>';
                echo '<p>Preis intern: '.$row['preisintern'].'<br>';
                echo 'Preis intern: '.$row['preisextern'].'<br>';
                echo 'Allergene: '.$row['allergen_codes'].'<br>'.'</p>';}
            echo '</div>';
        } else {
            echo "Fehler beim Abrufen der Daten: ".mysqli_error($link);
        }
        ?>
    </section>

    <section id="zahlen">
        <h2>E-Mensa in Zahlen</h2>
        <ul>
            <li>Anzahl der Gerichte: <span id="gerichte-anzahl"><?php echo $anzahl_gerichte; ?></span></li>
            <li>Anzahl der Besucher: <span id="besucher-anzahl"><?php echo $besucher; ?></span></li>
            <li>Anzahl der Newsletter-Anmeldungen: <span id="anmeldungen-anzahl"><?php echo $anzahl_anmeldungen; ?></span></li>
        </ul>
    </section>

    <section id="allergene">
        <h2>Allergene</h2>
        <?php
        $sql = "SELECT code, name FROM allergen";
        $result = mysqli_query($link, $sql);
        if ($result) {
            echo '<ul>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<li>'.$row['code'].': '.$row['name'].'</li>';
            }
            echo '</ul>';
        } else {
            echo "Fehler beim Abrufen der Daten: " . mysqli_error($link);
        }
        ?>
        </ul>
    </section>
</div>

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
                    <option value="" disabled selected>Deutsch</option>
                    <option value="deutsch">Deutsch</option>
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $datenschutz = isset($_POST['privacy']) ? (int)$_POST['privacy'] : 0;

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Der Name darf nicht leer sein.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Die E-Mail-Adresse ist ungültig.';
        }
        if ($datenschutz !== 1) {
            $errors[] = 'Sie müssen der Datenschutzbestimmung zustimmen.';
        }

        $blacklist = ['rcpt.at', 'damnthespam.at', 'wegwerfmail.de', 'trashmail.com'];
        $domain = substr(strrchr($email, "@"), 1);
        if (in_array($domain, $blacklist)) {
            $errors[] = 'Die E-Mail-Adresse stammt von einem nicht erlaubten Anbieter.';
        }

        if (empty($errors)) {
            $file = 'newsletter.txt';
            $entry = $name . ';' . $email . PHP_EOL;
            if (file_put_contents($file, $entry, FILE_APPEND | LOCK_EX) !== false) {
                echo '<p class="success">Vielen Dank für Ihre Anmeldung!</p>';
            } else {
                echo '<p class="error">Es gab einen Fehler beim Speichern Ihrer Anmeldung. Bitte versuchen Sie es später erneut.</p>';
            }
        } else {
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