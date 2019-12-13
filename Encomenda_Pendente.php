<?php
include_once "acess_bd.php";
session_start();

//$quantidade = $_POST(['quantidade_prato']);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Encomenda_Pendente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>

<main>
    <?php

    if (isset($_SESSION['success']) && $_SESSION['success']) {
        $cliente_usergeral_username = $_SESSION['username'];

        //trás a variavel da página Homepage_cliente e verifica se a variável existe
        if (isset($_GET["variavel"])) {
            $id = $_GET["variavel"];
            $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato WHERE id = '$id'";
            $result2 = pg_query($connection, $query2);

            //vai inserir encomenda - determina o id maximo da encomenda (a ultima encomenda)
            while ($res = pg_fetch_array($result2)) {
                $query3 = "SELECT max(id) FROM encomenda";
                $result3 = pg_query($connection, $query3);
                //verifica se a encomenda existe
                $valor = pg_fetch_result($result3, 0, 0);


                if (($_SESSION['encomenda_id'] <> $valor) || ($_SESSION['encomenda_id'] === 0)) {
                    $id_enc = $valor + 1;
                    $query4 = "INSERT INTO encomenda(id,cliente_usergeral_username) VALUES ($id_enc,'$cliente_usergeral_username')";
                    $result4 = pg_query($connection, $query4);
                    $_SESSION['encomenda_id'] = $id_enc;
                }

                $id_encomenda = $_SESSION['encomenda_id'];
                $query5 = "INSERT INTO detalhe (quantidade, prato_id, encomenda_id) VALUES (1,'$id','$id_encomenda')";
                $result5 = pg_query($connection, $query5);

            }
        }
        $id_encomenda = $_SESSION['encomenda_id'];
        $query6 = "SELECT nome, preco, id FROM  prato, detalhe WHERE prato.id = detalhe.prato_id AND detalhe.encomenda_id = $id_encomenda";
        $result6 = pg_query($connection, $query6);

        for ($i = 0; $i < pg_affected_rows($result6); $i++) {
            $arrayDetalhe = pg_fetch_array($result6);
            //$apagar = $i;
            ?>
            <h1>
                <?php
                echo pg_fetch_result($result6, $i, 0);
                ?>
            </h1>
            <h2>
                <?php
                echo pg_fetch_result($result6, $i, 1);
                ?>
                €
            </h2>
            <?php $id3 = pg_fetch_result($result6, $i, 2); ?>
            <label> <br>Quantidade
                <input type="number" min="1" name="<?php echo $id3 ?>" required></label>
            <br>
            </label>

            <a href="Encomenda_Pendente.php?variavel2=<?php echo $id3 ?>">
                <input type="submit" name="retirar_prato" value="Retirar prato da encomenda">
            </a>
            <?php
            if (isset($_GET["variavel2"])) {
                $id2 = $_GET["variavel2"];
                $query7 = "DELETE FROM detalhe WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id2'";
                $result7 = pg_query($connection, $query7);

                header('location: Encomenda_Pendente.php');
            }
        }
    }

    $username = $_SESSION['username'];
    $administrador = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = true";
    $cliente = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = false";
    $result1 = pg_query($connection, $administrador);
    $result2 = pg_query($connection, $cliente);
    if (pg_affected_rows($result1) == 0 && pg_affected_rows($result2) == 1) {
        ?>
        <a href="Homepage_Cliente.php">
            <input type="submit" class="botao" value="Continuar a comprar">
        </a>
        <form action="Encomenda_realizada.php" method="POST">
            <input type="submit" class="botao" value="Encomendar">
        </form>
    <?php }
    ?>


</main>

</body>
</html>

