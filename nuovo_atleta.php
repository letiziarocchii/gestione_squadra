<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Atleta</title>
    <link rel="icon" href="./images/logo.svg" type="image/icon type">
    <link rel="stylesheet" href="./css/style.css">
    <script>
        function clear() {
            const nome = document.getElementById('nome');
            const cognome = document.getElementById('cognome');
            const data_nascita = document.getElementById('data_nascita');
            const ruolo = document.getElementById('ruolo');
            nome.value = '';
            cognome.value = '';
            data_nascita.value = '';
            ruolo.value = '';
        }

        function back_home() {
            clear()
            window.location.href = 'home.php'
        }

        function submit() {
            console.log('submit')
            const Error__nome = document.getElementById('Error__nome')
            const Error__cognome = document.getElementById('Error__cognome')
            const Error__data_nascita = document.getElementById('Error__data_nascita')

            const nome = document.getElementById('nome');
            const cognome = document.getElementById('cognome');
            const data_nascita = document.getElementById('data_nascita');
            const ruolo = document.getElementById('ruolo');

            Error__nome.style.visibility = 'hidden'
            Error__cognome.style.visibility = 'hidden'
            Error__data_nascita.style.visibility = 'hidden'

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    try {
                        let res = JSON.parse(this.responseText)
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
                        back_home()
                    } else if (res['type'] === 'Error') {
                        alert(res['value'])
                    } else {
                        alert(res)
                    }
                }
            }

            xmlhttp.open("POST", "nuovo_atleta.script.php", false);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("nome=" + nome.value + "&cognome=" + cognome.value + "&data_nascita=" + data_nascita.value + "&ruolo=" + ruolo.value);
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
                <h1>Aggiungi nuovo atleta</h1>
                <img onclick='back_home()' class='Home' src="./images/home.svg" alt="Home" />
            </div>
            <div class="Main__body Nuovo_Atleta">
                <div class="form">
                    Nome: <input type="text" autocomplete="off" name="nome" id="nome">
                    <span class='Error' id='Error__nome'>Il campo nome è obbligatorio</span>
                    Cognome: <input type="text" autocomplete="off" name="cognome" id="cognome">
                    <span class='Error' id='Error__cognome'>Il campo cognome è obbligatorio</span>
                    Data di nascita: <input type="date" name="data_nascita" id="data_nascita">
                    <span class='Error' id='Error__data_nascita'>Il campo data di nascita è obbligatorio</span>
                    Ruolo: <input type="text" autocomplete="off" name="ruolo" id="ruolo">
                    <a class="Button" onclick="submit()"><img src="./images/add.svg" alt="Add" />Aggiungi Atleta</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>