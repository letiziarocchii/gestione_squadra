<!DOCTYPE html>
<html>

<head>
    <title>Dettagli Evento</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="widthead=device-widthead, initial-scale=1.0">
    <link rel="icon" href="./images/logo.svg" type="image/icon type">
    <link rel="stylesheet" href="./css/style.css">
    <script>
        function back_home() {
            window.location.href = 'home.php'
        }

        function back_atleta() {
            const id_atleta = document.getElementById('id_atleta').value;
            window.location.href = 'dettagli_atleta.php?id=' + id_atleta
        }

        function change_state() {
            var btn = document.getElementById('btnUpdate');
            var tipo = document.getElementById('tipo');
            var data_ora_inizio = document.getElementById('data_ora_inizio');
            var descrizione = document.getElementById('descrizione');
            var luogo = document.getElementById('luogo');
            var durata = document.getElementById('durata');

            const id_evento = document.getElementById('id_evento').value;
            const Error__tipo = document.getElementById('Error__tipo')
            const Error__data_ora_inizio = document.getElementById('Error__data_ora_inizio')
            const Error__descrizione = document.getElementById('Error__descrizione')
            const Error__luogo = document.getElementById('Error__luogo')
            const Error__durata = document.getElementById('Error__durata')
            Error__durata.innerHTML = 'Il campo durata è obbligatorio'



            if (btn.innerHTML.includes('Modifica')) {
                btn.innerHTML = '<img src="./images/save.svg" alt="Save user" />Salva';
                tipo.readOnly = false;
                tipo.style.backgroundColor = '#e5e596';
                data_ora_inizio.readOnly = false;
                data_ora_inizio.style.backgroundColor = '#e5e596';
                descrizione.readOnly = false;
                descrizione.style.backgroundColor = '#e5e596';
                luogo.readOnly = false;
                luogo.style.backgroundColor = '#e5e596';
                durata.readOnly = false;
                durata.style.backgroundColor = '#e5e596';

            } else if (btn.innerHTML.includes('Salva')) {

                Error__tipo.style.visibility = 'hidden'
                Error__data_ora_inizio.style.visibility = 'hidden'
                Error__descrizione.style.visibility = 'hidden'
                Error__luogo.style.visibility = 'hidden'
                Error__durata.style.visibility = 'hidden'

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let res;
                        try {
                            res = JSON.parse(this.responseText)
                            console.log(res)
                        } catch (e) {
                            alert(this.responseText)
                        }

                        if (res['type'] === 'Param_Error') {
                            let items = res['value'].trim().split(' ')
                            items.forEach(item => {
                                if (item === 'tipo') {
                                    Error__tipo.style.visibility = 'visible'
                                }
                                if (item === 'data_ora_inizio') {
                                    Error__data_ora_inizio.style.visibility = 'visible'
                                }
                                if (item === 'descrizione') {
                                    Error__descrizione.style.visibility = 'visible'
                                }
                                if (item === 'luogo') {
                                    Error__luogo.style.visibility = 'visible'
                                }
                                if (item === 'durata') {
                                    Error__durata.style.visibility = 'visible'
                                }
                                if (item === 'durataL') {
                                    Error__durata.innerHTML = 'Il campo durata deve essere maggiore di zero'
                                    Error__durata.style.visibility = 'visible'
                                }
                            })
                        } else if (res['type'] === 'Success') {
                            alert(res['value'])
                            btn.innerHTML = '<img src="./images/update.svg" alt="Update user" />Modifica';
                            tipo.readOnly = true;
                            tipo.style.backgroundColor = '#fff';
                            data_ora_inizio.readOnly = true;
                            data_ora_inizio.style.backgroundColor = '#fff';
                            descrizione.readOnly = true;
                            descrizione.style.backgroundColor = '#fff';
                            luogo.readOnly = true;
                            luogo.style.backgroundColor = '#fff';
                            durata.readOnly = true;
                            durata.style.backgroundColor = '#fff';
                        } else if (res['type'] === 'Error') {
                            alert(res['value'])
                        } else {
                            alert(res)
                        }
                    }
                }

                xmlhttp.open("POST", "salva_modifiche_evento.php", false);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("id=" + id_evento + "&tipo=" + tipo.value + "&data_ora_inizio=" + data_ora_inizio.value + "&durata=" + durata.value + "&descrizione=" + descrizione.value + "&luogo=" + luogo.value);
            }
        }

        function delete_evento() {
            const id_evento = document.getElementById('id_evento').value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let res;
                    try {
                        res = JSON.parse(this.responseText)
                        alert(res['value'])
                        if (res['type'] === 'Success') {
                            window.location.href = 'home.php'
                        }
                    } catch (e) {
                        alert(this.responseText)
                    }
                }
            }

            xmlhttp.open("POST", "elimina_evento.php", false);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("id=" + id_evento);
        }
    </script>
</head>

<body>
    <div class="Container">
        <div class="Header__container">
            <div class="Header__logo"><img src="./images/logo.svg" alt='Logo' /></div>
            <div class="Header__title"><span class="blu">Volley</span><span class="orange">Track</span></div>
        </div>
        <div class="Main__container">
            <div class="Main__header">
                <h1>Dettagli Evento</h1>
                <div>

                    <img onclick='back_atleta()' class='Back' src="./images/left.svg" alt="Back" />
                    <img onclick='back_home()' class='Home' src="./images/home.svg" alt="Home" />
                </div>
                <div class="Button" onclick="delete_evento()">
                    <img src="./images/delete.svg" alt="Delete event" />
                    Elimina
                </div>
            </div>
            <div class="Main__body Dettagli_Evento">
                <?php
                // Verifica se è stato passato l'ID dell'evento
                if (isset($_GET['id'])) {
                    require("config.php");  //file di config con i parametri di connessione
                    $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
                    if ($mydb->connect_errno) {
                        echo "Errore nella connessione a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                        exit();  //termina la pagina
                    }

                    // Prepara l'ID dell'evento per la query
                    $id_evento = $mydb->real_escape_string($_GET['id']);
                    $id_atleta = $mydb->real_escape_string($_GET['id_atleta']);

                    // Query per selezionare l'evento con l'ID specificato
                    $sql_evento = "SELECT * FROM evento where id = '$id_evento'";
                    // $sql_evento = "SELECT evento.*, punti_segnati, errori FROM evento INNER JOIN partecipa ON evento.id = partecipa.fkEvento WHERE evento.id = '$id_evento' and partecipa.fkAtleta = '$id_atleta'";
                    $result_evento = $mydb->query($sql_evento);

                    // Verifica se ci sono risultati nella query
                    if ($result_evento && $result_evento->num_rows > 0) {
                        // Stampa i dettagli dell'evento
                        $row_evento = $result_evento->fetch_assoc();
                ?>
                        <div class="form">
                            <input type="hidden" name="id" id="id_atleta" value="<?php echo $id_atleta; ?>">
                            <input type="hidden" name="id" id="id_evento" value="<?php echo $id_evento; ?>">
                            Tipo: <input type="text" name="tipo" id="tipo" readonly value='<?php echo $row_evento["tipo"] ?>'>
                            <span class='Error' id='Error__tipo'>Il campo tipo è obbligatorio</span>
                            Data e ora: <input type="datetime-local" name="data_ora_inizio" id="data_ora_inizio" readonly value='<?php echo $row_evento["data_ora_inizio"] ?>'>
                            <span class='Error' id='Error__data_ora_inizio'>Il campo data e ora è obbligatorio</span>
                            Descrizione <input type="text" name="descrizione" id="descrizione" readonly value='<?php echo $row_evento["descrizione"] ?>'>
                            <span class='Error' id='Error__descrizione'>Il campo descrizione è obbligatorio</span>
                            Luogo: <input type="text" name="luogo" id="luogo" readonly value='<?php echo $row_evento["luogo"] ?>'>
                            <span class='Error' id='Error__luogo'>Il campo luogo è obbligatorio</span>
                            Durata in minuti: <input type="text" name="durata" id="durata" readonly value='<?php echo $row_evento["durata"] ?>'>
                            <span class='Error' id='Error__durata'>Il campo durata è obbligatorio</span>
                            <a class="Button" onclick="change_state()" id='btnUpdate'><img src="./images/update.svg" alt="Update user" />Modifica</a>
                        </div>
                <?php
                        // echo "<p>Tipo: " . $row_evento["tipo"] . "<br>Data e ora inizio: " . $row_evento["data_ora_inizio"] . "<br>Duarata in minuti: " . $row_evento["durata"] . "<br>Descrizione: " . $row_evento["descrizione"] . "<br>Luogo: " . $row_evento["luogo"] . "</p>";
                        // echo "<p>Punti segnati: " . $row_evento["punti_segnati"] . "<br>Errori: " . $row_evento["errori"] . "<br>Percentuale successo: " . round(($row_evento["punti_segnati"] / ($row_evento["punti_segnati"] + $row_evento["errori"]) * 100), 2) . "%</p>";
                    } else {
                        echo "Evento non trovato";
                    }
                    $mydb->close();
                } else {
                    echo "ID dell'evento non specificato";
                }
                ?>
            </div>
        </div>
        <div class="Main__container">
            <div class="Main__header">
                <h1>Statistiche</h1>
            </div>
            <div class="Main__body Dettagli_Evento">
                <?php
                // Verifica se è stato passato l'ID dell'evento
                if (isset($_GET['id'])) {
                    require("config.php");  //file di config con i parametri di connessione
                    $mydb = new mysqli(SERVER, UTENTE, PASSWORD, DATABASE);
                    if ($mydb->connect_errno) {
                        echo "Errore nella connessione a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                        exit();  //termina la pagina
                    }


                    // Prepara l'ID dell'evento per la query
                    $id_evento = $mydb->real_escape_string($_GET['id']);
                    $id_atleta = $mydb->real_escape_string($_GET['id_atleta']);

                    // Query per selezionare l'evento con l'ID specificato
                    // $sql_evento = "SELECT * FROM partecipa WHERE fkEvento = '$id_evento'";
                    $sql_evento = "SELECT nome, cognome, punti_segnati, errori FROM partecipa INNER JOIN atleta ON partecipa.fkAtleta = atleta.id WHERE partecipa.fkEvento = '$id_evento'";
                    $result_evento = $mydb->query($sql_evento);

                    // Verifica se ci sono risultati nella query
                    if ($result_evento && $result_evento->num_rows > 0) {
                        // Stampa i dettagli dell'evento
                        echo "<table><thead><tr><th>Cognome</th><th>Nome</th><th>Punti segnati</th><th>Errori</th><th>Percentuale successo</th></tr></thead><tbody>";
                        while ($row_evento = $result_evento->fetch_assoc()) {

                            echo "<tr><td>" . $row_evento["cognome"] . "</td><td>" . $row_evento["nome"] . "</td><td class='text_center'>" . $row_evento["punti_segnati"] . "</td><td class='text_center'>" . $row_evento["errori"] . "</td><td class='text_center'>" . round(($row_evento["punti_segnati"] / ($row_evento["punti_segnati"] + $row_evento["errori"])) * 100, 2) . " %</td></tr>";
                        }
                        echo "</tbody></table>";
                    } else {
                        echo "Evento non trovato";
                    }
                    $mydb->close();
                } else {
                    echo "ID dell'evento non specificato";
                }
                ?>
            </div>
        </div>
    </div>
    <a href="modifica_evento.php?id=<?php echo $id_evento; ?>"><button>Modifica Dettagli evento</button></a>
    <form metheadod="post" action="elimina_evento.php">
        <input type="hidden" name="id" value="<?php echo $id_evento; ?>">
        <input type="submit" value="Elimina Evento" onclick="return confirm('Sei sicuro di voler eliminare questo evento?');">
    </form>

    <a href='elenco_atleti.php'><button>Indietro</button></a>

</body>

</html>