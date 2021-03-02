<html lang="ro">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Page</title>
    <link rel="stylesheet" type="text/css" href="style_body.css">
    <link rel="stylesheet" type="text/css" href="style_sport_tournaments.css">
    <link rel="stylesheet" type="text/css" href="style_table.css">
    <link rel="icon" href="images/students_league.ico">
</head>

<body>

<?php
include 'connection.php';
include 'nav_bar.php';
date_default_timezone_set("Europe/Bucharest");


?>

<div class="container_title">
    <h1>Tournaments</h1>
</div>

<div class="container">
    <?php
    $query = "SELECT SportID, NumeCompetitie FROM sporturi ORDER BY SportID";
    $query_run=mysqli_query($connection,$query);
    $index = 0;
    while ($row=mysqli_fetch_array($query_run)){
        $index++;?>
        <div class="card">
            <div class="img_sport">
                <div class="title_sport">
                    <h2><?php echo $row["NumeCompetitie"] ?></h2>
                </div>
            </div>
            <div class="btn_phases">
                <form action="preliminary.php" method="post">
                    <input type="submit" class="btn_preliminary" name="preliminary_sport_<?php echo $row["SportID"]?>" value="Preliminarii">
                </form>
                <form action="tournament.php" method="post">
                    <input type="submit" class="btn_tournament" name="tournament_sport_<?php echo $row["SportID"]?>" value="Turneu">
                </form>
            </div>
        </div>
        <?php
    }
    ?>
</div>


<div class="container">
    <div class="card_interval">
        <h2>Doresti sa stii daca ai timp sa prinzi vreun meci?</h2>
        <h2>Verifica acum</h2>
        <form action="sport_tournaments.php" method="get">
            <div class="column">
                <b>Data</b><br>
                <label><input type="date" name="data" required></label>
            </div>
            <div class="column">
                <b>Intervalul orar</b>
                <label><input type="time" name="time1" required></label>
                <label><input type="time" name="time2" required></label>
            </div>
            <button id="collapsible" type="submit" name="interval_match">Meciuri</button>
        </form>
    </div>
</div>
<?php if(isset($_GET["interval_match"])){?>
    <div id="content">
        <?php
        $query = "SELECT S.NumeCompetitie, F.Nume, E1.NumeEchipa, E2.NumeEchipa, M.OraIncepere, M.OraSfarsit, M.Locatie
                    FROM meciuri M
                    LEFT JOIN sporturi S ON M.SportID = S.SportID
                    LEFT JOIN faze F ON M.FazaID = F.FazaID
                    LEFT JOIN echipe E1 ON M.Echipa1ID = E1.EchipaID
                    LEFT JOIN echipe E2 ON M.Echipa2ID = E2.EchipaID
                    WHERE S.DataDesfasurare = '".$_GET["data"]."' AND M.OraIncepere BETWEEN '".$_GET["time1"]."' AND '".$_GET["time2"]."'
                    ORDER BY M.OraIncepere";
        $query_run = mysqli_query($connection,$query);
        $all_property = array();?>

        <table>
            <caption>Meciurile din data de <?php echo $_GET["data"];?></caption>
            <thead>
            <tr>
                <?php while ($property=mysqli_fetch_field($query_run)) {?>
                    <th> <?php echo $property->name;?> </th>
                    <?php array_push($all_property, $property->name);
                }?>
            </tr>
            </thead>

            <?php while ($row = mysqli_fetch_array($query_run)) {?>
                <tr>
                    <?php foreach ($all_property as $item) { ?>
                        <td> <?php echo $row[$item]; ?></td>
                        <?php
                    }?>
                </tr>
                <?php
            }?>
        </table>
    </div>
<?php
}
?>

</body>
</html>


