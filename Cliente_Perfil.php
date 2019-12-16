<?php
include_once "acess_bd.php";
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Homepage_cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<img id="fundo" alt="fundo" src="images/img_fundo.jpg" height="640" width="960"/>
<div class="fundo_quadrado"></div>
<?php include('header_in.php'); ?>

<main>
    <?php
    include_once "CheckCliente.php";

    if (isset($_SESSION['success']) && $_SESSION['success']) {
        $cliente_usergeral_username = $_SESSION['username'];
        ?>
        <a href="Homepage_Cliente.php"> Regressa à Homepage </a>
        <br><br>
        <?php
        //saldo inicial (predefinido)
        $query3 = "SELECT saldo FROM cliente WHERE usergeral_username='$cliente_usergeral_username'";
        $result3 = pg_query($connection, $query3);
        $saldo_ini = pg_fetch_result($result3, 0, 0);


        $query2= "select c.saldo-sum(d.quantidade*d.valor_final) 
        from cliente AS C, encomenda as E, detalhe AS D 
        where c. usergeral_username= e.cliente_usergeral_username and e.id= d.encomenda_id and e.terminada=TRUE
        and e.cliente_usergeral_username ='$cliente_usergeral_username'
        group by c. usergeral_username";

        $result2 = pg_query($connection, $query2);

        if(pg_affected_rows($result2)===0){
            echo "Saldo atual: ".$saldo_ini;
        }
        else {
            echo "Saldo atual: " . pg_fetch_result($result2, 0, 0);
        }
        ?>
        <br><br>
        <p> AS MINHAS ENCOMENDAS</p>
        <?php
        $query1 = "SELECT e.id, p.nome, d.quantidade, p.preco from cliente AS C, encomenda as E, prato as P, detalhe AS D
        where c. usergeral_username= e.cliente_usergeral_username and e.id= d.encomenda_id and
        d.prato_id= p.id and e.terminada=TRUE AND e.cliente_usergeral_username ='$cliente_usergeral_username'";
        $result1 = pg_query($connection, $query1);
        $total=0;
        $soma2=0;
        $aux1=0;

        for ($i = 0; $i < pg_affected_rows($result1); $i++) {
            //soma de cada linha
            $soma1=pg_fetch_result($result1, $i, 2)*pg_fetch_result($result1, $i, 3);

            //total=total+soma
            $total+=$soma1;

            //para mudar encomenda
            if((pg_fetch_result($result1, $i, 0) <> $aux1) && ($aux1<>0)){

                echo "&nbsp&nbsp&nbsp&nbsp"."Soma: ".$soma2;
                ?><br><br><br><?php
                $soma2=0;
            }
            $soma2+=$soma1;
            $aux1=pg_fetch_result($result1, $i, 0);

            echo "&nbsp&nbsp&nbsp&nbsp"."Encomenda: ".pg_fetch_result($result1, $i, 0);
            echo "&nbsp&nbsp&nbsp&nbsp"."Nome do prato: ".pg_fetch_result($result1, $i, 1);
            echo "&nbsp&nbsp&nbsp&nbsp"."Quantidade: ".pg_fetch_result($result1, $i, 2);
            echo "&nbsp&nbsp&nbsp&nbsp"."Preço: ".pg_fetch_result($result1, $i, 3);
            ?><br><?php

            if($i===pg_affected_rows($result1)-1){
                echo "&nbsp&nbsp&nbsp&nbsp"."Soma: ".$soma2;
                ?><br><br><br><?php
                echo "Total gasto em encomendas: ".$total;
            }
        }
    }
    ?>
</main>
</body>
</html>
