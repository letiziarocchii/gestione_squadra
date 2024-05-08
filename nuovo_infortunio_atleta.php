<?php
// Verifica se sono stati inviati dati tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['atleta'])) {
        // Prendi i dati inviati dal modulo
        $id_atleta = $_POST['atleta'];
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
            $sql = "INSERT INTO `informazioni_mediche` (`fkAtleta`, `data_ora_visita`, `tipo_infortunio`, `descrizione`, `altre_informazioni`) VALUES ('" . $id_atleta . "', '" . $data_ora_visita . "', '" . $tipo_infortunio . "', '" . $descrizione . "', '" . $altre_informazioni . "')";

            // Esegui la query di aggiornamento
            if ($mydb->query($sql) === TRUE) {
                echo json_encode(array('type' => 'Success', 'value' => 'Infortunio inserito con successo!'));
            } else {
                echo json_encode(array('type' => 'Error', 'value' => "Errore durante il salvataggio dell'infortunio: " . $mydb->error));
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
