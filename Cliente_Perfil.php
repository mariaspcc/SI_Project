<?php
include_once "acess_bd.php";
session_start();
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
    if (isset($_SESSION['success']) && $_SESSION['success']) {
        $cliente_usergeral_username = $_SESSION['username'];
        ?>
        <a href="Homepage_Cliente.php"> Regressa à Homepage </a>

        //SALDO ATUAL

        //COMPRAS FEITAS
        <?php
        $query = "select * from encomenda as E, detalhe AS D 
    where E.cliente_usergeral_username='$cliente_usergeral_username' and E.id= D.encomenda_id 
      and e.id= d.encomenda_id and d.prato_id= p.id
    group by c. usergeral_username";
        $result = pg_query($connection, $query);

    }
    ?>
</main>
</body>
</html>
