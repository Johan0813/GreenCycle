<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de árboles</title>
</head>
<body>

    <h1>Lista de árboles</h1>
    <!-- <form action="/api/add/tree" method="POST">
        @csrf
        <button type="submit">
            Plantar árbol
        </button>
    </form> -->
    <hr>

    @if ($trees->isEmpty())
        <p>No hay árboles registrados.</p>
    @else
        @foreach ($trees as $tree)

            <h2>Árbol #{{ $tree->id }}</h2>
            <p>Nivel: {{ $tree->level }}</p>
            <p>Salud: {{ $tree->health }}</p>
            <p>Progreso: {{ $tree->progress }}</p>
            <p>Estado: {{ $tree->status }}</p>
            <hr>

        @endforeach
    @endif
</body>
</html>