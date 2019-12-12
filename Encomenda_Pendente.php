<?php
include_once "acess_bd.php";
session_start();

$quantidade = $_POST(['quantidade_prato']);
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

<label> <br>Quantidade
            <input type="number" min="1" name="quantidade_prato" required></label>
        <br>
</label>

</main>

</body>
</html>

