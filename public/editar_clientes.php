<?php
require_once __DIR__ . "/verifica_admin.php";
require_once __DIR__ . "/../infra/conexao.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = $conexao->prepare("SELECT id_usuario, nome_usuario, email_usuario, tipo_usuario FROM usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$usuario) {
    $_SESSION["msg"] = "Usuário não encontrado.";
    $_SESSION["cor"] = "red";
    header("Location: Listar_clientes.php");
    exit;
}

$perfis = ["comum" => "Cliente", "funcionario" => "Funcionário", "administrador" => "Administrador"];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuário</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="flex">
            <div class="adn">
                <div class="adicionar">
                    <h3 class="h">Editando o usuário <?= htmlspecialchars($usuario["nome_usuario"]) ?>!</h3>

                    <form action="atualizar_clientes.php" method="POST">
                        <input type="hidden" name="id_usuario" value="<?= $usuario["id_usuario"] ?>">

                        <label for="nome">Nome:</label><br>
                        <input type="text" id="nome" name="nome_usuario" maxlength="100" value="<?= htmlspecialchars($usuario["nome_usuario"]) ?>" required>
                        <br>

                        <label for="email_usuario">E-mail:</label><br>
                        <input type="email" id="email_usuario" name="email_usuario" maxlength="100" value="<?= htmlspecialchars($usuario["email_usuario"]) ?>" required>
                        <br>

                        <label for="tipo_usuario">Perfil:</label><br>
                        <select class="sec" name="tipo_usuario" id="tipo_usuario">
                            <?php foreach ($perfis as $valor => $rotulo) { ?>
                                <option value="<?= $valor ?>" <?= $usuario["tipo_usuario"] === $valor ? "selected" : "" ?>><?= $rotulo ?></option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="senha_usuario">Nova senha (em branco mantém a atual):</label><br>
                        <input type="password" id="senha_usuario" name="senha_usuario" minlength="6" autocomplete="new-password">
                        <br><br>

                        <button type="submit">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
