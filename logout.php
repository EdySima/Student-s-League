<?php
    session_start();
    $_SESSION["logged_in"] = false;
    $_SESSION["admin"] = 0;
    header("Location: http://localhost/StudentsLeague/index.php");
    exit();
?>
