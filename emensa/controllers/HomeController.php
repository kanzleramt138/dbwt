<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gericht.php');


/* Datei: controllers/HomeController.php */
class HomeController
{
    public function index(RequestData $request) {
        $gerichte = db_gericht_select_all();
        return view('home', ['gerichte' => $gerichte ]);
    }
    
    public function debug(RequestData $request) {
        return view('debug');
    }
}