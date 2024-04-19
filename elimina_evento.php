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

    // Prendi l'ID dell'evento dall'input
    $id_evento = $mydb->real_escape_string($_POST['id']);

    // Prima di eliminare l'evento, eliminiamo i record correlati nella tabella partecipa
    $sql_elimina_partecipazioni = "DELETE FROM partecipa WHERE fkEvento = '$id_evento'";
    if ($mydb->query($sql_elimina_partecipazioni)) {
        // Query per eliminare l'evento
        $sql_elimina_evento = "DELETE FROM evento WHERE id = '$id_evento'";
        if ($mydb->query($sql_elimina_evento)) {
            echo json_encode(array('type' => 'Success', 'value' => "Evento eliminato con successo."));
        } else {
            echo json_encode(array('type' => 'Error', 'value' => "Errore durante l'eliminazione dell'evento: " . $mydb->error));
        }
    } else {
        echo json_encode(array('type' => 'Error', 'value' => "Errore durante l'eliminazione delle partecipazioni associate all'evento: " . $mydb->error));
    }

    // Chiudi la connessione al database
    $mydb->close();
} else {
    // Se l'ID dell'evento non è stato ricevuto, reindirizza l'utente alla pagina precedente o a una pagina di errore
    header("Location: home.php"); // Cambia "index.php" con la pagina a cui vuoi reindirizzare l'utente
    exit();
}
