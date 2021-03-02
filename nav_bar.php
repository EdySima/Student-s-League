<link rel="stylesheet" type="text/css" href="style_navbar.css">
<?php
session_start();

if($_SESSION["admin"]){
    ?>
    <ul>
        <li class="nav_icon"><a href="index.php"><img src="images/students_league_orange.png" alt="logo" class="logo"></a></li>
        <li><a href="logout.php">logout</a></li>
        <li><a <?php if(htmlentities($_SERVER['PHP_SELF']) == "/StudentsLeague/admin.php") { ?> class = "active" <?php } ?> href="admin.php">Admin</a></li>
        <li><a <?php if(htmlentities($_SERVER['PHP_SELF']) == "/StudentsLeague/stats.php") { ?> class = "active" <?php } ?> href="stats.php">Statistici</a></li>
        <li><a <?php if(htmlentities($_SERVER['PHP_SELF']) == "/StudentsLeague/sport_tournaments.php") { ?> class = "active" <?php } ?> href="sport_tournaments.php">Tournament</a></li>
        <li><a <?php if(htmlentities($_SERVER['PHP_SELF']) == "/StudentsLeague/index.php") { ?> class = "active" <?php } ?> href="index.php">Home</a></li>
    </ul>
    <?php
}
else{
    if($_SESSION["logged_in"]){
        ?>
        <ul>
            <li class="nav_icon"><a href="index.php"><img src="images/students_league_orange.png" alt="logo" class="logo"></a></li>
            <li><a href="logout.php">logout</a></li>
            <li><a <?php if(htmlentities($_SERVER['PHP_SELF']) == "/StudentsLeague/profile.php") { ?> class = "active" <?php } ?> href="profile.php">Profile</a></li>
            <li><a <?php if(htmlentities($_SERVER['PHP_SELF']) == "/StudentsLeague/sport_tournaments.php") { ?> class = "active" <?php } ?> href="sport_tournaments.php">Tournament</a></li>
            <li><a <?php if(htmlentities($_SERVER['PHP_SELF']) == "/StudentsLeague/index.php") { ?> class = "active" <?php } ?> href="index.php">Home</a></li>
        </ul>
        <?php
    }
    else{?>
        <ul>
            <li class="nav_icon"><a href="index.php"><img src="images/students_league_orange.png" alt="logo" class="logo"></a></li>
            <li><a <?php if(htmlentities($_SERVER['PHP_SELF']) == "/StudentsLeague/login.php") { ?> class = "active" <?php } ?> href="login.php">Login</a></li>
            <li><a <?php if(htmlentities($_SERVER['PHP_SELF']) == "/StudentsLeague/sport_tournaments.php") { ?> class = "active" <?php } ?> href="sport_tournaments.php">Tournament</a></li>
            <li><a <?php if(htmlentities($_SERVER['PHP_SELF']) == "/StudentsLeague/index.php") { ?> class = "active" <?php } ?> href="index.php">Home</a></li>
        </ul>
        <?php
    }
}
?>