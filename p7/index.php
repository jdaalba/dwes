<?php

$s = "sql300.byethost11.com";
$u = "b11_30764485";
$p = "ssAXec5Ugt4p8Tv";
$d = "b11_30764485_p6";

@$mysqli = new mysqli($s, $u, $p, $d);

if ($mysqli->connect_errno) {
    echo "conexión fallida";
} else {
    $mysqli->set_charset("utf8");
    echo "conexión correcta";
}


$resultset = $mysqli->query("select * from Libro");
    if ($resultset->num_rows > 0 && !$mysqli->error) {
        echo "<br>hay resultados";
        return $resultset->fetch_all(MYSQLI_ASSOC);
        var_dump($resultset);
    } else {
        echo "no hay resultados";
    }