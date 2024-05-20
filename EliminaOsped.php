<?php
include 'dbManager.php';
include 'DBconn.php';

$Codice = "";
if (count($_POST) > 0) {
    $Codice = $_POST["codice"];
} else if (count($_GET) > 0) {
    $Codice = $_GET["codice"];
}
if (is_null($Codice) || $Codice == "")
    return "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Se il modulo è stato inviato tramite POST, conferma l'eliminazione e procedi
    if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'yes') {
        $qry = "DELETE FROM Ospedale WHERE ";
        if ($Codice != "") {
            $qry .= "Ospedale.codice = '" . $Codice . "';";
            $qry .= " DELETE FROM Ricovero WHERE ";
            $qry .= "Ricovero.codOspedale = '" . $Codice . "';";
        }

        $result = executeQuery($qry);

        if (!$result) {
            echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
            $error = true;
            echo ("<script>alert(" . $e->getMessage() . ")</script>");

            echo ("ecco la " . $qry);
            echo $qry;
        } else {
            header("Location: ospedale.php");
            exit(); // Termina lo script dopo il reindirizzamento
        }
    } else {
        // Se l'utente non ha confermato l'eliminazione, reindirizza indietro
        header("Location: ospedale.php");
        exit(); // Termina lo script dopo il reindirizzamento
    }
}

// Se il modulo non è stato inviato tramite POST, visualizza il messaggio di conferma
?>
<!DOCTYPE html>

<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferma eliminazione</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="script.js"></script>


</head>

<body>



    <div class="container">
        <div class="contenuto">
            <div class="ce">
                <h2>Conferma Eliminazione</h2>
                <p>Sei sicuro di voler eliminare questo record?</p>
                <form method="post">
                    <input type="hidden" name="codice" value="<?php echo $Codice; ?>">
                    <input type="hidden" name="confirm_delete" value="yes">
                    <button type="submit">Sì, Elimina</button>
                    <button type="submit"> <a href="ospedale.php">Annulla</a></button>

                </form>
            </div>

        </div>
    </div>

</body>

</html>