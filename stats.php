<html lang="ro">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style_body.css">
    <link rel="stylesheet" type="text/css" href="style_stats.css">
    <link rel="icon" href="images/students_league.ico">
</head>
<body>

<?php
include 'connection.php';
include 'nav_bar.php';

if($_SESSION["admin"]) {
    if(!empty($_GET["select_sport"]))
        $select_sport = $_GET["select_sport"];
    else
        $select_sport = "";

    if(!empty($_GET["select_faculty"]))
        $select_faculty = $_GET["select_faculty"];
    else
        $select_faculty = "";


    ?>

    <div class="container_title">
        <h1>Statistici</h1>
    </div>

    <div class="card">
        <div class="row">
            <h2>Numarul de echipe la competitia </h2>
            <?php
            $query = "SELECT NumeCompetitie FROM sporturi";
            $query_run=mysqli_query($connection,$query);?>
            <form action="stats.php" method="get">
                <select name="select_sport" onchange="this.form.submit()">
                    <option value="">- Alege competitia -</option>
                    <?php
                    while($row=mysqli_fetch_array($query_run)){?>
                        <option value="<?php echo $row["NumeCompetitie"]?>" <?php if($select_sport == $row["NumeCompetitie"]) echo "selected" ?>><?php echo $row["NumeCompetitie"]?></option>
                    <?php
                    }?>
                </select>
            </form>
        </div>
        <?php
        $query = "SELECT COUNT(EchipaID) AS NumarEchipa
                    FROM echipe
                    WHERE EchipaID IN (SELECT DISTINCT Echipa1ID AS Echipa
                        FROM meciuri M
                        JOIN faze F ON F.FazaID=M.FazaID
                        JOIN sporturi S ON S.SportID=M.SportID
                        WHERE S.NumeCompetitie = '$select_sport'
                        UNION
                        SELECT DISTINCT Echipa2ID AS Echipa
                        FROM meciuri M
                        JOIN faze F ON F.FazaID=M.FazaID
                        JOIN sporturi S ON S.SportID=M.SportID
                        WHERE S.NumeCompetitie = '$select_sport')";
        $query_run=mysqli_query($connection,$query);
        $row=mysqli_fetch_array($query_run);?>
        <h2> <?php echo $row["NumarEchipa"];?></h2>

        <hr>

        <h2>Echipele cu mai mult de 10 goluri la Football </h2>
        <?php
        $query = "SELECT *
                FROM (SELECT E.NumeEchipa, (IFNULL(E1.Goluri,0) + IFNULL(E2.Goluri,0)) Total
                    FROM echipe E
                    LEFT JOIN (SELECT Echipa1ID, SUM(ScorEchipa1) Goluri
                              FROM meciuri M
                              JOIN sporturi S ON M.SportID = S.SportID 
                              WHERE S.NumeCompetitie = 'Football'
                              GROUP BY Echipa1ID) E1 ON E.EchipaID = E1.Echipa1ID
                    LEFT JOIN (SELECT Echipa2ID, SUM(ScorEchipa2) Goluri
                              FROM meciuri M
                              JOIN sporturi S ON M.SportID = S.SportID 
                              WHERE S.NumeCompetitie = 'Football'
                              GROUP BY Echipa2ID) E2 ON E.EchipaID = E2.Echipa2ID) T
                WHERE T.Total > 10";
        $query_run=mysqli_query($connection,$query);
        $row=mysqli_fetch_array($query_run);?>
        <p><b>
            <?php while($row){
                echo $row["NumeEchipa"];
                if($row=mysqli_fetch_array($query_run))
                    echo ", ";
            }?>
            </b></p>

        <hr>

        <h2>Capitani de echipa care sunt la facultatea</h2>
        <?php
        $query = "SELECT NumeFacultate FROM facultati";
        $query_run=mysqli_query($connection,$query);?>
        <form action="stats.php" method="get">
            <select name="select_faculty" onchange="this.form.submit()">
                <option value="">- Alege facultatea -</option>
                <?php
                while($row=mysqli_fetch_array($query_run)){?>
                    <option value="<?php echo $row["NumeFacultate"]?>" <?php if($select_faculty == $row["NumeFacultate"]) echo "selected" ?>><?php echo $row["NumeFacultate"]?></option>
                    <?php
                }?>
            </select>
        </form>
        <?php
        $query = "SELECT S1.Nume, S1.Prenume
                FROM echipe E
                JOIN studenti S1 ON E.CapitanID = S1.StudentID
                WHERE EXISTS (SELECT S.Nume, S.Prenume
                            FROM studenti S
                            JOIN facultati F ON S.FacultateID = F.FacultateID
                            WHERE F.NumeFacultate = '$select_faculty' AND E.CapitanID = S.StudentID)";
        $query_run=mysqli_query($connection,$query);
        $row=mysqli_fetch_array($query_run);?>
        <p><b>
                <?php while($row){
                    echo $row["Nume"]." ".$row["Prenume"];
                    if($row=mysqli_fetch_array($query_run))
                        echo ", ";
                }?>
            </b></p>

        <hr>


        <h2>Echipa cu cele mai multe puncte la preliminariile de la football</h2>
        <?php
        $query = "SELECT E.NumeEchipa,IFNULL(E1.Puncte1,0)+IFNULL(E2.Puncte2,0)+IFNULL(E3.Puncte3,0)+IFNULL(E4.Puncte4,0) Puncte
                FROM echipe E
                LEFT JOIN (SELECT Echipa1ID, COUNT(Echipa1ID)*S.PuncteCastig Puncte1
                           FROM meciuri M
                           JOIN sporturi S ON M.SportID = S.SportID
                           JOIN faze F ON M.FazaID = F.FazaID 
                           WHERE F.Nume = 'Preliminarii' AND S.NumeCompetitie = 'Football' AND ScorEchipa1 > ScorEchipa2
                           GROUP BY Echipa1ID) E1 ON E.EchipaID = E1.Echipa1ID
                LEFT JOIN (SELECT Echipa2ID, COUNT(Echipa2ID)*S.PuncteCastig Puncte2
                           FROM meciuri M
                           JOIN sporturi S ON M.SportID = S.SportID
                           JOIN faze F ON M.FazaID = F.FazaID 
                           WHERE F.Nume = 'Preliminarii' AND S.NumeCompetitie = 'Football' AND ScorEchipa2 > ScorEchipa1
                           GROUP BY Echipa2ID) E2 ON E.EchipaID = E2.Echipa2ID
                LEFT JOIN (SELECT Echipa1ID, COUNT(Echipa1ID)*S.PuncteEgal Puncte3
                           FROM meciuri M
                           JOIN sporturi S ON M.SportID = S.SportID
                           JOIN faze F ON M.FazaID = F.FazaID 
                           WHERE F.Nume = 'Preliminarii' AND S.NumeCompetitie = 'Football' AND ScorEchipa1 = ScorEchipa2
                           GROUP BY Echipa1ID) E3 ON E.EchipaID = E3.Echipa1ID
                LEFT JOIN (SELECT Echipa2ID, COUNT(Echipa2ID)*S.PuncteEgal Puncte4
                           FROM meciuri M
                           JOIN sporturi S ON M.SportID = S.SportID
                           JOIN faze F ON M.FazaID = F.FazaID 
                           WHERE F.Nume = 'Preliminarii' AND S.NumeCompetitie = 'Football' AND ScorEchipa1 = ScorEchipa2
                           GROUP BY Echipa2ID) E4 ON E.EchipaID = E4.Echipa2ID
                ORDER BY Puncte DESC
                LIMIT 1";
        $query_run=mysqli_query($connection,$query);
        $row=mysqli_fetch_array($query_run);?>
        <p><b><?php echo "Echipa: ".$row["NumeEchipa"];?></b></p>
        <p><b><?php echo "Puncte: ".$row["Puncte"];?></b></p>
    </div>
<?php
}
?>

</body>
</html>


