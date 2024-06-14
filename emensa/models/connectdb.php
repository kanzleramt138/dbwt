<?php

function connectdb() {
    $config = require($_SERVER['DOCUMENT_ROOT'].'/../config/db.php');
    $link = mysqli_connect($config['host'], $config['user'], $config['password'], $config['dbname']);
    if (!$link) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
    return $link;
}