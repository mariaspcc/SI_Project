<?php

include_once "acess_bd.php";

//buscar dados
if(isset($_POST['login'])) {
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query1 = "SELECT * FROM administrador WHERE '$username' = user_username AND '$password'= user_password";
    $query2 = "SELECT * FROM cliente WHERE '$username' = user_username AND '$password'= user_password";

    $result1 = pg_query($connection, $query1);
    $result2 = pg_query($connection, $query2);

    $name_error = "Username ou password incorretos.";

    if(pg_num_rows($result1)==1 && pg_num_rows($result2)==0){
        $_SESSION['username']=$username;
        $_SESSION['sucess']="Entrou!";
        header('location: Homepage_Administrador.php');
    } else if(pg_num_rows($result1)==0 && pg_num_rows($result2)==1){
        $_SESSION['username']=$username;
        $_SESSION['sucess']="Entrou!";
        header('location: Homepage_Cliente.php');
    }
    else if(pg_num_rows($result1)==0 && pg_num_rows($result2)==0){
        $name_error = "Username não existe";
    }
    else {
        $name_error = "Username ou password incorretos.";
    }


}
pg_close($connection);

?>
