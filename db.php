<?php 

$host = "localhost";
$dbname = "moviestar";
$pass = "";
$user = "bea";

$conn = new PDO ("mysql:host=$host;dbname=$dbname", $user, $pass);

/* habilitando erros PDO (se der algum erro na conexão vai exibir um erro
na tela) */
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);