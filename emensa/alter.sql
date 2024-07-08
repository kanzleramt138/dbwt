
-- M4 ALTER --

-- Schritt 1: Index für die Spalte `name` in der Tabelle `gericht`
CREATE INDEX index_gericht_name ON gericht (name);

-- Schritt 2: Trigger zum Überprüfen von Abhängigkeiten vor dem Löschen einer Kategorie
DELIMITER //

CREATE TRIGGER before_category_delete
    BEFORE DELETE ON kategorie
    FOR EACH ROW
BEGIN
    DECLARE v_gerichte_count INT;
    DECLARE v_kinder_count INT;

    -- Überprüfen, ob der Kategorie Gerichte zugeordnet sind
    SELECT COUNT(*) INTO v_gerichte_count
    FROM gericht_hat_kategorie
    WHERE kategorie_id = OLD.id;

    -- Überprüfen, ob der Kategorie Unterkategorien zugeordnet sind
    SELECT COUNT(*) INTO v_kinder_count
    FROM kategorie
    WHERE eltern_id = OLD.id;

    -- Wenn Gerichte oder Unterkategorien zugeordnet sind, Fehler auslösen
    IF v_gerichte_count > 0 OR v_kinder_count > 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Kategorie kann nicht gelöscht werden, da ihr noch Gerichte oder Unterkategorien zugeordnet sind.';
    END IF;
END;
//

DELIMITER ;


-- M5 ALTER --

-- Aufgabe 1: Benutzerstruktur implementieren --
-- Schritt 1: Erstellen einer Tabelle für Benutzer --
CREATE TABLE benutzer (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    name        VARCHAR(200) NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    passwort    VARCHAR(200) NOT NULL,
    admin       BOOLEAN NOT NULL DEFAULT FALSE,
    anzahlfehler INT NOT NULL DEFAULT 0,
    anzahlanmeldungen INT NOT NULL,
    letzteanmeldung DATETIME,
    letzterfehler DATETIME
);

-- Schritt 2: Hinzufügen des Admin-Benutzers --
INSERT INTO benutzer (name, email, passwort, admin, anzahlanmeldungen) 
VALUES ('Admin', 'admin@emensa.example', 'a723b52a425929168e551d526bf85e630601dd74', TRUE, 0);

-- Aufgabe 2: Erstellen von SQL-Trigger --
ALTER TABLE gericht
    ADD COLUMN bildname varchar(200) NULL;

-- Schritt 1: automatisches Setzen des Bildnamens --
UPDATE gericht SET bildname = '01_bratkartoffel' WHERE id = 1;
UPDATE gericht SET bildname = '03_bratkartoffel' WHERE id = 3;
UPDATE gericht SET bildname = '04_tofu' WHERE id = 4;
UPDATE gericht SET bildname = '00_image_missing' WHERE id = 5;
UPDATE gericht SET bildname = '06_lasagne' WHERE id = 6;
UPDATE gericht SET bildname = '09_suppe' WHERE id = 9;
UPDATE gericht SET bildname = '10_forelle' WHERE id = 10;
UPDATE gericht SET bildname = '11_soup' WHERE id = 11;
UPDATE gericht SET bildname = '12_kassler' WHERE id = 12;
UPDATE gericht SET bildname = '13_reibekuchen' WHERE id = 13;
UPDATE gericht SET bildname = '00_image_missing' WHERE id = 14;
UPDATE gericht SET bildname = '15_pilze' WHERE id = 15;
UPDATE gericht SET bildname = '00_image_missing' WHERE id = 16;
UPDATE gericht SET bildname = '17_broetchen' WHERE id = 17;
UPDATE gericht SET bildname = '00_image_missing' WHERE id = 18;
UPDATE gericht SET bildname = '19_mousse' WHERE id = 19;
UPDATE gericht SET bildname = '20_suppe' WHERE id = 20;

-- Aufgabe 4: Erstellen von SQL-Sichten --
-- a) Erstellen der SQL-Sicht view_suppengerichte
CREATE VIEW view_suppengerichte AS
SELECT *
FROM gericht
WHERE name LIKE '%suppe%';

-- b) Erstellen der SQL-Sicht view_anmeldungen
CREATE VIEW view_anmeldungen AS
SELECT id, name, anzahlanmeldungen
FROM benutzer
ORDER BY anzahlanmeldungen DESC;

-- c) Erstellen der SQL-Sicht view_kategoriegerichte_vegetarisch
CREATE VIEW view_kategoriegerichte_vegetarisch AS
SELECT k.id AS kategorie_id, k.name AS kategorie_name, g.id AS gericht_id, g.name AS gericht_name
FROM kategorie k
         LEFT JOIN gericht_hat_kategorie ghk ON k.id = ghk.kategorie_id
         LEFT JOIN gericht g ON ghk.gericht_id = g.id AND g.vegetarisch = TRUE;

-- Aufgabe 5: Erstellen von gespeicherten Prozeduren --
DELIMITER //

CREATE PROCEDURE inkrementiere_anmeldungen(IN benutzer_id INT)
BEGIN
    UPDATE benutzer
    SET anzahlanmeldungen = anzahlanmeldungen + 1,
        letzteanmeldung = NOW()
    WHERE id = benutzer_id;
END //

DELIMITER ;
