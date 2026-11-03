<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Listar_rotas.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);
$trem_id = (int) ($_POST["trem_id"] ?? 0);
$nome = trim($_POST["nome"] ?? "");
$origem = trim($_POST["origem"] ?? "");
$destino = trim($_POST["destino"] ?? "");
$partida = trim($_POST["horario_partida"] ?? "");
$duracao = (int) ($_POST["duracao_min"] ?? 0);
$distancia = str_replace(",", ".", trim($_POST["distancia_km"] ?? ""));
$mapa = $_POST["imagem_mapa"] ?? "";

$imagens = array_diff(scandir(__DIR__ . "/../assets/imag"), [".", ".."]);

$check = $conexao->prepare("SELECT 1 FROM trens WHERE id = ?");
$check->bind_param("i", $trem_id);
$check->execute();
$trem_existe = $check->get_result()->fetch_assoc();
$check->close();

$erro = "";
if ($id === 0 || !$trem_existe) {
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
}

if ($erro !== "") {
    $_SESSION["msg"] = $erro;
    $_SESSION["cor"] = "red";
    header("Location: editar_rotas.php?id=" . $id);
    exit;
}

if ($distancia === "") {
    $distancia = null;
}
if ($mapa === "") {
    $mapa = null;
}

$stmt = $conexao->prepare(
    "UPDATE rotas SET trem_id = ?, nome = ?, origem = ?, destino = ?, horario_partida = ?, duracao_min = ?, distancia_km = ?, imagem_mapa = ? WHERE id = ?"
);
$stmt->bind_param("issssidsi", $trem_id, $nome, $origem, $destino, $partida, $duracao, $distancia, $mapa, $id);
$stmt->execute();
$stmt->close();

$_SESSION["msg"] = "Rota atualizada com sucesso!";
$_SESSION["cor"] = "green";
header("Location: Listar_rotas.php");
exit;
