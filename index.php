<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
        include 'header.html';
        include 'nav.html';
        include 'footer.html';
        ?>

        <div class="container">
            <div class="filtro">
            <img src="sanita1.jpeg">
            </div>
            <div class="contenuto">
                <h2>Benvenuto all'applicativo di gestione dei ricoveri della regione Lombardia</h2>
                <p>Questo sistema è progettato per consentire agli operatori sanitari della Regione di gestire 
                in modo efficiente e accurato le informazioni relative ai cittadini, agli ospedali, ai ricoveri e alla patologie.
                </p>
                <h3>Informazioni sui cittadini:</h3>
                <p>Ogni cittadino è noto alla Regione attraverso il proprio codice del Servizio Sanitario Nazionale 
                e i dati anagrafici standard. Queste informazioni sono fondamentali per garantire una corretta 
                identificazione e gestione dei pazienti all'interno del sistema.
                </p>
                <h3>Informazioni sugli ospedali:
                </h3>
                <p>
                Gli ospedali sono identificati da un codice univoco e sono caratterizzati dal nome, 
                dalla città, dall'indirizzo e dal nome del Direttore Sanitario.
                </p>
                <h3>Informazioni sui ricoveri:</h3>
                <p>I ricoveri avvengono per curare una o più patologie e sono identificati da un codice univoco
                per l'ospedale in cui vengono effettuati. Ogni ricovero è caratterizzato dalla data di inizio, 
                dai giorni di permanenza, dal motivo del ricovero, dal costo e dal paziente (cittadino) ricoverato.
                </p>
                <h3>Informazioni sulle patologie:</h3>
                <p>Le patologie sono identificate da un codice e caratterizzate dal nome e dal 
                livello di criticità. Si gestiscono due sottoinsiemi: le patologie mortali e le patologie croniche. 
                </p>

            </div>
        </div>
    </body>
</html>
