<?php
$host = "localhost";

$usuario = "root";

$senha = "root";

$banco = "SA_Ferrorama";                

$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro na conexão com o banco: " . $conexao->connect_error);
};

$conexao->set_charset("utf8mb4");