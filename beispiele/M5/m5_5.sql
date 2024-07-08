DELIMITER //

CREATE PROCEDURE inkrementiere_anmeldungen(IN benutzer_id INT)
BEGIN
    UPDATE benutzer
    SET anzahlanmeldungen = anzahlanmeldungen + 1,
        letzteanmeldung = NOW()
    WHERE id = benutzer_id;
END //

DELIMITER ;
