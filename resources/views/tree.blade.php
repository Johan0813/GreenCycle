<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Tree #{{ $tree->id }}</h1>
    <p>Level: {{ $tree->level }}</p>
    <p>Health: {{ $tree->health }}</p>
    <p>Progress: {{ $tree->progress }}</p>
    <p>Status: {{ $tree->status }}</p>
</body>
</html>