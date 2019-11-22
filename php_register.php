<?php
echo "tentar chamar"
include_once("acess_bd.php");


    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "INSERT INTO utilizador_administrador_cliente (Username, Password) VALUES ('$username', '$password')";
    $result = pg_query($connection, $query);

pg_close($connection);

?>