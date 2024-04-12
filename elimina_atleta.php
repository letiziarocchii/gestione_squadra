<?php
// Verifica se è stato ricevuto l'ID dell'atleta da eliminare
if(isset($_POST['id'])) {
    require("config.php"); // Includi il file di configurazione per la connessione al database
    
    // Connessione al database
    $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
    if ($mydb->connect_errno) {
        echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
        exit();  // Termina lo script
    }
    
    // Prendi l'ID dell'atleta dall'input
    $id_atleta = $mydb->real_escape_string($_POST['id']);
    
    // Prima di eliminare l'atleta, eliminiamo i record correlati nella tabella partecipa
    $sql_elimina_partecipazioni = "DELETE FROM partecipa WHERE fkAtleta = '$id_atleta'";
    if ($mydb->query($sql_elimina_partecipazioni)) {
        // Ora possiamo eliminare l'atleta
        $sql_elimina_atleta = "DELETE FROM atleta WHERE id = '$id_atleta'";
        if ($mydb->query($sql_elimina_atleta)) {
            echo "Atleta eliminato con successo.";
           
        } else {
            echo "Errore durante l'eliminazione dell'atleta: " . $mydb->error;
        }
    } else {
        echo "Errore durante l'eliminazione delle partecipazioni dell'atleta: " . $mydb->error;
    }
    
    // Chiudi la connessione al database
    $mydb->close();
} else {
    // Se l'ID dell'atleta non è stato ricevuto, reindirizza l'utente alla pagina precedente o a una pagina di errore
    header("Location: index.php"); // Cambia "index.php" con la pagina a cui vuoi reindirizzare l'utente
    exit();
}
?>
<a href='elenco_atleti.php'><button>Indietro</button></a>