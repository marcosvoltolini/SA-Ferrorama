<?php
require_once __DIR__ . "/verifica_admin.php";
require_once __DIR__ . "/../infra/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Listar_clientes.php");
    exit;
}

$id = (int) ($_POST["id_usuario"] ?? 0);
$nome = trim($_POST["nome_usuario"] ?? "");
$email = trim($_POST["email_usuario"] ?? "");
$senha = $_POST["senha_usuario"] ?? "";

if ($id === 0 || $nome === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Dados inválidos. <a href='Listar_clientes.php'>Voltar</a>");
}


$check = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email_usuario = ? AND id_usuario <> ?");
$check->bind_param("si", $email, $id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    die("Este e-mail já está em uso por outro usuário. <a href='Listar_clientes.php'>Voltar</a>");
}
$check->close();

if ($senha !== "") {

    $hash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conexao->prepare(
        "UPDATE usuarios SET nome_usuario = ?, email_usuario = ?, senha_usuario = ? WHERE id_usuario = ?"
    );
    $stmt->bind_param("sssi", $nome, $email, $hash, $id);
} else {

    $stmt = $conexao->prepare(
        "UPDATE usuarios SET nome_usuario = ?, email_usuario = ? WHERE id_usuario = ?"
    );
    $stmt->bind_param("ssi", $nome, $email, $id);
}

$stmt->execute();
$stmt->close();

header("Location: Listar_clientes.php");
exit;