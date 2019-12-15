<?php include('PhpRegisterAdministrador.php')?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php include('header_in.php'); ?>

<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
</nav>
<main>
    <div class="formulario">
        <p> REGISTAR </p>
        <p>ADMINISTRADOR</p>
        <form action="RegisterAdministrador.php" method="POST" id="register_form">
            <label> <br>Username
                <div class="erro">
                    <input type="text" name="a_username" required>
                    <?php if(isset($name_error)){?>
                        <span><?php echo $name_error;?></span>
                    <?php }?>
                </div>
            </label>
            <br>
            <label> <br>Password
                <input type="password" name="a_password" required></label>
            <br>
            <input type="submit" name="register">
        </form>
        <p>Já tem uma conta? Faça login <a href="login.php">aqui</a>.</p>
    </div>
</main>

</body>
</html>

