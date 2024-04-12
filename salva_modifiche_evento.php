<?php
// Verifica se sono stati inviati dati tramite il metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se sono stati ricevuti tutti i dati necessari
    if(isset($_POST['id']) && isset($_POST['tipo']) && isset($_POST['data_ora_inizio']) && isset($_POST['durata']) && isset($_POST['descrizione']) && isset($_POST['luogo'])) {
        // Prendi l'ID dell'evento e gli altri dati inviati dal modulo
        $id_evento = $_POST['id'];
        $tipo = $_POST['tipo'];
        $data_ora_inizio = $_POST['data_ora_inizio'];
        $durata = $_POST['durata'];
        $descrizione = $_POST['descrizione'];
        $luogo = $_POST['luogo'];
        
        // Connessione al database
        require("config.php");  // File di configurazione per la connessione al database
        $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
        if ($mydb->connect_errno) {
            echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
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
