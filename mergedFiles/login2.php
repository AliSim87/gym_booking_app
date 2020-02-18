<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="login1.css" type="text/css" rel="stylesheet">
    <link href="inline.css" type="text/css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <title>Rockdale Gym | Login</title>
</head>
<body> 
    <div class="body"></div>
    <div class="grad"></div>
    <div class="header">
        <div><span>Welcome!</span></div>
    </div>
    <br>
        <form action="authentication.php" method="POST">
            <div class="login">
            <input type="text" placeholder="Username" name="user"  maxlength="5" required><br>
            <input type="password" placeholder="Password" name="password" minlength="5" maxlength ="8" required><br>
            <input type="submit" value="Log In">
            <p class="message">Not registered? <a href="signup.php"> Create an account</a></p>
            </div>
        </form>
</body>
</html>
