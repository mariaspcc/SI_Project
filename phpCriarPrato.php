<?php

include_once "acess_bd.php";

session_start();

//para registar - método post
if(isset($_POST['register'])) {

    $comprado=false;

    $nome_prato = $_POST['nome_prato'];
    $tipo_prato=$_POST['tipo_prato'];
    $preco = $_POST['preço_prato'];
    $descricao = $_POST['descrição_prato'];
    $administrador_usergeral_username=$_SESSION['username'];

    $query1="SELECT * FROM prato WHERE ('$nome_prato' = nome_prato)";
    $result1 = pg_query($connection, $query1);

    $name_error = "Já foi criado um prato com esse nome";

    //caso não exista, insere registo na BD
    if (pg_affected_rows($result1)> 0) {
        $name_error ="Já foi criado um prato com esse nome";
    } else {
        //insere dados inseridos pelo administrador na tabela prato
        $query = "INSERT INTO prato (id,nome,tipo,descricao, preco,comprado, restaurante_id, administrador_usergeral_username) VALUES ('','$nome_prato', '$tipo','$descricao','$preco','$comprado', '$restaurante_id', '$administrador_usergeral_username')";
        $result1 = pg_query($connection, $query);
        //echo "SAVED";
        //exit();
        header('location: Homepage_Administrador.php');
    }
}

pg_close($connection);

?>
