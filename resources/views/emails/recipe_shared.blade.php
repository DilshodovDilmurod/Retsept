
</body><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Shared</title>
</head>
<body>
    <h1>{{ $data['title'] }}</h1>
    <img src="{{ $data['image_url'] }}" alt="{{ $data['title'] }}" style="max-width: 100%; height: auto;">
    <h3>Ingredients</h3>
    <p>{{ $data['ingredients'] }}</p>
    <h3>Instructions</h3>
    <p>{{ $data['content'] }}</p>
</body>
</html>

</html>
