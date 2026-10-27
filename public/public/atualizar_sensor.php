<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Listar_sensor.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);
$nome = trim($_POST["nome"] ?? "");
$tipo = $_POST["tipo"] ?? "";
$trem_id = (int) ($_POST["trem_id"] ?? 0);

$tipos = ["localização", "Velocidade", "Energia"];

$check = $conexao->prepare("SELECT 1 FROM trens WHERE id = ?");
$check->bind_param("i", $trem_id);
$check->execute();
$trem_existe = $check->get_result()->fetch_assoc();
$check->close();

$erro = "";
if ($id === 0 || $nome === "") {
    $erro = "Informe o nome do sensor.";
} elseif (mb_strlen($nome) > 100) {
    $erro = "O nome deve ter no máximo 100 caracteres.";
} elseif (!in_array($tipo, $tipos, true)) {
    $erro = "Selecione um tipo de sensor válido.";
} elseif (!$trem_existe) {
    $erro = "Selecione o trem onde o sensor está instalado.";
}

if ($erro !== "") {
    $_SESSION["msg"] = $erro;
    $_SESSION["cor"] = "red";
    header("Location: editar_sensor.php?id=" . $id);
    exit;
}

$stmt = $conexao->prepare("UPDATE sensores SET nome = ?, tipo = ?, trem_id = ? WHERE id = ?");
$stmt->bind_param("ssii", $nome, $tipo, $trem_id, $id);
$stmt->execute();
$stmt->close();

$_SESSION["msg"] = "Sensor atualizado com sucesso!";
$_SESSION["cor"] = "green";
header("Location: Listar_sensor.php");
exit;
