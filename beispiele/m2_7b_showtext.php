<!--
- Praktikum DBWT. Autoren:
- Robert, Hormann, 3668591
- Josuel, Arz, 3307282
-->
<?php
$fileName = "en.txt";

if (isset($_GET['suche'])) {
    $searchWord = htmlspecialchars($_GET['suche']);
    $fileContent = file($fileName);

    $positionIndex = 0;
    foreach ($fileContent as $line) {
        if (in_array($searchWord, $line)) {
            
        }
    }
    //if (strpos)
}
var_dump($fileContent);

?>