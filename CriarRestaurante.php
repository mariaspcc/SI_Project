<?php

include('phpCriarRestaurante.php');

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Register_Restaurante</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>

<main>
    <div>
        <p> CRIAR RESTAURANTE</p>
        <?php if(isset($name_error)){?>
            <span><?php echo $name_error;?></span>
        <?php }?>
        <form action="CriarRestaurante.php" method="POST" id="form_restaurante">
            <label> <br>Nome
                <input type="text" name="nome_restaurante" required>
            </label>
            <br>
            <label> <br>Localização
                <input type="text" name="localizacao_restaurante" required></label>
            <br>
            <input type="submit" name="register_restaurante" value="Guardar">
        </form>
    </div>
</main>
</body>
</html>
