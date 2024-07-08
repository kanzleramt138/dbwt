<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/benutzer.php');

class AuthController
{
    public function anmeldung_verifizieren(RequestData $rd) {
        $log = logger();
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
                $log->warning('Failed login attempt: User does not exist', ['email' => $email]);
                return view('anmeldung', ['rd' => $rd]);
            }

            // Passwort und Name des Benutzers abrufen
            $user = get_password($link, $email);

            if ($hashed_passwort === $user['passwort']) {
                // Anmeldung erfolgreich, Session setzen
                $_SESSION['email'] = $email;
                $_SESSION['benutzer_name'] = $user['name'];

                // Anmeldungsinformationen aktualisieren
                $benutzer_id = get_benutzer_id($link, $email);
                success_anmeldung($link, $benutzer_id);

                // Transaktion abschließen
                $link->commit();

                $log->info('Successful login', ['email' => $email]);
                header("Location: /");
                exit();
            } else {
                // Falsches Passwort, Fehlerzeitpunkt aktualisieren
                fail_anmeldung($link, $email);

                $_SESSION['error'] = 'Passwort oder E-Mail falsch';
                $log->warning('Failed login attempt: Incorrect password', ['email' => $email]);
            }

            // Transaktion abschließen
            $link->commit();
        } catch (Exception $e) {
            // Bei einem Fehler die Transaktion zurücksetzen
            $link->rollback();
            $_SESSION['error'] = 'Ein Fehler ist aufgetreten: ' . $e->getMessage();
            $log->error('Error during login attempt', ['email' => $email, 'error' => $e->getMessage()]);
            return view('anmeldung', ['rd' => $rd]);
        } finally {
            $link->close();
        }

        return view('anmeldung', ['rd' => $rd]);
    }
}
