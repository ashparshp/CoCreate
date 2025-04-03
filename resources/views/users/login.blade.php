<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="UserController.php" method="POST">
        <label for="Username">Username</label>
        <input type="text" id="name" placeholder={username}>
        <label for="Password">Password</label>
        <input type="text" id="password" placeholder={Password}>

        <button type="submit" value="submit">
            Login
        </button>
    </form>
</body>
</html>