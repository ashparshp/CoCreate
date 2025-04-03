<!DOCTYPE html>
<html>
<head>
    <title>Clothes Shop</title>
</head>
<body>
    <h1>Clothes Available at the Shop</h1>
    <ul>
        @foreach($clothes as $cloth)
            <li>
                <a href="{{ route('clothes.show', $cloth->id) }}">
                    {{ $cloth->name }}
                </a>
            </li>
        @endforeach
    </ul>
</body>
</html>