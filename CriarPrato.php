<?php
session_start();

include('phpCriarPrato.php');

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
        <form action="CriarPrato.php" method="POST" id="form_prato">
            <label> <br>Nome do Prato
                    <input type="text" name="nome_prato" required>
            </label>
            <br>
            <label> <br>Preço
                <input type="number" name="preço_prato" required></label>
            <br>
            <label> <br>Descrição
                <input type="text" name="descrição_prato" required>
            </label>
            <br>
            <input type="submit" name="register" value="Guardar">
        </form>
</main>
</body>
</html>


