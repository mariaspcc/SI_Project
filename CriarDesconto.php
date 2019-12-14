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
        <input type="submit" name="create_desconto" value="Guardar">
    </form>
    <?php

    if (isset($_POST['create_desconto'])) {
        $valor = $_POST['valor'];
        $restaurante = $_POST['restaurante'];
        $validade = $_POST['validade'];
        $numero = $_POST['numero'];
        $query = "INSERT INTO desconto (valor,duracao,num_pessoas,restaurante_nome,administrador_usergeral_username) VALUES ('$valor','$validade','$numero','$restaurante','$username')";
        $result1 = pg_query($connection, $query);
        echo "Desconto gerado com sucesso!" ?> <a href="Homepage_Administrador.php">Voltar para a página
            principal</a> <?php


        $queryIdDesconto = "SELECT id FROM desconto WHERE administrador_usergeral_username = '$username' and valor='$valor' and duracao='$validade' and num_pessoas='$numero' and restaurante_nome='$restaurante' ORDER BY id DESC ";
        $resultIdDesconto = pg_query($connection, $queryIdDesconto);

        $queryIdDescontoInfo = "SELECT desconto_id FROM desconto_info";
        $resultIdDescontoInfo = pg_query($connection, $queryIdDescontoInfo);

        $queryPessoas = "select C. usergeral_username
        from cliente AS C, encomenda as E, prato as P, detalhe AS D, restaurante AS R
        where C.usergeral_username= E.cliente_usergeral_username and E.id= D.encomenda_id and D.prato_id= P.id
        and R.nome= P.restaurante_nome and R.administrador_usergeral_username='$username' and R.nome='$restaurante'
        group by P.restaurante_nome, C.usergeral_username
        ORDER BY sum(D.quantidade*P.preco) DESC limit '$numero'";
        $resultPessoas = pg_query($connection, $queryPessoas);


        if (pg_affected_rows($resultIdDescontoInfo) < pg_affected_rows($resultIdDesconto)) {
            for ($t = 0; $t < pg_affected_rows($resultPessoas); $t++) {

                $arrpessoas = pg_fetch_array($resultPessoas);
                $reiddesconto=pg_fetch_result($resultIdDesconto,0,0);
                $inserirIdDesconto = "INSERT INTO desconto_info (usado,desconto_id,cliente_usergeral_username) VALUES (false ,'$reiddesconto','$arrpessoas[$t]')";
                $result = pg_query($connection, $inserirIdDesconto);

            }

        }


        /*for ($j = 0; $j < pg_affected_rows($resultIdDesconto); $j++) {
            $arrid = pg_fetch_array($resultIdDesconto);
            for ($i = 0; $i < pg_affected_rows($resultIdDescontoInfo); $i++) {
                $arridinfo = pg_fetch_array($resultIdDescontoInfo);
                if ($arrid[$j] <> $arridinfo[$i]) {
                    for ($t = 0; $t < pg_affected_rows($resultPessoas); $t++) {
                        $arrpessoas = pg_fetch_array($resultPessoas);
                        $usado = false;
                        $a = $arrid[$j][$i][$t];
                        $b = $arrpessoas[$j][$i][$t];
                        $inserirIdDesconto = "INSERT INTO desconto_info (usado,desconto_id,cliente_usergeral_username) VALUES ('$usado','$a','$b')";
                        $resultinserirIdDesconto = pg_query($connection, $inserirIdDesconto);

                    }
                }
            }
        }*/
    }


    /*  $queryIdDesc = "SELECT id FROM desconto WHERE valor = '$valor' and duracao = '$validade' and num_pessoas = '$numero' and min_gasto = '$minimo' and restaurante_nome = '$restaurante' and administrador_usergeral_username = '$username'";

      $resultPessoas = pg_query($connection, $queryPessoas);


      /*

      $queryInfo = "SELECT T. id, C. usergeral_username
                  FROM desconto AS T, cliente AS C, encomenda AS E, prato AS P, detalhe AS D, restaurante AS R
                  WHERE C.usergeral_username= E.cliente_usergeral_username AND E.id= D.encomenda_id AND D.prato_id= P.id
                  AND R.nome= P.restaurante_nome AND R.administrador_usergeral_username='$username' AND R.nome='$restaurante'
                  GROUP BY T.id, P.restaurante_nome, C.usergeral_username HAVING sum(D.quantidade*P.preco)>='$minimo'
                  ORDER BY sum(D.quantidade*P.preco) DESC limit '$numero'";


      $queryInfo = "SELECT id FROM desconto WHERE valor = '$valor' and duracao = '$validade' and num_pessoas = '$numero' and min_gasto = '$minimo' and restaurante_nome = '$restaurante' and administrador_usergeral_username = '$username'";
      $resultInfo = pg_query($connection, $queryInfo);

      $queryInfo = "SELECT desconto_id FROM desconto_info";
      $resultInfo = pg_query($connection, $queryInfo);

      if (pg_affected_rows($resultInfo) == 1) {

      }
  }
  /*
      $valor = $_POST['valor'];
      $restaurante = $_POST['restaurante'];
      $validade = $_POST['validade'];
      $numero = $_POST['numero'];
      $minimo = $_POST['minimo'];

      $query2 = "select P.restaurante_nome, C. usergeral_username, sum(D.quantidade*P.preco)
      from cliente AS C, encomenda as E, prato as P, detalhe AS D, restaurante AS R
      where C.usergeral_username= E.cliente_usergeral_username and E.id= D.encomenda_id and D.prato_id= P.id
      and R.nome= P.restaurante_nome and R.administrador_usergeral_username='$username' and R.nome='$restaurante'
      group by P.restaurante_nome, C.usergeral_username having sum(D.quantidade*P.preco)>='$minimo'
      ORDER BY sum(D.quantidade*P.preco) DESC limit '$numero'";
      $result2 = pg_query($connection, $query2);

      /*if($numero > pg_affected_rows($result2)){
          $numero=pg_affected_rows($result2);
      }
      for ($i = 0; $i < $numero; $i++) {

          echo pg_fetch_result($result2, $i, 0);
          echo pg_fetch_result($result2, $i, 1);
          echo pg_fetch_result($result2, $i, 2); ?> <br><?php

      // if(pg_fetch_result($result2, $i, 2)>=$minimo && $restaurante==pg_fetch_result($result2, $i, 0)){
      }

      //}*/
    }
    ?>
</main>
</body>
</html>


