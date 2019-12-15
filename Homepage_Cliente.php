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
    <a href="Cliente_Perfil.php"> Perfil </a>
    <a href="Encomenda_Pendente.php"> Carrinho </a>
    <?php
    include_once "CheckCliente.php";

    if (isset($_SESSION['success']) && $_SESSION['success']) {
        $cliente_usergeral_username = $_SESSION['username'];?>

        <?php if (isset($name_error)) { ?>
            <span><?php echo $name_error; ?></span>
        <?php } ?>

        <?php
        $query1 = "SELECT nome FROM restaurante";
        $result1 = pg_query($connection, $query1);

        ?>

        <p>PRATOS</p>

        <form action="Homepage_Cliente.php" method="POST" id="ordenar">
            <input id="search" name="search" type="text" placeholder="Type here">
            <br>
            <select name="ordem">por
                <optgroup label="Preço">
                    <option value="p_crescente">Crescente</option>
                    <option value="p_decrescente">Decrescente</option>
                </optgroup>
                <optgroup label="Alabética">
                    <option value="a_crescente">Crescente</option>
                    <option value="a_decrescente">Decrescente</option>
                </optgroup>
            </select>
            <input type="submit" name="ordenar">
        </form>

        <?php
        //ORDENAR PRATOS
        if (isset($_POST['ordenar'])) {
            $valor = $_POST['ordem'];
            $pesquisa = $_POST['search'];
            //se escrever algo na search bar vai ordenar essa procura
            if ($pesquisa = $_POST['search']) {
                if ($valor === "p_crescente") {
                    $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato  WHERE nome LIKE '%$pesquisa%' OR restaurante_nome  LIKE '%$pesquisa%' ORDER BY preco ASC";
                } else if ($valor === "p_decrescente") {
                    $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato  WHERE nome LIKE '%$pesquisa%' OR restaurante_nome  LIKE '%$pesquisa%' ORDER BY preco DESC";
                } else if ($valor === "a_crescente") {
                    $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato  WHERE nome LIKE '%$pesquisa%' OR restaurante_nome  LIKE '%$pesquisa%' ORDER BY nome ASC";
                } else if ($valor === "a_decrescente") {
                    $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato  WHERE nome LIKE '%$pesquisa%' OR restaurante_nome  LIKE '%$pesquisa%'ORDER BY nome DESC";
                }
            } //se não escrever nada na search bar ($pesquisa fica vazia) e ordena todos os pratos
            else if ($pesquisa === '') {
                if ($valor === "p_crescente") {
                    $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato ORDER BY preco ASC";
                } else if ($valor === "p_decrescente") {
                    $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato ORDER BY preco DESC";
                } else if ($valor === "a_crescente") {
                    $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato ORDER BY nome ASC";
                } else if ($valor === "a_decrescente") {
                    $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato ORDER BY nome DESC";
                }
            }
        } //inicialmente aparecerão a lista de todos os pratos ordenados por ordem crescente de preço
        else {
            $query2 = "SELECT id, nome, restaurante_nome, preco FROM prato ORDER BY preco ASC";
        }
        $result2 = pg_query($connection, $query2);

        if (pg_affected_rows($result2) > 0) { ?>

            <ul class="listaPratos">
                <?php
                if (!isset($_SESSION['encomenda_id'])) {
                    $_SESSION['encomenda_id'] = 0;
                }

                //DESCONTOS
                $today = date("Y-m-d H:i:s");
                $desconto="select min(DI.desconto_id), D.restaurante_nome
                        from desconto as D, desconto_info as DI 
                        where DI.cliente_usergeral_username='$username'
                        and D.id=DI.desconto_id and DI.usado=FALSE and D.duracao>'$today'
                        group by D.restaurante_nome";
                $result_desconto = pg_query($connection, $desconto);

                for ($p = 0; $p < pg_affected_rows($result2); $p++) {

                    $id_desconto=0;
                    //vai ver se o prato tem desconto
                    for($q=0; $q < pg_affected_rows($result_desconto); $q++) {

                        $restaurante_tabela = pg_fetch_result($result_desconto, $q, 1);
                        $restaurante_prato = pg_fetch_result($result2, $p, 2);
                        if( $restaurante_tabela===$restaurante_prato){
                            $id_desconto=pg_fetch_result($result_desconto, $q, 0);
                        }
                    }
                    $result_valor_desc=0;
                    $resultado_desconto=0;
                    //se encontrar id desconto seleciona o valor do mesmo
                    if($id_desconto>0) {
                        $query_desc_rest = "select valor from desconto where desconto.id='$id_desconto'";
                        $result_valor_desc = pg_query($connection, $query_desc_rest);
                        $valor=pg_fetch_result($result_valor_desc, 0, 0);


                        $preco_prato = pg_fetch_result($result2, $p, 3);
                        $resultado_desconto=$preco_prato - ($valor/100*$preco_prato);

                    }

                    //seleciona a linha
                    $arrayPratos = pg_fetch_array($result2);
                    $y = $arrayPratos['id'];

                    ?>
                    <li>
                        <a href="DetalhePrato.php?variavel=<?php echo $y ?>">
                            <p><?php echo $arrayPratos['nome']; ?></p>
                        </a>
                        <h5><?php echo $arrayPratos['restaurante_nome']; ?></h5>
                        <h5><?php echo $arrayPratos['preco']; ?> €</h5>
                        <?php if($id_desconto>0) { ?>
                        <h5><?php echo "Com desconto fica:".$resultado_desconto ?> €</h5>
                        <?php
                        }

                        //por defeito nao existe prato na encomenda logo = true
                        $nao_existe = true;

                        //verifica se ela existe
                        if (isset($_SESSION['encomenda_id'])) {
                            //verifica se é maior q 0
                            if (($_SESSION['encomenda_id']) > 0) {
                                $id_encomenda = $_SESSION['encomenda_id'];
                                $query3 = "SELECT prato_id, encomenda_id FROM detalhe WHERE encomenda_id = '$id_encomenda' AND prato_id = '$y'";
                                $result3 = pg_query($connection, $query3);
                                if (pg_num_rows($result3) > 0) {
                                    //existe
                                    $nao_existe = false;
                                    echo "Este prato já foi adicionado à sua encomenda!";

                                }
                            }
                        }

                        if ($nao_existe === true) {

                            ?>
                            <br>
                            <a href="Encomenda_Pendente.php?variavel=<?php echo $y;
                            ?>">
                                <input type="submit" class="botao" value="Adicionar à encomenda">
                            </a>
                        <?php }
                        if ($nao_existe === false) {
                            ?>
                            <br>
                            <a href="Homepage_Cliente.php?variavel=<?php echo $y ?>">
                                <input type="submit" name="retirar_prato" value="Retirar prato da encomenda">
                            </a>
                            <br>
                            <?php
                            if (isset($_GET["variavel"])) {
                                $id = $_GET["variavel"];
                                $query4 = "DELETE FROM detalhe WHERE encomenda_id = '$id_encomenda' AND prato_id = '$id'";
                                $result4 = pg_query($connection, $query4);
                                $nao_existe = true;
                                header('location: Homepage_Cliente.php');
                            }
                        } ?>
                    </li>
                    <br>
                <?php } ?>
            </ul>
            <br>
        <?php } else {
            $name_error = "Não existem pratos para mostrar";
            echo $name_error;
        } ?>
        <?php ?>
        <br>
        <br>
    <?php
    } else {
        header('location: login.php');
    } ?>

</main>
</body>
</html>
