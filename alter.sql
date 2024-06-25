-- Schritt 1: Kombination aus `gericht` und `kategorie` einzigartig machen
ALTER TABLE gericht_hat_kategorie
    ADD UNIQUE INDEX unique_gericht_kategorie (gericht_id, kategorie_id);

-- Schritt 2: Index für die Spalte `name` in der Tabelle `gericht`
CREATE INDEX index_gericht_name ON gericht (name);

-- Schritt 3: Löschen von `gericht` und seinen Zuordnungen zu Kategorien und Allergenen
ALTER TABLE gericht_hat_kategorie
    ADD CONSTRAINT fk_gericht_hat_kategorie_gericht
        FOREIGN KEY (gericht_id)
            REFERENCES gericht(id)
            ON DELETE CASCADE;

ALTER TABLE gericht_hat_allergen
    ADD CONSTRAINT fk_gericht_hat_allergen_gericht
        FOREIGN KEY (gericht_id)
            REFERENCES gericht(id)
            ON DELETE CASCADE;

-- Schritt 4: Trigger zum Überprüfen von Abhängigkeiten vor dem Löschen einer Kategorie
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

-- Schritt 5: Automatische Aktualisierung des Allergencodes in referenzierenden Datensätzen
ALTER TABLE gericht_hat_allergen
    ADD CONSTRAINT fk_code_allergen
        FOREIGN KEY (code)
            REFERENCES allergen (code)
            ON UPDATE CASCADE;

-- Schritt 6: Kombination aus gericht_id und kategorie_id als Primärschlüssel
ALTER TABLE gericht_hat_kategorie
    DROP PRIMARY KEY,
    ADD PRIMARY KEY (gericht_id, kategorie_id);