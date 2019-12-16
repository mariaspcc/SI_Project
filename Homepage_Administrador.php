<?php
include_once "acess_bd.php";
session_start();
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
    <div class="criar">
        <h3>CRIAR ...</h3>
        <div class="criarrestaurante">
            <a href="CriarRestaurante.php">
                <img class="restauranteicon" src="images/restaurante.png" alt="">
                <p>Restaurante </p>
            </a>
        </div>
        <div class="criarprato">
            <a href="CriarPrato.php">
                <img class="pratoicon" src="images/prato.png" alt="">
                <p>Prato</p>
            </a>
        </div>
        <div class="criardesconto">
            <a href="CriarDesconto.php">
                <img class="descontoicon" src="images/DESCONTOS.png" alt="">
                <p>Desconto</p>
            </a>
        </div>
    </div>

    <?php
    include_once ("CheckAdministrador.php");

    if (isset($_SESSION['success']) && $_SESSION['success']) {
        //include_once "CheckAdministrador.php";
        ?>

        <?php if (isset($name_error)) { ?>
            <span><?php echo $name_error; ?></span>
        <?php } ?>

        <?php
        $administrador_usergeral_username = $_SESSION['username'];
        $query1 = "SELECT * FROM restaurante WHERE ('$administrador_usergeral_username' = administrador_usergeral_username)";
        $result1 = pg_query($connection, $query1);
        $query2 = "SELECT * FROM prato WHERE ('$administrador_usergeral_username' = administrador_usergeral_username)";
        $result2 = pg_query($connection, $query2); ?>
        <div class="meusrestaurantes">
        <h3>OS MEUS RESTAURANTES</h3>
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
        </div>

    <div class="meuspratos">
        <h3>OS MEUS PRATOS</h3>
        <?php if (pg_affected_rows($result2) > 0) { ?>
            <ul class="listaMeusPratos">
                <?php for ($t = 0; $t < pg_affected_rows($result2); $t++) {
                    $arrayPratosAdministrador = pg_fetch_array($result2);
                    $y = $arrayPratosAdministrador['id'];

                    ?>

                    <li>
                        <a href="DetalhePrato.php?variavel=<?php echo $y ?>">
                            <p class="NomeDoPrato"><?php echo $arrayPratosAdministrador['nome']; ?></p>
                        </a>
                        <h6 class="RestauranteDoPrato"><?php echo $arrayPratosAdministrador['restaurante_nome']; ?></h6>
                        <p class="PrecoDoPrato"><?php echo $arrayPratosAdministrador['preco']; ?> €</p>
                    </li>
                    <br>
                <?php } ?>
            </ul>
            <?php
        } else {
            $prato_error = "Não tem pratos para mostrar";
            echo $prato_error;
        } ?>
    </div>
<?php
    } ?>

</main>

</body>
</html>
