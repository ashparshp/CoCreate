<!DOCTYPE html>
<html>
<head>
    <title>{{ $post->title }}</title>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <div>
        {{ $post->content }}
    </div>
    <a href="{{ url('/') }}">Back to Home</a>
</body>
</html>