<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_login.php";

$sql = "SELECT trens.nome AS trem, trens.imagem, rotas.origem, rotas.destino,
               TIME_FORMAT(rotas.horario_partida, '%H:%i') AS partida,
               TIME_FORMAT(SEC_TO_TIME((TIME_TO_SEC(rotas.horario_partida) + rotas.duracao_min * 60) % 86400), '%H:%i') AS chegada
        FROM rotas
        JOIN trens ON trens.id = rotas.trem_id
        ORDER BY rotas.horario_partida, trens.nome";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horários</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="adn">
            <h2>Horários dos Trens</h2>
        </div>

        <?php if (mysqli_num_rows($resultado) == 0) { ?>
            <div class="adn">
                <p>Nenhuma rota cadastrada ainda.</p>
            </div>
        <?php } else { ?>
            <div class="bensgrand" style="flex-wrap: wrap">
                <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
                    <div class="visu">
                        <img src="../assets/imag/<?= rawurlencode($linha["imagem"] ?: "trem.png") ?>" alt="<?= htmlspecialchars($linha["trem"]) ?>" width="200">
                        <h1 class="fanfas"><?= htmlspecialchars($linha["trem"]) ?></h1>
                        <h4>Horário: <?= $linha["partida"] ?> - <?= $linha["chegada"] ?></h4>
                        <h4>Rota: <?= htmlspecialchars($linha["origem"]) ?> - <?= htmlspecialchars($linha["destino"]) ?></h4>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </main>

    <footer>

    </footer>
</body>

</html>
