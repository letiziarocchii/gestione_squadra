<!DOCTYPE html>
<html>

<head>
    <title>Nuovo Evento</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="widthead=device-widthead, initial-scale=1.0">
    <link rel="icon" href="./images/logo.svg" type="image/icon type">
    <link rel="stylesheet" href="./css/style.css">
    <script>
        function back_home() {
            window.location.href = 'home.php'
        }


        function submit() {
            const tipo = document.getElementById('tipo');
            const data_ora_inizio = document.getElementById('data_ora_inizio');
            const descrizione = document.getElementById('descrizione');
            const luogo = document.getElementById('luogo');
            const durata = document.getElementById('durata');

            const Error__tipo = document.getElementById('Error__tipo')
            const Error__data_ora_inizio = document.getElementById('Error__data_ora_inizio')
            const Error__descrizione = document.getElementById('Error__descrizione')
            const Error__luogo = document.getElementById('Error__luogo')
            const Error__durata = document.getElementById('Error__durata')
            const Error__durata2 = document.getElementById('Error__durata2')





            Error__tipo.style.visibility = 'hidden'
            Error__data_ora_inizio.style.visibility = 'hidden'
            Error__descrizione.style.visibility = 'hidden'
            Error__luogo.style.visibility = 'hidden'
            Error__durata.style.visibility = 'hidden'
            Error__durata2.style.visibility = 'hidden'

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let res;
                    try {
                        res = JSON.parse(this.responseText)
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
                                    Error__durata2.style.visibility = 'visible'
                                }
                            })
                        } else if (res['type'] === 'Success') {
                            alert(res['value'])
                            back_home()
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

            xmlhttp.open("POST", "nuovo_evento.script.php", false);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("tipo=" + tipo.value + "&data_ora_inizio=" + data_ora_inizio.value + "&durata=" + durata.value + "&descrizione=" + descrizione.value + "&luogo=" + luogo.value);
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
                <h1>Aggiungi nuovo Evento</h1>
                <div>
                    <img onclick='back_home()' class='Home' src="./images/home.svg" alt="Home" />
                </div>
            </div>
            <div class="Main__body Dettagli_Evento">
                <div class="form">
                    Tipo: <input type="text" autocomplete="off" name="tipo" id="tipo">
                    <span class='Error' id='Error__tipo'>Il campo tipo è obbligatorio</span>
                    Data e ora: <input type="datetime-local" name="data_ora_inizio" id="data_ora_inizio">
                    <span class='Error' id='Error__data_ora_inizio'>Il campo data e ora è obbligatorio</span>
                    Descrizione <input autocomplete="off" type="text" name="descrizione" id="descrizione">
                    <span class='Error' id='Error__descrizione'>Il campo descrizione è obbligatorio</span>
                    Luogo: <input type="text" autocomplete="off" name="luogo" id="luogo">
                    <span class='Error' id='Error__luogo'>Il campo luogo è obbligatorio</span>
                    Durata in minuti: <input type="number" autocomplete="off" min="0" name="durata" id="durata">
                    <span class='Error' id='Error__durata'>Il campo durata è obbligatorio</span>
                    <span class='Error' id='Error__durata2'>Il campo durata deve essere > 0</span>
                    <a class="Button" onclick="submit()"><img src="./images/add.svg" alt="Add" />Aggiungi Evento</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>