<?php
// Verifica se è stato ricevuto l'ID dell'evento da eliminare
if(isset($_POST['id'])) {
    require("config.php"); // Includi il file di configurazione per la connessione al database
    
    // Connessione al database
    $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
    if ($mydb->connect_errno) {
        echo "Errore nella connessione a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        exit();  // Termina lo script
    }
    
    // Prendi l'ID dell'evento dall'input
    $id_evento = $mydb->real_escape_string($_POST['id']);
    
    // Query per eliminare l'evento
    $sql_elimina_evento = "DELETE FROM evento WHERE id = '$id_evento'";
    
    // Esegui la query
    if ($mydb->query($sql_elimina_evento) === TRUE) {
        echo "Evento eliminato con successo.";
    } else {
        echo "Errore durante l'eliminazione dell'evento: " . $mydb->error;
    }
    
    // Chiudi la connessione al database
    $mydb->close();
} else {
    // Se l'ID dell'evento non è stato ricevuto, reindirizza l'utente alla pagina precedente o a una pagina di errore
    header("Location: index.php"); // Cambia "index.php" con la pagina a cui vuoi reindirizzare l'utente
    exit();
}
?>
