<?php

//chama acess_bd.php para ligar à BD
include_once "acess_bd.php";

//buscar dados
$username = $_POST['username'];
$password = $_POST['password'];


$query1 = "SELECT * FROM administrador WHERE ('$username' = user_username)";
$query2= "SELECT * FROM cliente WHERE ('$username' = user_username)";

$result1 = pg_query($connection, $query1);
$result2 = pg_query($connection, $query2);

//caso não exista, insere registo na BD
if(pg_num_rows($result1) == 0 && pg_num_rows($result2) == 0) {
    $query = "INSERT INTO cliente (user_username, user_password) VALUES ('$username', '$password')";

    $result = pg_query($connection, $query);
}

//fecha ligação à BD
pg_close($connection);

?>
