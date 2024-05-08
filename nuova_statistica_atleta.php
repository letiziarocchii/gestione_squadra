<?php
// Verifica se sono stati inviati dati tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['atleta'])) {
        // Prendi l'ID dell'evento e gli altri dati inviati dal modulo
        $id_evento = $_POST['id'];
        $id_atleta = $_POST['atleta'];
        $pt_fatti = $_POST['pt_fatti'];
        $pt_errori = $_POST['pt_errori'];

        $errore = '';

        if ($pt_fatti < 0) {
            $errore .= "pt_fatti";
        }

        if ($pt_errori < 0) {
            $errore .=  ' pt_errori';
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

            // Query per aggiornare i dettagli dell'atleta nel database
            $sql_add_stat_atleta = "INSERT INTO `partecipa` (`fkAtleta`, `fkEvento`, `punti_segnati`, `errori`) VALUES ('" . $id_atleta . "', '" . $id_evento . "', '" . $pt_fatti . "', '" . $pt_errori . "')";

            // Esegui la query di aggiornamento
            if ($mydb->query($sql_add_stat_atleta) === TRUE) {
                echo json_encode(array('type' => 'Success', 'value' => 'Statistiche inserite con successo!'));
            } else {
                echo json_encode(array('type' => 'Error', 'value' => "Errore durante il salvataggio delle statistiche: " . $mydb->error));
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
