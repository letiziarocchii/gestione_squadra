<?php
require("config.php");

// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i valori dal modulo
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $data_nascita = $_POST["data_nascita"];
    $ruolo = $_POST["ruolo"];

    // Connettiti al database
    $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
    if ($mydb->connect_errno) {
        echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
        exit();
    }

    // Prepara la query di inserimento
    $sql = "INSERT INTO atleta (nome, cognome, data_nascita, ruolo) VALUES (?, ?, ?, ?)";
    
    // Prepara e esegui la dichiarazione preparata
    if ($stmt = $mydb->prepare($sql)) {
        $stmt->bind_param("ssss", $nome, $cognome, $data_nascita, $ruolo);
        // Esegui la query di inserimento
        if ($stmt->execute()) {
        // Inserimento riuscito, reindirizza alla pagina dell'elenco degli atleti
        header("Location: elenco_atleti.php");
    exit();
} else {
    echo "Errore durante l'inserimento dell'atleta: " . $stmt->error;
}

        $stmt->close();
    } else {
        echo "Errore nella preparazione della query: " . $mydb->error;
    }

    // Chiudi la connessione al database
    $mydb->close();
}
?>
