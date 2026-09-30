<?php
require_once __DIR__ . "/verifica_admin.php";
require_once __DIR__ . "/../infra/conexao.php";

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome_usuario"] ?? "");
    $email = trim($_POST["email_usuario"] ?? "");
    $senha = $_POST["senha_usuario"] ?? "";
    $senha_confirma = $_POST["senha_confirma"] ?? "";
    $tipo_enviado = $_POST["tipo_usuario"] ?? "comum";
    $tipo = in_array($tipo_enviado, ["comum", "administrador"], true) ? $tipo_enviado : "comum";

    if ($nome === "" || $email === "" || $senha === "") {
        $erro = "Preencher todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Digite email valido.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } elseif ($senha !== $senha_confirma) {
        $erro = "As senhas estão diferentes.";
    } else {
        $stmt = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email_usuario = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $erro = "Este email já está cadastrado.";
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $insert = $conexao->prepare(
                "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, tipo_usuario) VALUES (?,?,?,?)"
            );
            $insert->bind_param("ssss", $nome, $email, $hash, $tipo);

            if ($insert->execute()) {
                $sucesso = "Usuário cadastrado com sucesso como: " . htmlspecialchars($tipo) . ".";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Administrador - Red Rush!</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <header>
        <nav class="nave">
            <div class="lg">
                <img class="logo" src="../assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
            </div>
            <div class="red">
                <h1 id="hs">Red Rush</h1>
            </div>
        </nav>
        <nav class="navs">
            <a id="lk" href="Rota_trem.php">Rota dos trens</a>
            <a id="lk" href="Horario_trem.php">Horários</a>
            <a id="lk" href="Listar_trens.php">Ver trens</a>
            <a id="lk" href="login.php">Fazer Login</a>
        </nav>
    </header>

    <main>
        <div class="container-cadastro">
            <h2 id="log-cadastro">Cadastrar Usuário (Admin)</h2>

            <?php if ($erro): ?>
                <div class="erro-cadastro"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <?php if ($sucesso): ?>
                <div class="sucesso-cadastro"><?= htmlspecialchars($sucesso) ?></div>
            <?php endif; ?>

            <form class="formss-cadastro" method="POST" action="">
                <label for="nome_usuario">Nome</label>
                <input type="text" id="nome_usuario" name="nome_usuario" value="<?= htmlspecialchars($_POST['nome_usuario'] ?? '') ?>" required>

                <label for="email_usuario">E-mail</label>
                <input type="email" id="email_usuario" name="email_usuario" value="<?= htmlspecialchars($_POST['email_usuario'] ?? '') ?>" required>

                <label for="senha_usuario">Senha</label>
                <input type="password" id="senha_usuario" name="senha_usuario" required>

                <label for="senha_confirma">Confirmar senha</label>
                <input type="password" id="senha_confirma" name="senha_confirma" required>

                <label for="tipo_usuario">Perfil</label>
                <select id="tipo_usuario" name="tipo_usuario">
                    <option value="comum">Usuário comum</option>
                    <option value="administrador">Administrador</option>
                </select>

                <button id="bot-cadastro" type="submit">Cadastrar</button>
            </form>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>