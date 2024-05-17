<?php
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';
const GET_PARAM_SHOW_DESCRIPTION = 'show_description';
const GET_PARAM_LANGUAGE = 'sprache';
const GET_PARAM_TOP_FLOP = 'top_flop';

/**
 * - Praktikum DBWT. Autoren:
 * - Robert, Hormann, 3668591
 * - Josuel, Arz, 3307282
 */

/**
 * List of all allergens.
 */
$allergens = [
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch',
];

$meal = [
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    'allergens' => [11, 13],
    'amount' => 42 // Anzahl der verfügbaren Mahlzeiten
];

$ratings = [
    [   'text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse. ',
        'author' => 'Ute U.',
        'stars' => 2 ],
    [   'text' => 'Sehr gut. Immer wieder gerne',
        'author' => 'Gustav G.',
        'stars' => 4 ],
    [   'text' => 'Der Klassiker für den Wochenstart. Frisch wie immer',
        'author' => 'Renate R.',
        'stars' => 4 ],
    [   'text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.',
        'author' => 'Marta M.',
        'stars' => 3 ]
];

$searchText = '';
$showRatings = [];

if (!empty($_GET[GET_PARAM_SEARCH_TEXT])) {
    $searchText = $_GET[GET_PARAM_SEARCH_TEXT];
    foreach ($ratings as $rating) {
        if (stripos($rating['text'], $searchText) !== false) {
            $showRatings[] = $rating;
        }
    }
} else if (!empty($_GET[GET_PARAM_MIN_STARS])) {
    $minStars = $_GET[GET_PARAM_MIN_STARS];
    foreach ($ratings as $rating) {
        if ($rating['stars'] >= $minStars) {
            $showRatings[] = $rating;
        }
    }
} else if (!empty($_GET[GET_PARAM_TOP_FLOP])) {
    if ($_GET[GET_PARAM_TOP_FLOP] == 'top') {
        $maxStars = max(array_column($ratings, 'stars'));
        foreach ($ratings as $rating) {
            if ($rating['stars'] == $maxStars) {
                $showRatings[] = $rating;
            }
        }
    } else if ($_GET[GET_PARAM_TOP_FLOP] == 'flop') {
        $minStars = min(array_column($ratings, 'stars'));
        foreach ($ratings as $rating) {
            if ($rating['stars'] == $minStars) {
                $showRatings[] = $rating;
            }
        }
    }
} else {
    $showRatings = $ratings;
}

function calcMeanStars(array $ratings): float {
    $sum = 0;
    foreach ($ratings as $rating) {
        $sum += $rating['stars'];
    }
    if (count($ratings) === 0) {
        return 0; // Vermeiden einer Division durch Null
    }
    return $sum / count($ratings);
}

$texts = [
    'de' => [
        'title' => 'Gericht: ' . $meal['name'],
        'allergens' => 'Allergene:',
        'ratings' => 'Bewertungen (Insgesamt: ',
        'filter' => 'Filter:',
        'search' => 'Suchen',
        'text' => 'Text',
        'name' => 'Name',
        'stars' => 'Sterne',
        'description' => $meal['description'],
        'language' => 'Sprache:',
        'top_flop' => 'Zeige Bewertungen:',
        'select_option' => 'Bitte wählen',
        'top' => 'Top-Bewertungen',
        'flop' => 'Flop-Bewertungen'
    ],
    'en' => [
        'title' => 'Meal: ' . $meal['name'],
        'allergens' => 'Allergens:',
        'ratings' => 'Ratings (Overall: ',
        'filter' => 'Filter:',
        'search' => 'Search',
        'text' => 'Text',
        'name' => 'Name',
        'stars' => 'Stars',
        'description' => $meal['description'],
        'language' => 'Language:',
        'top_flop' => 'Show reviews:',
        'select_option' => 'Please select',
        'top' => 'Top Reviews',
        'flop' => 'Flop Reviews'
    ]
];

$language = $_GET[GET_PARAM_LANGUAGE] ?? 'de';
$currentTexts = $texts[$language];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo $currentTexts['title']; ?></title>
    <style>
        * {
            font-family: Arial, serif;
        }
        .rating {
            color: darkgray;
        }
    </style>
</head>
<body>
<h1><?php echo $currentTexts['title']; ?></h1>
<nav>
    <a href="?sprache=de">Deutsch</a> |
    <a href="?sprache=en">English</a>
</nav>
<?php if (!isset($_GET[GET_PARAM_SHOW_DESCRIPTION]) || $_GET[GET_PARAM_SHOW_DESCRIPTION] != '0'): ?>
    <p><?php echo $currentTexts['description']; ?></p>
<?php endif; ?>
<p>
    <?php echo sprintf("Preis (intern): %.2f€", $meal['price_intern']); ?><br>
    <?php echo sprintf("Preis (extern): %.2f€", $meal['price_extern']); ?>
</p>
<h2><?php echo $currentTexts['allergens']; ?></h2>
<ul>
    <?php
    foreach ($meal['allergens'] as $allergenId) {
        echo "<li>{$allergens[$allergenId]}</li>";
    }
    ?>
</ul>
<h1><?php echo $currentTexts['ratings'] . calcMeanStars($ratings); ?>)</h1>
<form method="get">
    <label for="search_text"><?php echo $currentTexts['filter']; ?></label>
    <input id="search_text" type="text" name="search_text" value="<?php echo htmlspecialchars($searchText); ?>">
    <input type="hidden" name="sprache" value="<?php echo htmlspecialchars($language); ?>">
    <input type="submit" value="<?php echo $currentTexts['search']; ?>">
    <br>
    <label for="top_flop"><?php echo $currentTexts['top_flop']; ?></label>
    <select id="top_flop" name="top_flop">
        <option value=""><?php echo $currentTexts['select_option']; ?></option>
        <option value="top"><?php echo $currentTexts['top']; ?></option>
        <option value="flop"><?php echo $currentTexts['flop']; ?></option>
    </select>
    <input type="submit" value="<?php echo $currentTexts['filter']; ?>">
</form>
<table class="rating">
    <thead>
    <tr>
        <td><?php echo $currentTexts['text']; ?></td>
        <td><?php echo $currentTexts['name']; ?></td>
        <td><?php echo $currentTexts['stars']; ?></td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($showRatings as $rating) {
        echo "<tr><td class='rating_text'>{$rating['text']}</td>
                    <td class='rating_author'>{$rating['author']}</td>
                    <td class='rating_stars'>{$rating['stars']}</td>
                  </tr>";
    }
    ?>
    </tbody>
</table>
</body>
</html>