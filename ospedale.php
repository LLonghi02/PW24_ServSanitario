<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servizio sanitario Ospedale</title>
    <link rel="stylesheet" href="style.css" />
    <script type="text/javascript" src="jquery-2.0.0.js"></script>
	<script type="text/javascript" src="script.js"></script>

     <script type="text/javascript">
        let currentField = '';

        function mostraPopup() {
            document.getElementById('popup').style.display = 'block';
        }

        function apriPopup(fieldId) {
            currentField = fieldId;
            const fromDirettoreSanitarioInsField = document.getElementById('fromDirettoreSanitarioIns');
            fromDirettoreSanitarioInsField.value = (fieldId === 'direttoreSanitarioIns') ? '1' : '';
            mostraPopup();
        }

        function selezionaCSSN(selectElement) {
            const selectedCSSN = selectElement.value;
            if (selectedCSSN) {
                document.getElementById(currentField).value = selectedCSSN;
            }
            document.getElementById('popup').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('formRicerca').addEventListener('submit', function (event) {
                event.preventDefault();
                const nome = document.getElementById('nomeRicerca').value;
                const cognome = document.getElementById('cognomeRicerca').value;
                const fromDirettoreSanitarioIns = document.getElementById('fromDirettoreSanitarioIns').value;

                // AJAX request to fetch CSSN results
                $.ajax({
                    url: 'cerca.php',
                    type: 'POST',
                    data: { nome: nome, cognome: cognome, fromDirettoreSanitarioIns: fromDirettoreSanitarioIns },
                    success: function (data) {
                        if (data.includes('<option')) {
                            const selectHTML = '<select id="cssnSelect" onchange="selezionaCSSN(this)"><option value="" disabled selected>Seleziona direttore</option>' + data + '</select>';
                            document.getElementById('cssnSelectContainer').innerHTML = selectHTML;
                        } else {
                            document.getElementById('cssnSelectContainer').innerHTML = '<p>' + data + '</p>';
                        }
                    },
                    error: function () {
                        document.getElementById('cssnSelectContainer').innerHTML = '<p>Errore nella ricerca</p>';
                    }
                });
            });
        });
    </script>
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
            <form name="myform" id="myform" method="POST">
                <input id="codice" name="codice" type="text" placeholder="Codice" pattern="COD\d{3}" title="Inserisci un codice valido: COD+3 cifre numeriche" /><br />
                <input id="nome" name="nome" type="text" placeholder="Nome" /><br />
                <input id="città" name="città" type="text" placeholder="Città" /><br />
                <input id="indirizzo" name="indirizzo" type="text" placeholder="Indirizzo" /><br />
                <input id="direttoreSanitario" name="direttoreSanitario" type="text" placeholder="Direttore sanitario" onclick="apriPopup('direttoreSanitario')" readonly />
                <input type="submit" name="submitRicerca" value="Cerca" />
            </form>

            <h3>Inserisci un nuovo ospedale</h3>
            <form name="insertOsp" id="insertOsp" method="POST" onsubmit="return controlloInserimento()">
                <input type="text" id="nomeIns" name="nomeIns" placeholder="Nome" /><br />
                <input type="text" id="cittàIns" name="cittàIns" placeholder="Città" /><br />
                <input type="text" id="indirizzoIns" name="indirizzoIns" placeholder="Indirizzo" /><br />
                <input type="text" id="direttoreSanitarioIns" name="direttoreSanitarioIns" placeholder="Direttore sanitario" onclick="apriPopup('direttoreSanitarioIns')" readonly /><br />
                <input type="submit" name="submitIns" value="Inserisci" />
            </form>
            <p><img class="lente" src="Icone/freccia.png" />
                <?php
                echo '<a href="javascript:history.go(-1)">Torna indietro</a>';
                ?>
            </p>
        </div>

        <div id="popup" class="popup">
            <div class="popup-content">
                <h2>Cerca direttore sanitario</h2>
                <form id="formRicerca" method="POST">
                    <input type="text" id="nomeRicerca" name="nome" placeholder="Nome">
                    <input type="text" id="cognomeRicerca" name="cognome" placeholder="Cognome">
                    <input type="hidden" id="fromDirettoreSanitarioIns" name="fromDirettoreSanitarioIns" value="">
                    <input type="submit" value="Cerca">
                </form>
                <div id="cssnSelectContainer"></div>
            </div>
        </div>

       <div class="contenuto">
            <?php
            $codice = "";
            $nome = "";
            $citta = "";
            $indirizzo = "";
            $direttoreSanitario = "";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                        $query = getOspedale("", $nome, $citta, $indirizzo, $direttoreSanitario);
                        $result = executeQuery($query);
                        stampaResOsp($result);
                    } else {
                        echo "<p>Inserimento fallito</p>";
                    }
                }
            } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $codice = $_GET["codice"];
                $nome = $_GET["nome"];
                $citta = $_GET["città"];
                $indirizzo = $_GET["indirizzo"];
                $direttoreSanitario = $_GET["direttoreSanitario"];
                $controllo = $_GET["controllo"];

                $query = getOspedale($codice, $nome, $citta, $indirizzo, $direttoreSanitario);
                $result = executeQuery($query);
                stampaResOsp($result);
                
                if($controllo == "O"){
                	cittadiniOspedali($codice);
                }
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
