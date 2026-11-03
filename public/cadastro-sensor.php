<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$tipos = ["localização", "Velocidade", "Energia"];
$trens = mysqli_query($conexao, "SELECT id, nome FROM trens ORDER BY nome");

$nome = "";
$tipo = "";
$trem_id = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $tipo = $_POST["tipo"] ?? "";
    $trem_id = (int) ($_POST["trem_id"] ?? 0);

    $check = $conexao->prepare("SELECT 1 FROM trens WHERE id = ?");
    $check->bind_param("i", $trem_id);
    $check->execute();
    $trem_existe = $check->get_result()->fetch_assoc();
    $check->close();

    if ($nome === "") {
        $erro = "Informe o nome do sensor.";
    } elseif (mb_strlen($nome) > 100) {
        $erro = "O nome deve ter no máximo 100 caracteres.";
    } elseif (!in_array($tipo, $tipos, true)) {
        $erro = "Selecione um tipo de sensor válido.";
    } elseif (!$trem_existe) {
        $erro = "Selecione o trem onde o sensor está instalado.";
    } else {
        $stmt = $conexao->prepare("INSERT INTO sensores (nome, tipo, trem_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nome, $tipo, $trem_id);
        $stmt->execute();
        $stmt->close();

        $_SESSION["msg"] = "Sensor cadastrado com sucesso!";
        $_SESSION["cor"] = "green";
        header("Location: Listar_sensor.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Sensores</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="flex">
            <div class="adn">
                <div class="adicionar">
                    <h3 class="h">Cadastro de Sensores</h3>

                    <?php if ($erro) { ?>
                        <p style="color: red"><?= htmlspecialchars($erro) ?></p>
                    <?php } ?>

                    <?php if (mysqli_num_rows($trens) == 0) { ?>
                        <p style="color: red">Todo sensor pertence a um trem. <a href="cadastro_trem.php">Cadastre um trem</a> primeiro.</p>
                    <?php } ?>

                    <form method="POST" action="">
                        <label for="nome">Nome do sensor:</label><br>
                        <input type="text" name="nome" id="nome" maxlength="100" value="<?= htmlspecialchars($nome) ?>" required>
                        <br>

                        <label for="tipo">Tipo:</label><br>
                        <select class="sec" name="tipo" id="tipo" required>
                            <option value="">Selecione</option>
                            <?php foreach ($tipos as $t) { ?>
                                <option value="<?= $t ?>" <?= $tipo === $t ? "selected" : "" ?>><?= ucfirst($t) ?></option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="trem_id">Trem:</label><br>
                        <select class="sec" name="trem_id" id="trem_id" required>
                            <option value="">Selecione o trem</option>
                            <?php while ($t = mysqli_fetch_assoc($trens)) { ?>
                                <option value="<?= $t["id"] ?>" <?= $trem_id == $t["id"] ? "selected" : "" ?>><?= htmlspecialchars($t["nome"]) ?></option>
                            <?php } ?>
                        </select>
                        <br><br>

                        <button type="submit">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
