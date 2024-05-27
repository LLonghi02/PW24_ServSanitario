<?php

function executeQuery( $query )
 {
    include 'DBconn.php';

    try {
        $result = $conn->query( $query );
    } catch ( PDOException $e ) {
        $error = true;
        $result = false;
    }

    return $result;
}

//---------------------------------------------------------------------------------------------------------------------
// Metodi Cittadino

function getCittadino( $CSSN, $nome, $cognome, $dataNascita, $luogoNascita, $indirizzo ): string
 {
    $qry = 'SELECT * FROM Cittadino WHERE 1=1 ';

    if ( $CSSN != '' )
    $qry = $qry . "AND Cittadino.CSSN LIKE  '" . $CSSN . "%' ";

    if ( $nome != '' )
    $qry = $qry . "AND Cittadino.nome LIKE '" . $nome . "%' ";

    if ( $cognome != '' )
    $qry = $qry . "AND Cittadino.cognome LIKE '" . $cognome . "%' ";

    if ( $dataNascita != '' )
    $qry = $qry . "AND Cittadino.dataNascita LIKE '" . $dataNascita . "%' ";

    if ( $luogoNascita != '' )
    $qry = $qry . "AND Cittadino.luogoNascita LIKE '" . $luogoNascita . "%' ";

    if ( $indirizzo != '' )
    $qry = $qry . "AND Cittadino.indirizzo LIKE '" . $indirizzo . "%' ";

    return $qry;
}

function tabellaCittadini( $result ) {
    echo "<div class='table-container'>";

    echo "<table class='table'>";
    echo "<tr class='header'>
        <th><a href='#' class='sort-link' data-column='0'>CSSN<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
        <th><a href='#' class='sort-link' data-column='1'>Nome<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
        <th><a href='#' class='sort-link' data-column='2'>Cognome<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
        <th><a href='#' class='sort-link' data-column='3'>Data di Nascita<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
        <th><a href='#' class='sort-link' data-column='4'>Luogo di Nascita<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
        <th><a href='#' class='sort-link' data-column='5'>Indirizzo<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
    </tr>";

    $i = 0;
    foreach ( $result as $riga ) {
        $i = $i + 1;
        $classRiga = 'class="rowOdd"';
        if ( $i % 2 == 0 ) {
            $classRiga = 'class="rowEven"';
        }
        echo "<tr $classRiga>
                <td>{$riga['CSSN']}</td>
                <td>{$riga['nome']}</td>
                <td>{$riga['cognome']}</td>
                <td>{$riga['dataNascita']}</td>
                <td>{$riga['luogoNascita']}</td>
                <td>{$riga['indirizzo']}</td></tr>";
    }
    echo '</table>';
    echo '</div >';
}

function stampaCittadini( $CSSN, $nome, $cognome, $dataNascita, $luogoNascita, $indirizzo )
 {
    $query = getCittadino( $CSSN, $nome, $cognome, $dataNascita, $luogoNascita, $indirizzo );

    $result = executeQuery( $query );
    if ( $result === false || $result->rowCount() == 0 ) {
        echo '<h3>Nessuna corrispondenza per il valore cercato</h3>';
    } else {
        tabellaCittadini( $result );
    }
}

function getNati( $citta )
 {
    $query = "SELECT COUNT(*) AS numero_cittadini FROM Cittadino WHERE luogoNascita = '$citta'";

    $result = executeQuery( $query );

    if ( $result !== false ) {
        $row = $result->fetch( PDO::FETCH_ASSOC );
        return $row[ 'numero_cittadini' ];
    } else {
        return 'Errore nel recuperare i cittadini nati nella città specificata.';
    }
}

function getCSSN( $nome, $cognome )
 {
    $query = "SELECT CSSN FROM Cittadino WHERE nome= '$nome' AND cognome= '$cognome'";

    $result = executeQuery( $query );

    if ( $result !== false ) {
        $row = $result->fetch( PDO::FETCH_ASSOC );
        return $row[ 'CSSN' ];
    } else {
        return 'Errore nel recuperare i CSSN.';
    }
}
//-----------------------------------------------------------------------------------------------------------------------
// Metodi Ospedale

function getOspedale( $codice, $nome, $citta, $indirizzo, $direttoreSanitario ): string
 {
    $qry = 'SELECT * FROM Ospedale WHERE 1=1 ';

    if ( $codice != '' )
    $qry = $qry . "AND Ospedale.codice LIKE '" . $codice . "%' ";

    if ( $nome != '' )
    $qry = $qry . "AND Ospedale.nome LIKE '" . $nome . "%' ";

    if ( $citta != '' )
    $qry = $qry . "AND Ospedale.città LIKE '" . $citta . "%' ";

    if ( $indirizzo != '' )
    $qry = $qry . "AND Ospedale.indirizzo LIKE '" . $indirizzo . "%' ";

    if ( $direttoreSanitario != '' )
    $qry = $qry . "AND Ospedale.direttoreSanitario LIKE '" . $direttoreSanitario . "%' ";

    return $qry;
}

function stampaResOsp( $result )
 {
    if ( $result === false || $result->rowCount() == 0 ) {
        echo '<h3>Nessuna corrispondenza per il valore cercato</h3>';
    } else {
        echo "<div class='table-container'>";
        echo "<table class='table'>";
        echo "<tr class='header'>
            <th><a href='#' class='sort-link' data-column='0'>Codice<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
            <th><a href='#' class='sort-link' data-column='1'>Nome<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
            <th><a href='#' class='sort-link' data-column='2'>Città<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
            <th><a href='#' class='sort-link' data-column='3'>Indirizzo<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
            <th><a href='#' class='sort-link' data-column='4'>Direttore Sanitario<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
            <th>Modifica</th>
            <th>Elimina</th>
            </tr>";

        $i = 0;
        foreach ( $result as $riga ) {
            $i = $i + 1;
            $classRiga = 'class="rowOdd"';
            if ( $i % 2 == 0 ) {
                $classRiga = 'class="rowEven"';
            }
            $codice = $riga[ 'codice' ];
            $nome = $riga[ 'nome' ];
            $citta = $riga[ 'città' ];
            $indirizzo = $riga[ 'indirizzo' ];
            $direttoreSanitario = $riga[ 'direttoreSanitario' ];
            echo "<tr $classRiga>
                    <td>" . formatLink( 'ospedale.php?codice', $codice, '' ) . "</td>
                    <td>$nome</td>
                    <td>$citta</td>
                    <td>$indirizzo</td>
                    <td>" . formatLink( 'cittadino.php?CSSN', $direttoreSanitario, '' ) . "</td>
                    <td>" . modificaOsp( $codice ) . "</td>
                    <td>" . eliminaOsp( $codice ) . "</td>
                </tr>";
        }
        echo '</table>';
        echo '</div>';
    }
}

function eliminaOsp( $codice )
 {
    if ( is_null( $codice ) || $codice == '' )
    return '';
    return "<a href='EliminaOsped.php?codice=" . $codice . "'> <img  src='Icone/cestino.png' class='mc'/> </a>";
}

function modificaOsp( $codice )
 {
    if ( is_null( $codice ) || $codice == '' )
    return '';
    return "<a href='ModOsped.php?codice=" . $codice . "'> <img   src='Icone/matita.png' class='mc' /> </a>";
}

function setOs( $codice, $nome, $indirizzo, $citta, $direttoreSanitario ): string
 {

    $qry = 'UPDATE Ospedale SET ';
    $qry = $qry . " Ospedale.nome='" . $nome . "' ";
    $qry = $qry . ", Ospedale.indirizzo = '" . $indirizzo . "' ";
    $qry = $qry . ", Ospedale.città = '" . $citta . "' ";
    $qry = $qry . ", Ospedale.direttoreSanitario = '" . $direttoreSanitario . "' ";
    $qry = $qry . " WHERE Ospedale.codice='" . $codice . "' ";

    return $qry;
}

function insertOspedale( $nome, $città, $indirizzo, $direttore ): string
 {

    $qry = 'INSERT INTO Ospedale (codice, nome, città, indirizzo, direttoreSanitario) VALUES ';

    $codici = array();

    $result = executeQuery( 'SELECT codice FROM Ospedale' );

    foreach ( $result as $cod ) {
        $num = substr( $cod[ 'codice' ], -3 );
        $codici[] = $num;
    }

    $numCodici = max( $codici );

    if ( !existDirettore( $direttore ) ) {
        echo 'Inserire un direttore valido';
        return '';
    } else {
        if ( !noDoubleDir( $direttore ) ) {
            echo 'Direttore gia di un altro ospedale';
            return '';
        } else {
            if ( $numCodici < 100 ) {
                $codice = 'COD0' . ( $numCodici + 1 );
            } else {
                $codice = 'COD' . $numCodici;
            }

            $qry = $qry . "('" . $codice . "', '" . $nome . "', '" . $città . "', '" . $indirizzo . "', '" . $direttore . "')";
        }

    }

    return $qry;
}

function existDirettore( $direttore ): bool
 {
    $qry = 'SELECT CSSN FROM Cittadino';

    $result = executeQuery( $qry );

    foreach ( $result as $citt ) {
        if ( $citt[ 'CSSN' ] == $direttore ) {
            return true;
        }
    }

    return false;

}

function noDoubleDir( $direttore ): bool
 {
    $qry = 'SELECT direttoreSanitario FROM Ospedale';

    $result = executeQuery( $qry );

    foreach ( $result as $dir ) {
        if ( $dir[ 'direttoreSanitario' ] == $direttore ) {
            return false;
        }
    }

    return true;
}

//-------------------------------------------------------------------------------------------------------------------------
// Metodi Ricovero

function getRicovero( $codOspedale, $cod, $paziente, $data, $durata, $motivo, $costo ): string
 {
    $qry = 'SELECT * FROM Ricovero WHERE 1=1 ';

    if ( $codOspedale != '' )
    $qry = $qry . "AND Ricovero.codOspedale LIKE '" . $codOspedale . "%' ";

    if ( $cod != '' )
    $qry = $qry . "AND Ricovero.cod LIKE '" . $cod . "%' ";

    if ( $paziente != '' )
    $qry = $qry . "AND Ricovero.paziente LIKE '" . $paziente . "%' ";

    if ( $data != '' )
    $qry = $qry . "AND Ricovero.data LIKE '" . $data . "%' ";

    if ( $durata != '' )
    $qry = $qry . "AND Ricovero.durata = '" . $durata . "' ";

    if ( $motivo != '' )
    $qry = $qry . "AND Ricovero.motivo LIKE '" . $motivo . "%' ";

    if ( $costo != '' )
    $qry = $qry . "AND Ricovero.costo = '" . $costo . "' ";

    return $qry;
}

function tabellaRicovero( $result ) {

    if ( $result === false || $result->rowCount() == 0 ) {
        echo '<h3>Nessuna corrispondenza per il valore cercato</h3>';
    } else {
        echo "<div class='table-container'>";
        echo "<table class='table'>";
        echo "<tr class='header'>
        <th>
            <a href='#' class='sort-link' data-column='0'>Cod Ospedale<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'>
        </a></th>
        <th><a href='#' class='sort-link' data-column='1'>Cod<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'>
        </a></th>
        <th><a href='#' class='sort-link' data-column='2'>Paziente<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'>
        </a></th>
        <th><a href='#' class='sort-link' data-column='3'>Data<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'>
        </a></th>
        <th><a href='#' class='sort-link' onclick='sortTable2(4)'>Durata<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'>
        </a></th>
        <th><a href='#' class='sort-link' data-column='5'>Motivo<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'>
        </a></th>
        <th><a href='#' class='sort-link' data-column='6'>Costo<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'>
        </a></th>
    </tr>";

        $i = 0;
        foreach ( $result as $riga ) {
            $i = $i + 1;
            $classRiga = 'class="rowOdd"';
            if ( $i % 2 == 0 ) {
                $classRiga = 'class="rowEven"';
            }
            $codOspedale = $riga[ 'codOspedale' ];
            $cod = $riga[ 'cod' ];
            $paziente = $riga[ 'paziente' ];
            $data = $riga[ 'data' ];
            $durata = $riga[ 'durata' ];
            $motivo = $riga[ 'motivo' ];
            $costo = $riga[ 'costo' ];
            echo "<tr $classRiga>
        <td>" . formatLink( 'ospedale.php?codice', $codOspedale, 'O' ) . "</td>
        <td>$cod</td>
        <td>" . formatLink( 'cittadino.php?CSSN', $paziente, 'R' ) . "</td>
        <td>$data</td>
        <td>" . $durata . " giorni</td>
        <td>" . formatLink( 'patologia.php?nome', $motivo, '' ) . "</td>
        <td>$costo</td>
        </tr>";
        }
        echo '</table>';
        echo '</div>';
    }
}

function stampaRicoveri( $codOsp, $cod, $paziente, $data, $durata, $motivo, $costo )
 {
    $query = getRicovero( $codOsp, $cod, $paziente, $data, $durata, $motivo, $costo );

    $result = executeQuery( $query );

    tabellaRicovero( $result );
}

function stampaRicoveriCosto( $costoMinimo )
 {
    $qry = "SELECT * FROM Ricovero WHERE costo > $costoMinimo";

    $result = executeQuery( $qry );

    tabellaRicovero( $result );
}

function stampaRicoveriDurata( $durataMinima )
 {
    $qry = "SELECT * FROM Ricovero WHERE durata > '$durataMinima'";

    $result = executeQuery( $qry );

    tabellaRicovero( $result );
}

function numeroRicoveri( $durataMinima )
 {
    $query = "SELECT COUNT(*) AS numero_ricoveri FROM Ricovero WHERE durata > '$durataMinima'";
    $result = executeQuery( $query );
    if ( $result !== false ) {
        $row = $result->fetch( PDO::FETCH_ASSOC );
        return $row[ 'numero_ricoveri' ];
    } else {
        return 'Errore nel recuperare il numero di ricoveri.';
    }
}

function numeroRicoveriCostoSuperiore( $costoMinimo )
 {
    $query = "SELECT COUNT(*) AS numero_ricoveri FROM Ricovero WHERE costo > '$costoMinimo'";
    $result = executeQuery( $query );
    if ( $result !== false ) {
        $row = $result->fetch( PDO::FETCH_ASSOC );
        return $row[ 'numero_ricoveri' ];
    } else {
        return 'Errore nel recuperare il numero di ricoveri.';
    }
}

function sommaCostiPerMotivo( $motivo )
 {
    $query = "SELECT SUM(costo) AS somma_costi FROM Ricovero WHERE motivo LIKE '$motivo%'";
    $result = executeQuery( $query );
    if ( $result !== false ) {
        $row = $result->fetch( PDO::FETCH_ASSOC );
        return $row[ 'somma_costi' ];
    } else {
        return 'Errore nel calcolare la somma dei costi per il motivo specificato.';
    }
}

//------------------------------------------------------------------------------------------------------------------
// Metodi Patologia

function getPatologia( $cod, $nome, $criticita, $tipologia ): string
 {
    if ( $tipologia != '' ) {
        if ( $tipologia == 'Cronica' ) {
            return getPatologiaCronica( $cod, $nome, $criticità );
        } elseif ( $tipologia == 'Mortale' ) {
            return getPatologiaMortale( $cod, $nome, $criticità );
        }
    }

    $qry = 'SELECT * FROM Patologia AS P WHERE 1=1 ';

    if ( $cod != '' )
    $qry = $qry . "AND P.cod LIKE '" . $cod . "%' ";

    if ( $nome != '' )
    $qry = $qry . "AND P.nome LIKE '" . $nome . "%' ";

    if ( $criticita != '' )
    $qry = $qry . "AND P.criticità = '" . $criticita . "' ";

    return $qry;
}

function getPatologiaMortale( $cod, $nome, $criticita )
 {
    $query = 'SELECT * FROM PatologiaMortale join Patologia WHERE PatologiaMortale.codPatologia=Patologia.cod';
    if ( !empty( $cod ) ) {
        $query .= " AND cod LIKE '$cod%'";
    }
    if ( !empty( $nome ) ) {
        $query .= " AND nome LIKE '%$nome%'";
    }
    if ( !empty( $criticita ) ) {
        $query .= " AND criticità = '$criticita'";
    }

    return $query;
}

function getPatologiaCronica( $cod, $nome, $criticita )
 {
    $query = 'SELECT * FROM PatologiaCronica join Patologia WHERE PatologiaCronica.codPatologia=Patologia.cod';
    if ( !empty( $cod ) ) {
        $query .= " AND cod LIKE '$cod%'";
    }
    if ( !empty( $nome ) ) {
        $query .= " AND nome LIKE '%$nome%'";
    }
    if ( !empty( $criticita ) ) {
        $query .= " AND criticità = '$criticita'";
    }
    return $query;
}

function stampaPatologie( $cod, $nome, $criticita, $tipologia )
 {
    $query = getPatologia( $cod, $nome, $criticita, $tipologia );

    $result = executeQuery( $query );
    if ( $result === false || $result->rowCount() == 0 ) {
        echo '<h3>Nessuna corrispondenza per il valore cercato</h3>';
    } else {
        echo "<div class='table-container'>";
        echo "<table class='table'>";
        echo "<tr class='header'>
        <th><a href='#' class='sort-link' data-column='0'>Cod<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
        <th><a href='#' class='sort-link' data-column='1'>Nome<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
        <th><a href='#' class='sort-link' data-column='2'>Criticità<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
        <th><a href='#' class='sort-link' data-column='3'>Tipologia<img src='Icone/fb.png' alt='Freccia' class='arrow-icon'></a></th>
    </tr>";

        $i = 0;
        foreach ( $result as $riga ) {
            $i++;
            $classRiga = 'class="rowOdd"';
            if ( $i % 2 == 0 ) {
                $classRiga = 'class="rowEven"';
            }
            $tipologia = getTipologiaPatologia( $riga[ 'cod' ] );
            echo "<tr $classRiga>
                <td>{$riga['cod']}</td>
                <td>". formatLink( 'patologia.php?nome', $riga[ 'nome' ], '' ) . "</td>
                <td>{$riga['criticità']}</td>
                <td>$tipologia</td>
              </tr>";
        }
        echo '</table>';
        echo '</div >';
    }
}

function getTipologiaPatologia( $cod )
 {
    $queryMortale = getPatologiaMortale( $cod, '', '' );
    $resultMortali = executeQuery( $queryMortale );

    $queryCronica = getPatologiaCronica( $cod, '', '' );
    $resultCroniche = executeQuery( $queryCronica );

    if ( $resultMortali->rowCount() > 0 ) {
        return 'Mortale';
    } elseif ( $resultCroniche->rowCount() > 0 ) {
        return 'Cronica';
    }

    return 'N/A';
}

function countPatologieCriticitaMaggiore( $criticitaMinima )
 {
    $query = "SELECT COUNT(*) AS numero_patologie FROM Patologia WHERE criticità > '$criticitaMinima'";
    $result = executeQuery( $query );
    if ( $result !== false ) {
        $row = $result->fetch( PDO::FETCH_ASSOC );
        return $row[ 'numero_patologie' ];
    } else {
        return "Errore nel recuperare il numero di patologie con criticità maggiore di $criticitaMinima.";
    }
}
//----------------------------------------------------------------------------------------------------------------------

//Metodi generali

function formatLink( $link, $chiave, $controllo ): string
 {
    if ( is_null( $chiave ) || $chiave == '' ) {
        return '';
    }

    if ( $controllo == 'R' || $controllo == 'O' ) {
        return "<a href='" . $link . '=' . $chiave . '&controllo=' . $controllo . "'>" . $chiave . '</a>';
    }

    return "<a href='" . $link . '=' . $chiave . "'>" . $chiave . '</a>';
}

//Ricoveri di un cittadino

function ricoveriCittadino( $cssn ) {

    $query1 = "SELECT COUNT(*) AS numRicoveri FROM Ricovero WHERE paziente = '$cssn'";

    $result1 = executeQuery( $query1 );

    $query2 = "SELECT * FROM Ricovero WHERE paziente = '$cssn'";

    $result = executeQuery( $query2 );

    if ( $result1 != false ) {
        foreach ( $result1 as $rig ) {
            $numRicoveri = $rig[ 'numRicoveri' ];
        }

        echo "Il numero di ricoveri per il paziente $cssn è: $numRicoveri";
    } else {
        echo "Il numero di ricoveri per il paziente $cssn è: 0";
    }

    tabellaRicovero( $result );
}

// Cittadini ricoverati in un ospedale

function cittadiniOspedali( $codOspedale ) {
    $query1 = "SELECT COUNT(DISTINCT paziente) AS numCittadini FROM Ricovero R WHERE R.codOspedale = '$codOspedale'";

    $result1 = executeQuery( $query1 );

    $query = "SELECT DISTINCT C.* FROM Cittadino C JOIN Ricovero R ON C.CSSN = R.paziente WHERE R.codOspedale = '$codOspedale'";

    $result = executeQuery( $query );

    if ( $result1 != false ) {
        foreach ( $result1 as $rig ) {
            $numCittadini = $rig[ 'numCittadini' ];
        }

        echo "Il numero di cittadini ricoverati nell'ospedale $codOspedale è: $numCittadini";
    } else {
        echo "Il numero di cittadini ricoverati nell'ospedale $codOspedale è: 0";
    }

    tabellaCittadini( $result );
}

// Ricoveri di una data patologia

function ricoveriPatologia( $patologia ) {
    $query1 = "SELECT COUNT(*) AS numRicoveri FROM Ricovero WHERE motivo = '$patologia'";

    $result1 = executeQuery( $query1 );

    $query = "SELECT * FROM Ricovero WHERE motivo = '$patologia'";

    $result = executeQuery( $query );

    if ( $result1 != false ) {
        foreach ( $result1 as $rig ) {
            $numRicoveri = $rig[ 'numRicoveri' ];
        }

        echo "Il numero di ricoveri per la patologia $patologia è: $numRicoveri";
    } else {
        echo "Il numero di ricoveri per la patologia $patologia è: 0";
    }

    tabellaRicovero( $result );
}
?>