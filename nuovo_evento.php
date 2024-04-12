<!DOCTYPE html>
<html>
<head>
    <title>Aggiungi Evento</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Aggiungi nuovo evento</h2>
    <form action="nuovo_evento.script.php" method="post" >
        Id Atleta <input type="text" name="fkAtleta" id= "fkAtleta"><br><br>
        Tipo: <input type="text" name="tipo" id= "tipo"><br><br>
        Data e ora: <input type="datetime-local" name="data_ora_inizio" id= "data_ora_inizio"><br><br>
        Descrizione <input type="text" name="descrizione" id= "descrizione"><br><br>
        Luogo: <input type="text" name="luogo" id= "luogo"><br><br>
        Durata in minuti: <input type="text" name="durata" id= "durata"><br><br>
        Punti segnati: <input type="text" name="punti_segnati" id="punti_segnati">
        Errori: <input type="text" name="errori" id= "errori"><br><br>
        Percentuale di successo: <input type="text" name="errori" id= "errori"><br><br>
        <a href='dettagli_atleta.php?id=" . $id_atleta . "'><button>Aggiungi evento</button></a>
    </form>
</body>
</html>