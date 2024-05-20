<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Servizio sanitario Ricovero</title>
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="jquery-2.0.0.js"></script>
		<script type="text/javascript" src="script.js"></script>

    </head>

    <body onload="setTitoloRicovero()">
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
                    <input id="codOspedale" name="codOspedale" type="text" placeholder="Cod Ospedale" pattern="COD\d{3}" title="Inserisci un codice valido: COD+3 cifre numeriche" /><br>
                    <input id="cod" name="cod" type="text" placeholder="Cod Ricovero" pattern="RIC\d{3}" title="Inserisci un codice valido: RIC+3 cifre numeriche"  /><br>
                    <input id="paziente" name="paziente" type="text" placeholder="Paziente" pattern="CSSN\d{3}" title="Inserisci un cittadino valido: CSSN+3 cifre numeriche" /><br>
                    <input id="data" name="data" type="date" placeholder="Data" /><br>
                    <input id="durata" name="durata" type="text" placeholder="Durata"  pattern="\d+ giorni?" title="Inserisci una durata valida: numero seguito da 'giorni'" /><br>
                    <input id="motivo" name="motivo" type="text" placeholder="Motivo" /><br>
                    <input id="costo" name="costo" type="text" placeholder="Costo" /><br>
                    <input type="submit" name ="ricerca" value="Cerca" />
                </form>
                <p>Il costo complessivo dei ricoveri per:</p>
                <form name="formCostotot" method="POST">
                    <input id="motivo" name="motivo" type="text" placeholder="Motivo" />
                    <input type="submit" name="costoComplessivo" value="Calcola il costo" />
                </form>

                <p>Il numero di ricoveri che hanno un costo superiore di:</p>
                <form name="formCosto" method="POST">
                    <input id="costo" name="costo" type="text" placeholder="Costo" />
                    <input type="submit" name ="costoSup" value="Trova" />
                </form>

                <p>Il numero di ricoveri che hanno superato la durata di: </p>
                <form name="formRicoveriDurata" method="POST">
                    <input id="durata" name="durata" type="text" placeholder="Durata minima dei ricoveri"  pattern="\d+ giorni?" title="Inserisci una durata valida: numero seguito da 'giorni'" />
                    <input type="submit" name="durataSup" value="Trova" />
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
                    $codOspedale = "";
                    $cod = "";
                    $paziente = "";
                    $data = "";
                    $durata = "";
                    $motivo = "";
                    $costo = "";

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['costoComplessivo'])) {
                        $motivo = $_POST['motivo'];
                        $costotot = sommaCostiPerMotivo($motivo);
                        echo "Il costo complessivo dei ricoveri per $motivo è: $costotot";

                        stampaRicoveri($codOspedale, $cod, $paziente, $data, $durata, $motivo, $costo);
                    }
                    elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['costoSup'])) {
                        $costoMinimo = $_POST['costo'];
                        $num_ricoveri = numeroRicoveriCostoSuperiore($costoMinimo);
                        echo "Il numero di ricoveri il costo è superiore a $costoMinimo è: $num_ricoveri";

                        stampaRicoveriCosto($costoMinimo);
                    }
                    elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['durataSup'])) {
                        $durataMinima = $_POST['durata'];
                        $numero_ricoveri = numeroRicoveri($durataMinima);
                        echo "Il numero di ricoveri con durata superiore a $durataMinima è: $numero_ricoveri";

                        stampaRicoveriDurata($durataMinima);
                    }
                    elseif (count($_POST) > 0) {
                        $codOspedale = $_POST["codOspedale"];
                        $cod = $_POST["cod"];
                        $paziente = $_POST["paziente"];
                        $data = $_POST["data"];
                        $durata = $_POST["durata"];
                        $motivo = $_POST["motivo"];
                        $costo = $_POST["costo"];

                        stampaRicoveri($codOspedale, $cod, $paziente, $data, $durata, $motivo, $costo);
                    } 
                    elseif (count($_GET) > 0) {
                        $codOspedale = $_GET["cod ospedale"];
                        $cod = $_GET["cod ricovero"];
                        $paziente = $_GET["paziente"];
                        $data = $_GET["data"];
                        $durata = $_GET["durata"];
                        $motivo = $_GET["motivo"];
                        $costo = $_GET["costo"];

                        stampaRicoveri($codOspedale, $cod, $paziente, $data, $durata, $motivo, $costo);
                    }
                    else{
                        stampaRicoveri($codOspedale, $cod, $paziente, $data, $durata, $motivo, $costo);
                    }
                    
                ?>
            </div>
        </div>
    </body>
</html>