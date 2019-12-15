<?php
session_start();
//pôr a função $_SESSION['success'] como NULL para significar o logout e é redirecionado para a página inicial
unset($_SESSION['success']);
session_destroy();
header("Location: login.php");?>
