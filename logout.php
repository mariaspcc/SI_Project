<?php
//pôr a função $_SESSION['logged'] como NULL para significar o logout e é redirecionado para a página inicial
unset($_SESSION['success']);
header("Location: login.php");?>
