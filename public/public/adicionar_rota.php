<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$trens = mysqli_query($conexao, "SELECT id, nome FROM trens ORDER BY nome");
$imagens = array_diff(scandir(__DIR__ . "/../assets/imag"), [".", ".."]);

$trem_id = "";
$nome = "";
$origem = "";
$destino = "";
$partida = "";
$duracao = "";
$distancia = "";
$mapa = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $trem_id = (int) ($_POST["trem_id"] ?? 0);
    $nome = trim($_POST["nome"] ?? "");
    $origem = trim($_POST["origem"] ?? "");
    $destino = trim($_POST["destino"] ?? "");
    $partida = trim($_POST["horario_partida"] ?? "");
    $duracao = (int) ($_POST["duracao_min"] ?? 0);
    $distancia = str_replace(",", ".", trim($_POST["distancia_km"] ?? ""));
    $mapa = $_POST["imagem_mapa"] ?? "";

    $check = $conexao->prepare("SELECT 1 FROM trens WHERE id = ?");
    $check->bind_param("i", $trem_id);
    $check->execute();
    $trem_existe = $check->get_result()->fetch_assoc();
    $check->close();

    if (!$trem_existe) {
        $erro = "Selecione um trem válido.";
    } elseif ($nome === "" || $origem === "" || $destino === "") {
        $erro = "Preencha nome, origem e destino.";
    } elseif (mb_strlen($nome) > 100 || mb_strlen($origem) > 100 || mb_strlen($destino) > 100) {
        $erro = "Nome, origem e destino devem ter no máximo 100 caracteres.";
    } elseif (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $partida)) {
        $erro = "Informe um horário de partida válido.";
    } elseif ($duracao < 1 || $duracao > 10080) {
        $erro = "Informe a duração em minutos (entre 1 e 10080).";
    } elseif ($distancia !== "" && (!is_numeric($distancia) || $distancia < 0)) {
        $erro = "Distância inválida.";
    } elseif ($mapa !== "" && !in_array($mapa, $imagens, true)) {
        $erro = "Imagem inválida.";
    } else {
        if ($distancia === "") {
            $distancia = null;
        }
        if ($mapa === "") {
            $mapa = null;
        }

        $stmt = $conexao->prepare(
            "INSERT INTO rotas (trem_id, nome, origem, destino, horario_partida, duracao_min, distancia_km, imagem_mapa) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("issssids", $trem_id, $nome, $origem, $destino, $partida, $duracao, $distancia, $mapa);
        $stmt->execute();
        $stmt->close();

        $_SESSION["msg"] = "Rota cadastrada com sucesso!";
        $_SESSION["cor"] = "green";
        header("Location: Listar_rotas.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Rota</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="flex">
            <div class="adn">
                <div class="adicionar">
                    <h3 class="h">Adicionar rota para os trens</h3>

                    <?php if ($erro) { ?>
                        <p style="color: red"><?= htmlspecialchars($erro) ?></p>
                    <?php } ?>

                    <?php if (mysqli_num_rows($trens) == 0) { ?>
                        <p style="color: red">Antes de cadastrar uma rota é preciso ter um trem. <a href="cadastro_trem.php">Cadastrar trem</a></p>
                    <?php } ?>

                    <form method="POST" action="">
                        <label for="trem_id">Trem:</label><br>
                        <select class="sec" name="trem_id" id="trem_id" required>
                            <option value="">Selecione o trem</option>
                            <?php while ($t = mysqli_fetch_assoc($trens)) { ?>
                                <option value="<?= $t["id"] ?>" <?= $trem_id == $t["id"] ? "selected" : "" ?>><?= htmlspecialchars($t["nome"]) ?></option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="nome">Nome da rota:</label><br>
                        <input type="text" name="nome" id="nome" maxlength="100" value="<?= htmlspecialchars($nome) ?>" required>
                        <br>

                        <label for="origem">Origem:</label><br>
                        <input type="text" name="origem" id="origem" maxlength="100" value="<?= htmlspecialchars($origem) ?>" required>
                        <br>

                        <label for="destino">Destino:</label><br>
                        <input type="text" name="destino" id="destino" maxlength="100" value="<?= htmlspecialchars($destino) ?>" required>
                        <br>

                        <label for="horario_partida">Horário de partida:</label><br>
                        <input type="time" name="horario_partida" id="horario_partida" value="<?= htmlspecialchars($partida) ?>" required>
                        <br>

                        <label for="duracao_min">Duração (minutos):</label><br>
                        <input type="number" name="duracao_min" id="duracao_min" min="1" max="10080" value="<?= $duracao ?>" required>
                        <br>

                        <label for="distancia_km">Distância (km), opcional:</label><br>
                        <input type="text" name="distancia_km" id="distancia_km" value="<?= htmlspecialchars($distancia) ?>">
                        <br>

                        <label for="imagem_mapa">Imagem do mapa:</label><br>
                        <select class="sec" name="imagem_mapa" id="imagem_mapa">
                            <option value="">Nenhuma</option>
                            <?php foreach ($imagens as $i) { ?>
                                <option value="<?= htmlspecialchars($i) ?>" <?= $mapa === $i ? "selected" : "" ?>><?= htmlspecialchars($i) ?></option>
                            <?php } ?>
                        </select>
                        <br><br>

                        <button type="submit">Salvar rota</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
