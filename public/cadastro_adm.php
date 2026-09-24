<?php
require_once __DIR__ . "/verifica_admin.php";
require_once __DIR__ . "/../infra/conexao.php";
 
$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome_usuario"] ??  "");
    $email = trim($_POST["email_usuario"] ?? "");
    $senha = $_POST["senha_usuario"] ?? "";
    $senha_confirmada = $_POST["senha_confirmada"] ?? "";   
    $tipo_enviado = $_POST ["tipo_usuario"] ?? "comum";
    $tipo = in_array($tipo_enviado, ["comum", "administrador"], true) ? $tipo_enviado : "comum";
} 

if ($nome === "" || $email ===  "" || $senha === "") {
    $erro = "Preencher todos os campos.";
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = "Digite email valido.";

}elseif (strlen($senha !== "senha_confirmada")) {
    $erro = "As senhas estão diferentes.";
} else {
    $stmt = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email_usuario = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
}