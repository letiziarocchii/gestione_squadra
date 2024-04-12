<?php
// Verifica se sono stati inviati dati tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se sono stati ricevuti tutti i dati necessari
    if(isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['data_nascita']) && isset($_POST['ruolo'])) {
        // Prendi l'ID dell'atleta e gli altri dati inviati dal modulo
        $id_atleta = $_POST['id'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $data_nascita = $_POST['data_nascita'];
        $ruolo = $_POST['ruolo'];
        
        // Connessione al database
        require("config.php");  // File di configurazione per la connessione al database
        $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
        if ($mydb->connect_errno) {
            echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
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
            echo "Modifiche salvate con successo.";
        } else {
            echo "Errore durante il salvataggio delle modifiche: " . $mydb->error;
        }
        
        // Chiudi la connessione al database
        $mydb->close();
    } else {
        echo "Non tutti i dati necessari sono stati ricevuti.";
    }
} else {
    echo "Metodo di richiesta non valido.";
}
?>
<a href='elenco_atleti.php'><button>Indietro</button></a>
