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

function get_benutzer_id($link, $email)
{
    $stmt = $link->prepare("SELECT id FROM benutzer WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();
    $benutzer_id = $user['id'];

    $stmt->close();

    return $benutzer_id;
}

function success_anmeldung($link, $benutzer_id)
{
    $stmt = $link->prepare("CALL inkrementiere_anmeldungen(?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($link->error));
    }
    $stmt->bind_param('i', $benutzer_id);
    $stmt->execute();
    $stmt->close();
}

function fail_anmeldung($link, $email)
{
    if (check_benutzer($link, $email)) {
        $stmt = $link->prepare("UPDATE benutzer SET letzterfehler = NOW() WHERE email = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($link->error));
        }
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->close();
    }
}