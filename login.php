<?php include('phpLogin.php')?>

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
<nav
<div class="barra">
    <div id="logo">
        <p>LDMEats</p>
    </div>
</div>
</nav>
<main>
    <div class="formulario">
        <p> ENTRAR</p>
        <?php if(isset($name_error)){?>
            <span><?php echo $name_error;?></span>
        <?php }?>
        <form action="login.php" method="POST" >
            <label> <br>Username
                <div class="erro">
                    <input type="text" name="username" required>
                </div>
            <br>
            <label> <br>Password</br>
                <input type="password" name="password" required></label>
            <br>
            <input type="submit" value="Entrar" name="login" id="botão_entrar" >
            <br>
            <p>Não tem conta? Crie <a href="Choose.php">aqui</a>.</p>
        </form>
    </div>
</main>
</body>

</html>