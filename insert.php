<html lang="ro">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style_body.css">
    <link rel="stylesheet" type="text/css" href="style_insert.css">
    <link rel="stylesheet" type="text/css" href="style_table.css">
    <link rel="icon" href="images/students_league.ico">
</head>
<body>

<?php
include "connection.php";
include "nav_bar.php";

if($_SESSION["admin"]) {
    $table = $_SESSION["table"];

    /*---------------------------------- PHP Insert in tabel echipe --------------------------------------------*/

    if(isset($_GET["insert_team"])){
        $id_student = NULL;
        if(!empty($_GET["team_surname_captain"]) && !empty($_GET["team_name_captain"])) {
            $query = "SELECT StudentID FROM studenti WHERE Nume='" . $_GET["team_surname_captain"] . "' AND Prenume='" . $_GET["team_name_captain"] . "'";
            $query_run = mysqli_query($connection, $query);
            if($row = mysqli_fetch_array($query_run)){
                $id_student = $row["StudentID"];
                $query = "INSERT INTO echipe (CapitanID, NumeEchipa, PuncteFotbal)
                VALUES('$id_student', '".$_GET["team_name"]."', '0')";
                mysqli_query($connection, $query);
            }
            else{
                echo "<script>alert(\"Studentul nu exista!\")</script>";
            }
        }
        else {
            $query = "INSERT INTO echipe (CapitanID, NumeEchipa, PuncteFotbal)
                VALUES(NULL, '" . $_GET["team_name"] . "', '0')";
            mysqli_query($connection, $query);
        }
    }

    /*---------------------------------- PHP Insert in tabel facultati --------------------------------------------*/

    if(isset($_GET["insert_faculty"])){
        if(!empty($_GET["street_faculty"]) && !empty($_GET["number_faculty"])) {
            $query = "INSERT INTO facultati (NumeFacultate, Universitate, StradaFacultate, NumarFacultate, TelefonFacultate, EmailFacultate)
                VALUES('".$_GET["faculty"]."', '" . $_GET["university"] . "', '" . $_GET["street_faculty"] . "',
                '" . $_GET["number_faculty"] . "', '" . $_GET["telephone_faculty"] . "', '" . $_GET["email_faculty"] . "')";
            mysqli_query($connection, $query);
        }elseif(!empty($_GET["street_faculty"])){
            $query = "INSERT INTO facultati (NumeFacultate, Universitate, StradaFacultate, NumarFacultate, TelefonFacultate, EmailFacultate)
                VALUES('".$_GET["faculty"]."', '" . $_GET["university"] . "', '" . $_GET["street_faculty"] . "',
                NULL, '" . $_GET["telephone_faculty"] . "', '" . $_GET["email_faculty"] . "')";
            mysqli_query($connection, $query);
        }elseif(!empty($_GET["number_faculty"])){
            $query = "INSERT INTO facultati (NumeFacultate, Universitate, StradaFacultate, NumarFacultate, TelefonFacultate, EmailFacultate)
                VALUES('".$_GET["faculty"]."', '" . $_GET["university"] . "', NULL,
                '" . $_GET["number_faculty"] . "', '" . $_GET["telephone_faculty"] . "', '" . $_GET["email_faculty"] . "')";
            mysqli_query($connection, $query);
        }
        else{
            $query = "INSERT INTO facultati (NumeFacultate, Universitate, StradaFacultate, NumarFacultate, TelefonFacultate, EmailFacultate)
                VALUES('".$_GET["faculty"]."', '" . $_GET["university"] . "', NULL, NULL,
                '" . $_GET["telephone_faculty"] . "', '" . $_GET["email_faculty"] . "')";
            mysqli_query($connection, $query);
        }
    }
    /*---------------------------------- PHP Insert in tabel faze --------------------------------------------*/

    if(isset($_GET["insert_phase"])){
        $query = "INSERT INTO faze (Nume)
                VALUES('" . $_GET["phase"] . "')";
        mysqli_query($connection, $query);
    }

    /*---------------------------------- PHP Insert in tabel meciuri --------------------------------------------*/

    if(isset($_GET["insert_match"])){
        $query = "SELECT SportID FROM sporturi WHERE NumeCompetitie='".$_GET["sport_match"]."'";
        $query_run = mysqli_query($connection, $query);
        $sport = mysqli_fetch_array($query_run);
        $query = "SELECT FazaID FROM faze WHERE Nume='".$_GET["sport_phase"]."'";
        $query_run = mysqli_query($connection, $query);
        $phase = mysqli_fetch_array($query_run);
        $query = "SELECT EchipaID FROM echipe WHERE NumeEchipa='".$_GET["sport_team1"]."'";
        $query_run = mysqli_query($connection, $query);
        $team1 = mysqli_fetch_array($query_run);
        $query = "SELECT EchipaID FROM echipe WHERE NumeEchipa='".$_GET["sport_team2"]."'";
        $query_run = mysqli_query($connection, $query);
        $team2 = mysqli_fetch_array($query_run);
        if($sport && $phase && $team1 && $team2){
            $query = "INSERT INTO meciuri (SportID, FazaID, Echipa1ID, Echipa2ID)
                VALUES('" . $sport["SportID"] . "', '" . $phase["FazaID"] . "', '" . $team1["EchipaID"] . "', '" . $team2["EchipaID"] . "')";
            mysqli_query($connection, $query);
        } else{
            echo "<script>alert(\"Competitia, faza sau echipele nu exista!\")</script>";
        }

        if(!empty($_GET["score_team1"])) {
            $query = "UPDATE meciuri
                    SET ScorEchipa1 = '".$_GET["score_team1"]."'
                    WHERE SportID='" . $sport["SportID"] . "'
                    AND FazaID='" . $phase["FazaID"] . "'
                    AND Echipa1ID='" . $team1["EchipaID"] . "'
                    AND Echipa2ID='" . $team2["EchipaID"] . "'";
            mysqli_query($connection, $query);
        }

        if(!empty($_GET["score_team2"])) {
            $query = "UPDATE meciuri
                    SET ScorEchipa2 = '".$_GET["score_team2"]."'
                    WHERE SportID='" . $sport["SportID"] . "'
                    AND FazaID='" . $phase["FazaID"] . "'
                    AND Echipa1ID='" . $team1["EchipaID"] . "'
                    AND Echipa2ID='" . $team2["EchipaID"] . "'";
            mysqli_query($connection, $query);
        }

        if(!empty($_GET["time_start"])) {
            $query = "UPDATE meciuri
                    SET OraIncepere = '".$_GET["time_start"]."'
                    WHERE SportID='" . $sport["SportID"] . "'
                    AND FazaID='" . $phase["FazaID"] . "'
                    AND Echipa1ID='" . $team1["EchipaID"] . "'
                    AND Echipa2ID='" . $team2["EchipaID"] . "'";
            mysqli_query($connection, $query);
        }

        if(!empty($_GET["time_finish"])) {
            $query = "UPDATE meciuri
                    SET OraSfarsit = '".$_GET["time_finish"]."'
                    WHERE SportID='" . $sport["SportID"] . "'
                    AND FazaID='" . $phase["FazaID"] . "'
                    AND Echipa1ID='" . $team1["EchipaID"] . "'
                    AND Echipa2ID='" . $team2["EchipaID"] . "'";
            mysqli_query($connection, $query);
        }

        if(!empty($_GET["sport_location"])) {
            $query = "UPDATE meciuri
                    SET Locatie = '".$_GET["sport_location"]."'
                    WHERE SportID='" . $sport["SportID"] . "'
                    AND FazaID='" . $phase["FazaID"] . "'
                    AND Echipa1ID='" . $team1["EchipaID"] . "'
                    AND Echipa2ID='" . $team2["EchipaID"] . "'";
            mysqli_query($connection, $query);
        }
    }

    /*---------------------------------- PHP Insert in tabel sporturi --------------------------------------------*/

    if(isset($_GET["insert_sport"])){
        if(!empty($_GET["rules"])) {
            $query = "INSERT INTO sporturi (NumeCompetitie, DataDesfasurare, Reguli, PuncteCastig, PuncteEgal)
                    VALUES('" . $_GET["sport"] . "', '" . $_GET["data"] . "', '" . $_GET["rules"] . "', '" . $_GET["win"] . "', '" . $_GET["draw"] . "')";
            mysqli_query($connection, $query);
        }
        else{
            $query = "INSERT INTO sporturi (NumeCompetitie, DataDesfasurare, Reguli, PuncteCastig, PuncteEgal)
                    VALUES('" . $_GET["sport"] . "', '" . $_GET["data"] . "', NULL, '" . $_GET["win"] . "', '" . $_GET["draw"] . "')";
            mysqli_query($connection, $query);
        }
    }

    /*---------------------------------- PHP Insert in tabel studenti --------------------------------------------*/

    if(isset($_GET["insert_student"])){
        $query = "INSERT INTO studenti (Nume, Prenume, CNP, Sex, Telefon, Email, Parola)
                VALUES('" . $_GET["surname_stud"] . "', '" . $_GET["name_stud"] . "', '" . $_GET["cnp"] . "', '" . $_GET["sex"] . "',
                '" . $_GET["telephone_stud"] . "', '" . $_GET["email_stud"] . "', '" . $_GET["password_stud"] . "')";
        mysqli_query($connection, $query);
        if(!empty($_GET["team_stud"])){
            $query = "SELECT EchipaID FROM echipe WHERE NumeEchipa='".$_GET["team_stud"]."'";
            $query_run = mysqli_query($connection, $query);
            if($team = mysqli_fetch_array($query_run)) {
                $query = "UPDATE studenti
                    SET EchipaID = ".$team["EchipaID"]."
                    WHERE CNP='" . $_GET["cnp"] . "'";
                mysqli_query($connection, $query);
            }else{
                echo "<script>alert(\"Echipa nu exista!\")</script>";
            }
        }

        if(!empty($_GET["faculty_stud"])){
            $query = "SELECT FacultateID FROM facultati WHERE NumeFacultate='".$_GET["faculty_stud"]."'";
            $query_run = mysqli_query($connection, $query);
            if($faculty = mysqli_fetch_array($query_run)) {
                $query = "UPDATE studenti
                    SET FacultateID = ".$faculty["FacultateID"]."
                    WHERE CNP='" . $_GET["cnp"] . "'";
                mysqli_query($connection, $query);
            }else{
                echo "<script>alert(\"Facultatea nu exista!\")</script>";
            }
        }

        if(!empty($_GET["date_stud"])){
            $query = "UPDATE studenti
                SET DataNasterii = '".$_GET["date_stud"]."'
                WHERE CNP='" . $_GET["cnp"] . "'";
            mysqli_query($connection, $query);
        }

        if(!empty($_GET["street_stud"])){
            $query = "UPDATE studenti
                SET Strada = '".$_GET["street_stud"]."'
                WHERE CNP='" . $_GET["cnp"] . "'";
            mysqli_query($connection, $query);
        }

        if(!empty($_GET["number_stud"])){
            $query = "UPDATE studenti
                SET Numar = '".$_GET["number_stud"]."'
                WHERE CNP='" . $_GET["cnp"] . "'";
            mysqli_query($connection, $query);
        }

        if(!empty($_GET["state_stud"])){
            $query = "UPDATE studenti
                SET Judet = '".$_GET["state_stud"]."'
                WHERE CNP='" . $_GET["cnp"] . "'";
            mysqli_query($connection, $query);
        }

        if(!empty($_GET["town_stud"])){
            $query = "UPDATE studenti
                SET Oras = '".$_GET["town_stud"]."'
                WHERE CNP='" . $_GET["cnp"] . "'";
            mysqli_query($connection, $query);
        }
    }

    ?>
    <div class="container_title">
        <h1><?php echo "Insert in tabelul ".$table;?></h1>
    </div>

    <div class="input_card">
        <?php switch($table) {
            case "echipe":?>
                <form action="insert.php" method="get">
                    <div class="column">
                        <b>Nume Echipa*</b>
                        <label><input type="text" name="team_name" required></label>
                    </div>
                    <div class="column">
                        <b>Nume Capitan</b>
                        <label><input type="text" name="team_surname_captain"></label>
                    </div>
                    <div class="column">
                        <b>Prenume Capitan</b>
                        <label><input type="text" name="team_name_captain"></label><br>
                    </div>
                    <div class="insert">
                        <button type="submit" name="insert_team">Insereaza</button>
                    </div>
                </form>
            <?php break;
            case "facultati":?>
                <form action="insert.php" method="get">
                    <div class="column">
                        <b>Facutlate*</b>
                        <label><input type="text" name="faculty" required></label>
                    </div>
                    <div class="column">
                        <b>Universitate*</b>
                        <label><input type="text" name="university" required></label>
                    </div>
                    <div class="column">
                        <b>Strada</b>
                        <label><input type="text" name="street_faculty"></label><br>
                    </div>
                    <div class="column">
                        <b>Numar</b>
                        <label><input type="text" name="number_faculty"></label><br>
                    </div>
                    <div class="column">
                        <b>Telefon*</b>
                        <label><input type="text" name="telephone_faculty" required></label><br>
                    </div>
                    <div class="column">
                        <b>Email*</b>
                        <label><input type="text" name="email_faculty" required></label>
                    </div>
                    <div class="insert">
                        <button type="submit" name="insert_faculty">Insereaza</button>
                    </div>
                </form>
            <?php break;
            case "faze":?>
                <form action="insert.php" method="get">
                    <div class="column">
                        <b>Nume*</b>
                        <label><input type="text" name="phase" required></label>
                    </div>
                    <div class="insert">
                        <br><button type="submit" name="insert_phase">Insereaza</button>
                    </div>
                </form>
            <?php break;
            case "meciuri":?>
                <form action="insert.php" method="get">
                    <div class="column">
                        <b>Nume Competitie*</b>
                        <label><input type="text" name="sport_match" required></label>
                    </div>
                    <div class="column">
                        <b>Faza*</b>
                        <label><input type="text" name="sport_phase" required></label>
                    </div>
                    <div class="column">
                        <b>Echipa1*</b>
                        <label><input type="text" name="sport_team1" required></label>
                    </div>
                    <div class="column">
                        <b>Echipa2*</b>
                        <label><input type="text" name="sport_team2" required></label>
                    </div>
                    <div class="column">
                        <b>Scor Echipa 1</b>
                        <label><input type="text" name="score_team1"></label>
                    </div>
                    <div class="column">
                        <b>Scor Echipa 2</b>
                        <label><input type="text" name="score_team2"></label>
                    </div>
                    <div class="column">
                        <b>Ora Incepere</b>
                        <label><input type="time" name="time_start"></label>
                    </div>
                    <div class="column">
                        <b>Ora Sfarsit</b>
                        <label><input type="time" name="time_finish"></label>
                    </div>
                    <div class="column">
                        <b>Locatie</b>
                        <label><input type="text" name="sport_location"></label>
                    </div>
                    <div class="insert">
                        <br><button type="submit" name="insert_match">Insereaza</button>
                    </div>
                </form>
            <?php break;
            case "sporturi":?>
                <form action="insert.php" method="get">
                    <div class="column">
                        <b>Nume Competitie*</b>
                        <label><input type="text" name="sport" required></label>
                    </div>
                    <div class="column">
                        <b>Data Desfasurare*</b>
                        <label><input type="date" name="data" required></label>
                    </div>
                    <div class="column">
                        <b>Reguli</b>
                        <label><input type="text" name="rules"></label>
                    </div>
                    <div class="column">
                        <b>Puncte Castig*</b>
                        <label><input type="text" name="win" required></label>
                    </div>
                    <div class="column">
                        <b>Puncte Egal*</b>
                        <label><input type="text" name="draw" required></label>
                    </div>
                    <div class="insert">
                        <br><button type="submit" name="insert_sport">Insereaza</button>
                    </div>
                </form>
            <?php break;
            case "studenti":?>
                <form action="insert.php" method="get">
                    <div class="column">
                        <b>Nume*</b>
                        <label><input type="text" name="surname_stud" required></label>
                    </div>
                    <div class="column">
                        <b>Prenume*</b>
                        <label><input type="text" name="name_stud" required></label>
                    </div>
                    <div class="column">
                        <b>Echipa</b>
                        <label><input type="text" name="team_stud"></label>
                    </div>
                    <div class="column">
                        <b>Facultate</b>
                        <label><input type="text" name="faculty_stud"></label>
                    </div>
                    <div class="column">
                        <b>CNP*</b>
                        <label><input type="text" name="cnp" maxlength="13" required></label>
                    </div>
                    <div class="column">
                        <b>Sex*</b>
                        <select name="sex" required>
                            <option value="F">F</option>
                            <option value="M">M</option>
                        </select>
                    </div>
                    <div class="column">
                        <b>Data Nasterii</b>
                        <label><input type="date" name="date_stud"></label>
                    </div>
                    <div class="column">
                        <b>Telefon*</b>
                        <label><input type="tel" name="telephone_stud" maxlength="10" required></label>
                    </div>
                    <div class="column">
                        <b>Strada</b>
                        <label><input type="text" name="street_stud"></label>
                    </div>
                    <div class="column">
                        <b>Numar</b>
                        <label><input type="text" name="number_stud"></label>
                    </div>
                    <div class="column">
                        <b>Judet</b>
                        <label><input type="text" name="state_stud"></label>
                    </div>
                    <div class="column">
                        <b>Oras</b>
                        <label><input type="text" name="town_stud"></label>
                    </div>
                    <div class="column">
                        <b>Email*</b>
                        <label><input type="text" name="email_stud" required></label>
                    </div>
                    <div class="column">
                        <b>Parola*</b>
                        <label><input type="text" name="password_stud" required></label>
                    </div>
                    <div class="insert">
                        <br><button type="submit" name="insert_student">Insereaza</button>
                    </div>
                </form>
            <?php break;
        }?>

    </div>

    <div class="card">
        <?php
        switch($table) {
            case "echipe":      $query = "SELECT E.EchipaID, S.Nume 'Nume Capitan', S.Prenume 'Prenume Capitan', E.NumeEchipa 'Nume Echipa', E.PuncteFotbal 'Puncte Football'
                                        FROM echipe E
                                        LEFT JOIN studenti S ON S.StudentID = E.CapitanID";
                                break;
            case "studenti":    $query = "SELECT S.StudentID, S.Nume, S.Prenume, E.NumeEchipa Echipa, F.NumeFacultate Facultate, S.Email, S.CNP, S.Sex, S.DataNasterii, S.Telefon, S.Strada, S.Numar, S.Judet, S.Oras
                                        FROM studenti S
                                        LEFT JOIN echipe E ON S.EchipaID = E.EchipaID
                                        LEFT JOIN facultati F ON S.FacultateID = F.FacultateID";
                                break;
            case "facultati":   $query = "SELECT * FROM facultati";
                                break;
            case "faze":        $query = "SELECT * FROM faze";
                                break;
            case "meciuri":     $query = "SELECT M.MeciID, S.NumeCompetitie, F.Nume AS Faza, E1.NumeEchipa AS Echipa1, E2.NumeEchipa AS Echipa2, M.ScorEchipa1, M.ScorEchipa2, M.OraIncepere, M.OraSfarsit, M.Locatie
                                        FROM meciuri M
                                        LEFT JOIN sporturi S ON M.SportID = S.SportID
                                        LEFT JOIN faze F ON M.FazaID = F.FazaID
                                        LEFT JOIN echipe E1 ON M.Echipa1ID = E1.EchipaID
                                        LEFT JOIN echipe E2 ON M.Echipa2ID = E2.EchipaID";
                                break;
            case "sporturi":    $query = "SELECT * FROM sporturi";
                                break;
            default:            header("Location: http://localhost/StudentsLeague/admin.php");
                                exit();

        }
        $query_run = mysqli_query($connection,$query);
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
    <?php
}
else{
    header("Location: http://localhost/StudentsLeague/login.php");
    exit();
}
?>

</body>
</html>