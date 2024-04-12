<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i valori dal modulo
    $fkAtleta= $_POST["fkAtleta"];
    $tipo = $_POST["tipo"];
    $data_ora_inizio = $_POST["data_ora_inizio"];
    $descrizione = $_POST["descrizione"];
    $luogo = $_POST["luogo"];
    $durata = $_POST["durata"];
    $punti_segnati = $_POST["punti_segnati"];
    $errori = $_POST["errori"];
    
   

    // Connettiti al database
    $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
    if ($mydb->connect_errno) {
        echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
        exit();
    }
   
   

    // Prepara la query di inserimento per l'evento
    $sql_evento = "INSERT INTO evento (tipo, data_ora_inizio, descrizione, luogo, durata) VALUES (?, ?, ?, ?, ?)";
    
    // Prepara e esegui la dichiarazione preparata per l'evento
    if ($stmt_evento = $mydb->prepare($sql_evento)) {
        $stmt_evento->bind_param("sssss",  $tipo, $data_ora_inizio, $descrizione, $luogo, $durata);
        // Esegui la query di inserimento per l'evento
        if ($stmt_evento->execute()) {
            // Recupera l'ID dell'evento appena inserito
            $id_evento = $mydb->insert_id;

            // Prepara la query di inserimento per la tabella partecipa
            $sql_partecipa = "INSERT INTO partecipa (fkEvento, fkAtleta, punti_segnati, errori, percentuale_successo) VALUES (?, ?, ?, ?, NULL)";

            // Prepara e esegui la dichiarazione preparata per la tabella partecipa
            if ($stmt_partecipa = $mydb->prepare($sql_partecipa)) {
                $stmt_partecipa->bind_param("iiis", $id_evento,$fkAtleta,  $punti_segnati, $errori);
                if ($stmt_partecipa->execute()) {

                    header("Location: dettagli_atleta.php?id=" . $fkAtleta);
                    exit();
                } else {
                    echo "Errore durante l'inserimento nella tabella partecipa: " . $stmt_partecipa->error;
                }
                $stmt_partecipa->close();
            } else {
                echo "Errore nella preparazione della query per la tabella partecipa: " . $mydb->error;
            }
        } else {
            echo "Errore durante l'inserimento dell'evento: " . $stmt_evento->error;
        }
        $stmt_evento->close();
    } else {
        echo "Errore nella preparazione della query per l'evento: " . $mydb->error;
    }

    // Chiudi la connessione al database
    $mydb->close();
}
?>

?>
