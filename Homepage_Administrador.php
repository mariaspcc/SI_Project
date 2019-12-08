<?php
include_once "acess_bd.php";
session_start();
//include('phpHomepage_Administrador.php');
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
    if (isset($_SESSION['success']) && $_SESSION['success']) { ?>

        <?php if (isset($name_error)) { ?>
            <span><?php echo $name_error; ?></span>
        <?php } ?>

        <?php
        $administrador_usergeral_username = $_SESSION['username'];
        $query1 = "SELECT * FROM restaurante WHERE ('$administrador_usergeral_username' = administrador_usergeral_username)";
        $result1 = pg_query($connection, $query1);
        if (pg_affected_rows($result1) > 0) { ?>
            <ul class="listaMeusRestaurantes">
                <?php for ($i = 0; $i < pg_affected_rows($result1); $i++) {
                    $arr = pg_fetch_array($result1);
                    ?>
                    <li> <?php echo $arr['nome']; ?></li>
                <?php } ?>
            </ul>
        <?php } else {
            $name_error = "Não tem restaurantes para mostrar";
            echo $name_error;
        }
    } ?>

</main>

</body>
</html>
