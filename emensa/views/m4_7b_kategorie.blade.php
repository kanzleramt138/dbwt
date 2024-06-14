<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kategorien</title>
    <style>
        .bold { font-weight: bold; }
    </style>
</head>
<body>
<ul>
    @foreach($categories as $index => $category)
        <li class="{{ $index % 2 == 1 ? 'bold' : '' }}">{{ $category['name'] }}</li>
    @endforeach
</ul>
</body>
</html>




