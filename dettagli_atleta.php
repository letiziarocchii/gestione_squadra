<!DOCTYPE html>
<html>
<head>
    <title>Dettagli Atleta</title>
    
</head>
<body>

<h2>Dettagli Atleta</h2>


<?php

if(isset($_GET['id'])) {
    require("config.php"); 
			$mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
			if ($mydb->connect_errno) {
				echo "Errore nella connessione a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				exit(); 
			}
			
    
    $id_atleta = $mydb->real_escape_string($_GET['id']);
    
    // Query per selezionare l'atleta con l'ID specificato
    $sql_atleta = "SELECT * FROM atleta WHERE id = '$id_atleta'";
    $result_atleta = $mydb->query($sql_atleta);

    if ($result_atleta->num_rows > 0) {
        // Stampa i dettagli dell'atleta
        while($row_atleta = $result_atleta->fetch_assoc()) {
            echo "<p>Id atleta: ". $row_atleta["id"]. "<br>Nome: " . $row_atleta["nome"] . "<br>Cognome: " . $row_atleta["cognome"] . "<br>Data di nascita: " . $row_atleta["data_nascita"] . "<br>Ruolo: " . $row_atleta["ruolo"] . "</p>";

            // Query per selezionare gli eventi a cui l'atleta ha partecipato
            $sql_eventi = "SELECT evento.* FROM evento INNER JOIN partecipa ON evento.id = partecipa.fkEvento WHERE partecipa.fkAtleta = '$id_atleta'";
            $result_eventi = $mydb->query($sql_eventi);

            // Stampa gli eventi a cui l'atleta ha partecipato
            if ($result_eventi->num_rows > 0) {
                echo "<h3>Eventi a cui ha partecipato:</h3>";
                echo "<ul>";
                while($row_eventi = $result_eventi->fetch_assoc()) {
                    
                    echo "<li><a href='dettagli_evento.php?id=" . $row_eventi["id"] . "'>" . $row_eventi["descrizione"] . "</a></li>";
                }
                echo "</ul>";
            } 
            else {
                echo "<h3>Eventi a cui ha partecipato:</h3>";
                echo "L'atleta non ha partecipato a nessun evento.";
            }

            $sql_visita = "SELECT * FROM visita WHERE fkAtleta = '$id_atleta'";
            $result_vis = $mydb->query($sql_visita);
            // Stampa le informazioni mediche dell'atleta
            if ($result_vis->num_rows>0) {
                echo "<h3>Informazioni mediche:</h3>";
                echo "<ul>";
                while($row_vis = $result_vis->fetch_assoc()) {
                    echo "<li>Scadenza visita medica: " . $row_vis["data_scadenza"] . "</li>";
                }
                echo "</ul>";
                echo "<ul>";
                echo "</ul>";
            } 
            else {
                echo "<h3>Informazioni mediche:</h3>";
                echo "<ul>";
                echo "Visita medica sportiva non inserita";
            }

            $sql_infortunio = "SELECT * FROM infortunio INNER JOIN atleta ON infortunio.fkAtleta= atleta.id WHERE atleta.id = '$id_atleta'";
            $result_inf = $mydb->query($sql_infortunio);
        if ($result_inf->num_rows > 0 && $result_vis->num_rows > 0) {
            echo "<ul>";
            while ($row_inf = $result_inf->fetch_assoc()) {
                echo "<a href='dettaglio_infortunio.php?id=" . $row_inf["id"] . "'>";
                echo "<li>Tipologia: " . $row_inf["descrizione"] . "</li>";
                echo "</a>";
            }
            echo "</ul>";
        } else {
            echo "<h3>Informazioni mediche:</h3>";
            echo "<ul>";
            echo "<li>Nessuna informazione medica disponibile per questo atleta.</li>";
            echo "</ul>";
        }


}
    }
     else {
        echo "Atleta non trovato";
    }
    $mydb->close();
} else {
    echo "ID dell'atleta non specificato";
}
?>

<br><a href="modifica_atleta.php?id=<?php echo $id_atleta; ?>"><button>Modifica Dettagli Atleta</button></a>
<br>
<br><form method="post" action="elimina_atleta.php">
        <input type="hidden" name="id" value="<?php echo $id_atleta; ?>">
        <input type="submit" value="Elimina Atleta" onclick="return confirm('Sei sicuro di voler eliminare questo atleta?');">
    </form>
<br><a href='elenco_atleti.php?id=" . $id_atleta . "'><button>Indietro</button></a>

</body>
</html>

