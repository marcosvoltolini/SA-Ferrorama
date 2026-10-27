<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_login.php";

$tipo = $_SESSION["tipo_usuario"];

$sql = "SELECT trens.id, trens.nome, trens.tipo, usuarios.nome_usuario AS maquinista,
               (SELECT COUNT(*) FROM rotas WHERE rotas.trem_id = trens.id) AS qtd_rotas,
               (SELECT COUNT(*) FROM sensores WHERE sensores.trem_id = trens.id) AS qtd_sensores
        FROM trens
        LEFT JOIN usuarios ON usuarios.id_usuario = trens.maquinista_id
        ORDER BY trens.nome";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Trens</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="adn">
            <h2>Lista de Trens</h2>

            <?php if ($tipo !== "comum") { ?>
                <button class="botao"><a id="lk" href="cadastro_trem.php">Cadastrar trem</a></button>
            <?php } ?>

            <?php if (mysqli_num_rows($resultado) > 0) { ?>
                <table border="1" align="center" cellpadding="6">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Maquinista</th>
                        <th>Rotas</th>
                        <th>Sensores</th>
                        <?php if ($tipo !== "comum") { ?>
                            <th colspan="2">Ações</th>
                        <?php } ?>
                    </tr>

                    <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?= $linha["id"] ?></td>
                            <td><?= htmlspecialchars($linha["nome"]) ?></td>
                            <td><?= $linha["tipo"] ?></td>
                            <td><?= $linha["maquinista"] ? htmlspecialchars($linha["maquinista"]) : "-" ?></td>
                            <td><?= $linha["qtd_rotas"] ?></td>
                            <td><?= $linha["qtd_sensores"] ?></td>
                            <?php if ($tipo !== "comum") { ?>
                                <td><a href="editar_trens.php?id=<?= $linha["id"] ?>">Editar</a></td>
                                <td>
                                    <?php if ($tipo === "administrador") { ?>
                                        <form method="POST" action="excluir_trens.php" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                            <input type="hidden" name="id" value="<?= $linha["id"] ?>">
                                            <button type="submit">Excluir</button>
                                        </form>
                                    <?php } ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>Nenhum trem cadastrado.</p>
            <?php } ?>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
<?php mysqli_close($conexao); ?>
