<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/benutzer.php');

class AuthController
{
    public function index(RequestData $rd) {
        return view('anmeldung', ['rd' => $rd]);
    }

    public function anmeldung_verifizieren(RequestData $rd) {
        $data = $rd -> getData();
        dd($data);

    }

    public function logout(RequestData $rd) {
        session_destroy();
        header("Location: /");
    }
}





?>