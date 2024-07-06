<?php

function check_benutzer($email)
{
    $link = connectdb();
    $stmt = $link->prepare("SELECT email FROM benutzer WHERE email = ?");
    $stmt-> bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function get_password($email)
{
    // Suche den Benutzer mit der eingegebenen E-Mail in der Datenbank
    $link = connectdb();
    $stmt = $link->prepare("SELECT passwort, name FROM benutzer WHERE email = ?");
    $stmt-> bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = [];
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }

    $stmt->close();
    $link->close();

    return $user;
}

function success_anmeldung($email)
{
    $link  = connectdb();
    $stmt = 'UPDATE benutzer
             SET anzahlanmeldungen = anzahlanmeldungen + 1,
                letzteanmeldung = NOW()
             WHERE email = ?';
    $stmt = $link->prepare($stmt);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->close();
}

function fail_anmeldung($email)
{
    if (check_benutzer($email)) {
        $link = connectdb();
        $stmt = 'UPDATE benutzer SET letzterfehler = NOW() WHERE email = ?';
        $stmt = $link->prepare($stmt);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->close();
    }
}