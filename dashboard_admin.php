<?php
session_start();

$eh_admin = ($_SESSION["tipo_usuario"] ?? "") === "administrador";

if (!$eh_admin) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . "/infra/conexao.php";

$trens = $conexao->query("SELECT COUNT(*) FROM trens")->fetch_row()[0];
$rotas = $conexao->query("SELECT COUNT(*) FROM rotas")->fetch_row()[0];
$sensores = $conexao->query("SELECT COUNT(*) FROM sensores")->fetch_row()[0];
$usuarios = $conexao->query("SELECT COUNT(*) FROM usuarios")->fetch_row()[0];
$sem_maquinista = $conexao->query("SELECT COUNT(*) FROM trens WHERE maquinista_id IS NULL")->fetch_row()[0];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Rush! - Admin</title>
    <link rel="stylesheet" href="assets/imag/style/style.css">
</head>

<body>
    <header>
        <nav class="nave">
            <div class="lg">
                <img class="logo" src="assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
            </div>
            <div class="red">
                <h1 id="hs">Red Rush</h1>
            </div>
        </nav>
        <nav class="navs">
            <a id="lk" href="public/Listar_trens.php">Trens</a>
            <a id="lk" href="public/Listar_rotas.php">Rotas</a>
            <a id="lk" href="public/Horario_trem.php">Horários</a>
            <a id="lk" href="public/Listar_sensor.php">Sensores</a>
            <a id="lk" href="public/Listar_clientes.php">Usuários</a>
            <a id="lk" href="public/logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <div class="bem">
            <img class="trem" src="assets/imag/trem.png" alt="trem">
            <h1 id="bvd">Bem Vindo!</h1>
        </div>

        <div class="adn">
            <h3>Resumo</h3>
            <p>Trens: <?= $trens ?> | Rotas: <?= $rotas ?> | Sensores: <?= $sensores ?> | Usuários: <?= $usuarios ?></p>
            <p>Trens sem maquinista: <?= $sem_maquinista ?></p>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
