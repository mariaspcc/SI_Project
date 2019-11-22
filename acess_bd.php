<?php

$str = "dbname=postgres user=postgres password=POSTGRES host=localhost port=5432";
$connection = pg_connect($str);
if (!$connection) {
    die("Erro na ligacao"); }
echo "Ligacao estabelecida!";
?>
