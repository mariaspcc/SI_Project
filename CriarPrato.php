<?php
session_start();
include_once "acess_bd.php";
if (isset($_POST['register_prato'])) {
$comprado = "false";
$nome_prato = $_POST['nome_prato'];
$tipo_prato = $_POST['tipo_prato'];
$preco = $_POST['preco_prato'];
$descricao = $_POST['descricao_prato'];
$restaurante_nome = $_POST['restaurante'];
$administrador_usergeral_username = $_SESSION['username'];
$username = $_POST['username'];
$checkadministrador = "SELECT username FROM usergeral WHERE username='$username' AND administrador = true";
$resultadministrador = pg_query($connection, $checkadministrador);


$query1 = "SELECT * FROM prato WHERE ('$nome_prato' = nome)";
$result1 = pg_query($connection, $query1);
if (pg_affected_rows($result1) > 0) {
$name_error = "Já foi criado um prato com esse nome";
} else {
echo $restaurante_nome;
$query = "INSERT INTO prato (nome,tipo,descricao,preco,comprado,restaurante_nome,administrador_usergeral_username) VALUES ('$nome_prato','$tipo_prato','$descricao','$preco','$comprado','$restaurante_nome','$administrador_usergeral_username')";
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
    <title>CriarPrato</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>
<main>
    <p> CRIAR PRATO </p>

    <?php
    $username = $_POST['username'];
    $checkadministrador = "SELECT username FROM usergeral WHERE username='$username' AND administrador = true";
    $resultadministrador = pg_query($connection, $checkadministrador);
    if (isset($_SESSION['success']) && $_SESSION['success'] && pg_affected_rows($resultadministrador) == 0) { ?>
        <form action="CriarPrato.php" method="POST" id="form_prato">
            <label> <br>Nome do Prato
                <input type="text" name="nome_prato" required>
            </label>
            <?php if (isset($name_error)) { ?>
                <span><?php echo $name_error; ?></span>
            <?php } ?>
            <br>
            <label> <br>Restaurante
                <select name="restaurante">
                    <?php
                    $query2 = "SELECT nome FROM restaurante WHERE username='$username'";
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
            <label> <br>Tipo de prato
                <select name="tipo_prato">
                    <option value="Carne">Carne</option>
                    <option value="Peixe">Peixe</option>
                    <option value="Vegetariano">Vegetariano</option>
                </select>
            </label>
            <br>
            <label> <br>Preço
                <input type="number" name="preco_prato" required></label>
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


