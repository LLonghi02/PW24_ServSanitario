<?php
include 'DBconn.php';

header('Content-Type: text/html; charset=UTF-8');

if ($error) {
    echo 'Database connection error';
    exit;
}

$nome = isset($_POST['nome']) ? strtolower($_POST['nome']) : '';
$cognome = isset($_POST['cognome']) ? strtolower($_POST['cognome']) : '';
$fromDirettoreSanitarioIns = isset($_POST['fromDirettoreSanitarioIns']) ? $_POST['fromDirettoreSanitarioIns'] : false;

// Log per debug
error_log("Nome: $nome, Cognome: $cognome, From direttoreSanitarioIns: $fromDirettoreSanitarioIns");

try {
    // Query per trovare i CSSN corrispondenti
    $stmt = $conn->prepare("SELECT * FROM Cittadino WHERE LOWER(nome) LIKE ? AND LOWER(cognome) LIKE ?");
    $stmt->execute(["%$nome%", "%$cognome%"]);
    $cittadini = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($cittadini) > 0) {
        $cssnValues = array_column($cittadini, 'CSSN');
        $placeholders = str_repeat('?,', count($cssnValues) - 1) . '?';

        if ($fromDirettoreSanitarioIns) {
            // Query per trovare CSSN che non sono già direttori sanitari
            $stmt2 = $conn->prepare("SELECT CSSN FROM Cittadino WHERE CSSN NOT IN (SELECT DISTINCT direttoreSanitario FROM Ospedale) AND CSSN IN ($placeholders)");
        } else {
            // Query per verificare se i CSSN trovati sono direttori sanitari in Ospedale
            $stmt2 = $conn->prepare("SELECT DISTINCT direttoreSanitario FROM Ospedale WHERE direttoreSanitario IN ($placeholders)");
        }
        $stmt2->execute($cssnValues);
        $direttori = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if (count($direttori) > 0) {
            foreach ($direttori as $direttore) {
                $cssn = $fromDirettoreSanitarioIns ? $direttore['CSSN'] : $direttore['direttoreSanitario'];
                foreach ($cittadini as $cittadino) {
                    if ($cittadino['CSSN'] == $cssn) {
                        echo '<option value="' . htmlspecialchars($cittadino['CSSN']) . '">' . htmlspecialchars($cittadino['nome']) . ' ' . htmlspecialchars($cittadino['cognome']) . ' (' . htmlspecialchars($cittadino['CSSN']) . ')</option>';
                    }
                }
            }
        } else {
            echo 'Nessun risultato trovato';
        }
    } else {
        echo 'Nessun risultato trovato';
    }
} catch (PDOException $e) {
    echo 'Errore nella ricerca';
    error_log("Database error: " . $e->getMessage());
}
?>
