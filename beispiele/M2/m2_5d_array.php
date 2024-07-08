<!--
- Praktikum DBWT. Autoren:
- Robert, Hormann, 3668591
- Josuel, Arz, 3307282
-->
<?php
$famousMeals = [
    1 => ['name' => 'Currywurst mit Pommes',
    'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis',
    'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese',
    'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes',
    'winner' => 2019]
];

echo "<ol>";
foreach ($famousMeals as $meal) {
    echo "<li style='margin-top: 10px;'>".$meal['name']."<br>";
    if (is_array($meal['winner'])) {
        $reversedYears = array_reverse($meal['winner']);
        $years = implode(", ", $reversedYears);
        echo $years;
    } else {
        echo $meal['winner'];
    }
    echo "</li>";
}
echo "</ol>";
echo "<br>";

function getMissingYears($winnerYearsMeals) {
    $startYear = 2000;
    $endYear = date('Y');
    $years = [];
    for ($startYear; $startYear <= $endYear; $startYear++) {
        $years[] = $startYear;
    }
    
    $missingYears = [];
    foreach ($years as $year) {
        if (in_array($year, $winnerYearsMeals)) {
            continue;
        } else {
            $missingYears[] = $year;
        }
    }
    return $missingYears;
}

$winnerYears = [];
foreach ($famousMeals as $meal) {
    $winnerYearsMeals = $meal['winner'];
    if (is_array($winnerYearsMeals)) {
        foreach ($winnerYearsMeals as $winnerYearMeal) {
            $winnerYears[] = $winnerYearMeal;
        }
    } else {
        $winnerYears[] = $winnerYearsMeals;
    }
}

$missingYears = getMissingYears($winnerYears);
echo "<p>Die Jahre ohne Sieger sind:<br><ul>";
foreach ($missingYears as $missingYear) {
    echo "<li>".$missingYear."</li>";
}
echo "</ul></p>";
?>