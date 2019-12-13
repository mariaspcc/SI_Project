<?php
include_once "acess_bd.php";
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Encomenda_Realizada</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>

<main>
    <?php $_SESSION['encomenda_id'] = 0;
    ?>
    <p>Encomenda realizada com sucesso</p>
    <a href="Homepage_Cliente.php">
        <input type="submit" class="botao" value="Regressar para a Homepage">
    </a>

</main>

</body>
</html>

