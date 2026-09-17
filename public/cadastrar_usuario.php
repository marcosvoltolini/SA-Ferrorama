<?php
require_once __DIR__ . "/../infra/conexao.php";
 
$erro = "";
$sucesso = "";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    $nome  = trim($_POST["nome_usuario"] ?? "");
    $email = trim($_POST["email_usuario"] ?? "");
    $senha = $_POST["senha_usuario"] ?? "";
    $senha_confirma = $_POST["senha_confirma"] ?? "";
 
    if ($nome === "" || $email === "" || $senha === "") {
        $erro = "Preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Digite um e-mail válido.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } elseif ($senha !== $senha_confirma) {
        $erro = "As senhas não conferem.";
    } else {

        $stmt = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email_usuario = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            $erro = "Este e-mail já está cadastrado.";
        } else {
    
            $hash = password_hash($senha, PASSWORD_DEFAULT);

            $insert = $conexao->prepare(
                "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario) VALUES (?, ?, ?)"
            );
            $insert->bind_param("sss", $nome, $email, $hash);
 
            if ($insert->execute()) {
                $sucesso = "Cadastro realizado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar: " . $conexao->error;
            }
            $insert->close();
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-cadastro">
        <h2 id="log-cadastro">Criar Conta</h2>
 
        <?php if ($erro): ?>
            <div class="erro-cadastro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
 
        <?php if ($sucesso): ?>
            <div class="sucesso-cadastro"><?= htmlspecialchars($sucesso) ?></div>
        <?php endif; ?>
 
        <form class="formss-cadastro" method="POST" action="">
            <label for="nome_usuario">Nome</label>
            <input type="text" id="nome_usuario" name="nome_usuario" value="<?= htmlspecialchars($_POST['nome_usuario'] ?? '') ?>" required>
            <br>
            <label for="email_usuario">E-mail</label>
            <input type="email" id="email_usuario" name="email_usuario" value="<?= htmlspecialchars($_POST['email_usuario'] ?? '') ?>" required>
            <br>
            <label for="senha_usuario">Senha</label>
            <input type="password" id="senha_usuario" name="senha_usuario" required>
            <br>
            <label for="senha_confirma">Confirmar senha</label>
            <input type="password" id="senha_confirma" name="senha_confirma" required>
            <br>
            <button id="bot-cadastro" type="submit">Cadastrar</button>
        </form>
    </div>
    <a href="../index.php">Voltar para o inicio.</a>
</body>
</html>
