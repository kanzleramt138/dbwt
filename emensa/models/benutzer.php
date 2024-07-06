<?php

function ()
{

}

// Suche den Benutzer mit der eingegebenen E-Mail in der Datenbank
$sql = "SELECT * FROM benutzer WHERE email='$email'";
$result = mysqli_query($link, $sql);

?>