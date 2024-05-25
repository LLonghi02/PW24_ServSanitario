

function controlloInserimento(){
    let nome = document.forms["insertOsp"]["nomeIns"].value;
    let citta = document.forms["insertOsp"]["cittàIns"].value;
    let indirizzo = document.forms["insertOsp"]["indirizzoIns"].value;
    let direttore = document.forms["insertOsp"]["direttoreSanitarioIns"].value;

    if(nome == "" || citta == "" || indirizzo == "" || direttore == ""){
        alert("Inserimento non valido: compilare tutti i campi!");
        return false;
    }

    return true;
}

function setTitoloOspedale(){
    $("#titoloPagina").text("OSPEDALE");
}

function setTitoloCittadino(){
    $("#titoloPagina").text("CITTADINO");
}

function setTitoloRicovero(){
    $("#titoloPagina").text("RICOVERO");
}

function setTitoloPatologia(){
    $("#titoloPagina").text("PATOLOGIA");
}

document.addEventListener("DOMContentLoaded", function() {
    var sortLinks = document.querySelectorAll('.sort-link');

    sortLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var column = this.dataset.column;

            // Chiamata alla funzione di ordinamento
            sortTable(column);
        });
    });
});
function sortTable(column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.querySelector('.table');
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName('td')[column];
            y = rows[i + 1].getElementsByTagName('td')[column];

            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
function sortTable2(column) {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.querySelector('.table');
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName('td')[column];
            y = rows[i + 1].getElementsByTagName('td')[column];

            // Estrai i numeri dalle stringhe "numero giorni"
            var numX = parseInt(x.innerHTML.toLowerCase().replace(" giorni", "").trim());
            var numY = parseInt(y.innerHTML.toLowerCase().replace(" giorni", "").trim());

            if (numX > numY) {
                shouldSwitch = true;
                break;
            }
        }

        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

