<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_login.php";

$sql = "SELECT trens.nome AS trem, trens.imagem, rotas.origem, rotas.destino, rotas.imagem_mapa
        FROM rotas
        JOIN trens ON trens.id = rotas.trem_id
        ORDER BY trens.nome, rotas.nome";
$resultado = mysqli_query($conexao, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rota dos Trens</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="adn">
            <h2>Rota dos Trens</h2>
        </div>

        <?php if (mysqli_num_rows($resultado) == 0) { ?>
            <div class="adn">
                <p>Nenhuma rota cadastrada ainda.</p>
            </div>
        <?php } else { ?>
            <div class="bensgrand" style="flex-wrap: wrap">
                <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
                    <div class="visu">
                        <img src="../assets/imag/<?= rawurlencode($linha["imagem"] ?: "trem.png") ?>" alt="<?= htmlspecialchars($linha["trem"]) ?>" width="200">
                        <h1 class="fanfas"><?= htmlspecialchars($linha["trem"]) ?></h1>
                        <h4>Rota: <?= htmlspecialchars($linha["origem"]) ?> - <?= htmlspecialchars($linha["destino"]) ?></h4>
                        <?php if ($linha["imagem_mapa"]) { ?>
                            <img class="rotinhas" src="../assets/imag/<?= rawurlencode($linha["imagem_mapa"]) ?>" alt="Mapa da rota">
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </main>

    <footer>

    </footer>
</body>

</html>
