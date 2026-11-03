<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$tipo = $_SESSION["tipo_usuario"];

$sql = "SELECT sensores.id, sensores.nome, sensores.tipo, trens.nome AS trem
        FROM sensores
        JOIN trens ON trens.id = sensores.trem_id
        ORDER BY trens.nome, sensores.nome";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensores</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="adn">
            <h2>Lista de Sensores</h2>

            <button class="botao"><a id="lk" href="cadastro-sensor.php">Cadastrar sensor</a></button>

            <?php if (mysqli_num_rows($resultado) > 0) { ?>
                <table border="1" align="center" cellpadding="6">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Trem</th>
                        <th colspan="2">Ações</th>
                    </tr>

                    <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?= $linha["id"] ?></td>
                            <td><?= htmlspecialchars($linha["nome"]) ?></td>
                            <td><?= $linha["tipo"] ?></td>
                            <td><?= htmlspecialchars($linha["trem"]) ?></td>
                            <td><a href="editar_sensor.php?id=<?= $linha["id"] ?>">Editar</a></td>
                            <td>
                                <?php if ($tipo === "administrador") { ?>
                                    <form method="POST" action="excluir_sensor.php" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        <input type="hidden" name="id" value="<?= $linha["id"] ?>">
                                        <button type="submit">Excluir</button>
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>Nenhum sensor cadastrado.</p>
            <?php } ?>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
