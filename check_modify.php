<?php

include 'connection.php';

session_start();

$_SESSION['table'] = $_POST['table'];

if(isset($_POST["btn_update"])){
    header("Location: http://localhost/StudentsLeague/update.php");
    exit();
}
elseif(isset($_POST["btn_insert"])){
    header("Location: http://localhost/StudentsLeague/insert.php");
    exit();
}
elseif(isset($_POST["btn_delete"])){
    header("Location: http://localhost/StudentsLeague/delete.php");
    exit();
}
else{
    header("Location: http://localhost/StudentsLeague/admin.php");
    exit();
}
?>
