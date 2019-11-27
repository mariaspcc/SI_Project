<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<main>
    <div class="formulario">
        <p> ENTRAR</p>
        <form action="login.php" method="POST">
            <label> <br>Username</br>
                <input type="text" name="username" required></label>
            <br>
            <label> <br>Password</br>
                <input type="password" name="password" required></label>
            <br>
            <input id="botão_entrar" type="submit" value="Entrar">
            <br>
            <p>Não tem conta? Crie <a href="Choose.html">aqui</a>.</p>
        </form>
    </div>
</main>
</body>

</html>