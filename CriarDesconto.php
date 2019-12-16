<?php
session_start();
include_once "acess_bd.php";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Desconto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php');
include_once "CheckAdministrador.php";

if (isset($_SESSION['success']) && $_SESSION['success']) {
?>
<main>
    <p> CRIAR DESCONTO </p>
    <form action="CriarDesconto.php" method="POST" id="form_desconto">
        <label> <br>Valor
            <input type="number" min="1" name="valor" required>
        </label>
        <br>
        <label> <br>Restaurante
            <?php
            $today = date("Y-m-d H:i:s");
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
            <input type="datetime-local" name="validade" min="<?php echo date('Y-m-d').'T'.date('H:i'); ?>" value="<?php echo date('Y-m-d').'T'.date('H:i'); ?>" required></label>
        <br>
        <label> <br> Número de Clientes
            <input type="number" min="1" name="numero"  required>
        </label>
        <br>
        <input type="submit" name="create_desconto" value="Guardar">
    </form>
    <?php

    if (isset($_POST['create_desconto'])) {
        $valor = $_POST['valor'];
        $restaurante = $_POST['restaurante'];
        $validade = $_POST['validade'];
        $today = date("Y-m-d H:i:s");
        $numero = $_POST['numero'];
        if ($validade > $today) {
            $query = "INSERT INTO desconto (valor,duracao,num_pessoas,restaurante_nome,administrador_usergeral_username) VALUES 
                ('$valor','$validade','$numero','$restaurante','$username')";
            $result1 = pg_query($connection, $query);
            echo "Desconto gerado com sucesso!" ?> <a href="Homepage_Administrador.php">Voltar para a página
                principal</a> <?php

            $query2 = "select P.restaurante_nome, C. usergeral_username, sum(D.quantidade*P.preco) 
    from cliente AS C, encomenda as E, prato as P, detalhe AS D, restaurante AS R 
    where C.usergeral_username= E.cliente_usergeral_username and E.id= D.encomenda_id and D.prato_id= P.id 
    and R.nome= P.restaurante_nome and R.administrador_usergeral_username='$username' and R.nome='$restaurante'
    group by P.restaurante_nome, C.usergeral_username
    ORDER BY sum(D.quantidade*P.preco) DESC";
            $result2 = pg_query($connection, $query2);

            //numero de pessoas que quero q afete o desconto
            if ($numero > pg_affected_rows($result2)) {
                $numero = pg_affected_rows($result2);
            }
            $today = date("Y-m-d H:i:s");
            $query3 = "SELECT desconto.id from desconto where desconto.administrador_usergeral_username='$username' 
                    and Desconto.restaurante_nome='$restaurante' and desconto.duracao>='$today'
                    Order by desconto.id desc";
            $desconto_id_calc = pg_query($connection, $query3);

            if (pg_affected_rows($desconto_id_calc) > 0) {
                $desconto_id_calc = pg_fetch_result($desconto_id_calc, 0, 0);

            } else {
                $desconto_id_calc = 0;
            }
            if ($desconto_id_calc > 0) {
                for ($i = 0; $i < $numero; $i++) {
                    //restaurante escolhido
                    echo pg_fetch_result($result2, $i, 0);
                    //nome do vencedor
                    echo pg_fetch_result($result2, $i, 1);
                    //dinheiro gasto no respetivo restaurante
                    echo pg_fetch_result($result2, $i, 2);

                    //id do cliente vencedor
                    $nome_cliente = pg_fetch_result($result2, $i, 1);

                    $query4 = "INSERT INTO desconto_info(usado, desconto_id, cliente_usergeral_username) 
            VALUES (FALSE, '$desconto_id_calc','$nome_cliente')";
                    $result4 = pg_query($connection, $query4);
                }
            }
        }
    }
    else {
        echo "Tem que inserir uma validade válida.";
    }
    }
    ?>
</main>
</body>
</html>


