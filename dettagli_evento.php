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
            if (confirm('Sei sicuro di voler eliminare questo evento?')) {
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

        }

        function handleAddStat() {
            var elements = document.getElementsByClassName('Stats__add_inputs');
            try {
                Array.from(elements).forEach((el) => {
                    el.style = 'display:table-row';
                })

            } catch (e) {
                console.log(e);
            }
        }

        function handleCancelStat() {
            var elements = document.getElementsByClassName('Stats__add_inputs');
            try {
                Array.from(elements).forEach((el) => {
                    el.style = 'display:none';
                })

                const Error__pt_fatti = document.getElementById('Error__pt_fatti');
                const Error__pt_errori = document.getElementById('Error__pt_errori');

                Error__pt_fatti.style.visibility = 'hidden';
                Error__pt_errori.style.visibility = 'hidden';

                const pt_fatti = document.getElementById('pt_fatti');
                const pt_errori = document.getElementById('pt_errori');
                pt_fatti.value = 0;
                pt_errori.value = 0;
            } catch (e) {
                console.log(e);
            }
        }

        function handleSaveNewStat() {
            const id_evento = document.getElementById('id_evento').value;
            const atleta = document.getElementById('atleta').value;
            const pt_fatti = document.getElementById('pt_fatti').value;
            const pt_errori = document.getElementById('pt_errori').value;

            const Error__pt_fatti = document.getElementById('Error__pt_fatti');
            const Error__pt_errori = document.getElementById('Error__pt_errori');

            Error__pt_fatti.style.visibility = 'hidden';
            Error__pt_errori.style.visibility = 'hidden';


            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let res;
                    try {
                        res = JSON.parse(this.responseText)
                        if (res['type'] === 'Param_Error') {
                            let items = res['value'].trim().split(' ')
                            items.forEach(item => {
                                if (item === 'pt_fatti') {
                                    Error__pt_fatti.style.visibility = 'visible'
                                } else if (item === 'pt_errori') {
                                    Error__pt_errori.style.visibility = 'visible'
                                }
                            })
                        } else if (res['type'] === 'Success') {
                            alert(res['value'])
                            window.location.reload();
                        } else if (res['type'] === 'Error') {
                            alert(res['value'])
                        } else {
                            alert(res)
                        }
                    } catch (e) {
                        alert(this.responseText)
                    }
                }
            }

            xmlhttp.open("POST", "nuova_statistica_atleta.php", false);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("id=" + id_evento + "&atleta=" + atleta + "&pt_fatti=" + pt_fatti + "&pt_errori=" + pt_errori);
        }

        function handle_row_update(num) {
            const el = document.getElementById("errori_" + num);
            const el2 = document.getElementById("sp_errori_" + num);
            const el3 = document.getElementById("punti_" + num);
            const el4 = document.getElementById("sp_punti_" + num);
            el.style = "display:table-cell !important;";
            el3.style = "display:table-cell !important;";
            el2.style = "display:none";
            el4.style = "display:none";
            const btns1 = document.getElementById("Stats__action_state_1_" + num);
            const btns2 = document.getElementById("Stats__action_state_2_" + num);
            btns2.style = 'display:flex';
            btns1.style = 'display:none';
        }

        function handle_row_cancel(num) {
            const el = document.getElementById("errori_" + num);
            const el2 = document.getElementById("sp_errori_" + num);
            const el3 = document.getElementById("punti_" + num);
            const el4 = document.getElementById("sp_punti_" + num);
            el2.style = "display:block !important;";
            el4.style = "display:block !important;";
            el3.style = "display:none !important";
            el.style = "display:none !important";
            const btns1 = document.getElementById("Stats__action_state_1_" + num);
            const btns2 = document.getElementById("Stats__action_state_2_" + num);
            btns1.style = 'display:flex';
            btns2.style = 'display:none';
        }

        function handleUpdateStat(num) {
            console.log(num)
            const pt_fatti = document.getElementById('punti_' + num).value;
            const pt_errori = document.getElementById('errori_' + num).value;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let res;
                    try {
                        res = JSON.parse(this.responseText)
                        if (res['type'] === 'Param_Error') {
                            let items = res['value'].trim().split(' ')
                            items.forEach(item => {
                                if (item === 'pt_fatti') {
                                    alert("Il campo 'punti segnati' deve essere >= di 0")
                                } else if (item === 'pt_errori') {
                                    alert("Il campo 'errori' deve essere >= di 0")
                                }
                            })
                        } else if (res['type'] === 'Success') {
                            alert(res['value'])
                            window.location.reload();
                        } else if (res['type'] === 'Error') {
                            alert(res['value'])
                        } else {
                            alert(res)
                        }
                    } catch (e) {
                        alert(this.responseText)
                    }
                }
            }

            xmlhttp.open("POST", "modifica_statistica_atleta.php", false);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("id=" + num + "&pt_fatti=" + pt_fatti + "&pt_errori=" + pt_errori);
        }

        function handleDeleteStat(num) {
            if (confirm('Sei sicuro di voler eliminare le statistiche di questo atleta?')) {
                const id_evento = document.getElementById('id_evento').value;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let res;
                        try {
                            res = JSON.parse(this.responseText)
                            alert(res['value'])
                            if (res['type'] === 'Success') {
                                window.location.reload();
                            }
                        } catch (e) {
                            alert(this.responseText)
                        }
                    }
                }

                xmlhttp.open("POST", "elimina_statistica_atleta.php", false);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("id=" + num);
            }
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
                <div class="Button" onclick="handleAddStat()">
                    <img src="./images/add.svg" alt="Add athlete" />
                    Aggiungi Atleta
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
                    // $sql_evento = "SELECT * FROM partecipa WHERE fkEvento = '$id_evento'";
                    $sql_evento = "SELECT partecipa.id, nome, cognome, punti_segnati, errori FROM partecipa INNER JOIN atleta ON partecipa.fkAtleta = atleta.id WHERE partecipa.fkEvento = '$id_evento' ORDER BY (punti_segnati/(punti_segnati+errori)) desc, cognome, nome";
                    $result_evento = $mydb->query($sql_evento);

                    // Verifica se ci sono risultati nella query
                    if ($result_evento && $result_evento->num_rows > 0) {
                        // Stampa i dettagli dell'evento
                        echo "<table><thead><tr><th>Cognome</th><th>Nome</th><th>Punti segnati</th><th>Errori</th><th>Percentuale successo</th><th></th></tr></thead><tbody>";
                        while ($row_evento = $result_evento->fetch_assoc()) {
                ?>
                            <tr>
                                <td><?php echo $row_evento['cognome'] ?></td>
                                <td><?php echo $row_evento['nome'] ?></td>
                                <td class='text_center punti'>
                                    <input class='tbl_stat_input' type='number' min='0' <?php echo "name='punti_" . $row_evento["id"] . "' id='punti_" . $row_evento["id"] . "' value='" . $row_evento["punti_segnati"] . "'" ?>>
                                    <?php echo "<span class='text_center' id='sp_punti_" . $row_evento["id"] . "'>" . $row_evento["punti_segnati"] . "</span>" ?>
                                </td>
                                <td class='text_center errori'>
                                    <input class='tbl_stat_input' type='number' min='0' <?php echo "name='errori_" . $row_evento["id"] . "' id='errori_" . $row_evento["id"] . "' value='" . $row_evento["errori"] . "'" ?>>
                                    <?php echo "<span class='text_center' id='sp_errori_" . $row_evento["id"] . "'>" . $row_evento["errori"] . "</span>" ?>
                                </td>
                                <td class='text_center'><?php echo round(($row_evento["punti_segnati"] / ($row_evento["punti_segnati"] + $row_evento["errori"])) * 100, 2) . " % " ?></td>
                                <td>
                                    <div class='Stats__action Stats__action_state_1' id='Stats__action_state_1_<?php echo $row_evento["id"] ?>'><a onclick='handle_row_update(<?php echo $row_evento["id"] ?>)' class='Button' id='btnUpdateStat'><img src='./images/update.svg' alt='Update stat' /></a><a class='Button' onclick='handleDeleteStat(<?php echo $row_evento["id"] ?>)'><img src='./images/delete.svg' alt='Delete stat' /></a></div>
                                    <div class='Stats__action Stats__action_state_2' id='Stats__action_state_2_<?php echo $row_evento["id"] ?>'><a class='Button' id='btnSaveStats' onclick='handleUpdateStat(<?php echo $row_evento["id"] ?>)'><img src='./images/save.svg' /></a><a class='Button' id='btnCancelStats' onclick='handle_row_cancel(<?php echo $row_evento["id"] ?>)'><img src='./images/cancel_white.svg' /></a></div>
                                </td>
                            </tr>
                        <?php
                        }

                        $sql_atleti_new = "SELECT id, nome, cognome FROM atleta WHERE id NOT IN (SELECT fkatleta FROM partecipa INNER JOIN atleta ON partecipa.fkAtleta = atleta.id WHERE partecipa.fkEvento = '$id_evento') ORDER BY cognome, nome";
                        $result_atleti = $mydb->query($sql_atleti_new);
                        if ($result_atleti && $result_atleti->num_rows > 0) {
                        ?>
                            <tr class="Stats__add_inputs">
                                <td colspan=2>
                                    <select name="atleta" id="atleta">
                                        <?php
                                        while ($row_atleta = $result_atleti->fetch_assoc()) {
                                            echo "<option value='" . $row_atleta["id"] . "'>" . $row_atleta["cognome"] . " " . $row_atleta["nome"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td><input type="number" min="0" name="pt_fatti" id="pt_fatti" value='0'></td>
                                <td><input type="number" min="0" name="pt_errori" id="pt_errori" value='0'></td>
                                <td></td>
                                <td>
                                    <div class="Stats__action"><a class="Button" id='btnAddStats' onclick="handleSaveNewStat()"><img src="./images/add.svg" alt="Add user stat" /></a><a class="Button" id='btnCancelStats' onclick="handleCancelStat()"><img src="./images/cancel_white.svg" alt="Cancel user stat" /></a></div>
                                </td>
                            </tr>
                            <tr class="Stats__add_inputs">
                                <td></td>
                                <td></td>
                                <td><span class='Error' id='Error__pt_fatti'>Il campo 'punti segnati' deve essere >= di 0</span></td>
                                <td><span class='Error' id='Error__pt_errori'>Il campo 'errori' deve essere >= di 0</span></td>
                                <td></td>
                                <td></td>
                            </tr>
                <?php
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
</body>

</html>