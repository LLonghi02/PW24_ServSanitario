<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Servizio sanitario Ospedale</title>
        <link rel="stylesheet" href="style.css" />
        <script type="text/javascript" src="jquery-2.0.0.js"></script>
        <script type="text/javascript" src="script.js"></script>
        <script type="text/javascript" src="dynamic.js"></script>

    </head>

    <body onload="setTitoloOspedale()">
        <?php
        include 'header.html';
        include 'nav.html';
        include 'footer.html';
        include 'dbManager.php';
        ?>

        <div class="container">
            <div class="filtro">
                <h3>Effettua le tue ricerche <img class="lente" src="Icone/lente.png" /></h3>
                <form name="myform" method="POST">
                    <input id="codice" name="codice" type="text" placeholder="Codice" pattern="COD\d{3}" title="Inserisci un codice valido: COD+3 cifre numeriche" /><br />
                    <input id="nome" name="nome" type="text" placeholder="Nome" /><br />
                    <input id="città" name="città" type="text" placeholder="Città" /><br />
                    <input id="indirizzo" name="indirizzo" type="text" placeholder="Indirizzo" /><br />
                    <input id="direttoreSanitario" name="direttoreSanitario" type="text"
                        placeholder="Direttore sanitario" pattern="CSSN\d{3}" title="Inserisci un CSSN valido: CSSN+3 cifre numeriche"/><br />
                    <input type="submit" name="submitRicerca" value="Cerca" />
                </form>

                <h3>Inserisci un nuovo ospedale</h3>
                <form name="insertOsp" method="POST" onsubmit="return controlloInserimento()">
                    <input type="text" id="nomeIns" name="nomeIns" placeholder="Nome" /><br />
                    <input type="text" id="cittàIns" name="cittàIns" placeholder="Città" /><br />
                    <input type="text" id="indirizzoIns" name="indirizzoIns" placeholder="Indirizzo" /><br />
                    <input type="text" id="direttoreSanitarioIns" name="direttoreSanitarioIns"
                        placeholder="Direttore sanitario" pattern="CSSN\d{3}" title="Inserisci un CSSN valido: CSSN+3 cifre numeriche"/><br />

                    <input type="submit" name="submitIns" value="Inserisci" />
                </form>
                <p><img class="lente" src="Icone/freccia.png" />
                    <?php
                    // Questo è il codice PHP per tornare alla pagina precedente con un link "Torna indietro"
                    echo '<a href="javascript:history.go(-1)">Torna indietro</a>';
                    ?>
                </p>

            </div>

            <div class="contenuto">
                <?php
                $codice = "";
                $nome = "";
                $citta = "";
                $indirizzo = "";
                $direttoreSanitario = "";

                if (count($_POST) > 0) {
                    $codice = $_POST["codice"];
                    $nome = $_POST["nome"];
                    $citta = $_POST["città"];
                    $indirizzo = $_POST["indirizzo"];
                    $direttoreSanitario = $_POST["direttoreSanitario"];

                    if (isset($_POST["submitRicerca"])) {
                        $codice = $_POST["codice"];
                        $nome = $_POST["nome"];
                        $citta = $_POST["città"];
                        $indirizzo = $_POST["indirizzo"];
                        $direttoreSanitario = $_POST["direttoreSanitario"];

                        $query = getOspedale($codice, $nome, $citta, $indirizzo, $direttoreSanitario);
                
                        $result = executeQuery($query);

                        stampaResOsp($result);
                    } elseif (isset($_POST["submitIns"])) {
                        $nome = $_POST["nomeIns"];
                        $citta = $_POST["cittàIns"];
                        $indirizzo = $_POST["indirizzoIns"];
                        $direttoreSanitario = $_POST["direttoreSanitarioIns"];

                        $query = insertOspedale($nome, $citta, $indirizzo, $direttoreSanitario);
                
                        $result = executeQuery($query);

                        if ($result) {
                            echo "<p>Inserimento avvenuto con successo</p>";

                            $codice = "";

                            $query = getOspedale($codice, $nome, $citta, $indirizzo, $direttoreSanitario);
                
                            $result = executeQuery($query);

                            stampaResOsp($result);
                        } else {
                            echo "<p>Inserimento fallito</p>";
                        }
                    }

                } else if (count($_GET) > 0) {
                    $codice = $_GET["codice"];
                    $nome = $_GET["nome"];
                    $citta = $_GET["città"];
                    $indirizzo = $_GET["indirizzo"];
                    $direttoreSanitario = $_GET["direttoreSanitario"];

                    $query = getOspedale($codice, $nome, $citta, $indirizzo, $direttoreSanitario);
                
                    $result = executeQuery($query);

                    stampaResOsp($result);

                    cittadiniOspedali($codice);
                } else {
                    $query = getOspedale("", "", "", "", "");
                
                    $result = executeQuery($query);

                    stampaResOsp($result);
                }

                ?>
            </div>
        </div>
    </body>
</html>