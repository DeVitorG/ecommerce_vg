<?php
define('SERVIDOR', 'SERVER');
define('USUARIO', 'USER');
define('SENHA', 'SENHA');
define('BANCO', 'vendas');
$conexao = mysqli_connect(SERVIDOR, USUARIO, SENHA, BANCO);
mysqli_query($conexao, "SET lc_time_names = 'pt_BR'");
mysqli_query($conexao, "SET NAMES 'utf8'");
mysqli_query($conexao, "SET character_set_connection=utf8");
mysqli_query($conexao, "SET character_set_client=utf8");
mysqli_query($conexao, "SET character_set_results=utf8");
$host = "http://".$_SERVER['HTTP_HOST'].'/php1/Operadores';
?>
