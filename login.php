<!DOCTYPE html>
<html lang="ro">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style_body.css">
    <link rel="stylesheet" type="text/css" href="style_login.css">
    <link rel="icon" href="images/students_league.ico">
</head>
<body>

<?php
include 'nav_bar.php';
?>

<form class="vertical-center" action="check.php" method="post">
    <div class="imgcontainer">
        <img src="images/students_league.svg" alt="login_logo" class="login_logo">
    </div>

    <div class="container">
        <div class="inputs_container">
            <label>
                <b>E-mail</b><br>
            </label>
            <input type="text" placeholder="E-mail" name="email" required><br>
        </div>
        <div class="inputs_container">
            <label>
                <b>Password</b><br>
            </label>
            <input type="password" placeholder="Enter Password" name="psw" required><br>
        </div>
        <button type="submit">Login</button>

    </div>
</form>


</body>
</html>