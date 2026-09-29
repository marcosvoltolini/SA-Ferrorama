<?php
require_once __DIR__ . "/verifica_admin.php";
require_once __DIR__ . "/../infra/conexao.php";

$erro = "";
$sucesso = "";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de clientes - Red Rush!</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <header>
        <nav class="nave">
            <div class="lg">
                <img class="logo" src="../assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
            </div>
            <div class="red">
                <h1 id="hs">Red Rush</h1>
            </div>
        </nav>
        <nav class="navs">
            <a id="lk" href="Rota_trem.php">Rota dos trens</a>
            <a id="lk" href="Horario_trem.php">Horários</a>
            <a id="lk" href="Listar_trens.php">Ver trens</a>
            <a id="lk" href="login.php">Fazer Login</a>
        </nav>
    </header>