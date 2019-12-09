<?php
$username = $_SESSION['username'];
$administrador= "SELECT username FROM usergeral WHERE username='$username' AND administrador = true";
$resultadmin = pg_query($connection, $administrador);
if(pg_affected_rows($resultadmin) == 0){
    header('location: login.php');
}
?>