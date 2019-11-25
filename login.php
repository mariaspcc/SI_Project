<?php

include_once "acess_bd.php";

//buscar dados
$username = $_POST['username'];
$password = $_POST['password'];

//$username = pg_real_escape_string($_POST['username']);
//$password = pg_real_escape_string($_POST['password']);

//$result=pg_query("Select * from cliente, administrador where user_username = '$username' and user_password = '$password'")
//or die("Falha");


$query1 = "SELECT * FROM administrador WHERE ('$username' = user_username)";
//$query2 = "SELECT * FROM cliente WHERE ('$username' = user_username)";

$result1 = pg_query($connection, $query1);
//$result2 = pg_query($connection, $query2);

$row = pg_fetch_array($result1);

if($row['username'] == $username && $row['password'] == $password){
    echo "LOGADO!";
}
else {
    echo "NOT LOGADO!";
}

//pg_close($connection);

?>
