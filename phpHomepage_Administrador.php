<?php

include_once "acess_bd.php";

session_start();

if($_SESSION['sucess']) {
    $administrador_usergeral_username = $_SESSION['username'];

    $query1 = "SELECT * FROM restaurante WHERE ('$administrador_usergeral_username' = administrador_usergeral_username)";
    $result1 = pg_query($connection, $query1);

    $name_error = "Não tem restaurantes para mostrar";

if (pg_affected_rows($result1)> 0) {
    $name_error ="Não tem restaurantes para mostrar";
} else {
    //NOT ACABADO
   pg_fetch_all();
}
}

pg_close($connection);


?>