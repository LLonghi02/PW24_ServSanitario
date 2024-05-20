<!DOCTYPE html>
<html lang="it">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Servizio sanitario Patologia</title>
        <link rel="stylesheet" href="style.css">
        <script type="text/javascript" src="jquery-2.0.0.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </head>

    <body onload="setTitoloPatologia()">
        <?php
        include 'header.html';
        include 'nav.html';
        include 'footer.html';
        include_once 'DBconn.php';
        include_once 'dbManager.php';
        ?>

        <div class="container">
            <div class="filtro">
                <h3>Effettua le tue ricerche <img class="lente" src="Icone/lente.png" /></h3>

                <form name="myform" method="POST">
                    <input id="cod" name="cod" type="text" placeholder="Cod" pattern="PAT\d{3}"
                        title="Inserisci un codice valido: PAT+3 cifre numeriche" /><br/>
                    <input id="nome" name="nome" type="text" placeholder="Nome" /><br/>
                    <input id="criticità" name="criticità" type="text" placeholder="Criticità"/><br/>
                    <select id="tipologia" name="tipologia" placeholder="Tipologia">
                        <option></option>
                        <option>Cronica</option>
                        <option>Mortale</option>
                    </select><br/>
                    <!--<input type="text" id="tipologia" name="tipologia" placeholder="Tipologia"/>-->
                    <input type="submit" value="Cerca" />
                </form>
                <p>Il numero di patologie che hanno criticità maggiore di: </p>
                <form name="formcriti" method="POST">
                    <input id="criticità1" name="criticità1" type="text" placeholder="Criticità" />
                    <input type="submit" value="Trova" />
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
                if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['criticità1'])) {
                    $criticitaMinima = $_POST['criticità1'];
                    $count = countPatologieCriticitaMaggiore($criticitaMinima);
                    echo "Il numero di patologie che hanno criticità maggiore di $criticitaMinima è: $count";
                } elseif (count($_POST) > 0) {
                    $cod = $_POST["cod"];
                    $nome = $_POST["nome"];
                    $criticita = $_POST["criticità"];
                    $tipologia = $_POST["tipologia"];

                    stampaPatologie($cod, $nome, $criticita, $tipologia);
                } elseif (count($_GET) > 0) {
                    $cod = $_GET["cod"];
                    $nome = $_GET["nome"];
                    $criticita = $_GET["criticità"];
                    $tipologia = $_GET["tipologia"];

                    stampaPatologie($cod, $nome, $criticita, $tipologia);
                } else {
                    stampaPatologie($cod, $nome, $criticita, $tipologia);
                }
                ?>
            </div>
        </div>

    </body>

</html>