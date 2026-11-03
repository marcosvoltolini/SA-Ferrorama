<?php
require_once __DIR__ . "/verifica_admin.php";
require_once __DIR__ . "/../infra/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Listar_clientes.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);

if ($id == $_SESSION["id_usuario"]) {
    $_SESSION["msg"] = "Você não pode excluir a sua própria conta.";
    $_SESSION["cor"] = "red";
} else {
    $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION["msg"] = "Usuário excluído.";
        $_SESSION["cor"] = "green";
    } else {
        $_SESSION["msg"] = "Usuário não encontrado.";
        $_SESSION["cor"] = "red";
    }
    $stmt->close();
}

header("Location: Listar_clientes.php");
exit;
