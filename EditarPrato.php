<?php
include_once "acess_bd.php";
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Prato</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>
<main>
    <p> EDITAR PRATO </p>

    <?php
    if (isset($_SESSION['success']) && $_SESSION['success']) {
        $username = $_SESSION['username'];
        $arrayDetalhe = $_SESSION['detalhe'];
        ?>
        <form action="EditarPrato.php" method="POST" id="form_prato">
            <label> <br>Nome do Prato
                <input type="text" name="nome_prato" required value="<?php echo $arrayDetalhe[0]; ?>">
            </label>
            <?php if (isset($name_error)) { ?>
                <span><?php echo $name_error; ?></span>
            <?php } ?>
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
                            <option <?php if ($arr['nome'] == $arrayDetalhe[2]) { ?> selected="selected"<?php } ?>><?php echo $arr['nome']; ?></option>
                        <?php }
                    } ?>
                </select>
            </label>
            <br>
            <label> <br>Tipo de prato
                <select name="tipo_prato">
                    <option value="Carne" <?php if ("Carne" == $arrayDetalhe[1]) { ?> selected="selected"<?php } ?> >
                        Carne
                    </option>
                    <option value="Peixe" <?php if ("Peixe" == $arrayDetalhe[1]) { ?> selected="selected"<?php } ?> >
                        Peixe
                    </option>
                    <option value="Vegetariano" <?php if ("Vegetariano" == $arrayDetalhe[1]) { ?> selected="selected"<?php } ?> >
                        Vegetariano
                    </option>
                </select>
            </label>
            <br>
            <label> <br>Preço
                <input type="number" min="1" name="preco_prato" required
                       value="<?php echo $arrayDetalhe[4]; ?>"></label>
            <br>
            <label> <br>Descrição
                <input type="text" name="descricao_prato" required value="<?php echo $arrayDetalhe[3]; ?>">
            </label>
            <br>
            <input type="submit" name="edit_prato" value="Guardar Alterações">
            <input type="submit" name="eliminar_prato" value="Apagar Prato">
        </form>
        <?php
        if (isset($_POST['edit_prato']) || isset($_POST['eliminar_prato']) ) {
            $comprado = "false";
            $nome_prato = $_POST['nome_prato'];
            $tipo_prato = $_POST['tipo_prato'];
            $preco = $_POST['preco_prato'];
            $descricao = $_POST['descricao_prato'];
            $restaurante_nome = $_POST['restaurante'];
            $pratoid = "SELECT id FROM prato WHERE nome = '$arrayDetalhe[0]'";
            $resultid = pg_query($connection, $pratoid);
            $id = pg_fetch_result($resultid, 0);
            if (isset($_POST['edit_prato'])) {
                $pratoupdate = "UPDATE prato SET nome = '$nome_prato', tipo = '$tipo_prato', descricao ='$descricao', preco ='$preco', comprado ='$comprado', restaurante_nome ='$restaurante_nome', administrador_usergeral_username ='$username' WHERE id ='$id'";
                $result = pg_query($connection, $pratoupdate);
                header('location:Homepage_Administrador.php');
            } else if (isset($_POST['eliminar_prato'])) {
                $pratoupdate = "DELETE FROM prato WHERE id ='$id'";
                $result = pg_query($connection, $pratoupdate);
                header('location:Homepage_Administrador.php');

            }
        }
    }?>



</main>

</body>
</html>

