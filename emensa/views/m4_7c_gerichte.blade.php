<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gerichte</title>
</head>
<body>
<ul>
    @foreach($dishes as $dish)
        <li>{{ $dish['name'] }} - {{ number_format($dish['preis'], 2) }} €</li>
    @endforeach
</ul>
</body>
</html>
