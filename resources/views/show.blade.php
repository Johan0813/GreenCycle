<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del árbol</title>
</head>
<body>
    @if ($tree)
        <h1>Información del árbol</h1>
        <p>ID: {{ $tree->id }}</p>
        <p>Nivel: {{ $tree->level }}</p>
        <p>Salud: {{ $tree->health }}</p>
        <p>Progreso: {{ $tree->progress }}</p>
        <p>Estado: {{ $tree->status }}</p>
    @else
        <h1>Árbol no encontrado</h1>
        <p>El árbol que estás buscando no existe.</p>
    @endif
</body>
</html>