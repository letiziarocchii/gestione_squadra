<?php
session_start();
$q = $_REQUEST["q"];

$filtered = array();

if ($q !== "") {
    $q = strtolower($q);
    $len = strlen($q);
    foreach ($_SESSION["atleti"] as $row) {
        if (stripos($row[1], $q) || stripos($row[2], $q)) {
            array_push($filtered, $row);
        }
    }
} else {
    $filtered = $_SESSION["atleti"];
}

if (count($filtered) === 0) {
    echo "<div class='NoData'>Nessun alteta trovato</div>";
} else {
    foreach ($filtered as $row) {
        echo "
        <a class='Card' href='dettagli_atleta.php?id=" . $row[0] . "'>
        <img src='./images/user.svg' alt='user photo' loading='lazy' />
        <span>" . $row[1] . "</span>
        <span>" . $row[2] . "</span>
        </a>";
    }
}
