<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$tipo = $_SESSION["tipo_usuario"];

$sql = "SELECT usuarios.id_usuario, usuarios.nome_usuario, usuarios.email_usuario, usuarios.tipo_usuario, trens.nome AS trem
        FROM usuarios
        LEFT JOIN trens ON trens.maquinista_id = usuarios.id_usuario";

if ($tipo !== "administrador") {
    $sql = $sql . " WHERE usuarios.tipo_usuario = 'comum'";
}

$sql = $sql . " ORDER BY usuarios.tipo_usuario, usuarios.nome_usuario";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de usuarios</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="adn">
            <h2>Lista de <?= $tipo === "administrador" ? "Usuários" : "Clientes" ?></h2>

            <?php if ($tipo === "administrador") { ?>
                <button class="botao"><a id="lk" href="cadastrar_admin.php">Cadastrar usuário</a></button>
            <?php } else { ?>
                <button class="botao"><a id="lk" href="cadastrar_usuario.php">Cadastrar cliente</a></button>
            <?php } ?>

            <table border="1" align="center" cellpadding="6">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <?php if ($tipo === "administrador") { ?>
                        <th>Perfil</th>
                        <th>Maquinista do trem</th>
                        <th colspan="2">Ações</th>
                    <?php } ?>
                </tr>

                <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
                    <tr>
                        <td><?= $linha["id_usuario"] ?></td>
                        <td><?= htmlspecialchars($linha["nome_usuario"]) ?></td>
                        <td><?= htmlspecialchars($linha["email_usuario"]) ?></td>
                        <?php if ($tipo === "administrador") { ?>
                            <td><?= $linha["tipo_usuario"] ?></td>
                            <td><?= $linha["trem"] ? htmlspecialchars($linha["trem"]) : "-" ?></td>
                            <td><a href="editar_clientes.php?id=<?= $linha["id_usuario"] ?>">Editar</a></td>
                            <td>
                                <?php if ($linha["id_usuario"] != $_SESSION["id_usuario"]) { ?>
                                    <form method="POST" action="excluir_clientes.php" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        <input type="hidden" name="id" value="<?= $linha["id_usuario"] ?>">
                                        <button type="submit">Excluir</button>
                                    </form>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
