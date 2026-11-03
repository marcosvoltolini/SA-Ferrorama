<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_admin.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Listar_trens.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);

$stmt = $conexao->prepare(
    "SELECT (SELECT COUNT(*) FROM rotas WHERE trem_id = ?) + (SELECT COUNT(*) FROM sensores WHERE trem_id = ?) AS total"
);
$stmt->bind_param("ii", $id, $id);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()["total"];
$stmt->close();

if ($total > 0) {
    $_SESSION["msg"] = "Não é possível excluir: o trem ainda tem rotas ou sensores.";
    $_SESSION["cor"] = "red";
} else {
    $stmt = $conexao->prepare("DELETE FROM trens WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION["msg"] = "Trem excluído.";
        $_SESSION["cor"] = "green";
    } else {
        $_SESSION["msg"] = "Trem não encontrado.";
        $_SESSION["cor"] = "red";
    }
    $stmt->close();
}

header("Location: Listar_trens.php");
exit;
