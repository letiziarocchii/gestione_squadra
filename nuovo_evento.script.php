<?php
require("config.php");


// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i valori dal modulo
    $tipo = $_POST["tipo"];
    $data_ora_inizio = $_POST["data_ora_inizio"];
    $durata = intval($_POST["durata"]);
    $descrizione = $_POST["descrizione"];
    $luogo = $_POST["luogo"];

    $errore = '';

    if (empty($tipo)) {
        $errore .= "tipo";
    }

    if (empty($data_ora_inizio)) {
        $errore .=  ' data_ora_inizio';
    }

    if (empty($durata)) {
        $errore .= ' durata';
    }
    if ($durata <= 0) {
        $errore .= ' durataL';
    }

    if (empty($descrizione)) {
        $errore .= ' descrizione';
    }

    if (empty($luogo)) {
        $errore .= ' luogo';
    }

    if (!empty($errore)) {
        echo json_encode(array('type' => 'Param_Error', 'value' => $errore));
    } else {
        // Connettiti al database
        $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
        if ($mydb->connect_errno) {
            echo json_encode(array('type' => 'Error', 'value' => "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error));
            exit();
        }

        // Prepara la query di inserimento
        $sql = "INSERT INTO evento (tipo, data_ora_inizio, descrizione, luogo, durata) VALUES ('" . $tipo . "', '" . $data_ora_inizio . "', '" . $descrizione . "', '" . $luogo . "', " . $durata . ")";
        if ($mydb->query($sql)) {
            //         // Inserimento riuscito, reindirizza alla pagina dell'elenco degli atleti
            //         // header("Location: elenco_atleti.php");
            echo json_encode(array('type' => 'Success', 'value' => 'Evento inserito con successo'));
            //         exit();
        } else {
            echo json_encode(array('type' => 'Error', 'value' => "Errore durante l'inserimento dell'evento: " . $stmt->error));
        }
        // Chiudi la connessione al database
        $mydb->close();
    }
}
