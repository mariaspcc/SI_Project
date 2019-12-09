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
    if (isset($_SESSION['success']) && $_SESSION['success']) { ?>

    <?php if (isset($name_error)) { ?>
        <span><?php echo $name_error; ?></span>
    <?php } ?>

    <?php
    $query1 = "SELECT nome FROM restaurante";
    $result1 = pg_query($connection, $query1);
 ?>

    <p>PRATOS</p>
    <label> <br>Ordernar por
        <select name="tipo_prato">
            <option value="Carne">Carne</option>
            <option value="Peixe">Peixe</option>
            <option value="Vegetariano">Vegetariano</option>
        </select>
    </label>
    <select><br>por
        <optgroup label="Preço">
            <option value="p_crescente">Crescente</option>
            <option value="p_decrescente">Decrescente</option>
        </optgroup>
        <optgroup label="Alabética">
            <option value="a_crescente">Crescente</option>
            <option value="a_decrescente">Decrescente</option>
        </optgroup>
    </select>
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
        }?>
    <?php } ?>

</main>
</body>
</html>
