<?php include('PhpRegisterCliente.php')?>

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
<main>
    <div class="formulario">
        <p> REGISTAR</p>
        <p> CLIENTE</p>
        <form action="RegisterCliente.php" method="POST" id="register_form">
            <label> <br>Username
                <div class="erro">
                    <input type="text" name="c_username" required>
                    <?php if(isset($name_error)){?>
                        <span><?php echo $name_error;?></span>
                    <?php }?>
                </div>
            </label>
            <br>
            <label> <br>Password
                <input type="password" name="c_password" required></label>
            <br>
            <input type="submit" name="register">
            <p>Já tem uma conta? Faça login <a href="login.php">aqui</a>.</p>
        </form>
    </div>
</main>

</body>
</html>
