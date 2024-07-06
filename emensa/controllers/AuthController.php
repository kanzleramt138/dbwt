<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/benutzer.php');

class AuthController
{
    public function index(RequestData $rd) {
        return view('anmeldung', ['rd' => $rd]);
    }

    public function anmeldung_verifizieren(RequestData $rd) {
        $data = $rd -> getData();
        $email = $data['email'] ?? null;
        $passwort = $data['password'] ?? null;
        $hashed_passwort = sha1('abcd'.$passwort);





    }

    public function logout(RequestData $rd) {
        session_destroy();
        header("Location: /");
    }
}





?>