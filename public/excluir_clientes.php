<?php

session_start();

require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_admin.php";


if (!isset($_GET["id_usuario"]) || !is_numeric($_GET["id_usuario"])) {
    die("Erro: usuário não encontrado.");
}

$id = $_GET["id"];

$sql = "DELETE FROM usuarios WHERE id_usuario = ?";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Erro ao preparar a exclusão do usuário.");
}


if (!mysqli_stmt_bind_param($stmt, "i", $id_usuario)) {
    mysqli_stmt_close($stmt);
    die("Erro ao preparar os dados para exclusão.");
}

if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    die("Erro ao excluir o usuário. Tente novamente.");
}

if (mysqli_stmt_affected_rows($stmt) == 0) {
    mysqli_stmt_close($stmt);
    die("Nenhum usuário foi encontrado para exclusão.");
}

mysqli_stmt_close($stmt);

header("Location: Listar_clientes.php");
exit;

?>