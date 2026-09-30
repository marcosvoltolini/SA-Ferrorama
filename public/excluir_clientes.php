<?php
session_start();

require_once __DIR__ . "/../infra/conexao.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Erro: usuário não encontrado.");
}

$id = $_GET["id"];

$sql = "DELETE FROM usuarios WHERE id_usuario = ?";

$stmt = mysqli_prepare($conexao, $sql);

if (!$stmt) {
    die("Erro ao preparar a exclusão no banco: " . mysqli_error($conexao));
}

mysqli_stmt_bind_param($stmt, "i", $id);

if (!mysqli_stmt_execute($stmt)) {
    $erro = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    die("Erro ao executar exclusão: " . $erro);
}

if (mysqli_stmt_affected_rows($stmt) == 0) {
    mysqli_stmt_close($stmt);
    die("Nenhum usuário com o ID $id foi encontrado no banco.");
}

mysqli_stmt_close($stmt);

header("Location: listar_clientes.php");
exit;
?>