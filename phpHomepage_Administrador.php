<?php
include_once "acess_bd.php";
session_start();
if (isset($_SESSION['success']) && $_SESSION['success']) {
    $administrador_usergeral_username = $_SESSION['username'];
    $query1 = "SELECT * FROM restaurante WHERE ('$administrador_usergeral_username' = administrador_usergeral_username)";
    $result1 = pg_query($connection, $query1) or die;


    if (pg_affected_rows($result1) > 0) {
        for ($i = 0; $i < pg_affected_rows($result1); $i++) {
            $arr = pg_fetch_array($result1);
            print $arr['nome'];
        }
    } else {
        $name_error = "Não tem restaurantes para mostrar";
    }
}

pg_close($connection);


?>