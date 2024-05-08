<?php
// Verifica se è stato ricevuto l'ID dell'evento da eliminare
if (isset($_POST['id'])) {
    require("config.php"); // Includi il file di configurazione per la connessione al database

    // Connessione al database
    $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
    if ($mydb->connect_errno) {
        echo json_encode(array('type' => 'Error', 'value' => "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error));
        exit();  // Termina lo script
    }

    // Prendi l'ID 
    $id = $mydb->real_escape_string($_POST['id']);

    $sql_elimina = "DELETE FROM informazioni_mediche WHERE id = '$id'";
    if ($mydb->query($sql_elimina)) {
        echo json_encode(array('type' => 'Success', 'value' => "Infortunio eliminato con successo."));
    } else {
        echo json_encode(array('type' => 'Error', 'value' => "Errore durante l'eliminazione dell'infortunio: " . $mydb->error));
    }


    // Chiudi la connessione al database
    $mydb->close();
} else {
    exit();
}
