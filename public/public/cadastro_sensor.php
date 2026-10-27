<?php
$raiz = "../";
require_once __DIR__ . "/../infra/auth.php";
exigir_perfil(["administrador", "funcionario"]);

$tipos = ["localização", "Velocidade", "Energia"];
$id = (int) ($_GET["id"] ?? 0);
$sensor = ["nome" => "", "tipo" => "", "trem_id" => ""];

if ($id > 0) {
    $stmt = $conexao->prepare("SELECT nome, tipo, trem_id FROM sensores WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $sensor = $stmt->get_result()->fetch_assoc();
    if (!$sensor) {
        flash("erro", "Sensor não encontrado.");
        redirecionar("Listar_sensor.php");
    }
}

$trens = todos_os_trens($conexao);
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    csrf_validar();

    $nome = trim($_POST["nome"] ?? "");
    $tipo = $_POST["tipo"] ?? "";
    $trem_id = (int) ($_POST["trem_id"] ?? 0);
    $sensor = ["nome" => $nome, "tipo" => $tipo, "trem_id" => $trem_id];

    if ($nome === "") {
        $erro = "Informe o nome do sensor.";
    } elseif (mb_strlen($nome) > 100) {
        $erro = "O nome deve ter no máximo 100 caracteres.";
    } elseif (!in_array($tipo, $tipos, true)) {
        $erro = "Selecione um tipo de sensor válido.";
    } elseif (!in_array($trem_id, array_map("intval", array_column($trens, "id")), true)) {
        $erro = "Selecione o trem onde o sensor está instalado.";
    } else {
        try {
            if ($id > 0) {
                $stmt = $conexao->prepare("UPDATE sensores SET nome = ?, tipo = ?, trem_id = ? WHERE id = ?");
                $stmt->bind_param("ssii", $nome, $tipo, $trem_id, $id);
            } else {
                $stmt = $conexao->prepare("INSERT INTO sensores (nome, tipo, trem_id) VALUES (?, ?, ?)");
                $stmt->bind_param("ssi", $nome, $tipo, $trem_id);
            }
            $stmt->execute();

            flash("ok", $id > 0 ? "Sensor atualizado com sucesso!" : "Sensor cadastrado com sucesso!");
            redirecionar("Listar_sensor.php");
        } catch (mysqli_sql_exception $e) {
            $erro = "Não foi possível salvar o sensor.";
        }
    }
}

$titulo = $id > 0 ? "Editar sensor" : "Cadastrar sensor";
require __DIR__ . "/../includes/topo.php";
?>
<h2><?= h($titulo) ?></h2>

<?php if (!$trens) { ?>
    <p style="color: red">Todo sensor pertence a um trem. <a href="cadastro_trem.php">Cadastre um trem</a> primeiro.</p>
<?php } ?>
<?php if ($erro) { ?>
    <p style="color: red"><?= h($erro) ?></p>
<?php } ?>

<form class="formss" style="display: inline-block; text-align: left" method="POST" action="">
    <?= csrf_campo() ?>

    <label for="nome">Nome do sensor:</label><br>
    <input type="text" name="nome" id="nome" maxlength="100" value="<?= h($sensor["nome"]) ?>" required>
    <br><br>

    <label for="tipo">Tipo:</label><br>
    <select class="sec" name="tipo" id="tipo" required>
        <option value="">Selecione</option>
        <?php foreach ($tipos as $t) { ?>
            <option value="<?= h($t) ?>" <?= $sensor["tipo"] === $t ? "selected" : "" ?>><?= h(ucfirst($t)) ?></option>
        <?php } ?>
    </select>
    <br><br>

    <label for="trem_id">Trem:</label><br>
    <select class="sec" name="trem_id" id="trem_id" required>
        <option value="">Selecione</option>
        <?php foreach ($trens as $t) { ?>
            <option value="<?= $t["id"] ?>" <?= (string) $sensor["trem_id"] === (string) $t["id"] ? "selected" : "" ?>><?= h($t["nome"]) ?></option>
        <?php } ?>
    </select>
    <br><br>

    <button class="botao" type="submit" <?= $trens ? "" : "disabled" ?>>Salvar</button>
    <a href="Listar_sensor.php">Cancelar</a>
</form>
<?php require __DIR__ . "/../includes/rodape.php"; ?>
