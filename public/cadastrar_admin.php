<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_admin.php";

$perfis = ["comum" => "Cliente", "funcionario" => "Funcionário", "administrador" => "Administrador"];

$erro = "";
$nome = "";
$email = "";
$tipo = "comum";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome_usuario"] ?? "");
    $email = trim($_POST["email_usuario"] ?? "");
    $senha = $_POST["senha_usuario"] ?? "";
    $senha_confirma = $_POST["senha_confirma"] ?? "";
    $tipo = $_POST["tipo_usuario"] ?? "comum";

    if ($nome === "" || $email === "" || $senha === "") {
        $erro = "Preencher todos os campos.";
    } elseif (mb_strlen($nome) > 100 || mb_strlen($email) > 100) {
        $erro = "Nome e email devem ter no máximo 100 caracteres.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Digite email valido.";
    } elseif (!array_key_exists($tipo, $perfis)) {
        $erro = "Perfil inválido.";
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
                "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, tipo_usuario) VALUES (?, ?, ?, ?)"
            );
            $insert->bind_param("ssss", $nome, $email, $hash, $tipo);
            $insert->execute();
            $insert->close();

            $_SESSION["msg"] = "Usuário cadastrado com sucesso!";
            $_SESSION["cor"] = "green";
            header("Location: Listar_clientes.php");
            exit;
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
    <title>Cadastro de Usuário - Red Rush!</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="flex">
            <div class="adn">
                <div class="adicionar">
                    <h3 class="h">Cadastrar usuário</h3>

                    <?php if ($erro) { ?>
                        <p style="color: red"><?= htmlspecialchars($erro) ?></p>
                    <?php } ?>

                    <form method="POST" action="">
                        <label for="nome">Nome:</label><br>
                        <input type="text" id="nome" name="nome_usuario" maxlength="100" value="<?= htmlspecialchars($nome) ?>" required>
                        <br>

                        <label for="email_usuario">E-mail:</label><br>
                        <input type="email" id="email_usuario" name="email_usuario" maxlength="100" value="<?= htmlspecialchars($email) ?>" required>
                        <br>

                        <label for="senha_usuario">Senha:</label><br>
                        <input type="password" id="senha_usuario" name="senha_usuario" minlength="6" required>
                        <br>

                        <label for="senha_confirma">Confirmar senha:</label><br>
                        <input type="password" id="senha_confirma" name="senha_confirma" minlength="6" required>
                        <br>

                        <label for="tipo_usuario">Perfil:</label><br>
                        <select class="sec" name="tipo_usuario" id="tipo_usuario">
                            <?php foreach ($perfis as $valor => $rotulo) { ?>
                                <option value="<?= $valor ?>" <?= $tipo === $valor ? "selected" : "" ?>><?= $rotulo ?></option>
                            <?php } ?>
                        </select>
                        <br><br>

                        <button type="submit">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
