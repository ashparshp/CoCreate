<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        form {
            width: 300px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
        }
        
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        
        button {
            background-color: #07c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form action="{{ route('users.checkuser') }}" method="POST">
        @csrf
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Username">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password">

        <button type="submit">
            Login
        </button>
    </form>
</body>
</html>
