<?php

function check_benutzer($link, $email): bool
{
    $stmt = $link->prepare("SELECT email FROM benutzer WHERE email = ?");
    $stmt-> bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $exists = $result->num_rows > 0;

    $stmt->close();

    return $exists;
}

function get_password($link, $email)
{
    // Suche den Benutzer mit der eingegebenen E-Mail in der Datenbank
    $stmt = $link->prepare("SELECT passwort, name FROM benutzer WHERE email = ?");
    $stmt-> bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = [];
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }

    $stmt->close();

    return $user;
}

function success_anmeldung($link, $email)
{
    $stmt = 'UPDATE benutzer
             SET anzahlanmeldungen = anzahlanmeldungen + 1,
                letzteanmeldung = NOW()
             WHERE email = ?';
    $stmt = $link->prepare($stmt);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($link->error));
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->close();
}

function fail_anmeldung($link, $email)
{
    if (check_benutzer($link, $email)) {
        $stmt = 'UPDATE benutzer SET letzterfehler = NOW() WHERE email = ?';
        $stmt = $link->prepare($stmt);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($link->error));
        }
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->close();
    }
}