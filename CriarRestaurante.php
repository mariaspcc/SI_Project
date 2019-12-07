<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>

<main>
    <div>
        <p> CRIAR RESTAURANTE</p>
        <form action="RegisterCliente.php" method="POST" id="form_restaurante">
            <label> <br>Nome
                <input type="text" name="nome" required>
            </label>
            <br>
            <label> <br>Localização
                <input type="text" name="localizacao" required></label>
            <br>
            <input type="submit" name="criar_restaurante">
        </form>
    </div>
</main>
</body>
</html>
