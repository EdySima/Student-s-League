<html lang="ro">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style_body.css">
    <link rel="stylesheet" type="text/css" href="style_update.css">
    <link rel="stylesheet" type="text/css" href="style_table.css">
    <link rel="icon" href="images/students_league.ico">
</head>
<body>

<?php
include "connection.php";
include "nav_bar.php";

if($_SESSION["admin"]) {
    $table = $_SESSION["table"];

    /*---------------------------------- Update tabel echipe--------------------------------------------*/

    if(isset($_GET["modify_echipe"])){
        if(!empty($_GET["team"])){
            if (!empty($_GET["team_surname_captain"]) && !empty($_GET["team_name_captain"])) {
                $query = "SELECT StudentID FROM studenti WHERE Nume='" . $_GET["team_surname_captain"] . "' AND Prenume='" . $_GET["team_name_captain"] . "'";
                $query_run = mysqli_query($connection, $query);
                if ($row = mysqli_fetch_array($query_run)) {
                    $id_student = $row["StudentID"];
                    $query = "UPDATE echipe SET CapitanID=" . $id_student . " WHERE EchipaID='" . $_GET["team"] . "'";
                    mysqli_query($connection, $query);
                } else {
                    echo "<script>alert(\"Studentul nu a fost gasit!\")</script>";
                }
            }
            if (!empty($_GET["team_name"])) {
                $query = "UPDATE echipe SET NumeEchipa ='" . $_GET["team_name"] . "' WHERE EchipaID='" . $_GET["team"] . "'";
                mysqli_query($connection, $query);
            }
        }
        else{
            echo "<script>alert(\"Nu ai ales linia!\")</script>";
        }
    }

    /*---------------------------------- Update tabel facultati--------------------------------------------*/

    if(isset($_GET["modify_faculty"])) {
        if(!empty($_GET["faculty"])){
            $query = "UPDATE facultati SET NumeFacultate='" . $_GET["faculty"] . "' WHERE FacultateID='" . $_GET["idfaculty"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["university"])){
            $query = "UPDATE facultati SET Universitate='" . $_GET["university"] . "' WHERE FacultateID='" . $_GET["idfaculty"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["street_faculty"])){
            $query = "UPDATE facultati SET StradaFacultate='" . $_GET["street_faculty"] . "' WHERE FacultateID='" . $_GET["idfaculty"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["number_faculty"])){
            $query = "UPDATE facultati SET NumarFacultate='" . $_GET["number_faculty"] . "' WHERE FacultateID='" . $_GET["idfaculty"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["telephone_faculty"])){
            $query = "UPDATE facultati SET TelefonFacultate='" . $_GET["telephone_faculty"] . "' WHERE FacultateID='" . $_GET["idfaculty"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["email_faculty"])){
            $query = "UPDATE facultati SET EmailFacultate='" . $_GET["email_faculty"] . "' WHERE FacultateID='" . $_GET["idfaculty"] . "'";
            mysqli_query($connection, $query);
        }

    }

/*---------------------------------- Update tabel faze --------------------------------------------*/

    if(isset($_GET["modify_phase"])) {
        if(!empty($_GET["phase"])){
            $query = "UPDATE faze SET Nume='" . $_GET["phase"] . "' WHERE FazaID='" . $_GET["idphase"] . "'";
            mysqli_query($connection, $query);
        }
    }

    /*---------------------------------- Update tabel meciuri --------------------------------------------*/

    if(isset($_GET["modify_match"])) {
        if(!empty($_GET["sport_match"])){
            $query = "SELECT SportID FROM sporturi WHERE NumeCompetitie='".$_GET["sport_match"]."'";
            $query_run = mysqli_query($connection, $query);
            if($sport = mysqli_fetch_array($query_run)) {
                $query = "UPDATE meciuri SET SportID='" . $sport["SportID"] . "' WHERE MeciID='" . $_GET["id_sport_match"] . "'";
                mysqli_query($connection, $query);
            }
            else
                echo "<script>alert(\"Nu s-a gasit competitia!\")</script>";
        }
        if(!empty($_GET["sport_phase"])){
            $query = "SELECT FazaID FROM faze WHERE Nume='".$_GET["sport_phase"]."'";
            $query_run = mysqli_query($connection, $query);
            if($phase = mysqli_fetch_array($query_run)) {
                $query = "UPDATE meciuri SET FazaID='" . $phase["FazaID"] . "' WHERE MeciID='" . $_GET["id_sport_match"] . "'";
                mysqli_query($connection, $query);
            }
            else
                echo "<script>alert(\"Nu s-a gasit faza!\")</script>";
        }
        if(!empty($_GET["sport_team1"])){
            $query = "SELECT EchipaID FROM echipe WHERE NumeEchipa='".$_GET["sport_team1"]."'";
            $query_run = mysqli_query($connection, $query);
            if($team1 = mysqli_fetch_array($query_run)) {
                $query = "UPDATE meciuri SET Echipa1ID='" . $team1["EchipaID"] . "' WHERE MeciID='" . $_GET["id_sport_match"] . "'";
                mysqli_query($connection, $query);
            }
            else
                echo "<script>alert(\"Nu s-a gasit echipa 1!\")</script>";
        }
        if(!empty($_GET["sport_team2"])){
            $query = "SELECT EchipaID FROM echipe WHERE NumeEchipa='".$_GET["sport_team2"]."'";
            $query_run = mysqli_query($connection, $query);
            if($team2 = mysqli_fetch_array($query_run)) {
                $query = "UPDATE meciuri SET Echipa2ID='" . $team2["EchipaID"] . "' WHERE MeciID='" . $_GET["id_sport_match"] . "'";
                mysqli_query($connection, $query);
            }
            else
                echo "<script>alert(\"Nu s-a gasit echipa 2!\")</script>";
        }
        if(!empty($_GET["score_team1"])){
            $query = "UPDATE meciuri SET ScorEchipa1='" . $_GET["score_team1"] . "' WHERE MeciID='" . $_GET["id_sport_match"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["score_team2"])){
            $query = "UPDATE meciuri SET ScorEchipa2='" . $_GET["score_team2"] . "' WHERE MeciID='" . $_GET["id_sport_match"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["time_start"])){
            $query = "UPDATE meciuri SET OraIncepere='" . $_GET["time_start"] . "' WHERE MeciID='" . $_GET["id_sport_match"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["time_finish"])){
            $query = "UPDATE meciuri SET OraSfarsit='" . $_GET["time_finish"] . "' WHERE MeciID='" . $_GET["id_sport_match"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["sport_location"])){
            $query = "UPDATE meciuri SET Locatie='" . $_GET["sport_location"] . "' WHERE MeciID='" . $_GET["id_sport_match"] . "'";
            mysqli_query($connection, $query);
        }
    }

    /*---------------------------------- Update tabel sporturi --------------------------------------------*/

    if(isset($_GET["modify_sport"])) {
        if(!empty($_GET["sport"])){
            $query = "UPDATE sporturi SET NumeCompetitie='" . $_GET["sport"] . "' WHERE SportID='" . $_GET["idsport"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["data"])){
            $query = "UPDATE sporturi SET DataDesfasurare='" . $_GET["data"] . "' WHERE SportID='" . $_GET["idsport"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["rules"])){
            $query = "UPDATE sporturi SET Reguli='" . $_GET["rules"] . "' WHERE SportID='" . $_GET["idsport"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["win"])){
            $query = "UPDATE sporturi SET PuncteCastig='" . $_GET["win"] . "' WHERE SportID='" . $_GET["idsport"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["draw"])){
            $query = "UPDATE sporturi SET PuncteEgal='" . $_GET["draw"] . "' WHERE SportID='" . $_GET["idsport"] . "'";
            mysqli_query($connection, $query);
        }

    }

    /*---------------------------------- Update tabel studenti --------------------------------------------*/

    if(isset($_GET["modify_student"])) {
        if(!empty($_GET["surname_stud"])){
            $query = "UPDATE studenti SET Nume='" . $_GET["surname_stud"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["name_stud"])){
            $query = "UPDATE studenti SET Prenume='" . $_GET["name_stud"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["team_stud"])){
            $query = "SELECT EchipaID FROM echipe WHERE NumeEchipa='".$_GET["team_stud"]."'";
            $query_run = mysqli_query($connection, $query);
            if($team = mysqli_fetch_array($query_run)) {
                $query = "UPDATE studenti SET EchipaID='" . $team["EchipaID"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
                mysqli_query($connection, $query);
            }
            else
                echo "<script>alert(\"Nu s-a gasit echipa!\")</script>";
        }
        if(!empty($_GET["faculty_stud"])){
            $query = "SELECT FacultateID FROM facultati WHERE NumeFacultate='".$_GET["faculty_stud"]."'";
            $query_run = mysqli_query($connection, $query);
            if($faculty = mysqli_fetch_array($query_run)) {
                $query = "UPDATE studenti SET FacultateID='" . $faculty["FacultateID"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
                mysqli_query($connection, $query);
            }
            else
                echo "<script>alert(\"Nu s-a gasit facultatea!\")</script>";
        }
        if(!empty($_GET["cnp"])){
            $query = "UPDATE studenti SET CNP='" . $_GET["cnp"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["sex"])){
            $query = "UPDATE studenti SET Sex='" . $_GET["sex"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["date_stud"])){
            $query = "UPDATE studenti SET DataNasterii='" . $_GET["date_stud"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["telephone_stud"])){
            $query = "UPDATE studenti SET Telefon='" . $_GET["telephone_stud"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["street_stud"])){
            $query = "UPDATE studenti SET Strada='" . $_GET["street_stud"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["number_stud"])){
            $query = "UPDATE studenti SET Numar='" . $_GET["number_stud"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["state_stud"])){
            $query = "UPDATE studenti SET Judet='" . $_GET["state_stud"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["town_stud"])){
            $query = "UPDATE studenti SET Oras='" . $_GET["town_stud"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["email_stud"])){
            $query = "UPDATE studenti SET Email='" . $_GET["email_stud"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
        if(!empty($_GET["password_stud"])){
            $query = "UPDATE studenti SET Parola='" . $_GET["password_stud"] . "' WHERE StudentID='" . $_GET["idstud"] . "'";
            mysqli_query($connection, $query);
        }
    }

    if(isset($_GET["btn_football"])) {
        $table = "echipe";
        $query = "SELECT NumeEchipa FROM echipe";
        $query_run_teams = mysqli_query($connection,$query);
        $nr_echipe = mysqli_num_rows($query_run_teams);
        for($index = 0; $index < $nr_echipe; $index++) {
            $puncte = 0;
            $nume_echipa = mysqli_fetch_array($query_run_teams);
            $query = "SELECT SUM(S.PuncteCastig) AS Puncte
                    FROM meciuri M
                    JOIN sporturi S ON M.SportID = S.SportID
                    JOIN faze F ON M.FazaID = F.FazaID
                    JOIN echipe E1 ON M.Echipa1ID = E1.EchipaID
                    JOIN echipe E2 ON M.Echipa2ID = E2.EchipaID
                    WHERE ((E1.NumeEchipa = '".$nume_echipa["NumeEchipa"]."' AND M.ScorEchipa1>M.ScorEchipa2)
                    OR (E2.NumeEchipa = '".$nume_echipa["NumeEchipa"]."' AND M.ScorEchipa1<M.ScorEchipa2))
                    AND F.Nume = 'Preliminarii' AND S.NumeCompetitie = 'Football'";
            $query_run = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($query_run);
            if($row["Puncte"])
                $puncte += $row["Puncte"];

            $query = "SELECT SUM(S.PuncteEgal) AS Puncte
                    FROM meciuri M
                    JOIN sporturi S ON M.SportID = S.SportID
                    JOIN faze F ON M.FazaID = F.FazaID
                    JOIN echipe E1 ON M.Echipa1ID = E1.EchipaID
                    JOIN echipe E2 ON M.Echipa2ID = E2.EchipaID
                    WHERE ((E1.NumeEchipa = '".$nume_echipa["NumeEchipa"]."' AND M.ScorEchipa1=M.ScorEchipa2)
                    OR (E2.NumeEchipa = '".$nume_echipa["NumeEchipa"]."' AND M.ScorEchipa1=M.ScorEchipa2))
                    AND F.Nume = 'Preliminarii' AND S.NumeCompetitie = 'Football'";
            $query_run = mysqli_query($connection, $query);
            $row = mysqli_fetch_array($query_run);
            if($row["Puncte"])
                $puncte += $row["Puncte"];

            $query = "UPDATE echipe SET PuncteFotbal=".$puncte." WHERE NumeEchipa='".$nume_echipa["NumeEchipa"]."'";
            mysqli_query($connection, $query);
        }
    }
    ?>
    <div class="container_title">
        <h1><?php echo "Update tabel ".$table;?></h1>
    </div>

    <div class="input_card">
        <?php switch($table) {
        case "echipe":?>
            <form action="update.php" method="get">
                <div class="column">
                    <b>ID-ul echipei pentru modificare*</b>
                    <label><input type="text" name="team" required></label>
                </div>
                <div class="column">
                    <b>Nume nou echipa</b>
                    <label><input type="text" name="team_name"></label>
                </div>
                <div class="column">
                    <b>Nume capitan nou</b>
                    <label><input type="text" name="team_surname_captain"></label><br>
                </div>
                <div class="column">
                    <b>Preume capitan nou</b>
                    <label><input type="text" name="team_name_captain"></label><br>
                </div>
                <div class="update">
                    <br><button type="submit" name="modify_echipe">Aplica</button>
                </div>
            </form>
            <div class="update">
                <form action="update.php" method="get">
                    <button id="prelim_football" type="submit" name="btn_football">Puncte Preliminarii Football</button>
                </form>
            </div>
            <?php break;
        case "facultati":?>
            <form action="update.php" method="get">
                <div class="column">
                    <b>ID-ul facultatii pentru modificare*</b>
                    <label><input type="text" name="idfaculty" required></label>
                </div>
                <div class="column">
                    <b>Nume nou facutlate</b>
                    <label><input type="text" name="faculty"></label>
                </div>
                <div class="column">
                    <b>Nume nou universitate</b>
                    <label><input type="text" name="university"></label>
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
                    <b>Telefon</b>
                    <label><input type="text" name="telephone_faculty"></label><br>
                </div>
                <div class="column">
                    <b>Email</b>
                    <label><input type="text" name="email_faculty"></label>
                </div>
                <div class="insert">
                    <button type="submit" name="modify_faculty">Aplica</button>
                </div>
            </form>
        <?php break;
            case "faze":?>
                <form action="update.php" method="get">
                    <div class="column">
                        <b>ID-ul fazei pentru modificare*</b>
                        <label><input type="text" name="idphase" required></label>
                    </div>
                    <div class="column">
                        <b>Nume nou</b>
                        <label><input type="text" name="phase"></label>
                    </div>
                    <div class="insert">
                        <br><button type="submit" name="modify_phase">Aplica</button>
                    </div>
                </form>
            <?php break;
        case "meciuri":?>
            <form action="update.php" method="get">
                <div class="column">
                    <b>ID-ul meciului pentru modificare*</b>
                    <label><input type="text" name="id_sport_match" required></label>
                </div>
                <div class="column">
                    <b>Nume Competitie</b>
                    <label><input type="text" name="sport_match"></label>
                </div>
                <div class="column">
                    <b>Faza</b>
                    <label><input type="text" name="sport_phase" ></label>
                </div>
                <div class="column">
                    <b>Echipa1</b>
                    <label><input type="text" name="sport_team1" ></label>
                </div>
                <div class="column">
                    <b>Echipa2</b>
                    <label><input type="text" name="sport_team2" ></label>
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
                    <br><button type="submit" name="modify_match">Aplica</button>
                </div>
            </form>
            <?php break;
        case "sporturi":?>
            <form action="update.php" method="get">
                <div class="column">
                    <b>ID-ul sportului pentru modificare*</b>
                    <label><input type="text" name="idsport" required></label>
                </div>
                <div class="column">
                    <b>Nume Competitie</b>
                    <label><input type="text" name="sport" ></label>
                </div>
                <div class="column">
                    <b>Data Desfasurare</b>
                    <label><input type="date" name="data" ></label>
                </div>
                <div class="column">
                    <b>Reguli</b>
                    <label><input type="text" name="rules" ></label>
                </div>
                <div class="column">
                    <b>Puncte Castig</b>
                    <label><input type="text" name="win" ></label>
                </div>
                <div class="column">
                    <b>Puncte Egal</b>
                    <label><input type="text" name="draw" ></label>
                </div>
                <div class="insert">
                    <br><button type="submit" name="modify_sport">Aplica</button>
                </div>
            </form>
            <?php break;
        case "studenti":?>
            <form action="update.php" method="get">
                <div class="column">
                    <b>ID-ul studentului pentru modificare*</b>
                    <label><input type="text" name="idstud" required></label>
                </div>
                <div class="column">
                    <b>Nume</b>
                    <label><input type="text" name="surname_stud"></label>
                </div>
                <div class="column">
                    <b>Prenume</b>
                    <label><input type="text" name="name_stud"></label>
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
                    <b>CNP</b>
                    <label><input type="text" name="cnp" maxlength="13"></label>
                </div>
                <div class="column">
                    <b>Sex</b>
                    <select name="sex">
                        <option value="F">F</option>
                        <option value="M">M</option>
                    </select>
                </div>
                <div class="column">
                    <b>Data Nasterii</b>
                    <label><input type="date" name="date_stud"></label>
                </div>
                <div class="column">
                    <b>Telefon</b>
                    <label><input type="tel" name="telephone_stud" maxlength="10"></label>
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
                    <b>Email</b>
                    <label><input type="text" name="email_stud"></label>
                </div>
                <div class="column">
                    <b>Parola</b>
                    <label><input type="text" name="password_stud"></label>
                </div>
                <div class="insert">
                    <br><button type="submit" name="modify_student">Aplica</button>
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