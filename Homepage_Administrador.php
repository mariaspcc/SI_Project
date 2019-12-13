<?php
include_once "acess_bd.php";
session_start();
//include('phpHomepage_Administrador.php');
//include('CheckAdministrador.php');
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
    <a href="CriarPrato.php">Criar Prato</a>

    <?php
    if (isset($_SESSION['success']) && $_SESSION['success']) { ?>

        <?php if (isset($name_error)) { ?>
            <span><?php echo $name_error; ?></span>
        <?php } ?>

        <?php
        $administrador_usergeral_username = $_SESSION['username'];
        $query1 = "SELECT * FROM restaurante WHERE ('$administrador_usergeral_username' = administrador_usergeral_username)";
        $result1 = pg_query($connection, $query1);
        $query2 = "SELECT * FROM prato WHERE ('$administrador_usergeral_username' = administrador_usergeral_username)";
        $result2 = pg_query($connection, $query2); ?>
        <h1>Os meus Restaurantes</h1>
        <?php if (pg_affected_rows($result1) > 0) { ?>
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
        } ?>

        <h1>Os meus Pratos</h1>
        <?php if (pg_affected_rows($result2) > 0) { ?>
            <ul class="listaMeusRestaurantes">
                <?php for ($t = 0; $t < pg_affected_rows($result2); $t++) {
                    $arrayPratosAdministrador = pg_fetch_array($result2);
                    $y=$arrayPratosAdministrador['nome'];

                    ?>
                    <li>
                        <a href="DetalhePrato.php?variavel=<?php echo $y ?>">
                            <p><?php echo $arrayPratosAdministrador['nome']; ?></p>
                        </a>
                        <h6><?php echo $arrayPratosAdministrador['restaurante_nome']; ?></h6>
                        <h6><?php echo $arrayPratosAdministrador['preco']; ?> €</h6>
                        <input type="submit" class="botao" value="Editar Prato" name="editar">
                    </li>
                    <br>
                <?php } ?>
            </ul>
        <?php } else {
            $prato_error = "Não tem pratos para mostrar";
            echo $prato_error;
        }

    } ?>

</main>

</body>
</html>
