<?php
include_once "acess_bd.php";
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Encomenda_Realizada</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>

<main>
    <?php
    if (isset($_SESSION['success']) && $_SESSION['success']) {

        include_once "CheckCliente.php";
    $cliente_usergeral_username = $_SESSION['username'];


    if(isset($_POST['enco'])) {
        $today = date("Y-m-d H:i:s");
        $desconto = "select min(DI.desconto_id), D.restaurante_nome
                        from desconto as D, desconto_info as DI 
                        where DI.cliente_usergeral_username='$cliente_usergeral_username'
                        and D.id=DI.desconto_id and DI.usado=FALSE and D.duracao>'$today'
                        group by D.restaurante_nome";
        $result_desconto = pg_query($connection, $desconto);

        for ($q = 0; $q < pg_affected_rows($result_desconto); $q++) {
            $id_desconto = pg_fetch_result($result_desconto, $q, 0);

            $query_update="UPDATE desconto_info SET usado=TRUE
            WHERE cliente_usergeral_username='$cliente_usergeral_username'
            and desconto_id='$id_desconto'";
            $result_update = pg_query($connection, $query_update);

        }
    }




    $id_encomenda_atual=$_SESSION['encomenda_id'];
    $query11="UPDATE encomenda SET terminada='true' WHERE id='$id_encomenda_atual'";
    $result11 = pg_query($connection, $query11);

    //seleciona o id do prato da tabela detalhe tudo junto por id de prato
    $query10="SELECT prato_id FROM detalhe GROUP BY prato_id";
    $result10 = pg_query($connection, $query10);

    //caso a tabela encomendas e detalhes seja esvaziada, todas as variaveis ficam a false pois nao há encomendas
    //coloca boolean comprado a falso sempre
    $query12="UPDATE prato SET comprado='false'";
    $result12 = pg_query($connection, $query12);

    //percorre todos os pratos id da tabela e faz o update do id do prato comprado, pratos estes q estão na tabela detalhe
    for ($i = 0; $i < pg_affected_rows($result10); $i++) {
        $prato_id=pg_fetch_result($result10, $i, 0);

        $query11="UPDATE prato SET comprado='true' WHERE id='$prato_id'";
        $result11 = pg_query($connection, $query11);
    }

    //variavel sessão fica a 0 quando encomenda anterior termina, para quando escolher um novo prato iniciar uma encomenda nova
    $_SESSION['encomenda_id'] = 0;

    ?>
    <p>Encomenda realizada com sucesso</p>
    <a href="Homepage_Cliente.php">
        <input type="submit" class="botao" value="Regressar para a Homepage">
    </a>
<?php }?>
</main>

</body>
</html>

