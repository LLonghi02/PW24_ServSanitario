<!DOCTYPE html>
<html lang="it">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Servizio sanitario Cittadino</title>
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="jquery-2.0.0.js"></script>
		<script type="text/javascript" src="script.js"></script>
        <script type="text/javascript" src="dynamic.js"></script>
    </head>

    <body onload="setTitoloCittadino()">
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
 				<input id="CSSN" name="CSSN" type="text" placeholder="CSSN" pattern="CSSN\d{3}" title="Inserisci un CSSN valido: CSSN+3 cifre numeriche"/><br>
                    <input id="nome" name="nome" type="text" placeholder="Nome" /><br>
                    <input id="cognome" name="cognome" type="text" placeholder="Cognome" /><br>
                    <input id="dataNascita" name="dataNascita" type="date" placeholder="Data di nascita" /><br>
                    <input id="luogoNascita" name="luogoNascita" type="text" placeholder="Luogo di nascita" /><br>
                    <input id="indirizzo" name="indirizzo" type="text" placeholder="Indirizzo" />
                    <input type="submit" value="Cerca" />
                </form>
                <p>Quanti cittadini sono nati a:
                <form name="formCittadiniNati" method="POST">
                    <input id="luogoNascita" name="luogoNascita" type="text" placeholder="Luogo di nascita" />
                    <input type="submit" value="Cerca" />
                </form>
                </p>
         <p><img class="lente" src="Icone/freccia.png" />     
		<?php
            // Questo è il codice PHP per tornare alla pagina precedente con un link "Torna indietro"
            echo '<a href="javascript:history.go(-1)">Torna indietro</a>';
        ?>
        </p>
            </div>

            <div class="contenuto">
                <?php
                    $CSSN = "";
                    $nome = "";
                    $cognome = "";
                    $dataNascita = "";
                    $luogoNascita = "";
                    $indirizzo = "";
                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['luogoNascita'])) {
                        $luogoNascita = $_POST['luogoNascita'];
                        $numero_cittadini = getNati($luogoNascita);
                        echo "Il numero di cittadini nati a $luogoNascita è: $numero_cittadini";
                    }
                    elseif (count($_POST) > 0) {
                        $CSSN = $_POST["CSSN"];
                        $nome = $_POST["nome"];
                        $cognome = $_POST["cognome"];
                        $dataNascita = $_POST["dataNascita"];
                        $luogoNascita = $_POST["luogoNascita"];
                        $indirizzo = $_POST["indirizzo"];

                        stampaCittadini($CSSN, $nome, $cognome, $dataNascita, $luogoNascita, $indirizzo);
                    } 
                    elseif (count($_GET) > 0) {
                        $CSSN = $_GET["CSSN"];
                        $nome = $_GET["nome"];
                        $cognome = $_GET["cognome"];
                        $dataNascita = $_GET["dataNascita"];
                        $luogoNascita = $_GET["luogoNascita"];
                        $indirizzo = $_GET["indirizzo"];
                        $controllo = $_GET["controllo"];

                        stampaCittadini($CSSN, $nome, $cognome, $dataNascita, $luogoNascita, $indirizzo);
                        
                        if($controllo == "R"){
                            ricoveriCittadino($CSSN);
                        }
                        
                    }
                    else{
                        stampaCittadini($CSSN, $nome, $cognome, $dataNascita, $luogoNascita, $indirizzo);
                    }
                ?>
            </div>

    </body>

</html>