<?php
session_start();
$q = $_REQUEST["q"];

$filtered = array();

if ($q !== "") {
    $q = strtolower($q);
    $len = strlen($q);
    foreach ($_SESSION["atleti"] as $row) {
        if (str_contains($row[1], $q) || str_contains($row[2], $q)) {
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
        <div class='Card'>
        <img src='./images/user.svg' alt='user photo' loading='lazy' />
        <span>" . $row[1] . "</span>
        <span>" . $row[2] . "</span>
        </div>";
    }
}
