<!DOCTYPE html>
<html>
<head>
    <title>Modifica Atleta</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<h2>Modifica Dettagli Atleta</h2>

<?php
// Verifica se è stato passato l'ID dell'atleta
if(isset($_GET['id'])) {
    $id_atleta = $_GET['id'];
    
    // Connessione al database
    require("config.php");  // File di configurazione per la connessione al database
    $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
    if ($mydb->connect_errno) {
        echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
        exit();  // Termina la pagina
    }
    
    // Query per selezionare l'atleta con l'ID specificato
    $sql_atleta = "SELECT * FROM atleta WHERE id = '$id_atleta'";
    $result_atleta = $mydb->query($sql_atleta);

    if ($result_atleta->num_rows > 0) {
        // Mostra il modulo per modificare i dettagli dell'atleta
        $row_atleta = $result_atleta->fetch_assoc();
?>
        <form method="post" action="salva_modifiche_atleta.php">
            <input type="hidden" name="id" value="<?php echo $id_atleta; ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $row_atleta['nome']; ?>"><br><br>
            <label for="cognome">Cognome:</label>
            <input type="text" id="cognome" name="cognome" value="<?php echo $row_atleta['cognome']; ?>"><br><br>
            <label for="data_nascita">Data di Nascita:</label>
            <input type="date" id="data_nascita" name="data_nascita" value="<?php echo $row_atleta['data_nascita']; ?>"><br><br>
            <label for="ruolo">Ruolo:</label>
            <input type="text" id="ruolo" name="ruolo" value="<?php echo $row_atleta['ruolo']; ?>"><br><br>
            <input type="submit" value="Salva Modifiche">
        </form>
<?php
    } else {
        echo "Atleta non trovato";
    }
    $mydb->close();
} else {
    echo "ID dell'atleta non specificato";
}
?>
<br>
<a href="dettagli_atleta.php?id=<?php echo $id_atleta; ?>">Indietro</a>

</body>
</html>
