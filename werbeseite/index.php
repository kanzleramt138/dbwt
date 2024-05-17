<!--
- Praktikum DBWT. Autoren:
- Robert, Hormann, 3668591
- Josuel, Arz, 3307282
-->
<?php
include 'reload.php';
?>

<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="index.css" />
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
        <ul>
          <li>Spätzle mit Soß</li>
          <li>SchniPoSa</li>
        </ul>
      </section>

      <section id="zahlen">
        <h2>E-Mensa in Zahlen</h2>
        <ul>
          <li>Anzahl der Gerichte: <span id="gerichte-anzahl">XX</span></li>
          <li>Anzahl der Besucher: <span id="besucher-anzahl"><?php echo $visitCounter ?></span></li>
        </ul>
      </section>
    </div>
    <section id="kontakt">
      <h2>Interesse geweckt? Wir informieren Sie!</h2>
      <form id="newsletterForm">
        <div class="form-row">
            <div class="form-group">
                <label for="name">Ihr Name</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Ihre E-Mail</label>
                <input type="email" id="email" name="email" required>
                <label for="language">Newsletter bitte in:</label>
                <select id="language" name="language" required>
                    <option value="" disabled selected>Sprache auswählen</option>
                    <option value="deutsch">Deutsch</option>
                    <option value="englisch">Englisch</option>
                </select>
            </div>
        
                
            </div>
            <div class="form-group">
              
                <input type="checkbox" id="privacy" name="privacy" required>
                <label for="privacy">Den Datenschutzbestimmungen stimme ich zu</label>
                <button type="submit">Anmelden</button>
            </div>
        </div>
       
    </form>
      <button id="newsletter-anmelden" disabled>Zum Newsletter anmelden</button>
    </section>

  

    <section id="wichtig">
      <h2>Das ist uns wichtig</h2>
      <p>Dass alle unsere Gäste satt und glücklich sind!</p>
    </section>

    <footer>
      <p>Impressum</p>
    </footer>
  </body>
</html>