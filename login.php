<?php

include_once "acess_bd.php";

//buscar dados
$username = $_POST['username'];
$password = $_POST['password'];

$query1 = "SELECT * FROM administrador WHERE ('$username' = user_username)";
$query2 = "SELECT * FROM cliente WHERE ('$username' = user_username)";

$result1 = pg_query($connection, $query1);
$result2 = pg_query($connection, $query2);

$row1 = pg_fetch_array($result1);
$row2 = pg_fetch_array($result2);

if($row1['user_username'] == $username && $row1['user_password'] == $password || $row2['user_username'] == $username && $row2['user_password'] == $password){
    echo "LOGADO!";
}
else {
    echo "NOT LOGADO!";
}

pg_close($connection);

?>
