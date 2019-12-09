<?php
$username = $_SESSION['username'];
$cliente="SELECT username FROM usergeral WHERE username='$username' AND administrador = false";
$resultcliente = pg_query($connection, $cliente);
if(pg_affected_rows($resultcliente) == 0){
    header('location: login.php');
}
?>
