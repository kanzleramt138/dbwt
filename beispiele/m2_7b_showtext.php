<!--
- Praktikum DBWT. Autoren:
- Robert, Hormann, 3668591
- Josuel, Arz, 3307282
-->
<?php
function searchLine($line, $searchWord) {
    $explodedLine = explode(";", $line);
    $cleanLine = [];
    foreach ($explodedLine as $word) {
        $word = trim($word);
        $cleanLine[] = $word;
    }
    if (in_array($searchWord, $cleanLine)) {
        return $cleanLine[0];
    } else {
        return null;
    }
}

$fileName = "en.txt";

if (isset($_GET['suche'])) {
    $searchWord = $_GET['suche'];
    $fileContent = file($fileName);
    $translation = "";
    foreach ($fileContent as $line) {
        $translation = searchLine($line, $searchWord);
        if ($translation != null) {
            break;
        }
    }
    
    if ($translation == null) {
        echo "Es wurde keine Übersetzung für $searchWord gefunden.";
    } else {
        echo "Die Übersetzung von $searchWord lautet $translation.";
    }
}
?>