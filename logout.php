<?php
session_start();
//pôr a função $_SESSION['logged'] como NULL para significar o logout e é redirecionado para a página inicial
unset($_SESSION['logged']);
header("Location: Homepage_Geral.php");?>
