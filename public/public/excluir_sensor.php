<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_admin.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Listar_sensor.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);

$stmt = $conexao->prepare("DELETE FROM sensores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION["msg"] = "Sensor excluído.";
    $_SESSION["cor"] = "green";
} else {
    $_SESSION["msg"] = "Sensor não encontrado.";
    $_SESSION["cor"] = "red";
}
$stmt->close();

header("Location: Listar_sensor.php");
exit;
