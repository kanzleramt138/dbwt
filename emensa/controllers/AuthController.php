<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/benutzer.php');

class AuthController
{
    public function index(RequestData $rd) {
        return view('anmeldung', ['rd' => $rd]);
    }

    public function anmeldung_verifizieren(RequestData $rd) {
        $data = $rd->getData();
        $email = $data['email'];
        $passwort = $data['password'];
        $hashed_passwort = sha1('abcd' . $passwort);

        // Datenbankverbindung herstellen
        $link = connectdb();

        // Transaktion starten
        $link->begin_transaction();

        try {
            // Überprüfen, ob der Benutzer existiert
            if (!check_benutzer($link, $email)) {
                $_SESSION['error'] = 'Benutzer existiert nicht';
                $link->rollback();
                return view('anmeldung', ['rd' => $rd]);
            }

            // Passwort und Name des Benutzers abrufen
            $user = get_password($link, $email);

            if ($hashed_passwort === $user['passwort']) {
                // Anmeldung erfolgreich, Session setzen
                $_SESSION['email'] = $email;
                $_SESSION['benutzer_name'] = $user['name'];

                // Anmeldungsinformationen aktualisieren
                success_anmeldung($link, $email);

                // Transaktion abschließen
                $link->commit();

                header("Location: /");
                exit();
            } else {
                // Falsches Passwort, Fehlerzeitpunkt aktualisieren
                fail_anmeldung($link, $email);

                $_SESSION['error'] = 'Passwort oder E-Mail falsch';
            }

            // Transaktion abschließen
            $link->commit();
        } catch (Exception $e) {
            // Bei einem Fehler die Transaktion zurücksetzen
            $link->rollback();
            $_SESSION['error'] = 'Ein Fehler ist aufgetreten: ' . $e->getMessage();
            return view('anmeldung', ['rd' => $rd]);
        } finally {
            $link->close();
        }

        return view('anmeldung', ['rd' => $rd]);
    }

    public function logout(RequestData $rd) {
        session_destroy();
        header("Location: /");
        exit();
    }
}





?>