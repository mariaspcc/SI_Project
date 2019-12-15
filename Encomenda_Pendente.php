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

        //variável da página Homepage_cliente e verifica se esta existe
        if (isset($_GET["variavel"])) {
            //declaração/atribuição da variável
            $aux = $_GET["variavel"];
            $id = $aux[0];
            $valor = $aux[1];

            echo "id:" . $id;
            echo "valor:" . $valor;

            //seleciona atributos da tabela prato onde a variavel id é igual ao id do prato selecionado
            $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato WHERE id = '$id'";
            $result2 = pg_query($connection, $query2);

            //ciclo que lê as linhas do $result2 (percorre tabela prato)
            //while ($res = pg_fetch_array($result2)) {
            //determina a ultima encomenda feita (id maior que existe na tabela encomenda)
            $query3 = "SELECT max(id) FROM encomenda";
            //resultado vai ser apenas um parametro da tabela
            $result3 = pg_query($connection, $query3);
            //vai buscar esse valor com o index(0,0)
            $valor = pg_fetch_result($result3, 0, 0);

            //$_SESSION guarda o numero da encomenda em curso
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
            //id da encomenda atual
            $id_encomenda = $_SESSION['encomenda_id'];
            $adiciona = true;

            // }

            $query5_1 = "SELECT prato_id, encomenda_id FROM detalhe WHERE prato_id='$id' AND encomenda_id='$id_encomenda'";
            $result5_1 = pg_query($connection, $query5_1);
            if (pg_num_rows($result5_1) > 0) {
                $adiciona = false;
            }
            //insere na tabela detalhe a quantidade do prato, o id do prato e o id da respetiva encomenda
            if ($adiciona === true) {
                $query5 = "INSERT INTO detalhe (quantidade, prato_id, encomenda_id) VALUES (1,'$id','$id_encomenda')";
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
        $query6 = "SELECT nome, preco, id, quantidade FROM  prato, detalhe WHERE prato.id = detalhe.prato_id AND detalhe.encomenda_id = $id_encomenda";
        $result6 = pg_query($connection, $query6);

        //ciclo for para escrever os dados dos pratos
        for ($i = 0; $i < pg_affected_rows($result6); $i++) {
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
            <!--variavel $id3 contem id do prato selecionado -->
            <?php $id2 = pg_fetch_result($result6, $i, 2);
            $nome_p = pg_fetch_result($result6, $i, 0);
            $qnt2 = pg_fetch_result($result6, $i, 3);


            $querymostrar="SELECT quantidade FROM detalhe WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id2'";
            $resultmostrar= pg_query($connection, $querymostrar);
            $mostrar=pg_fetch_result($resultmostrar,0,0);

            ?>
            <label>
                <br>Quantidade
                <form name="form" action="" method="POST">
                    <input type="number" min="1" name="quantidade" value="<?php echo $mostrar ?>" required>
                    <button type="submit" name="aplicar" id=>Aplicar</button>
                </form>
            </label>
            <?php

            ?>
            <br>

            <a href="Encomenda_Pendente.php?variavel2=<?php echo $id2 ?>">
                <input type="submit" name="retirar_prato" value="Retirar prato da encomenda">
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
            /* $qnt = $_POST['quantidade'];
             echo "quantidade:" . $qnt;
             $queryqnt = "UPDATE detalhe SET quantidade='$qnt' WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id2'";
             $resultqnt = pg_query($connection, $queryqnt);*/
            $quantidade= $_POST['quantidade'];
            $queryqnt = "UPDATE detalhe SET quantidade = '$quantidade' WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id2'";
            $resultqnt = pg_query($connection, $queryqnt);

            $querymostrar2="SELECT quantidade FROM detalhe WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id2'";
            $resultmostrar2= pg_query($connection, $querymostrar2);
            $mostrar=pg_fetch_result($resultmostrar,0,0);
        }
        else{
                           $mostrar=1;

        }

        //saldo inicial (predefinido)
        $query11 = "SELECT saldo FROM cliente WHERE usergeral_username='$cliente_usergeral_username'";
        $result11 = pg_query($connection, $query11);
        $saldo_restante = pg_fetch_result($result11, 0, 0);

        $query12 = "select sum(d.quantidade*p.preco) from encomenda as E, prato as P, detalhe AS D
    where e.id= d.encomenda_id and d.prato_id= p.id AND d.encomenda_id=$id_encomenda
    group by e.id";
        $result12 = pg_query($connection, $query12);
        if (pg_affected_rows($result12) === 0) {
            echo "Valor total da encomenda: 0";
        } else {
            echo "Valor total da encomenda: " . pg_fetch_result($result12, 0, 0);
        }
        ?>
        <br>
        <?php
        //saldo após encomendas (restante)
        $query10 = "select c.saldo-sum(d.quantidade*p.preco) 
    from cliente AS C, encomenda as E, prato as P, detalhe AS D 
    where c. usergeral_username= e.cliente_usergeral_username and e.id= d.encomenda_id and d.prato_id= p.id
    and c.usergeral_username='$cliente_usergeral_username'
    group by c. usergeral_username";
        $result10 = pg_query($connection, $query10);

        //entra no if se o cliente já tiver alguma encomenda feita
        if (pg_affected_rows($result10) > 0) {
            $saldo_restante = pg_fetch_result($result10, 0, 0);
        }
        echo "saldo restante: " . $saldo_restante;


        if ($saldo_restante >= 0) {

            $username = $_SESSION['username'];
            $administrador = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = true";
            $cliente = "SELECT * FROM usergeral WHERE '$username' = username AND administrador = false";
            $result1 = pg_query($connection, $administrador);
            $result2 = pg_query($connection, $cliente);

            if (pg_affected_rows($result1) == 0 && pg_affected_rows($result2) == 1) {
                ?>
                <br>
                <br>
                <a href="Homepage_Cliente.php">
                    <input type="submit" class="botao" value="Continuar a comprar" name="comp">
                </a>
                <br>
                <?php if (pg_affected_rows($result12) > 0) { ?>
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
            echo "O seu carrinho está vazio";
        }
        ?>
        <br>
        <a href="Homepage_Cliente.php">Voltar à página principal</a>
        <?php
    }
    ?>


</main>

</body>
</html>

