<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Choose</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('header_in.php'); ?>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>

<main>
    <div class="escolha">
        <form action='PhpRegisterAdministrador.php' method='POST'>
            <label>
                <a href="RegisterCliente.php">
                    <input id="clientebutton" type='button' value='Cliente' name='B_cliente' >
                </a>
                <a href="RegisterAdministrador.php">
                    <input id="administradorbutton" type='button' value='Administrador' name='B_admin'>
                </a>
            </label>
        </form>
    </div>

</main>
</body>
</html>
