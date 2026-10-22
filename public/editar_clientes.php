<?php
require_once __DIR__ . "/verifica_admin.php";
require_once __DIR__ . "/../infra/conexao.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = $conexao->prepare(
    "SELECT id_usuario, nome_usuario, email_usuario FROM usuarios WHERE id_usuario = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$usuario) {
    die("Cliente não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar cliente</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <header>
        <nav class="nave">
            <img class="logo" src="../assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
            <div class="red">
                <h1 id="hs"><a href="../index.php">Red Rush</a></h1>
            </div>
        </nav>
        <nav class="navs">
            <a id="lk" href="Listar_clientes.php">Ver clientes</a>
            <a id="lk" href="login.php">Voltar para o home</a>
        </nav>
    </header>
    <main>
        <h2>Editando o cliente <?= htmlspecialchars($usuario["nome_usuario"]) ?>!</h2>
        <form action="atualizar_clientes.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?= $usuario["id_usuario"] ?>">

            <label for="nome_usuario">Nome:</label>
            <input type="text" id="nome_usuario" name="nome_usuario" value="<?= htmlspecialchars($usuario["nome_usuario"]) ?>" required>
            <br>
            <label for="email_usuario">E-mail:</label>
            <input type="email" id="email_usuario" name="email_usuario" value="<?= htmlspecialchars($usuario["email_usuario"]) ?>" required>
            <br>
            <label for="senha_usuario">Nova senha:</label>
            <input type="password" id="senha_usuario" name="senha_usuario">
            <br>
            <button type="submit">Atualizar</button>
        </form>
    </main>
    <footer>

    </footer>
</body>

</html>