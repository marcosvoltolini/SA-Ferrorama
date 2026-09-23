<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logado = isset($_SESSION["id_usuario"]);
$eh_admin = $logado && ($_SESSION["tipo_usuario"] ?? "") === "administrador";

if (!$logado) {
    header("Location: ../login.php");
    exit;
}

if (!$eh_admin) {
    http_response_code(403);
    die("Acesso negado.")
}