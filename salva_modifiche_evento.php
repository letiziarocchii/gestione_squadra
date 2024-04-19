<?php
// Verifica se sono stati inviati dati tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        // Prendi l'ID dell'evento e gli altri dati inviati dal modulo
        $id_evento = $_POST['id'];
        $tipo = $_POST['tipo'];
        $data_ora_inizio = $_POST['data_ora_inizio'];
        $durata = $_POST['durata'];
        $descrizione = $_POST['descrizione'];
        $luogo = $_POST['luogo'];

        $errore = '';

        if (empty($tipo)) {
            $errore .= "tipo";
        }
        if (empty($data_ora_inizio)) {
            $errore .= " data_ora_inizio";
        }
        if (empty($durata)) {
            $errore .= " durata";
        } else {
            if ($durata <= 0) {
                $errore .= " durataL";
            }
        }
        if (empty($descrizione)) {
            $errore .= " descrizione";
        }
        if (empty($luogo)) {
            $errore .= " luogo";
        }
        if (!empty($errore)) {
            echo json_encode(array('type' => 'Param_Error', 'value' => $errore));
        } else {

            // Connessione al database
            require("config.php");  // File di configurazione per la connessione al database
            $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
            if ($mydb->connect_errno) {
                echo json_encode(array('type' => 'Error', 'value' => "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error));
                exit();  // Termina lo script
            }

            // Prepara i dati per l'inserimento nel database
            $tipo = $mydb->real_escape_string($tipo);
            $data_ora_inizio = $mydb->real_escape_string($data_ora_inizio);
            $durata = $mydb->real_escape_string($durata);
            $descrizione = $mydb->real_escape_string($descrizione);
            $luogo = $mydb->real_escape_string($luogo);

            // Query per aggiornare i dettagli dell'evento nel database
            $sql_aggiorna_evento = "UPDATE evento SET tipo = '$tipo', data_ora_inizio = '$data_ora_inizio', durata = '$durata', descrizione = '$descrizione', luogo = '$luogo' WHERE id = '$id_evento'";

            // Esegui la query di aggiornamento
            if ($mydb->query($sql_aggiorna_evento) === TRUE) {
                echo json_encode(array('type' => 'Success', 'value' => 'Modifiche salvate con successo'));
            } else {
                echo json_encode(array('type' => 'Error', 'value' => "Errore durante il salvataggio delle modifiche: " . $mydb->error));
            }

            // Chiudi la connessione al database
            $mydb->close();
        }
    } else {
        header("Location: home.php"); // Cambia "index.php" con la pagina a cui vuoi reindirizzare l'utente
        exit();
    }
} else {
    echo json_encode(array('type' => 'Error', 'value' => "Metodo di richiesta non valido."));
}
