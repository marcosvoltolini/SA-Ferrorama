<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$logado = isset($_SESSION["id_usuario"]);

if (!$logado) {
    header("Location: login.php");
    exit;
}

$tipo = $_SESSION["tipo_usuario"] ?? "";
$perfis_permitidos = ["administrador", "funcionario"];

if (!in_array($tipo, $perfis_permitidos, true)) {
    http_response_code(403);
    die("PAH! acesso negado.");
}