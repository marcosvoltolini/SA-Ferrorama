<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = $conexao->prepare(
    "SELECT id, trem_id, nome, origem, destino, TIME_FORMAT(horario_partida, '%H:%i') AS partida, duracao_min, distancia_km, imagem_mapa
     FROM rotas WHERE id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$rota = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$rota) {
    $_SESSION["msg"] = "Rota não encontrada.";
    $_SESSION["cor"] = "red";
    header("Location: Listar_rotas.php");
    exit;
}

$trens = mysqli_query($conexao, "SELECT id, nome FROM trens ORDER BY nome");
$imagens = array_diff(scandir(__DIR__ . "/../assets/imag"), [".", ".."]);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Rota</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="flex">
            <div class="adn">
                <div class="adicionar">
                    <h3 class="h">Editando a rota <?= htmlspecialchars($rota["nome"]) ?>!</h3>

                    <form action="atualizar_rota.php" method="POST">
                        <input type="hidden" name="id" value="<?= $rota["id"] ?>">

                        <label for="trem_id">Trem:</label><br>
                        <select class="sec" name="trem_id" id="trem_id" required>
                            <?php while ($t = mysqli_fetch_assoc($trens)) { ?>
                                <option value="<?= $t["id"] ?>" <?= $rota["trem_id"] == $t["id"] ? "selected" : "" ?>><?= htmlspecialchars($t["nome"]) ?></option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="nome">Nome da rota:</label><br>
                        <input type="text" name="nome" id="nome" maxlength="100" value="<?= htmlspecialchars($rota["nome"]) ?>" required>
                        <br>

                        <label for="origem">Origem:</label><br>
                        <input type="text" name="origem" id="origem" maxlength="100" value="<?= htmlspecialchars($rota["origem"]) ?>" required>
                        <br>

                        <label for="destino">Destino:</label><br>
                        <input type="text" name="destino" id="destino" maxlength="100" value="<?= htmlspecialchars($rota["destino"]) ?>" required>
                        <br>

                        <label for="horario_partida">Horário de partida:</label><br>
                        <input type="time" name="horario_partida" id="horario_partida" value="<?= $rota["partida"] ?>" required>
                        <br>

                        <label for="duracao_min">Duração (minutos):</label><br>
                        <input type="number" name="duracao_min" id="duracao_min" min="1" max="10080" value="<?= $rota["duracao_min"] ?>" required>
                        <br>

                        <label for="distancia_km">Distância (km), opcional:</label><br>
                        <input type="text" name="distancia_km" id="distancia_km" value="<?= $rota["distancia_km"] ?>">
                        <br>

                        <label for="imagem_mapa">Imagem do mapa:</label><br>
                        <select class="sec" name="imagem_mapa" id="imagem_mapa">
                            <option value="">Nenhuma</option>
                            <?php foreach ($imagens as $i) { ?>
                                <option value="<?= htmlspecialchars($i) ?>" <?= $rota["imagem_mapa"] === $i ? "selected" : "" ?>><?= htmlspecialchars($i) ?></option>
                            <?php } ?>
                        </select>
                        <br><br>

                        <button type="submit">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
