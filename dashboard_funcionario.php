<?php
session_start();

$eh_funcionario = ($_SESSION["tipo_usuario"] ?? "") === "funcionario";

if (!$eh_funcionario) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . "/infra/conexao.php";

$id = $_SESSION["id_usuario"];

$stmt = $conexao->prepare("SELECT id, nome, tipo FROM trens WHERE maquinista_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$trem = $stmt->get_result()->fetch_assoc();

$rotas = [];
if ($trem) {
    $stmt = $conexao->prepare(
        "SELECT nome,
                TIME_FORMAT(horario_partida, '%H:%i') AS partida,
                TIME_FORMAT(SEC_TO_TIME((TIME_TO_SEC(horario_partida) + duracao_min * 60) % 86400), '%H:%i') AS chegada
         FROM rotas WHERE trem_id = ? ORDER BY horario_partida"
    );
    $stmt->bind_param("i", $trem["id"]);
    $stmt->execute();
    $rotas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Rush! - Funcionario</title>
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
            <a id="lk" href="public/Listar_clientes.php">Clientes</a>
            <a id="lk" href="public/logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <div class="bem">
            <img class="trem" src="assets/imag/trem.png" alt="trem">
            <h1 id="bvd">Bem Vindo!</h1>
        </div>

        <div class="adn">
            <h3>Seu trem</h3>
            <?php if (!$trem) { ?>
                <p>Você ainda não foi associado a nenhum trem como maquinista.</p>
            <?php } else { ?>
                <p><?= htmlspecialchars($trem["nome"]) ?> (<?= htmlspecialchars($trem["tipo"]) ?>)</p>
                <?php foreach ($rotas as $r) { ?>
                    <p><?= htmlspecialchars($r["nome"]) ?>: <?= $r["partida"] ?> - <?= $r["chegada"] ?></p>
                <?php } ?>
            <?php } ?>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
