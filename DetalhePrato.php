<?php
include_once "acess_bd.php";
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Detalhe prato</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php');


?>

<main>
    <form action="" method="POST" id="adicionar_prato">
        <?php
        if (isset($_SESSION['success']) && $_SESSION['success']) {

            $nome = $_GET["variavel"];

            $query2 = "SELECT nome, tipo,restaurante_nome, descricao, preco FROM prato WHERE '$nome'= nome";
            $result2 = pg_query($connection, $query2);
            for ($i = 0; $i < pg_affected_rows($result2); $i++) {
                $arrayDetalhe = pg_fetch_array($result2);
                $_SESSION['detalhe']= $arrayDetalhe;
            }
            ?>
            <h1>
                <?php
                echo $arrayDetalhe[0];
                ?>
            </h1>
            <h3>
                <?php
                echo $arrayDetalhe[1];
                ?>
            </h3>

            <h3>
                <?php
                echo $arrayDetalhe[2];
                ?>
            </h3>

            <p>
                <?php
                echo $arrayDetalhe[3];
                ?>
            </p>
            <h2>
                <?php
                echo $arrayDetalhe[4];
                ?>
                €
            </h2>

            <?php
        }
        $username = $_SESSION['username'];
        $administrador = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = true";
        $cliente = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = false";
        $result1 = pg_query($connection, $administrador);
        $result2 = pg_query($connection, $cliente);
        $pratocomprado="SELECT * FROM prato WHERE '$username' = administrador_usergeral_username AND  '$nome' = nome  AND comprado = false";
        $result3 = pg_query($connection, $pratocomprado);
        if (pg_affected_rows($result1) == 0 && pg_affected_rows($result2) == 1) {
            ?>

            <input type="submit" class="botao" value="Adicionar prato à encomenda" name="enco">
        <?php } else if (pg_affected_rows($result1) == 1 && pg_affected_rows($result2) == 0 && pg_affected_rows($result3) == 1) { ?>
            <input type="submit" class="botao" value="Editar Prato" name="editar">
        <?php }
        if (isset($_POST['enco'])) {
            header('location:Encomenda_Pendente.php');
        } else if (isset($_POST['editar'])) {
            header('location:EditarPrato.php');
        }

        ?>

    </form>
</main>

</body>
</html>
