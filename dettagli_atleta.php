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
            if (confirm('Sei sicuro di voler eliminare questo atleta?')) {
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
        }

        function handleAddInjury() {
            var elements = document.getElementsByClassName('Injury__add_inputs');
            try {
                Array.from(elements).forEach((el) => {
                    el.style = 'display:table-row';
                })

            } catch (e) {
                console.log(e);
            }
        }

        function handleCancelInjury() {
            var elements = document.getElementsByClassName('Injury__add_inputs');
            try {
                Array.from(elements).forEach((el) => {
                    el.style = 'display:none';
                })

                const Error__data_ora_visita = document.getElementById('Error__data_ora_visita');
                const Error__tipo_infortunio = document.getElementById('Error__tipo_infortunio');
                const Error__descrizione = document.getElementById('Error__descrizione');

                Error__data_ora_visita.style.visibility = 'hidden';
                Error__tipo_infortunio.style.visibility = 'hidden';
                Error__descrizione.style.visibility = 'hidden';

                const data_ora_visita = document.getElementById('data_ora_visita');
                const tipo_infortunio = document.getElementById('tipo_infortunio');
                const descrizione = document.getElementById('descrizione');
                const altre_informazioni = document.getElementById('altre_informazioni');
                data_ora_visita.value = '';
                tipo_infortunio.value = '';
                descrizione.value = '';
                altre_informazioni.value = '';
            } catch (e) {
                console.log(e);
            }
        }

        function handleSaveNewInjury() {
            const atleta = document.getElementById('id_atleta').value;
            const data_ora_visita = document.getElementById('data_ora_visita').value;
            const tipo_infortunio = document.getElementById('tipo_infortunio').value;
            const descrizione = document.getElementById('descrizione').value;
            const altre_informazioni = document.getElementById('altre_informazioni').value;

            const Error__data_ora_visita = document.getElementById('Error__data_ora_visita');
            const Error__tipo_infortunio = document.getElementById('Error__tipo_infortunio');
            const Error__descrizione = document.getElementById('Error__descrizione');

            Error__data_ora_visita.style.visibility = 'hidden';
            Error__tipo_infortunio.style.visibility = 'hidden';
            Error__descrizione.style.visibility = 'hidden';


            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let res;
                    try {
                        res = JSON.parse(this.responseText)
                        if (res['type'] === 'Param_Error') {
                            let items = res['value'].trim().split(' ')
                            items.forEach(item => {
                                if (item === 'data_ora_visita') {
                                    Error__data_ora_visita.style.visibility = 'visible'
                                } else if (item === 'tipo_infortunio') {
                                    Error__tipo_infortunio.style.visibility = 'visible'
                                } else if (item === 'descrizione') {
                                    Error__descrizione.style.visibility = 'visible'
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

            xmlhttp.open("POST", "nuovo_infortunio_atleta.php", false);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("atleta=" + atleta + "&data_ora_visita=" + data_ora_visita + "&tipo_infortunio=" + tipo_infortunio + "&descrizione=" + descrizione + "&altre_informazioni=" + altre_informazioni);
        }

        function handleDeleteInjury(num) {
            if (confirm('Sei sicuro di voler eliminare l\'infortunio selezionato?')) {
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

                xmlhttp.open("POST", "elimina_infortunio_atleta.php", false);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("id=" + num);
            }
        }

        function handle_row_update(num) {
            const el = document.getElementById("data_ora_visita_" + num);
            const elsp = document.getElementById("sp_data_ora_visita_" + num);
            const el2 = document.getElementById("tipo_infortunio_" + num);
            const el2sp = document.getElementById("sp_tipo_infortunio_" + num);
            const el3 = document.getElementById("descrizione_" + num);
            const el3sp = document.getElementById("sp_descrizione_" + num);
            const el4 = document.getElementById("altre_informazioni_" + num);
            const el4sp = document.getElementById("sp_altre_informazioni_" + num);
            el.style = "display:table-cell !important;";
            el2.style = "display:table-cell !important;";
            el3.style = "display:table-cell !important;";
            el4.style = "display:table-cell !important;";
            elsp.style = "display:none";
            el2sp.style = "display:none";
            el3sp.style = "display:none";
            el4sp.style = "display:none";
            const btns1 = document.getElementById("Injury__action_state_1_" + num);
            const btns2 = document.getElementById("Injury__action_state_2_" + num);
            btns2.style = 'display:flex';
            btns1.style = 'display:none';
        }

        function handle_row_cancel(num) {
            const el = document.getElementById("data_ora_visita_" + num);
            const elsp = document.getElementById("sp_data_ora_visita_" + num);
            const el2 = document.getElementById("tipo_infortunio_" + num);
            const el2sp = document.getElementById("sp_tipo_infortunio_" + num);
            const el3 = document.getElementById("descrizione_" + num);
            const el3sp = document.getElementById("sp_descrizione_" + num);
            const el4 = document.getElementById("altre_informazioni_" + num);
            const el4sp = document.getElementById("sp_altre_informazioni_" + num);
            el.style = "display:none !important";
            el2.style = "display:none !important";
            el3.style = "display:none !important";
            el4.style = "display:none !important";
            elsp.style = "display:table-cell !important;";
            el2sp.style = "display:table-cell !important;";
            el3sp.style = "display:table-cell !important;";
            el4sp.style = "display:table-cell !important;";
            const btns1 = document.getElementById("Injury__action_state_1_" + num);
            const btns2 = document.getElementById("Injury__action_state_2_" + num);
            btns1.style = 'display:flex';
            btns2.style = 'display:none';
        }

        function handleUpdateInjury(num) {
            const data_ora_visita = document.getElementById('data_ora_visita_' + num).value;
            const tipo_infortunio = document.getElementById('tipo_infortunio_' + num).value;
            const descrizione = document.getElementById('descrizione_' + num).value;
            const altre_informazioni = document.getElementById('altre_informazioni_' + num).value;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {

                if (this.readyState == 4 && this.status == 200) {
                    let res;
                    try {
                        res = JSON.parse(this.responseText)
                        if (res['type'] === 'Param_Error') {
                            let items = res['value'].trim().split(' ')
                            items.forEach(item => {
                                if (item === 'data_ora_visita') {
                                    alert("Il campo 'data_ora_visita' deve essere compilato")
                                } else if (item === 'tipo_infortunio') {
                                    alert("Il campo 'tipo_infortunio' deve essere compilato")
                                } else if (item === 'descrizione') {
                                    alert("Il campo 'descrizione' deve essere compilato")
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

            xmlhttp.open("POST", "modifica_infortunio_atleta.php", false);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("id=" + num + "&data_ora_visita=" + data_ora_visita + "&tipo_infortunio=" + tipo_infortunio + "&descrizione=" + descrizione + "&altre_informazioni=" + altre_informazioni);
        }
    </script>
</head>

<body>
    <div class="Container">
        <div class="Header__container">
            <div class="Header__logo"><img src="./images/logo.svg" alt='Logo' /></div>
            <div class="Header__title"><span class="blu">Volley</span><span class="orange">Track</span></div>
        </div>
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

        ?>


                <div class="Main__container">
                    <div class="Main__header">
                        <h1>Dettagli Atleta</h1>
                        <img onclick='back_home()' class='Home' src="./images/home.svg" alt="Home" />
                        <div class="Button" onclick="delete_atleta()">
                            <img src="./images/delete.svg" alt="Delete user" />
                            Elimina
                        </div>
                    </div>
                    <div class="Container__atleta">
                        <div class="Main__body Dettagli_Atleta">
                            <?php
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
                            <?php
                            }
                            ?>
                        </div>
                        <div class="infortuni">
                            <div class="Main__container">
                                <div class="Main__header">
                                    <h1>Infortuni</h1>
                                    <div class="Button" onclick="handleAddInjury()">
                                        <img src="./images/add.svg" alt="Add injury" />
                                        Aggiungi Infortunio
                                    </div>
                                </div>
                                <div class="Main__body">
                                    <?php
                                    $sql = "SELECT * FROM `informazioni_mediche` where fkAtleta = '$id_atleta' order by data_ora_visita";
                                    $result = $mydb->query($sql);

                                    echo "<table><thead><tr><th>Data ora visita</th><th>Tipo infortunio</th><th>descrizione</th><th>altre info</th><th></th></tr></thead><tbody>";
                                    if ($result && $result->num_rows > 0) {
                                    ?>
                                        <?php

                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <input class='tbl_inj_input' type='datetime-local' <?php echo "name='data_ora_visita_" . $row["id"] . "' id='data_ora_visita_" . $row["id"] . "' value='" . $row["data_ora_visita"] . "'" ?>>
                                                    <?php echo "<span id='sp_data_ora_visita_" . $row["id"] . "'>" . $row['data_ora_visita'] . "</span>" ?>
                                                </td>
                                                <td>
                                                    <input class='tbl_inj_input' type='text' autocomplete="off" <?php echo "name='tipo_infortunio_" . $row["id"] . "' id='tipo_infortunio_" . $row["id"] . "' value='" . $row["tipo_infortunio"] . "'" ?>>
                                                    <?php echo "<span id='sp_tipo_infortunio_" . $row["id"] . "'>" . $row['tipo_infortunio'] . "</span>" ?>
                                                </td>
                                                <td>
                                                    <input class='tbl_inj_input' type='text' autocomplete="off" <?php echo "name='descrizione_" . $row["id"] . "' id='descrizione_" . $row["id"] . "' value='" . $row["descrizione"] . "'" ?>>
                                                    <?php echo "<span id='sp_descrizione_" . $row["id"] . "'>" . $row['descrizione'] . "</span>" ?>
                                                </td>
                                                <td>
                                                    <input class='tbl_inj_input' type='text' autocomplete="off" <?php echo "name='altre_informazioni_" . $row["id"] . "' id='altre_informazioni_" . $row["id"] . "' value='" . $row["altre_informazioni"] . "'" ?>>
                                                    <?php echo "<span id='sp_altre_informazioni_" . $row["id"] . "'>" . $row['altre_informazioni'] . "</span>" ?>
                                                </td>
                                                <td>
                                                    <div class='Injury__action Injury__action_state_1' id='Injury__action_state_1_<?php echo $row["id"] ?>'><a onclick='handle_row_update(<?php echo $row["id"] ?>)' class='Button' id='btnUpdateStat'><img src='./images/update.svg' alt='Update injury' /></a><a class='Button' onclick='handleDeleteInjury(<?php echo $row["id"] ?>)'><img src='./images/delete.svg' alt='Delete stat' /></a></div>
                                                    <div class='Injury__action Injury__action_state_2' id='Injury__action_state_2_<?php echo $row["id"] ?>'><a class='Button' id='btnSaveInjury' onclick='handleUpdateInjury(<?php echo $row["id"] ?>)'><img src='./images/save.svg' /></a><a class='Button' id='btnCancelInjury' onclick='handle_row_cancel(<?php echo $row["id"] ?>)'><img src='./images/cancel_white.svg' /></a></div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr class="Injury__add_inputs">
                                            <td><input autocomplete="off" type="datetime-local" name="data_ora_visita" id="data_ora_visita"></td>
                                            <td><input autocomplete="off" type="text" name="tipo_infortunio" id="tipo_infortunio"></td>
                                            <td><input autocomplete="off" type="text" name="descrizione" id="descrizione"></td>
                                            <td><input autocomplete="off" type="text" name="altre_informazioni" id="altre_informazioni"></td>
                                            <td>
                                                <div class="Injury__action"><a class="Button" id='btnAddInjury' onclick="handleSaveNewInjury()"><img src="./images/add.svg" alt="Add user injury" /></a><a class="Button" id='btnCancelInjury' onclick="handleCancelInjury()"><img src="./images/cancel_white.svg" alt="Cancel user injury" /></a></div>
                                            </td>
                                        </tr>
                                        <tr class="Injury__add_inputs">
                                            <td><span class='Error' id='Error__data_ora_visita'>Il campo 'data_ora_visita' deve essere compilato</span></td>
                                            <td><span class='Error' id='Error__tipo_infortunio'>Il campo 'tipo_infortunio' deve essere compilato</span></td>
                                            <td><span class='Error' id='Error__descrizione'>Il campo 'descrizione' deve essere compilato</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <?php


                                        echo "</tbody></table>";

                                        ?>

                                    <?php
                                    } else {
                                    ?>
                                        <tr class="Injury__add_inputs">
                                            <td><input autocomplete="off" type="datetime-local" name="data_ora_visita" id="data_ora_visita"></td>
                                            <td><input autocomplete="off" type="text" name="tipo_infortunio" id="tipo_infortunio"></td>
                                            <td><input autocomplete="off" type="text" name="descrizione" id="descrizione"></td>
                                            <td><input autocomplete="off" type="text" name="altre_informazioni" id="altre_informazioni"></td>
                                            <td>
                                                <div class="Injury__action"><a class="Button" id='btnAddInjury' onclick="handleSaveNewInjury()"><img src="./images/add.svg" alt="Add user injury" /></a><a class="Button" id='btnCancelInjury' onclick="handleCancelInjury()"><img src="./images/cancel_white.svg" alt="Cancel user injury" /></a></div>
                                            </td>
                                        </tr>
                                        <tr class="Injury__add_inputs">
                                            <td><span class='Error' id='Error__data_ora_visita'>Il campo 'data_ora_visita' deve essere compilato</span></td>
                                            <td><span class='Error' id='Error__tipo_infortunio'>Il campo 'tipo_infortunio' deve essere compilato</span></td>
                                            <td><span class='Error' id='Error__descrizione'>Il campo 'descrizione' deve essere compilato</span></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                        </table>
                                        <div class="NoData">
                                            Nessun infortunio registrato per questo atleta.
                                        </div>
                                    <?php

                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="Main__container eventi">
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
                                }
                                    ?>

                    </div>
                </div>


        <?php

            } else {
                echo "Atleta non trovato";
            }
            $mydb->close();
        } else {
            header('Location: home.php');
            exit;
        }
        ?>
    </div>
</body>

</html>