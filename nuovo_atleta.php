<!DOCTYPE html>
<html>
<head>
    <title>Aggiungi Atleta</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Aggiungi nuovo atleta</h2>
    <form action="nuovo_atleta.script.php" method="post" >
        Nome: <input type="text" name="nome" id= "nome"><br><br>
        Cognome: <input type="text" name="cognome" id= "cognome"><br><br>
        Data di nascita: <input type="date" name="data_nascita" id= "data_nascita"><br><br>
        Ruolo: <input type="text" name="ruolo" id= "ruolo"><br><br>
        <input type="submit" name="submit" value="Aggiungi Atleta">
    </form>
</body>
</html>


