<html lang="ro">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style_body.css">
    <link rel="stylesheet" type="text/css" href="style_delete.css">
    <link rel="stylesheet" type="text/css" href="style_table.css">
    <link rel="icon" href="images/students_league.ico">
</head>
<body>

<?php
include "connection.php";
include "nav_bar.php";

if($_SESSION["admin"]) {
    $table = $_SESSION["table"];

    /*---------------------------------- Stergere element din tabelul $table --------------------------------------------*/

    if(isset($_GET["delete_submit"])){
        switch($table) {
            case "echipe":      $query = "DELETE FROM echipe WHERE EchipaID='".$_GET["delete"]."'";
                break;
            case "studenti":    $query = "DELETE FROM studenti WHERE StudentID='".$_GET["delete"]."'";
                break;
            case "facultati":   $query = "DELETE FROM facultati WHERE FacultateID='".$_GET["delete"]."'";
                break;
            case "faze":        $query = "DELETE FROM faze WHERE FazaID='".$_GET["delete"]."'";
                break;
            case "meciuri":     $query = "DELETE FROM meciuri WHERE MeciID='".$_GET["delete"]."'";
                break;
            case "sporturi":    $query = "DELETE FROM sporturi WHERE SportID='".$_GET["delete"]."'";
                break;
            default: echo "<script>alert(\"Nu exista tabelul!\")</script>";

        }
        mysqli_query($connection, $query);
    }

    ?>
    <div class="container_title">
        <h1><?php echo "Stergere element din tabelul ".$table;?></h1>
    </div>

    <div class="input_card">
        <form action="delete.php" method="get">
            <div class="column">
                <b>Alege ID-ul*</b>
                <label><input type="text" name="delete" required></label>
            </div>
            <br><button type="submit" name="delete_submit">Sterge</button>
        </form>
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
