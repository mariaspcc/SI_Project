<?php

include_once "acess_bd.php";

//para registar - método post
if(isset($_POST['register'])) {

    $nome_prato = $_POST['nome_prato'];
    $preco = $_POST['preço_prato'];
    $descricao = $_POST['descrição_prato'];

    //insere dados inseridos pelo administrador na tabela prato
    $query = "INSERT INTO prato (nome,preco,descricao) VALUES ('$nome_prato', '$preco','$descricao')";
    $result1 = pg_query($connection, $query);
}

//FUNCIONA
function isLoggedIn()
{
    if (isset($_SESSION['user_username'])) {
        return true;
    }else{
        return false;
    }
}

pg_close($connection);

?>
