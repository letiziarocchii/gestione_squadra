<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTIONE SQUADRA</title>
    <link rel="icon" href="./images/logo.svg" type="image/icon type">
    <link rel="stylesheet" href="./css/style.css">
    <script>
        function filter(str) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementsByClassName("Main__body")[0].innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "filter.php?q=" + str, true);
            xmlhttp.send();
        }

        function filter_evento(str) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementsByClassName("Main__body")[1].innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "filter_evento.php?q=" + str, true);
            xmlhttp.send();
        }

        function clearInput(id) {
            if (id === 'search') {
                filter('')
            }
            if (id === 'search_evento') {
                filter_evento('')
            }

            document.getElementById(id).value = ''
        }
    </script>

<body>

</body>
<div class="Container">
    <div class="Header__container">
        <div class="Header__logo"><img src="./images/logo.svg" alt='Logo' /></div>
        <div class="Header__title"><span class="blu">Volley</span><span class="orange">Track</span></div>
    </div>
    <div class="Main__container">
        <div class="Main__header">
            <h1>La tua squadra</h1>
            <div class="Search">
                <img class='Search__Search_icon' src="./images/search.svg" alt="Search" />
                <input type="text" id="search" autocomplete="off" onkeyup="filter(this.value)" placeholder="Cerca atleta" />
                <img class='Search__Cancel_icon' src="./images/cancel.svg" alt="Cancel" onclick="clearInput('search')" />
            </div>
            <a class="Button" href="nuovo_atleta.php">
                <img src="./images/add.svg" alt="Add user" />
                Nuovo Atleta
            </a>
        </div>
        <div class="Main__body">
            <?php
            error_reporting(E_ALL);
            session_start();
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
                // // Stampa i dati di ogni atleta con link ai dettagli
                $_SESSION["atleti"] = $result->fetch_all();

                foreach ($_SESSION["atleti"] as $row) {
                    echo "
                    <a class='Card' href='dettagli_atleta.php?id=" . $row[0] . "'>
                    <img src='./images/user.svg' alt='user photo' loading='lazy' />
                    <span>" . $row[1] . "</span>
                    <span>" . $row[2] . "</span>
                    </a>";
                }
            } else {
            ?>
                <div class="NoData">
                    Nessun alteta trovato
                </div>
            <?php
            }

            // Chiusura della connessione
            $mydb->close();

            ?>
        </div>
    </div>
    <div class="Main__container">
        <div class="Main__header">
            <h1>I tuoi eventi</h1>
            <div class="Search">
                <img class='Search__Search_icon' src="./images/search.svg" alt="Search" />
                <input type="text" id="search_evento" autocomplete="off" onkeyup="filter_evento(this.value)" placeholder="Cerca evento" />
                <img class='Search__Cancel_icon' src="./images/cancel.svg" alt="Cancel" onclick="clearInput('search_evento')" />
            </div>
            <a class="Button" href="nuovo_evento.php">
                <img src="./images/add.svg" alt="Add user" />
                Nuovo Evento
            </a>
        </div>
        <div class="Main__body">
            <?php
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

            $sql = "SELECT * FROM evento ";
            $result = $mydb->query($sql);

            if ($result->num_rows > 0) {
                // // Stampa i dati di ogni atleta con link ai dettagli
                $_SESSION["eventi"] = $result->fetch_all();
            ?>
                <table>
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Data e Ora</th>
                            <th>Descrizione</th>
                            <th>Luogo</th>
                            <th>Durata in minuti</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($_SESSION["eventi"] as $row) {
                            echo "
                            <tr><td>" . $row[1] . "</td>
                                <td>" . $row[2] . "</td>
                                <td>" . $row[3] . "</td>
                                <td>" . $row[4] . "</td>
                                <td class='text_center'>" . $row[5] . "</td>
                                <td>(<a class='table_link' href='dettagli_evento.php?id=" . $row[0] . "'>Dettagli</a>)</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
            ?>
                <div class="NoData">
                    Nessun evento trovato
                </div>
            <?php
            }

            // Chiusura della connessione
            $mydb->close();

            ?>
        </div>
    </div>
</div>

</html>