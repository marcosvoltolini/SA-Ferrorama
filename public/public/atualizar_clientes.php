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
$tipo = $_POST["tipo_usuario"] ?? "";
$senha = $_POST["senha_usuario"] ?? "";

$perfis = ["comum", "funcionario", "administrador"];
$erro = "";

$stmt = $conexao->prepare("SELECT tipo_usuario FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$antigo = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$antigo || $nome === "") {
    $erro = "Dados inválidos.";
} elseif (mb_strlen($nome) > 100 || mb_strlen($email) > 100) {
    $erro = "Nome e email devem ter no máximo 100 caracteres.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = "Digite um e-mail válido.";
} elseif (!in_array($tipo, $perfis, true)) {
    $erro = "Perfil inválido.";
} elseif ($senha !== "" && strlen($senha) < 6) {
    $erro = "A nova senha deve ter pelo menos 6 caracteres.";
} elseif ($id == $_SESSION["id_usuario"] && $tipo !== "administrador") {
    $erro = "Você não pode remover o seu próprio perfil de administrador.";
} else {
    $check = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email_usuario = ? AND id_usuario <> ?");
    $check->bind_param("si", $email, $id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $erro = "Este e-mail já está em uso por outro usuário.";
    }
    $check->close();
}

if ($erro !== "") {
    $_SESSION["msg"] = $erro;
    $_SESSION["cor"] = "red";
    header("Location: editar_clientes.php?id=" . $id);
    exit;
}

if ($senha !== "") {
    $hash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conexao->prepare(
        "UPDATE usuarios SET nome_usuario = ?, email_usuario = ?, tipo_usuario = ?, senha_usuario = ? WHERE id_usuario = ?"
    );
    $stmt->bind_param("ssssi", $nome, $email, $tipo, $hash, $id);
} else {
    $stmt = $conexao->prepare(
        "UPDATE usuarios SET nome_usuario = ?, email_usuario = ?, tipo_usuario = ? WHERE id_usuario = ?"
    );
    $stmt->bind_param("sssi", $nome, $email, $tipo, $id);
}
$stmt->execute();
$stmt->close();

if ($antigo["tipo_usuario"] === "funcionario" && $tipo !== "funcionario") {
    $stmt = $conexao->prepare("UPDATE trens SET maquinista_id = NULL WHERE maquinista_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$_SESSION["msg"] = "Usuário atualizado com sucesso!";
$_SESSION["cor"] = "green";
header("Location: Listar_clientes.php");
exit;
