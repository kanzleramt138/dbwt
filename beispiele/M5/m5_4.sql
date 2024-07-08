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
