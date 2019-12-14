<?php
session_start();
include_once "acess_bd.php";
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
<?php include('header_in.php');
if (isset($_SESSION['success']) && $_SESSION['success']) {
?>
<main>
    <p> CRIAR DESCONTO </p>
    <form action="CriarDesconto.php" method="POST" id="form_desconto">
        <label> <br>Valor
            <input type="number" min="1" name="valor" required></label>
        </label>
        <br>
        <label> <br>Restaurante
            <?php
            $username = $_SESSION['username'];
            $query2 = "SELECT nome FROM restaurante WHERE administrador_usergeral_username ='$username'";
            $result2 = pg_query($connection, $query2);
            if (pg_affected_rows($result2) > 0) { ?>
                <select name="restaurante">
                    <?php
                    for ($i = 0; $i < pg_affected_rows($result2); $i++) {
                        $arr = pg_fetch_array($result2);
                        ?>
                        <option><?php echo $arr['nome']; ?></option>
                    <?php }
                    ?>
                </select>
            <?php } else { ?>
                <br>
                <a href="CriarRestaurante.php">Criar Restaurante</a>
            <?php } ?>
        </label>
        <br>
        <label> <br>Validade
            <br>
            <input type="datetime-local" name="validade" required></label>
        <br>
        <label> <br> Número de Clientes
            <input type="number" min="1" name="numero" required>
        </label>
        <br>
        <label> <br> Valor Mínimo gasto
            <input type="number" min="1" name="minimo" required>
        </label>
        <br>
        <input type="submit" name="create_desconto" value="Guardar">
    </form>
    <?php

    if (isset($_POST['create_desconto'])) {
        $valor = $_POST['valor'];
        $restaurante = $_POST['restaurante'];
        $validade = $_POST['validade'];
        $numero = $_POST['numero'];
        $minimo = $_POST['minimo'];
        $query = "INSERT INTO desconto (valor,duracao,numero_pessoas,minimo,restaurante_nome,administrador_usergeral_username) VALUES ('$valor','$validade','$numero','$minimo','$restaurante','$username')";
        $result1 = pg_query($connection, $query);
    }

    $query2="select P.restaurante_nome, C. usergeral_username, sum(d.quantidade*p.preco) 
    from cliente AS C, encomenda as E, prato as P, detalhe AS D, restaurante AS R 
    where C.usergeral_username= E.cliente_usergeral_username and E.id= D.encomenda_id and D.prato_id= P.id 
    and R.nome= P.restaurante_nome and R.administrador_usergeral_username='$username'
    group by P.restaurante_nome, C.usergeral_username";
    $result2 = pg_query($connection, $query2);

    for ($i = 0; $i < pg_affected_rows($result2); $i++) {

    echo pg_fetch_result($result2, $i, 0);
        echo pg_fetch_result($result2, $i, 1);
        echo pg_fetch_result($result2, $i, 2);?> <br><?php

    }

    }

    ?>
</main>
</body>
</html>


