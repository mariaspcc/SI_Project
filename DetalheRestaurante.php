<?php
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
    <a href="CriarPrato.php">Criar Prato</a>
    <div>
        <?php echo $_SESSION['nome_restaurante']; ?>
    </div>
    <div>
        <?php echo $_SESSION['localizacao_restaurante']; ?>
    </div>

</main>

</body>
</html>
