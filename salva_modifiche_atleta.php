<?php
// Verifica se sono stati inviati dati tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        // Prendi l'ID dell'atleta e gli altri dati inviati dal modulo
        $id_atleta = $_POST['id'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $data_nascita = $_POST['data_nascita'];
        $ruolo = $_POST['ruolo'];

        $errore = '';

        if (empty($nome)) {
            $errore .= "nome";
        }

        if (empty($cognome)) {
            $errore .=  ' cognome';
        }

        if (empty($data_nascita)) {
            $errore .= ' data_nascita';
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
            $nome = $mydb->real_escape_string($nome);
            $cognome = $mydb->real_escape_string($cognome);
            $data_nascita = $mydb->real_escape_string($data_nascita);
            $ruolo = $mydb->real_escape_string($ruolo);

            // Query per aggiornare i dettagli dell'atleta nel database
            $sql_aggiorna_atleta = "UPDATE atleta SET nome = '$nome', cognome = '$cognome', data_nascita = '$data_nascita', ruolo = '$ruolo' WHERE id = '$id_atleta'";

            // Esegui la query di aggiornamento
            if ($mydb->query($sql_aggiorna_atleta) === TRUE) {
                echo json_encode(array('type' => 'Success', 'value' => 'Modifiche salvate con successo'));
            } else {
                echo json_encode(array('type' => 'Error', 'value' => "Errore durante il salvataggio delle modifiche: " . $mydb->error));
            }

            // Chiudi la connessione al database
            $mydb->close();
        }
    } else {
        // Se l'ID dell'atleta non è stato ricevuto, reindirizza l'utente alla pagina precedente o a una pagina di errore
        header("Location: home.php"); // Cambia "index.php" con la pagina a cui vuoi reindirizzare l'utente
        exit();
    }
} else {
    echo json_encode(array('type' => 'Error', 'value' => "Metodo di richiesta non valido."));
}
