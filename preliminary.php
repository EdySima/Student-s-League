<html lang="ro">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Page</title>
    <link rel="stylesheet" type="text/css" href="style_body.css">
    <link rel="stylesheet" type="text/css" href="style_preliminary.css">
    <link rel="stylesheet" type="text/css" href="style_table.css">
    <link rel="icon" href="images/students_league.ico">
</head>

<body>

<?php
include 'connection.php';
include 'nav_bar.php';
date_default_timezone_set("Europe/Bucharest");

$query = "SELECT COUNT(NumeCompetitie) nr_sporturi FROM sporturi";
$query_run = mysqli_query($connection, $query);
$nr_sporturi = mysqli_fetch_array($query_run);

for($index = 1; $index <= $nr_sporturi["nr_sporturi"]; $index++){
    if(isset($_POST['preliminary_sport_'.$index])) {
        $query = "SELECT NumeCompetitie FROM sporturi WHERE SportID ='".$index."'";
        $query_run = mysqli_query($connection, $query);
        $nume_competitie = mysqli_fetch_array($query_run);
    ?>

    <div class="container_title">
        <h1>Preliminarii <?php echo $nume_competitie["NumeCompetitie"]?></h1>
    </div>
    <div class="card">
        <h2>Top</h2>
     <?php
        $query = "SELECT E.NumeEchipa AS Echipa, E.PuncteFotbal
                FROM echipe E
                ORDER BY E.PuncteFotbal DESC";
        $query_run = mysqli_query($connection, $query);
     $all_property = array();?>
        <table>
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

    <div class="container_title">
        <h1>Meciuri</h1>
    </div>

    <div id="container_preliminary">
    <?php
        $query = "SELECT E1.NumeEchipa Echipa1, E2.NumeEchipa Echipa2, M.ScorEchipa1, M.ScorEchipa2
                FROM meciuri M
                JOIN sporturi S ON S.SportID = M.SportID
                JOIN echipe E1 ON E1.EchipaID = M.Echipa1ID
                JOIN echipe E2 ON E2.EchipaID = M.Echipa2ID
                JOIN faze F ON F.FazaID = M.FazaID
                WHERE S.NumeCompetitie = '".$nume_competitie["NumeCompetitie"]."' AND F.Nume = 'Preliminarii'";
        $query_run = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($query_run)){?>
            <div class="match">
                <div class="row">
                    <div class="team <?php if($row["ScorEchipa1"] > $row["ScorEchipa2"]) echo "winscore" ?>">
                        <h2 class="team_name"> <?php echo $row["Echipa1"]?></h2>
                    </div>
                    <div class="score <?php if($row["ScorEchipa1"] > $row["ScorEchipa2"]) echo "winscore" ?>">
                        <h2> <?php echo $row["ScorEchipa1"]?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="team <?php if($row["ScorEchipa2"] > $row["ScorEchipa1"]) echo "winscore" ?>">
                        <h2 class="team_name"><?php echo $row["Echipa2"]?></h2>
                    </div>
                    <div class="score <?php if($row["ScorEchipa2"] > $row["ScorEchipa1"]) echo "winscore" ?>">
                        <h2><?php echo $row["ScorEchipa2"]?></h2>
                    </div>
                </div>
            </div>
        <?php
        }?>
    </div>
    <?php
    }
}?>
</body>
</html>