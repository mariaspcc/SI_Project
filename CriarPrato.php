<?php
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}
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
    <title>CriarPrato</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>
<main>
    <div class="FormPrato">
        <p> CRIAR PRATO </p>
        <form action="CriarPrato.php" method="POST" id="form_prato">
            <label> <br>Nome do Prato
                    <input type="text" name="nome_prato" required>
            </label>
            <br>
            <label> <br>Preço
                <input type="number" name="prato_preço" required></label>
            <br>
            <label> <br>Detalhes
                <input type="text" name="detalhes_prato" required>
            </label>
            <br>
            <input type="submit" name="register" value="Guardar">
        </form>
    </div>
</main>
</body>
</html>


