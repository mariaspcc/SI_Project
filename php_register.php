<?php

echo "entra";
//chama acess_bd.php para ligar à BD
include_once "acess_bd.php";

echo "depois";
//buscar dados
$username = $_POST['username'];
$password = $_POST['password'];

$query1="";

//verifica se ursename existe na BD
if(isset($_POST['B_cliente'])) {
$query1 = "SELECT * FROM cliente WHERE ('$username' = user_username)";
}
if(isset($_POST['B_admin'])) {
$query1 = "SELECT * FROM administrador WHERE ('$username' = user_username)";
}
$result1 = pg_query($connection, $query1);

//caso não exista, insere registo na BD
if(pg_num_rows($result1) == 0) {
    if(isset($_POST['B_cliente'])) {
    $query = "INSERT INTO cliente (user_username, user_password) VALUES ('$username', '$password')";
    }
    if(isset($_POST['B_admin'])) {
    $query = "INSERT INTO administrador (user_username, user_password) VALUES ('$username', '$password')";
    }
    $result = pg_query($connection, $query);
}

//fecha ligação à BD
pg_close($connection);

?>
