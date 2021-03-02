<?php

include 'connection.php';

session_start();

$_SESSION["logged_in"] = false;
$_SESSION["username"] = "";
$_SESSION["admin"] = 0;

if(isset($_POST['email'], $_POST['psw']))
{
    $email = $_POST['email'];
    $password = $_POST['psw'];

    if($email == 'admin' && $password == 'admin'){
        $_SESSION["admin"] = 1;
        header("Location: http://localhost/StudentsLeague/admin.php");
    }
    else{
        $query = "SELECT Email, Parola FROM studenti WHERE Email = '".$email."' AND  Parola = '".$password."'";
        $result1 = mysqli_query($connection, $query);

        if(mysqli_num_rows($result1) > 0)
        {
                $_SESSION["logged_in"] = true;
                $_SESSION["username"] = $email;
        }
        else
        {
            $_SESSION["logged_in"] = false;
            $_SESSION["username"] = "";
        }
        header("Location: http://localhost/StudentsLeague/profile.php");
        exit();
    }
}
else
{
    header("Location: http://localhost/StudentsLeague/login.php");
    exit();
}
?>