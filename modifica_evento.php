<!DOCTYPE html>
<html>
<head>
    <title>Modifica Evento</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Modifica Dettagli Evento</h2>

<?php
// Verifica se è stato passato l'ID dell'evento
if(isset($_GET['id'])) {
    $id_evento = $_GET['id'];
    
    // Connessione al database
    require("config.php");  // File di configurazione per la connessione al database
    $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
    if ($mydb->connect_errno) {
        echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
        exit();  // Termina la pagina
    }
    
    // Query per selezionare l'evento con l'ID specificato
    $sql_evento = "SELECT * FROM evento WHERE id = '$id_evento'";
    $result_evento = $mydb->query($sql_evento);

    if ($result_evento->num_rows > 0) {
        // Mostra il modulo per modificare i dettagli dell'evento
        $row_evento = $result_evento->fetch_assoc();
?>
        <form method="post" action="salva_modifiche_evento.php">
            <input type="hidden" name="id" value="<?php echo $id_evento; ?>">
            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" value="<?php echo $row_evento['tipo']; ?>"><br><br>
            <label for="data_ora_inizio">Data e Ora Inizio:</label>
            <input type="datetime-local" id="data_ora_inizio" name="data_ora_inizio" value="<?php echo date('Y-m-d\TH:i', strtotime($row_evento['data_ora_inizio'])); ?>"><br><br>
            <label for="durata">Durata (minuti):</label>
            <input type="number" id="durata" name="durata" value="<?php echo $row_evento['durata']; ?>"><br><br>
            <label for="descrizione">Descrizione:</label>
            <textarea id="descrizione" name="descrizione"><?php echo $row_evento['descrizione']; ?></textarea><br><br>
            <label for="luogo">Luogo:</label>
            <input type="text" id="luogo" name="luogo" value="<?php echo $row_evento['luogo']; ?>"><br><br>
            <input type="submit" value="Salva Modifiche">
        </form>
<?php
    } else {
        echo "Evento non trovato";
    }
    $mydb->close();
} else {
    echo "ID dell'evento non specificato";
}
?>
<br>
<a href="dettagli_evento.php?id=<?php echo $id_evento; ?>">Indietro</a>

</body>
</html>
