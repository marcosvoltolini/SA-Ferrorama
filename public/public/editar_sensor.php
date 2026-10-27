<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = $conexao->prepare("SELECT id, nome, tipo, trem_id FROM sensores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$sensor = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$sensor) {
    $_SESSION["msg"] = "Sensor não encontrado.";
    $_SESSION["cor"] = "red";
    header("Location: Listar_sensor.php");
    exit;
}

$tipos = ["localização", "Velocidade", "Energia"];
$trens = mysqli_query($conexao, "SELECT id, nome FROM trens ORDER BY nome");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Sensor</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="flex">
            <div class="adn">
                <div class="adicionar">
                    <h3 class="h">Editando o sensor <?= htmlspecialchars($sensor["nome"]) ?>!</h3>

                    <form action="atualizar_sensor.php" method="POST">
                        <input type="hidden" name="id" value="<?= $sensor["id"] ?>">

                        <label for="nome">Nome do sensor:</label><br>
                        <input type="text" name="nome" id="nome" maxlength="100" value="<?= htmlspecialchars($sensor["nome"]) ?>" required>
                        <br>

                        <label for="tipo">Tipo:</label><br>
                        <select class="sec" name="tipo" id="tipo" required>
                            <?php foreach ($tipos as $t) { ?>
                                <option value="<?= $t ?>" <?= $sensor["tipo"] === $t ? "selected" : "" ?>><?= ucfirst($t) ?></option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="trem_id">Trem:</label><br>
                        <select class="sec" name="trem_id" id="trem_id" required>
                            <?php while ($t = mysqli_fetch_assoc($trens)) { ?>
                                <option value="<?= $t["id"] ?>" <?= $sensor["trem_id"] == $t["id"] ? "selected" : "" ?>><?= htmlspecialchars($t["nome"]) ?></option>
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
