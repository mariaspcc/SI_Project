<?php
include_once "acess_bd.php";
session_start();

//$quantidade = $_POST(['quantidade_prato']);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Encomenda_Pendente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>

<main>
        <?php

        if(!isset( $_SESSION['lista'])){
            $_SESSION['lista']=array();
        }

        if (isset($_SESSION['success']) && $_SESSION['success']) {

            //verifica se a variável existe
            if(isset($_GET["variavel"])) {
                if (!in_array($_GET["variavel"], $_SESSION['lista'])) {
                    //adiciona ao array
                    array_push($_SESSION['lista'], $_GET["variavel"]);
                    //$_SESSION['lista']=array_map('array_values',$_SESSION['lista']);
                }
            }

            //converte array em string
            //$list contem os pratos adionados não os repetindo caso já estejam adicionados (join faz isso)
            $list = join("','",$_SESSION['lista']);
            //echo $list;
            $query2 = "SELECT nome, preco FROM prato WHERE nome IN ('$list')";

            $result2 = pg_query($connection, $query2);
            echo pg_affected_rows($result2);
            for ($i = 0; $i < pg_affected_rows($result2); $i++) {
                $arrayDetalhe = pg_fetch_array($result2);
                $apagar=$i;
                ?>
                <h1>
                    <?php
                    echo $arrayDetalhe[0];
                    echo $i;
                    ?>
                </h1>
                <h2>
                    <?php
                    echo $arrayDetalhe[1];
                    ?>
                    €
                </h2>
                <label> <br>Quantidade
                    <input type="number" min="1" name="quantidade_prato" required></label>
                <br>
                </label>
            <form action="Encomenda_Pendente.php" method="POST">
                <input type="submit" name="eliminar_prato" class="botao" value="Eliminar prato">
                </form>
                <?php if(isset($_POST['eliminar_prato'])){
                   unset($_SESSION['lista'][0]);
                } ?>
                <?php
            }
                ?>
            <?php
        }

        $username= $_SESSION['username'];
        $administrador = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = true";
        $cliente = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = false";
        $result1 = pg_query($connection, $administrador);
        $result2 = pg_query($connection, $cliente);
        if (pg_affected_rows($result1) == 0 && pg_affected_rows($result2) == 1 ) {
            ?>
    <form action="Encomenda_realizada.php" method="POST">
            <input type="submit" class="botao" value="Encomendar">
    </form>
        <?php }
        ?>



</main>

</body>
</html>

