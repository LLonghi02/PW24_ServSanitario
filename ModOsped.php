<!DOCTYPE HTML>
<html lang="it">

<head>
    <title>Modifica Ospedale</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include 'header.html';
    include 'nav.html';
    include 'footer.html';
    include 'dbManager.php';
    include 'DBconn.php';
    ?>

    <div class="container">
        <div class="filtro">
            <h3>Effettua le tue ricerche <img class="lente" src="Icone/lente.png" /></h3>
            <form name="myform" method="POST">
                <input id="codice" name="codice" type="text" placeholder="Codice" /><br />
                <input id="nome" name="nome" type="text" placeholder="Nome" /><br />
                <input id="città" name="città" type="text" placeholder="Città" /><br />
                <input id="indirizzo" name="indirizzo" type="text" placeholder="Indirizzo" /><br />
                <input id="direttoreSanitario" name="direttoreSanitario" type="text"
                    placeholder="Direttore sanitario" /><br />
                <input type="submit" name="submitRicerca" value="Cerca" />
            </form>
            <br>
            <p><img class="lente" src="Icone/freccia.png" />
                <?php
                // Questo è il codice PHP per tornare alla pagina precedente con un link "Torna indietro"
                echo '<a href="javascript:history.go(-1)">Torna indietro</a>';
                ?>
            </p>

        </div>
        <div class="contenuto">

            <?php
            $error = false;

            $codice = "";
            $nome = "";
            $indirizzo = "";
            $citta = "";
            $direttoreSanitario = "";
            if (count($_POST) > 0) {
                $codice = $_POST["codice"];
                $nome = $_POST["nome"];
                $indirizzo = $_POST["indirizzo"];
                $citta = $_POST["città"];
                $direttoreSanitario = $_POST["direttoreSanitario"];

                $qryCheck = "SELECT direttoreSanitario FROM Ospedale WHERE codice = '$codice'";
                $resultCheck = executeQuery($qryCheck);


                 $row = $resultCheck->fetch(PDO::FETCH_ASSOC);
                 $oldDirector = $row['direttoreSanitario'];
                 
                    if ($direttoreSanitario != $oldDirector) {
                        if (!existDirettore($direttoreSanitario)) {
                            echo "<script>alert('Direttore sanitario non valido!')</script>";
                        } else {
                            if (!noDoubleDir($direttoreSanitario)) {
                                echo "<script>alert('Direttore gia di un altro ospedale')</script>";
                            }
                        }
                    }
                    else{
                        $query = setOs($codice, $nome, $indirizzo, $citta, $direttoreSanitario);
                        try {
                            $result = $conn->query($query);
                            echo    "<script>
                                        alert('Modifica andata a buon fine');
                                        window.location.href = 'ospedale.php';
                                    </script>";

                        } catch (PDOException $e) {
                            $error = true;
                        }
                        if (!$error) {
                            exit(); //Termina lo script dopo il reindirizzamento
                        }
                    }

            } else if (count($_GET) > 0) {
                $codice = $_GET["codice"];
            }

            $query = getOspedale($codice, $nome = "", $citta = "", $indirizzo = "", $direttoreSanitario = "");

            try {
                $result = $conn->query($query);
            } catch (PDOException $e) {
                $error = true;
            }

            ?>
            <form name="myform" method="POST">
                <table class="smalltable">
                    <tr class="header">
                        <th>Codice</th>
                        <th>Nome</th>
                        <th>Città</th>
                        <th>Indirizzo</th>
                        <th>Direttore Sanitario</th>
                    </tr>
                    <?php
                    $i = 0;
                    foreach ($result as $riga) {
                        $i = $i + 1;
                        $classRiga = 'class="rowOdd"';
                        if ($i % 2 == 0) {
                            $classRiga = 'class="rowEven"';
                        }
                        $codice = $riga["codice"];
                        $nome = $riga["nome"];
                        $indirizzo = $riga["indirizzo"];
                        $citta = $riga["città"];
                        $direttoreSanitario = $riga["direttoreSanitario"];
                        ?>

                        <tr <?php echo $classRiga; ?>>
                            <td> <input id="codice" name="codice" type="text" value=<?php echo $codice; ?> readonly /> </td>
                            <td> <input id="nome" name="nome" type="text" value=<?php echo $nome; ?> /> </td>
                            <td> <input id="città" name="città" type="text" placeholder="Città"
                                    value='<?php echo $citta; ?>' /> </td>
                            <td> <input id="indirizzo" name="indirizzo" type="text" placeholder="Indirizzo"
                                    value='<?php echo $indirizzo ?>' /> </td>
                            <td> <input id="direttoreSanitario" name="direttoreSanitario" type="text"
                                    placeholder="Direttore Sanitario" value=<?php echo $direttoreSanitario ?> /> </td>
                        </tr>
                    <?php } ?>
                </table>
                <br>
                <input type="submit" value="Applica modifiche" />
            </form>
        </div>
    </div>
    </div>
</body>

</html>