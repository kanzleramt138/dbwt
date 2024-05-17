<!--
- Praktikum DBWT. Autoren:
- Robert, Hormann, 3668591
- Josuel, Arz, 3307282
-->
<form method="get">
    <label for=a>A:</label>
    <input type="number" id="a" name="a" required>
    <br>
    <label for=b>B:</label>
    <input type="number" id="b" name="b" required>
    <br>
    <button type="submit" name="addieren">Addieren</button>
    <button type="submit" name="multiplizieren">Multiplizieren</button>
</form>

<?php
if (isset($_GET['a']) && isset($_GET['b'])) {
    $a = $_GET['a'];
    $b = $_GET['b'];
    
    if (isset($_GET['addieren'])) {
        $result = $a + $b;
        echo "<p>Ergebnis der Addition: $result</p>";
    } elseif (isset($_GET['multiplizieren'])) {
        $result = $a * $b;
        echo "<p>Ergebnis der Multiplikation: $result</p>";
    }
} else {
    echo "<p>Bitte geben Sie beiden Eingabefeldern eine Zahl als gültigen Eingabewert.<p>";
}
?>