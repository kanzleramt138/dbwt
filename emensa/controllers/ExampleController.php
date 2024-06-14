<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/kategorie.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gericht.php');
class ExampleController
{
    public function m4_6a_queryparameter(RequestData $rd) {
        /*
           Wenn Sie hier landen:
           bearbeiten Sie diese Action,
           so dass Sie die Aufgabe löst
        */

        return view('notimplemented', [
            'request' => $rd,
            'url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"
        ]);
    }

    public function m4_7a_queryParameter(RequestData $rd)
    {
        $name = isset($_GET['name']) ? $_GET['name'] : 'unknown';
        return view('m4_7a_queryparameter', ['name' => $name]);
    }

    // Methode zur Behandlung der Route /m4_7b_kategorie
    public function m4_7b_kategorie()
    {
        // Verwenden der Funktion db_kategorie_select_all, um alle Kategorien abzurufen
        $categories = db_kategorie_select_all();

        // Debug-Ausgabe der Kategorien
        error_log(print_r($categories, true));

        // Übergabe der Kategorien an die View
        return view('m4_7b_kategorie', ['categories' => $categories]);
    }


    // Methode zur Behandlung der Route /m4_7c_gerichte
    public function m4_7c_gerichte()
    {
        // Abrufen aller Gerichte, die mehr als 2€ kosten und nach Namen absteigend sortiert sind
        $dishes = db_gerichte_select_above_price(2);

        // Übergabe der Gerichte an die View
        return view('m4_7c_gerichte', ['dishes' => $dishes]);
    }

    // Methode zur Behandlung der Route /m4_7d_layout
    public function m4_7d_layout()
    {
        $pageNo = isset($_GET['no']) ? $_GET['no'] : 1;

        if ($pageNo == 2) {
            return view('examples.pages.m4_7d_page_2', ['title' => 'Seite 2']);
        } else {
            return view('examples.pages.m4_7d_page_1', ['title' => 'Seite 1']);
        }
    }
}

