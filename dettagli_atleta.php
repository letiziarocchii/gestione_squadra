<!DOCTYPE html>
<html>

<head>
    <title>Dettagli Atleta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/logo.svg" type="image/icon type">
    <link rel="stylesheet" href="./css/style.css">
    <script>
        function back_home() {
            window.location.href = 'home.php'
        }

        function change_state() {
            var btn = document.getElementById('btnUpdate');
            var nome = document.getElementById('nome');
            var cognome = document.getElementById('cognome');
            var data_nascita = document.getElementById('data_nascita');
            var ruolo = document.getElementById('ruolo');
            const id_atleta = document.getElementById('id_atleta').value;
            const Error__nome = document.getElementById('Error__nome')
            const Error__cognome = document.getElementById('Error__cognome')
            const Error__data_nascita = document.getElementById('Error__data_nascita')


            if (btn.innerHTML.includes('Modifica')) {
                btn.innerHTML = '<img src="./images/save.svg" alt="Save user" />Salva';
                nome.readOnly = false;
                nome.style.backgroundColor = '#e5e596';
                cognome.readOnly = false;
                cognome.style.backgroundColor = '#e5e596';
                data_nascita.readOnly = false;
                data_nascita.style.backgroundColor = '#e5e596';
                ruolo.readOnly = false;
                ruolo.style.backgroundColor = '#e5e596';
            } else if (btn.innerHTML.includes('Salva')) {

                Error__nome.style.visibility = 'hidden'
                Error__cognome.style.visibility = 'hidden'
                Error__data_nascita.style.visibility = 'hidden'

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let res;
                        try {
                            res = JSON.parse(this.responseText)
                        } catch (e) {
                            alert(this.responseText)
                        }

                        if (res['type'] === 'Param_Error') {
                            let items = res['value'].trim().split(' ')
                            items.forEach(item => {
                                if (item === 'nome') {
                                    Error__nome.style.visibility = 'visible'
                                }
                                if (item === 'cognome') {
                                    Error__cognome.style.visibility = 'visible'
                                }
                                if (item === 'data_nascita') {
                                    Error__data_nascita.style.visibility = 'visible'
                                }
                            })
                        } else if (res['type'] === 'Success') {
                            alert(res['value'])
                            btn.innerHTML = '<img src="./images/update.svg" alt="Update user" />Modifica';
                            nome.readOnly = true;
                            nome.style.backgroundColor = '#fff';
                            cognome.readOnly = true;
                            cognome.style.backgroundColor = '#fff';
                            data_nascita.readOnly = true;
                            data_nascita.style.backgroundColor = '#fff';
                            ruolo.readOnly = true;
                            ruolo.style.backgroundColor = '#fff';
                        } else if (res['type'] === 'Error') {
                            alert(res['value'])
                        } else {
                            alert(res)
                        }
                    }
                }

                xmlhttp.open("POST", "salva_modifiche_atleta.php", false);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("id=" + id_atleta + "&nome=" + nome.value + "&cognome=" + cognome.value + "&data_nascita=" + data_nascita.value + "&ruolo=" + ruolo.value);
            }
        }

        function delete_atleta() {
            const id_atleta = document.getElementById('id_atleta').value;
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

            xmlhttp.open("POST", "elimina_atleta.php", false);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("id=" + id_atleta);
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
                <h1>Dettagli Atleta</h1>
                <img onclick='back_home()' class='Home' src="./images/home.svg" alt="Home" />
                <div class="Button" onclick="delete_atleta()">
                    <img src="./images/delete.svg" alt="Delete user" />
                    Elimina
                </div>
            </div>
            <div class="Main__body Dettagli_Atleta">
                <?php

                if (isset($_GET['id'])) {
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
                        while ($row_atleta = $result_atleta->fetch_assoc()) {
                ?>
                            <div class="form">
                                <input type="hidden" name="id" id="id_atleta" value="<?php echo $id_atleta; ?>">
                                Nome: <input type="text" autocomplete="off" name="nome" id="nome" readonly value='<?php echo $row_atleta["nome"] ?>'>
                                <span class='Error' id='Error__nome'>Il campo nome è obbligatorio</span>
                                Cognome: <input type="text" autocomplete="off" name="cognome" id="cognome" readonly value='<?php echo $row_atleta["cognome"] ?>'>
                                <span class='Error' id='Error__cognome'>Il campo cognome è obbligatorio</span>
                                Data di nascita: <input type="date" name="data_nascita" id="data_nascita" readonly value='<?php echo $row_atleta["data_nascita"] ?>'>
                                <span class='Error' id='Error__data_nascita'>Il campo data di nascita è obbligatorio</span>
                                Ruolo: <input type="text" autocomplete="off" name="ruolo" id="ruolo" readonly value='<?php echo $row_atleta["ruolo"] ?>'>
                                <a class="Button" onclick="change_state()" id='btnUpdate'><img src="./images/update.svg" alt="Update user" />Modifica</a>
                            </div>
            </div>
        </div>
        <div class="Main__container">
            <div class="Main__header">
                <h1>Eventi a cui ha partecipato</h1>
            </div>
            <div class="Main__body Eventi">
                <?php

                            // Query per selezionare gli eventi a cui l'atleta ha partecipato
                            $sql_eventi = "SELECT evento.* FROM evento INNER JOIN partecipa ON evento.id = partecipa.fkEvento WHERE partecipa.fkAtleta = '$id_atleta'";
                            $result_eventi = $mydb->query($sql_eventi);

                            // Stampa gli eventi a cui l'atleta ha partecipato
                            if ($result_eventi->num_rows > 0) {
                                echo "<ul>";
                                while ($row_eventi = $result_eventi->fetch_assoc()) {

                                    echo "<li>" . $row_eventi["descrizione"] . " (<a href='dettagli_evento.php?id=" . $row_eventi["id"] . "&id_atleta=" . $id_atleta . "'>Dettagli</a>)</li>";
                                }
                                echo "</ul>";
                            } else {
                ?> <div class="NoData">
                        L'atleta non ha partecipato a nessun evento.
                    </div><?php
                                echo "L'atleta non ha partecipato a nessun evento.";
                            }
                            ?>

            </div>
        </div>
    </div>

<?php

                            $sql_visita = "SELECT * FROM visita WHERE fkAtleta = '$id_atleta'";
                            $result_vis = $mydb->query($sql_visita);
                            // Stampa le informazioni mediche dell'atleta
                            if ($result_vis->num_rows > 0) {
                                echo "<h3>Informazioni mediche:</h3>";
                                echo "<ul>";
                                while ($row_vis = $result_vis->fetch_assoc()) {
                                    echo "<li>Scadenza visita medica: " . $row_vis["data_scadenza"] . "</li>";
                                }
                                echo "</ul>";
                                echo "<ul>";
                                echo "</ul>";
                            } else {
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
                    } else {
                        echo "Atleta non trovato";
                    }
                    $mydb->close();
                } else {
                    header('Location: home.php');
                    exit;
                }
?>

<br><a href="modifica_atleta.php?id=<?php echo $id_atleta; ?>"><button>Modifica Dettagli Atleta</button></a>
<br>
<br>
<form method="post" action="elimina_atleta.php">
    <input type="hidden" name="id" value="<?php echo $id_atleta; ?>">
    <input type="submit" value="Elimina Atleta" onclick="return confirm('Sei sicuro di voler eliminare questo atleta?');">
</form>
<br><a href='elenco_atleti.php?id=" . $id_atleta . "'><button>Indietro</button></a>

</body>

</html>