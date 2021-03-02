<html lang="ro">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Page</title>
    <link rel="stylesheet" type="text/css" href="style_body.css">
    <link rel="stylesheet" type="text/css" href="style_profile.css">
    <link rel="stylesheet" type="text/css" href="style_table.css">
    <link rel="icon" href="images/students_league.ico">
</head>

<body>

<?php
    include 'connection.php';
    include 'nav_bar.php';
    date_default_timezone_set("Europe/Bucharest");

if($_SESSION["admin"]) {
    header("Location: http://localhost/StudentsLeague/admin.php");
    exit();
}

if($_SESSION["logged_in"] && $_SESSION["username"] != "")
{
    $email = $_SESSION["username"];
?>

    <!---------------- Numele persoanei ------------------->

    <div class="container_title">
        <h2>
            <?php
            $query = "SELECT * FROM studenti A WHERE A.Email = '".$email."'";
            $query_run=mysqli_query($connection,$query);
            while ($row=mysqli_fetch_array($query_run)){
                echo $row["Nume"]." ".$row["Prenume"];
            }
            ?>
        </h2>
    </div>

    <!---------------- Cardul din stanga paginii ------------------->

    <div class = "left_column">
        <div class="card">
            <h1>Detalii personale:</h1>
            <p>
            <?php
                $query = "SELECT * FROM studenti A 
                        LEFT JOIN facultati B ON A.FacultateID = B.FacultateID 
                        WHERE A.Email = '".$email."'";
                $query_run=mysqli_query($connection,$query);
                while ($row=mysqli_fetch_array($query_run)){?>
                    <b>Data nasterii: </b><?php echo $row["DataNasterii"];?>
                    <br><b>E-mail: </b><?php echo $row["Email"];?>
                    <br><b>Telefon: </b><?php echo $row["Telefon"];?>
                    <br><b>Facultate: </b><?php echo $row["NumeFacultate"].", ".$row["Universitate"];?>
                    <br><b>Adresa: </b><?php echo $row["Strada"].", ".$row["Numar"].", ".$row["Judet"].", ".$row["Oras"];
                }
            ?>
            </p>
        </div>
    </div>

    <!---------------- Cardul din dreapta paginii ------------------->

    <div class = "right_column">
        <div class="card">
            <h1>Echipa:</h1>

            <!---------------- Numele echipei din care face parte user-ul ------------------->

            <p class = "nume_echipa"><b>
                <?php
                $query = "SELECT E.NumeEchipa FROM studenti ST 
                        LEFT JOIN echipe E ON ST.EchipaID = E.EchipaID 
                        WHERE ST.Email = '".$email."'";
                $query_run=mysqli_query($connection,$query);
                if ($row=mysqli_fetch_array($query_run)){
                    $my_team = $row["NumeEchipa"];
                    echo "- ".$my_team." -";
                }
                else $my_team = "";
                ?>
                </b></p>

            <!------------ Generarea de butoane pentru competitiile la care ia parte user-ul ---------------->

            <h1>Competitii:</h1>
            <div class = "div_btn_center">
            <?php
            $sports = array();
            $query = "SELECT NumeCompetitie FROM sporturi ORDER BY SportID";
            $query_run=mysqli_query($connection,$query);
            while ($row=mysqli_fetch_array($query_run)){
                array_push($sports, $row["NumeCompetitie"]);
            }

            $query ="SELECT COUNT(SportID) num_sporturi FROM sporturi";
            $query_run=mysqli_query($connection,$query);
            $row=mysqli_fetch_array($query_run);
            $nr_sport = $row["num_sporturi"];
            $query = "SELECT DISTINCT S.NumeCompetitie
                    FROM meciuri M
                    JOIN sporturi S ON M.SportID = S.SportID
                    JOIN echipe E1 ON M.Echipa1ID = E1.EchipaID
                    JOIN echipe E2 ON M.Echipa2ID = E2.EchipaID
                    WHERE E1.NumeEchipa = '".$my_team."' OR E2.NumeEchipa = '".$my_team."'
                    ORDER BY S.SportID";
            $query_run = mysqli_query($connection, $query);
            while($row=mysqli_fetch_array($query_run)) {
                $index = array_search($row["NumeCompetitie"], $sports)?>
                <button class="btn_competitii" id="btn_sport_<?php echo $index;?>"><?php echo $sports[$index];?></button>
                <?php
            }
            ?>
            </div>
        </div>
    </div>

    <!-----------------Creare de tabele modale pentru fiecare competitie la care ia parte user-ul---------------->

    <div id="popup" class="modal">
    <?php
        for($index = 0; $index < $nr_sport; $index++) {
            $query = "SELECT F.Nume AS Faza, E1.NumeEchipa AS Echipa1, E2.NumeEchipa AS Echipa2, M.ScorEchipa1, M.ScorEchipa2, M.OraIncepere, M.OraSfarsit, M.Locatie
                    FROM meciuri M
                    JOIN sporturi S ON M.SportID = S.SportID
                    JOIN faze F ON M.FazaID = F.FazaID
                    JOIN echipe E1 ON M.Echipa1ID = E1.EchipaID
                    JOIN echipe E2 ON M.Echipa2ID = E2.EchipaID
                    WHERE (E1.NumeEchipa = '".$my_team."' OR E2.NumeEchipa = '".$my_team."') AND S.NumeCompetitie = '".$sports[$index]."'
                    ORDER BY M.OraIncepere";
            $query_run = mysqli_query($connection, $query);
            if($row=mysqli_fetch_array($query_run)) {
                ?>
                <table id="table_sport_<?php echo $index;?>" class="modal-content">
                    <caption>Meciurile mele: <?php echo $sports[$index];?></caption>
                    <thead>
                    <!---------------- Titlul fiecarei coloane din tabel -------------------->
                    <tr>
                        <th>Nr.Crt</th>
                        <th>Faza</th>
                        <th>Echipa 1</th>
                        <th>Echipa 2</th>
                        <th>Scor Echipa 1</th>
                        <th>Scor Echipa 2</th>
                        <th>Ora Incepere</th>
                        <th>Ora Sfarsit</th>
                        <th>Locatie</th>
                    </tr>
                    </thead>
                    <?php
                    $nr_crt = 0;
                    while ($row){
                        $nr_crt += 1;?>

                        <!---------------- Scrierea randurilor in tabel -------------------->

                        <tr>
                            <td><?php echo $nr_crt;?></td>
                            <td><?php echo $row["Faza"];?></td>

                            <!---------------- Bolduirea numelui echipei din care face perte user-ul, in tabel -------------------->

                            <?php if($row["Echipa1"] == $my_team) {?>
                                <td <?php if($row["ScorEchipa1"] > $row["ScorEchipa2"]) echo "class=\"winscore\""?>><b><?php echo $row["Echipa1"];?></b></td>
                                <td <?php if($row["ScorEchipa1"] < $row["ScorEchipa2"]) echo "class=\"winscore\""?>><?php echo $row["Echipa2"];?></td><?php
                            }
                            else {?>
                            <td <?php if($row["ScorEchipa1"] > $row["ScorEchipa2"]) echo "class=\"winscore\""?>><?php echo $row["Echipa1"];?></td>
                            <td <?php if($row["ScorEchipa1"] < $row["ScorEchipa2"]) echo "class=\"winscore\""?>><b><?php echo $row["Echipa2"];?></b></td><?php
                            } ?>

                            <td><?php echo $row["ScorEchipa1"];?></td>
                            <td><?php echo $row["ScorEchipa2"];?></td>
                            <td><?php echo $row["OraIncepere"];?></td>
                            <td><?php echo $row["OraSfarsit"];?></td>
                            <td><?php echo $row["Locatie"];?></td>
                        </tr>

                    <!---------------- Citirea urmatoarei linii din tabelul SQL rezutlat -------------------->
                    <?php
                        $row=mysqli_fetch_array($query_run);
                    }
                    ?>
                    </table>

                <?php
            }
        }
    ?>
    </div>
<?php
}
else
{
?>

<!---------------- Mesaj de eroare in cazul in care credentialele sunt incorecte  -------------------->

<div class="card">
    <h1><?php
            echo 'Parola sau emailul incorecte!';
            echo '<br>';
            echo 'Te rog sa mai incerci odata';
        ?></h1>
    <a href="login.php"><button>Back</button></a>
</div>
<?php
}
?>

<!---------------- Scriptul pentru afisarea div-urilor modale in care sunt tabelele -------------------->

<script>
    var popup = document.getElementById("popup");
    var meciuri = document.getElementsByClassName("modal-content");
    function ShowContent(index){
        for(var k = 0; k < meciuri.length; k++){
            meciuri[k].style.display = "none";
        }
        popup.style.display = "block";
        meciuri[index].style.display = "block";
        console.log(meciuri[index]);
    }
    var sports_btn = document.getElementsByClassName("btn_competitii");
    console.log(sports_btn.length);
    for(var i = 0; i < sports_btn.length; i++){
        sports_btn[i].addEventListener('click',ShowContent.bind(null,i));
        console.log(sports_btn[i]);
    }
    window.onclick = function(event) {
        if (event.target === popup) {
            popup.style.display = "none";
        }
    }
</script>


</body>
</html>