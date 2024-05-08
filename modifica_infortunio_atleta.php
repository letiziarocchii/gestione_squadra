<?php
// Verifica se sono stati inviati dati tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $data_ora_visita = $_POST['data_ora_visita'];
        $tipo_infortunio = $_POST['tipo_infortunio'];
        $descrizione = $_POST['descrizione'];
        $altre_informazioni = $_POST['altre_informazioni'];

        $errore = '';

        if (empty($data_ora_visita)) {
            $errore .= "data_ora_visita";
        }

        if (empty($tipo_infortunio)) {
            $errore .=  ' tipo_infortunio';
        }

        if (empty($descrizione)) {
            $errore .=  ' descrizione';
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
            $sql_aggiorna = "UPDATE informazioni_mediche SET data_ora_visita = '$data_ora_visita', tipo_infortunio = '$tipo_infortunio', descrizione = '$descrizione', altre_informazioni = '$altre_informazioni' WHERE id = '$id'";
            // Esegui la query di aggiornamento
            if ($mydb->query($sql_aggiorna) === TRUE) {
                echo json_encode(array('type' => 'Success', 'value' => 'Modifiche salvate con successo'));
            } else {
                echo json_encode(array('type' => 'Error', 'value' => "Errore durante il salvataggio delle modifiche: " . $mydb->error));
            }

            // Chiudi la connessione al database
            $mydb->close();
        }
    } else {
        // Se l'ID dell'atleta non è stato ricevuto, reindirizza l'utente alla pagina precedente o a una pagina di errore
        exit();
    }
} else {
    echo json_encode(array('type' => 'Error', 'value' => "Metodo di richiesta non valido."));
}
