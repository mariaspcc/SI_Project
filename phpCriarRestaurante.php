<?php

include_once "acess_bd.php";

session_start();

//para registar - método post
if(isset($_POST['register_restaurante']) && ($_SESSION['success'])) {

    $nome_restaurante = $_POST['nome_restaurante'];
    $localizacao_restaurante=$_POST['localizacao_restaurante'];
    $administrador_usergeral_username=$_SESSION['username'];

    $query1="SELECT * FROM restaurante WHERE ('$nome_restaurante' = nome)";
    $result1 = pg_query($connection, $query1);

    $name_error = "Já foi criado um restaurante com esse nome";

    //caso não exista, insere registo na BD
    if (pg_affected_rows($result1)> 0) {
        $name_error ="Já foi criado um restaurante com esse nome";
    } else {
        //insere dados inseridos pelo administrador na tabela prato
        $query = "INSERT INTO restaurante (nome,localizacao, administrador_usergeral_username) VALUES ('$nome_restaurante', '$localizacao_restaurante','$administrador_usergeral_username')";
        $result1 = pg_query($connection, $query);
        //echo "SAVED";
        //exit();
        header('location: Homepage_Administrador.php');
    }
}

pg_close($connection);

?>
