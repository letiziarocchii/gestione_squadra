<!DOCTYPE html>
<html>

<head>
    <title>Elenco Atleti</title>

</head>

<body>

    <div class="container">
        <h2>Elenco Atleti</h2>

        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        require("config.php"); //parametri di connessione
        $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
        if ($mydb->connect_errno) {
            echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
            exit();
        }


        // Verifica della connessione
        if ($mydb->connect_errno) {
            echo "Errore nella connessione a MySQL: (" . $mydb->connect_errno . ") " . $mydb->connect_error;
            exit();
        }

        $sql = "SELECT id, nome, cognome FROM atleta";
        $result = $mydb->query($sql);

        if ($result->num_rows > 0) {
            // Stampa i dati di ogni atleta con link ai dettagli
            while ($row = $result->fetch_assoc()) {
                echo "<div class='atleta'><a href='dettagli_atleta.php?id=" . $row["id"] . "'>" . $row["nome"] . " " . $row["cognome"] . "</a></div>";
            }
        } else {
            echo "Nessun risultato trovato";
        }




        // Chiusura della connessione
        $mydb->close();

        ?>
    </div>
    <div>
        <br><a href='nuovo_atleta.php'><button class='button'>Inserisci nuovo atleta</button></a>
    </div>

</body>

</html>