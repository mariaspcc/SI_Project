<?php
include('phpHomepage_Administrador.php');
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
    <a href="CriarRestaurante.php">Criar Restaurante</a>

    <?php
    if ( isset($_SESSION['sucess']) && $_SESSION['sucess'] ) {?>

        <?php if(isset($name_error)){?>
            <span><?php echo $name_error;?></span>
        <?php }?>

    <ul>
        <li>
            <div>
                <?php echo $_POST['nome_restaurante']; ?>
            </div>
            <div>
                <?php echo $_POST['localizacao_restaurante']; ?>
            </div>
        </li>
    </ul>
    <?php } ?>
</main>

</body>
</html>
