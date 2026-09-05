<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Lista de Árboles</h1>
    <ul>
        @foreach ($arboles as $arbol)
            <li>{{ $arbol->nombre }} - {{ $arbol->especie }}</li>
        @endforeach
    </ul>
</body>
</html>