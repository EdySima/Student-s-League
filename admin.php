<html lang="ro">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style_body.css">
    <link rel="stylesheet" type="text/css" href="style_admin.css">
    <link rel="icon" href="images/students_league.ico">
</head>
<body>

<?php
include 'connection.php';
include 'nav_bar.php';

if($_SESSION["admin"]) {
?>
    <div class="container_title">
        <h1>Admin Profile</h1>
    </div>

    <div class="left_column">
        <div class="card">
            <h2>- Selecteaza tabelul -</h2>
            <form action="check_modify.php" method="post">
                <label><select name="table" required>
                        <option value="">-- Selecteaza tabelul --</option>
                        <option value="echipe">echipe</option>
                        <option value="facultati">facultati</option>
                        <option value="faze">faze</option>
                        <option value="meciuri">meciuri</option>
                        <option value="sporturi">sporturi</option>
                        <option value="studenti">studenti</option>
                    </select></label><br>
                <button type="submit" name="btn_insert">Insert</button>
                <button type="submit" name="btn_update">Update</button>
                <button type="submit" name="btn_delete">Delete</button>
            </form>
        </div>
    </div>

    <div class="right_column">
        <div class="card">
            <h2>- Tabelele din baza de date -</h2>
            <?php
            $query = "show TABLES from students_league_db";
            $query_run=mysqli_query($connection,$query);
            while ($row=mysqli_fetch_array($query_run)){?>
                <h3> <?php echo $row["Tables_in_students_league_db"];?></h3>
            <?php
            }?>
        </div>
    </div>


<?php
}
else{
    header("Location: http://localhost/StudentsLeague/login.php");
    exit();
}
?>

</body>
</html>