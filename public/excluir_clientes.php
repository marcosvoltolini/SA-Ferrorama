<?php
require_once __DIR__ . "/../infra/conexao.php";

if (isset($_GET["id_usuario"])) {
    $id_usuario = $_GET["id_usuario"];

    $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conexao, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: ../Listar_clientes.php");
exit();
