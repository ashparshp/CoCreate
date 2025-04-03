<!DOCTYPE html>
<html>
<head>
    <title>{{ $cloth->name }}</title>
</head>
<body>
    <h1>{{ $cloth->name }}</h1>
    <p>Price: {{ $cloth->price }}</p>
    <p>Description: {{ $cloth->description }}</p>
    <a href="{{ route('clothes.index') }}">Back to Clothes List</a>
</body>
</html>