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

            $id =$_GET["variavel"];

            $query2 = "SELECT nome, tipo,restaurante_nome, descricao, preco FROM prato WHERE '$id'= id";
            $result2 = pg_query($connection, $query2);

            for ($i = 0; $i < pg_affected_rows($result2); $i++) {
                $arrayDetalhe = pg_fetch_array($result2);
                $_SESSION['detalhe'] = $arrayDetalhe;
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
        $result1 = pg_query($connection, $administrador);
        $cliente = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = false";
        $result2 = pg_query($connection, $cliente);
        $pratocomprado = "SELECT * FROM prato WHERE '$username' = administrador_usergeral_username AND  '$id' = id  AND comprado = false";
        $result3 = pg_query($connection, $pratocomprado);

        $aux_cliente = false;

        if (pg_affected_rows($result1) == 0 && pg_affected_rows($result2) == 1) {
            $aux_cliente = true;

        } else if (pg_affected_rows($result1) == 1 && pg_affected_rows($result2) == 0 && pg_affected_rows($result3) == 1) { ?>
            <input type="submit" class="botao" value="Editar Prato" name="editar">
        <?php }
        if (isset($_POST['enco'])) {
            header('location:Encomenda_Pendente.php');
        } else if (isset($_POST['editar'])) {
            header('location:EditarPrato.php');
        }

        ?>

    </form>
    <?php
    //verifica se ela existe
    //verifica se é maior q 0

    if (($_SESSION['encomenda_id']) >= 0) {
        $id_encomenda = $_SESSION['encomenda_id'];
        $query3 = "SELECT prato_id, encomenda_id FROM detalhe WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id'";
        $result3 = pg_query($connection, $query3);

        if (pg_num_rows($result3) > 0) {
            //existe
            $nao_existe = false;
            echo "Este prato já foi adicionado à sua encomenda!";
            ?>
            <a href="Homepage_Cliente.php">
                <input type="submit" class="botao" value="Continuar a comprar" name="comp">
            </a>
            <?php
        } else {
            if ($aux_cliente) { ?>
                <a href="Encomenda_Pendente.php?variavel=<?php echo $id ?>">
                    <input type="submit" class="botao" value="Adicionar à encomenda">
                </a>
            <?php }
        }
    } ?>
</main>

</body>
</html>
