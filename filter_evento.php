<?php
session_start();
$q = $_REQUEST["q"];

$filtered = array();


if ($q !== "") {
    $q = strtolower($q);
    $len = strlen($q);
    foreach ($_SESSION["eventi"] as $row) {
        if (stripos($row[1], $q) || stripos($row[2], $q) || stripos($row[3], $q) || stripos($row[4], $q) || stripos($row[5], $q)) {
            array_push($filtered, $row);
        }
    }
} else {
    $filtered = $_SESSION["eventi"];
}

if (count($filtered) === 0) {
    echo "<div class='NoData'>Nessun evento trovato</div>";
} else {

?>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Data e Ora</th>
                <th>Descrizione</th>
                <th>Luogo</th>
                <th>Durata in minuti</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($filtered as $row) {
                echo "
                    <tr><td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        <td>" . $row[3] . "</td>
                        <td>" . $row[4] . "</td>
                        <td class='text_center'>" . $row[5] . "</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
<?php
}
