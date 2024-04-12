<!DOCTYPE html>
<html>
<head>
    <title>Dettagli Evento</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Dettagli Evento</h2>

<?php
// Verifica se è stato passato l'ID dell'evento
if(isset($_GET['id'])) {
    require("config.php");  //file di config con i parametri di connessione
    $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
    if ($mydb->connect_errno) {
        echo "Errore nella connessione a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        exit();  //termina la pagina
    }

    // Prepara l'ID dell'evento per la query
    $id_evento = $mydb->real_escape_string($_GET['id']);

    // Query per selezionare l'evento con l'ID specificato
    $sql_evento = "SELECT evento.* FROM evento LEFT JOIN partecipa ON evento.id = partecipa.fkEvento WHERE evento.id = '$id_evento'";
    $result_evento = $mydb->query($sql_evento);

    // Verifica se ci sono risultati nella query
    if ($result_evento && $result_evento->num_rows > 0) {
        // Stampa i dettagli dell'evento
        $row_evento = $result_evento->fetch_assoc();
        echo "<p>Tipo: " . $row_evento["tipo"] . "<br>Data e ora inizio: " . $row_evento["data_ora_inizio"] . "<br>Duarata in minuti: " . $row_evento["durata"] . "<br>Descrizione: " . $row_evento["descrizione"] . "<br>Luogo: " . $row_evento["luogo"] . "</p>" ;
        
    } else {
        echo "Evento non trovato";
    }
    $mydb->close();
} else {
    echo "ID dell'evento non specificato";
}


?>
<a href="modifica_evento.php?id=<?php echo $id_evento; ?>"><button>Modifica Dettagli evento</button></a>
<form method="post" action="elimina_evento.php">
    <input type="hidden" name="id" value="<?php echo $id_evento; ?>">
    <input type="submit" value="Elimina Evento" onclick="return confirm('Sei sicuro di voler eliminare questo evento?');">
</form>

<a href='elenco_atleti.php'><button>Indietro</button></a>

</body>
</html>

