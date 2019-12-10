<?php
include_once "acess_bd.php";
session_start();
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
    if (isset($_SESSION['success']) && $_SESSION['success']) {
        $query2 = "SELECT nome, tipo,restaurante_nome, descricao, preco FROM prato";
        $result2 = pg_query($connection, $query2);
        for ($i = 0; $i < pg_affected_rows($result2); $i++) {
            $arr = pg_fetch_array($result2);
        }
        ?>
        <h1>
            <?php
            echo $arr[0];
            ?>
        </h1>
        <h3>
            <?php
            echo $arr[1];
            ?>
        </h3>

        <h3>
            <?php
            echo $arr[2];
            ?>
        </h3>

        <p>
            <?php
            echo $arr[3];
            ?>
        </p>
        <h2>
            <?php
            echo $arr[4];
            ?>
            €
        </h2>

        <?php
    }
    ?>

</main>

</body>
</html>
