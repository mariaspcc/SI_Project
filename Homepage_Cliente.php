<?php
include_once "acess_bd.php";
session_start();

/*FUNCIONA - ATIVAR NA ENTREGA*/
/*include('login.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}*/
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Homepage_cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>

<main>
    <?php
    /* $username = $_POST['username'];
     $query= "SELECT username FROM usergeral WHERE username='$username' AND administrador = true";
     $result = pg_query($connection, $query);*/
    include_once "CheckCliente.php";

    if (isset($_SESSION['success']) && $_SESSION['success']/* && pg_affected_rows($result) == 1*/) { ?>

        <?php if (isset($name_error)) { ?>
            <span><?php echo $name_error; ?></span>
        <?php } ?>

        <?php
        $query1 = "SELECT nome FROM restaurante";
        $result1 = pg_query($connection, $query1);

        //ORDENAR PRATOS
        if (isset($_POST['ordenar'])) {
            $valor = $_POST['ordem'];
            if ($valor === "p_crescente") {
                $query2 = "SELECT * FROM prato ORDER BY preco ASC";
                $result2 = pg_query($connection, $query2);
            } else if ($valor === "p_crescente") {
                $query2 = "SELECT * FROM prato ORDER BY preco DESC";
                $result2 = pg_query($connection, $query2);
            } else if ($valor === "a_crescente") {
                $query2 = "SELECT * FROM prato ORDER BY nome ASC";
                $result2 = pg_query($connection, $query2);
            } else if ($valor === "a_decrescente") {
                $query2 = "SELECT * FROM prato ORDER BY nome DESC";
                $result2 = pg_query($connection, $query2);
            }
        }
        ?>

        <p>PRATOS</p>
        <form action="Homepage_Cliente.php" method="POST" id="ordenar">
            <select name="ordem"><br>por
                <optgroup label="Preço">
                    <option value="p_crescente">Crescente</option>
                    <option value="p_decrescente">Decrescente</option>
                </optgroup>
                <optgroup label="Alabética">
                    <option value="a_crescente">Crescente</option>
                    <option value="a_decrescente">Decrescente</option>
                </optgroup>
            </select>
            <input type="submit" name="ordenar">
        </form>

        <?php

        if (pg_affected_rows($result2) > 0) { ?>
            <ul class="listaRestaurantes">
                <?php for ($p = 0; $p < pg_affected_rows($result2); $p++) {
                    $arrayPratos = pg_fetch_array($result2);
                    ?>
                    <li> <?php echo $arrayPratos['nome']; ?></li>
                <?php } ?>
            </ul>
        <?php } else {
            $name_error = "Não existem pratos para mostrar";
            echo $name_error;
        } ?>
        <?php ?>
        <br>
        <br>
        <p>RESTAURANTES</p>
        <?php if (pg_affected_rows($result1) > 0) { ?>
            <ul class="listaRestaurantes">
                <?php for ($i = 0; $i < pg_affected_rows($result1); $i++) {
                    $arr = pg_fetch_array($result1);
                    ?>
                    <li> <?php echo $arr['nome']; ?></li>
                <?php } ?>
            </ul>
        <?php } else {
            $name_error = "Não existem restaurantes para mostrar";
            echo $name_error;
        } ?>
    <?php } else {
        header('location: login.php');
    } ?>

</main>
</body>
</html>
