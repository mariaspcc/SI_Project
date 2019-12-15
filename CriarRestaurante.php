<?php
session_start();
include_once "acess_bd.php";
if (isset($_POST['register_restaurante'])) {
    $nome_restaurante = $_POST['nome_restaurante'];
    $localizacao_restaurante = $_POST['localizacao_restaurante'];
    $administrador_usergeral_username = $_SESSION['username'];

    $query1 = "SELECT * FROM restaurante WHERE ('$nome_restaurante' = nome)";
    $result1 = pg_query($connection, $query1);
    //caso não exista, insere registo na BD
    if (pg_affected_rows($result1) > 0) {
        $name_error = "Já foi criado um restaurante com esse nome";
    } else {
        //insere dados inseridos pelo administrador na tabela prato
        $query = "INSERT INTO restaurante (nome,localizacao, administrador_usergeral_username) VALUES ('$nome_restaurante', '$localizacao_restaurante','$administrador_usergeral_username')";
        $result1 = pg_query($connection, $query);
        //echo "SAVED";
        //exit();
        header('location: Homepage_Administrador.php');
    }
}
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
    <?php include_once "CheckAdministrador.php"; ?>
    <div>
        <p> CRIAR RESTAURANTE</p>
        <?php if (($_SESSION['success']) && isset($_SESSION['success'])) {?>
        <form action="CriarRestaurante.php" method="POST" id="form_restaurante">
            <label> <br>Nome
                <input type="text" name="nome_restaurante" required>
            </label>
            <?php if (isset($name_error)) { ?>
                <span><?php echo $name_error; ?></span>
            <?php } ?>
            <br>
            <label> <br>Localização
                <input type="text" name="localizacao_restaurante" required></label>
            <br>

            <input type="submit" name="register_restaurante" value="Guardar">
        </form>
    </div>
    <?php
    }

    pg_close($connection);

    ?>
</main>
</body>
</html>
