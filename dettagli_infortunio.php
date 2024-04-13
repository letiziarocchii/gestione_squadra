<!DOCTYPE html>
<html>
<head>
    <title>Dettagli Atleta</title>
    
</head>
<body>

<h2>Dettagli infortunio</h2>


<?php
    if(isset($_GET['id'])) {
        require("config.php");  //file di config con i parametri di connessione
        $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
        if ($mydb->connect_errno) {
            echo "Errore nella connessione a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            exit();  //termina la pagina
        }
    
        // Prepara l'ID dell'evento per la query
        $id_infortunio = $mydb->real_escape_string($_GET['id']);
    
        // Query per selezionare l'evento con l'ID specificato
        $sql_infortunio = "SELECT * FROM infortunio INNER JOIN atleta ON infortunio.fkAtleta= atleta.id WHERE fkAtleta = '$id_infortunio'";
        $result_inf = $mydb->query($sql_infortunio);
        // Verifica se ci sono risultati nella query
        if ($result_inf && $result_inf->num_rows > 0) {
            // Stampa i dettagli dell'evento
            $row_inf = $result_inf->fetch_assoc();
            echo "<p>Tipologia: " . $row_inf["descrizione"] . "<br>Data dell'infortunio: " . $row_inf["data"] . "<br>data di rientro: " . $row_inf["data_rientro"] . "<br>Tempo di stop: " . $row_inf["pausa"] . "</p>" ;
            
        } else {
            echo "Evento non trovato";
        }
        $mydb->close();
    } else {
        echo "ID dell'evento non specificato";
    }
    
?>
<br>
<br><a href='elenco_atleti.php?id=" . $id_atleta . "'><button>Indietro</button></a>
