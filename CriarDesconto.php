<?php
session_start();
include_once "acess_bd.php";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>CriarPrato</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>
<main>
    <p> CRIAR DESCONTO </p>
        <form action="CriarDesconto.php" method="POST" id="form_desconto">
            <label> <br>Valor
                <input type="number" min="1" name="valor" required></label>
            </label>
            <br>
            <label> <br>Restaurante
                <select name="restaurante">
                    <?php
                    $query2 = "SELECT nome FROM restaurante WHERE administrador_usergeral_username ='$username'";
                    $result2 = pg_query($connection, $query2);
                    if (pg_affected_rows($result2) > 0) {
                        for ($i = 0; $i < pg_affected_rows($result2); $i++) {
                            $arr = pg_fetch_array($result2);
                            ?>
                            <option><?php echo $arr['nome']; ?></option>
                        <?php }
                    } else { ?>
                        <a href="CriarRestaurante.php">Criar Restaurante</a>//NÃO ESTÁ A FUNCIONAR
                    <?php } ?>
                </select>
            </label>
            <br>
            <label> <br>Preço
                <input type="number" min="1" name="preco_prato" required></label>
            <br>
            <label> <br>Descrição
                <input type="text" name="descricao_prato" required>
            </label>
            <br>
            <input type="submit" name="register_prato" value="Guardar">
        </form>
        <?php
    }
    pg_close($connection);
    ?>
</main>
</body>
</html>


