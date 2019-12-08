<?php
include_once "acess_bd.php";
session_start();

//para registar - método post
if (isset($_POST['register']) && ($_SESSION['success']) && isset($_SESSION['success'])) {

    $comprado = false;
    //$nome_prato = $_POST['nome_prato'];
    $tipo_prato = $_POST['tipo_prato'];
    $preco = $_POST['preço_prato'];
    $descricao = $_POST['descrição_prato'];
    $restaurante_id = $_SESSION['nome_restaurante'];
    $administrador_usergeral_username = $_SESSION['username'];

   $query1 = "SELECT * FROM prato WHERE ('$nome_prato' = nome_prato)";
    $result1 = pg_query($connection, $query1);
    /*
       $name_error = "Já foi criado um prato com esse nome";*/

    //caso não exista, insere registo na BD
    if (pg_affected_rows($result1) > 0) {
        $name_error = "Já foi criado um prato com esse nome";
    } else {
        //insere dados inseridos pelo administrador na tabela prato
        $query = "INSERT INTO prato (nome,tipo,descricao, preco,comprado, restaurante_id, administrador_usergeral_username) VALUES ('$nome_prato'$tipo_prato','$descricao','$preco','$comprado', '$restaurante_id', '$administrador_usergeral_username')";
        $result1 = pg_query($connection, $query);
        //echo "SAVED";
        //exit();
        header('location: Homepage_Administrador.php');
    }
    session_start();

    $query3="SELECT id FROM restaurante WHERE ('burgers' = nome)";
    $result3=pg_query($connection, $query3);
    $restaurante_id= pg_fetch_array($result3);

    echo $restaurante_id[1];
}

pg_close($connection);

?>
