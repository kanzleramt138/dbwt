<?php
/**
 * Praktikum DBWT. Autoren:
 * Robert Hormann, 3668591
 * Josuel Arz, 3307282
 */

// Einbinden der Datei mit den Gerichten
include 'gerichte.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Werbeseite</title>
    <style>
        .gericht {
            border: 1px solid #ddd;
            padding: 8px;
            margin-bottom: 8px;
        }
        .gericht img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
<h1>Unsere Gerichte</h1>
<?php if (isset($gerichte) && is_array($gerichte)): ?>
    <?php foreach ($gerichte as $gericht): ?>
        <div class="gericht">
            <h2><?php echo htmlspecialchars($gericht['name']); ?></h2>
            <img src="<?php echo htmlspecialchars($gericht['image']); ?>" alt="<?php echo htmlspecialchars($gericht['name']); ?>">
            <p><?php echo htmlspecialchars($gericht['description']); ?></p>
            <p>Preis intern: <?php echo number_format($gericht['price_intern'], 2); ?>€</p>
            <p>Preis extern: <?php echo number_format($gericht['price_extern'], 2); ?>€</p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Keine Gerichte verfügbar.</p>
<?php endif; ?>
</body>
</html>