<!doctype html>
<html class="no-js" lang="DE">
<head>
    <meta charset="utf-8">
    <title>E-Mensa Routing Script</title>
    <meta name="description" content="unused">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/index.css">
    @yield("cssextra")
    <meta name="theme-color" content="#dadada">
    <!-- good developers check the markup ;) -->
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
                @if (isset($_SESSION["email"]))
                    <li><p>Angemeldet als {{$user}}</p></li>
                    <li><a href="/abmeldung">Abmelden</a></li>
                @else
                    <li><a href="/anmeldung">Anmelden</a></li>
                @endif
            </ul>
        </nav>
    </header>
<div class="container">
    <div class="row">
        @yield("content")
    </div>
</div>
<footer>
    <p>(c) E-Mensa GmbH</p>
    <p>Josuel Arz, Robert Hormann</p>
    <p>Impressum</p>
</footer>
@yield("jsextra")
</body>

</html>
