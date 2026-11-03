<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_login.php";

$tipo = $_SESSION["tipo_usuario"];

$sql = "SELECT rotas.id, rotas.nome, rotas.origem, rotas.destino, rotas.duracao_min, rotas.distancia_km,
               trens.nome AS trem,
               TIME_FORMAT(rotas.horario_partida, '%H:%i') AS partida,
               TIME_FORMAT(SEC_TO_TIME((TIME_TO_SEC(rotas.horario_partida) + rotas.duracao_min * 60) % 86400), '%H:%i') AS chegada
        FROM rotas
        JOIN trens ON trens.id = rotas.trem_id
        ORDER BY trens.nome, rotas.horario_partida";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Rotas</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="adn">
            <h2>Lista de Rotas</h2>

            <?php if ($tipo !== "comum") { ?>
                <button class="botao"><a id="lk" href="adicionar_rota.php">Cadastrar rota</a></button>
            <?php } ?>
            <button class="botao"><a id="lk" href="Rota_trem.php">Ver mapas</a></button>

            <?php if (mysqli_num_rows($resultado) > 0) { ?>
                <table border="1" align="center" cellpadding="6">
                    <tr>
                        <th>Trem</th>
                        <th>Rota</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Partida</th>
                        <th>Chegada</th>
                        <th>Duração (min)</th>
                        <th>Distância (km)</th>
                        <?php if ($tipo !== "comum") { ?>
                            <th colspan="2">Ações</th>
                        <?php } ?>
                    </tr>

                    <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($linha["trem"]) ?></td>
                            <td><?= htmlspecialchars($linha["nome"]) ?></td>
                            <td><?= htmlspecialchars($linha["origem"]) ?></td>
                            <td><?= htmlspecialchars($linha["destino"]) ?></td>
                            <td><?= $linha["partida"] ?></td>
                            <td><?= $linha["chegada"] ?></td>
                            <td><?= $linha["duracao_min"] ?></td>
                            <td><?= $linha["distancia_km"] ?? "-" ?></td>
                            <?php if ($tipo !== "comum") { ?>
                                <td><a href="editar_rotas.php?id=<?= $linha["id"] ?>">Editar</a></td>
                                <td>
                                    <?php if ($tipo === "administrador") { ?>
                                        <form method="POST" action="excluir_rotas.php" onsubmit="return confirm('Tem certeza que deseja excluir?')">
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
                <p>Nenhuma rota cadastrada.</p>
            <?php } ?>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>
