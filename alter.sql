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


