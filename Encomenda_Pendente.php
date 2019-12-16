<?php
include_once "acess_bd.php";
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Encomenda_Pendente</title>
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

        if(!isset($_SESSION['encomenda_id'])) {
            $_SESSION['encomenda_id']=0;
        }

        //variável da página Homepage_cliente e verifica se esta existe
        if (isset($_GET["variavel"])) {
            //declaração/atribuição da variável

            //ID DO PRATO SELECIONADO
            $id = $_GET["variavel"];

            //seleciona atributos da tabela prato onde a variavel id é igual ao id do prato selecionado
            $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato WHERE id = '$id'";
            $result2 = pg_query($connection, $query2);
            //PREÇO INICIAL DO PRATO
            $preco_inicial_prato = pg_fetch_result($result2, 0, 3);

            //ciclo que lê as linhas do $result2 (percorre tabela prato)
            //while ($res = pg_fetch_array($result2)) {

            //ULTIMA ENCOMENDA FEITA (id maior que existe na tabela encomenda)
            $query3 = "SELECT max(id) FROM encomenda";
            //resultado vai ser apenas um parametro da tabela
            $result3 = pg_query($connection, $query3);
            //vai buscar esse valor com o index(0,0)
            $valor = pg_fetch_result($result3, 0, 0);

            //$_SESSION ['encomenda_id] - ENCOMENDA EM CURSO
            //se este for diferente ao id da ultima encomenda ou se ainda não existir encomendas feitas
            if (($_SESSION['encomenda_id'] <> $valor) || ($_SESSION['encomenda_id'] === 0)) {
                //atribuimos uma variavel que soma ao id maximo ($valor) + 1
                // (ex: nao existe ainda nenhuma 0+1= 1º encomenda || ultima encomenda feita tem id=3 cria nova com id = 4)
                $id_enc = $valor + 1;
                //insere na tabela encomenda o id da encomenda e o username do cliente
                $query4 = "INSERT INTO encomenda(id,terminada,cliente_usergeral_username) VALUES ($id_enc,'FALSE','$cliente_usergeral_username')";
                $result4 = pg_query($connection, $query4);
                //guarda o id da encomenda que acabou de ser criada
                $_SESSION['encomenda_id'] = $id_enc;
            }
            //ID ENCOMENDA ATUAL
            $id_encomenda = $_SESSION['encomenda_id'];
            $adiciona = true;

            // }
            //não cria nova encomenda se na encomenda atual for adicionado um prato que já pertence à encomenda
            $query5_1 = "SELECT prato_id, encomenda_id FROM detalhe WHERE prato_id='$id' AND encomenda_id='$id_encomenda'";
            $result5_1 = pg_query($connection, $query5_1);
            if (pg_num_rows($result5_1) > 0) {
                $adiciona = false;
            }
            //insere na tabela detalhe a quantidade do prato, o id do prato e o id da respetiva encomenda
            if ($adiciona === true) {
                $query5 = "INSERT INTO detalhe (quantidade, prato_id, valor_final,encomenda_id) VALUES (1,'$id','$preco_inicial_prato','$id_encomenda')";
                $result5 = pg_query($connection, $query5);
            }
            //}
            //determina a ultima encomenda feita (id maior que existe na tabela encomenda)
            $query3 = "SELECT max(id) FROM encomenda";
            //resultado vai ser apenas um parametro da tabela
            $result3 = pg_query($connection, $query3);
            //vai buscar esse valor com o index(0,0)
            $valor = pg_fetch_result($result3, 0, 0);

        }

        //id da encomenda atual
        $id_encomenda = $_SESSION['encomenda_id'];

        //buscar dados relativos ao prato inseridos na encomenda
        //verifica se o id do prato na tabela prato é igual ao prato.id da tabela detalhe
        // e se a encomenda_id da tabela detalhe é igual à variavel id_encomenda
        $query6 = "SELECT nome, preco, id, quantidade, restaurante_nome, encomenda_id FROM  prato, detalhe WHERE prato.id = detalhe.prato_id AND detalhe.encomenda_id = $id_encomenda";
        $result6 = pg_query($connection, $query6);



        //DESCONTOS
        $today = date("Y-m-d H:i:s");

        //Procura descontos que tenham sido atribuidos ao cliente
        $desconto = "select min(DI.desconto_id), D.restaurante_nome
                        from desconto as D, desconto_info as DI 
                        where DI.cliente_usergeral_username='$cliente_usergeral_username'
                        and D.id=DI.desconto_id and DI.usado=FALSE and D.duracao>'$today'
                        group by D.restaurante_nome";
        $result_desconto = pg_query($connection, $desconto);

        //ciclo for para escrever os dados dos pratos
        for ($i = 0; $i < pg_affected_rows($result6); $i++) {

            $id_desconto = 0;
            //vai ver se o prato tem desconto

            for ($q = 0; $q < pg_affected_rows($result_desconto); $q++) {
                //tabela restaurante nome
                $restaurante_tabela = pg_fetch_result($result_desconto, $q, 1);
                //nome do restaurante
                $restaurante_prato = pg_fetch_result($result6, $i, 4);
                //se o nome do restaurante existir na tabela desconto
                if ($restaurante_tabela === $restaurante_prato) {
                    //vai buscar o id do desconto a q esse restaurante está associado
                    $id_desconto = pg_fetch_result($result_desconto, $q, 0);
                }
            }
            $result_valor_desc = 0;
            $resultado_desconto = 0;

            //se encontrar id desconto seleciona o valor do mesmo
            if ($id_desconto > 0) {
                //seleciona o valor do desconto (%)
                $query_desc_rest = "select valor from desconto where desconto.id='$id_desconto'";
                $result_valor_desc = pg_query($connection, $query_desc_rest);
                $valor = pg_fetch_result($result_valor_desc, 0, 0);

                //Aplica desconto ao preço do prato
                $preco_prato = pg_fetch_result($result6, $i, 1);
                $resultado_desconto = $preco_prato - ($valor / 100 * $preco_prato);

                $id_prato = pg_fetch_result($result6, $i, 2);
                $id_encomenda_prato = pg_fetch_result($result6, $i, 5);
                $query_preco_desconto = "UPDATE detalhe SET valor_final='$resultado_desconto'
                WHERE detalhe.prato_id='$id_prato' and detalhe.encomenda_id='$id_encomenda_prato'";
                $result_query_preco_desconto = pg_query($connection, $query_preco_desconto);
            }


            ?>
            <!--escreve o nome do prato selecionado-->
            <h1>
                <?php
                echo pg_fetch_result($result6, $i, 0);
                ?>
            </h1>
            <!--escreve o preço do prato selecionado -->
            <h2>
                <?php
                echo pg_fetch_result($result6, $i, 1);
                ?>
                €
            </h2>

            <?php
            if ($id_desconto > 0) { ?>
                <h5><?php echo "Com desconto fica: " . number_format($resultado_desconto,2)." €";
                    ?> </h5>
                <?php
            }

            $id2 = pg_fetch_result($result6, $i, 2);
            $nome_p = pg_fetch_result($result6, $i, 0);
            $qnt2 = pg_fetch_result($result6, $i, 3);

            //seleciona a quantidade de cada prato
            $querymostrar = "SELECT quantidade FROM detalhe WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id2'";
            $resultmostrar = pg_query($connection, $querymostrar);
            $mostrar = pg_fetch_result($resultmostrar, 0, 0);

            ?>
            <label>
                <br>Quantidade
                <form name="form" action="" method="POST">
                    <input type="number" min="1" name="quantidade" value="<?php echo $mostrar ?>" required>
                    <br>
                    <button type="submit" name="aplicar" id="aplicar">Aplicar</button>
                </form>
            </label>
            <?php

            ?>
            <br>

            <a href="Encomenda_Pendente.php?variavel2=<?php echo $id2 ?>">
                <input type="submit" name="retirar_prato" class="botao" value="Retirar prato da encomenda">
            </a>
            <br>
            <br>
            <br>
            <?php
            //variavel contem o id do prato (de uma encomenda especifica) para apagá-lo dessa encomenda
            if (isset($_GET["variavel2"])) {
                $id2 = $_GET["variavel2"];
                $query7 = "DELETE FROM detalhe WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id2'";
                $result7 = pg_query($connection, $query7);
                //atualiza página
                header('location: Encomenda_Pendente.php');
            }

        }
        if (isset($_POST['aplicar'])) {

            //botao vai buscar o valor inserido na quantidade
            $quantidade = $_POST['quantidade'];
            $queryqnt = "UPDATE detalhe SET quantidade = '$quantidade' WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id2'";
            $resultqnt = pg_query($connection, $queryqnt);

            //seleciona a nova quantidade inserida na tabela detalhe
            $querymostrar2 = "SELECT quantidade FROM detalhe WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id2'";
            $resultmostrar2 = pg_query($connection, $querymostrar2);

            $mostrar = pg_fetch_result($resultmostrar, 0, 0);
        } else {
            $mostrar = 1;
        }


            //SALDO INICIAL(predefinido)
        //Vai buscar o saldo inicial do utilizador
            $query11 = "SELECT saldo FROM cliente WHERE usergeral_username='$cliente_usergeral_username'";
            $result11 = pg_query($connection, $query11);
            //saldo inicial
            $saldo_restante = pg_fetch_result($result11, 0, 0);


            //valor final a partir da tabela encomenda
            //agrupa todos os elementos da mesma encomenda e calcula o saldo total da encomenda
            $query_valor_final = "SELECT sum(valor_final) from detalhe where encomenda_id='$id_encomenda' group by encomenda_id";
            $result_valor_final = pg_query($connection, $query_valor_final);

            //variavel inicializada com 0
            $valor = 0;

            if (pg_affected_rows($result_valor_final) > 0) {
                //primeiro valor da tabela do $result_valor_final é o total da encomenda
                $valor = pg_fetch_result($result_valor_final, 0, 0);
            }
            
            if (pg_affected_rows($result_valor_final) === 0) {
                echo "<br><br>"."Valor total da encomenda: 0";
            } else {
                echo "<br><br>"."Valor total da encomenda: " . pg_fetch_result($result_valor_final, 0, 0)." €";
            }
            ?>
            <br>
            <?php
            //saldo após encomendas (restante)
            $query10 = "select c.saldo-sum(d.quantidade*d.valor_final) 
        from cliente AS C, encomenda as E, detalhe AS D 
        where c. usergeral_username= e.cliente_usergeral_username and e.id= d.encomenda_id
        and c.usergeral_username='$cliente_usergeral_username'
        group by c. usergeral_username";
            $result10 = pg_query($connection, $query10);

            //entra no if se o cliente já tiver alguma encomenda feita
            if (pg_affected_rows($result10) > 0) {
                $saldo_restante = pg_fetch_result($result10, 0, 0);
            }
            echo "<br>"."Saldo restante: " . number_format($saldo_restante,2)." €";


            if ($saldo_restante >= 0) {

                $username = $_SESSION['username'];
                $administrador = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = true";
                $cliente = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = false";
                $result1 = pg_query($connection, $administrador);
                $result2 = pg_query($connection, $cliente);

                if (pg_affected_rows($result1) == 0 && pg_affected_rows($result2) == 1 && pg_affected_rows($result6) > 0) {
                    ?>
                    <br>
                    <br>
                    <a href="Homepage_Cliente.php">
                        <input type="submit" class="botao" value="Continuar a comprar" name="comp">
                    </a>
                    <br>
                    <br>
                    <?php if (pg_affected_rows($result10) > 0) { ?>
                        <form action="Encomenda_realizada.php" method="POST">
                            <input type="submit" class="botao" value="Encomendar" name="enco">
                        </form>
                        <?php
                    }
                }
            }
            if (pg_affected_rows($result10) > 0) {
                if (pg_fetch_result($result10, 0, 0) < 0) {
                    echo "Não tem saldo suficiente para continuar a encomenda.";

                }
            }

            if (pg_affected_rows($result6) === 0) {
                echo "<br><br>"."O seu carrinho está vazio";
            }
            ?>
            <br>
        <br>
            <a href="Homepage_Cliente.php" style="color:white">Voltar à página principal</a>
            <?php
        }
    ?>


</main>

</body>
</html>

