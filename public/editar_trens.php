<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = $conexao->prepare("SELECT id, nome, tipo, maquinista_id, imagem FROM trens WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$trem = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$trem) {
    $_SESSION["msg"] = "Trem não encontrado.";
    $_SESSION["cor"] = "red";
    header("Location: Listar_trens.php");
    exit;
}

$tipos = ["Carga", "Passageiro"];
$imagens = array_diff(scandir(__DIR__ . "/../assets/imag"), [".", ".."]);

$stmt = $conexao->prepare(
    "SELECT id_usuario, nome_usuario FROM usuarios
     WHERE tipo_usuario = 'funcionario'
     AND (id_usuario NOT IN (SELECT maquinista_id FROM trens WHERE maquinista_id IS NOT NULL) OR id_usuario = ?)
     ORDER BY nome_usuario"
);
$atual = (int) $trem["maquinista_id"];
$stmt->bind_param("i", $atual);
$stmt->execute();
$maquinistas = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Trem</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="flex">
            <div class="adn">
                <div class="adicionar">
                    <h3 class="h">Editando o trem <?= htmlspecialchars($trem["nome"]) ?>!</h3>

                    <form action="atualizar_trem.php" method="POST">
                        <input type="hidden" name="id" value="<?= $trem["id"] ?>">

                        <label for="nome">Nome:</label><br>
                        <input type="text" name="nome" id="nome" maxlength="100" value="<?= htmlspecialchars($trem["nome"]) ?>" required>
                        <br>

                        <label for="sel">Tipo de trem:</label><br>
                        <select class="sec" name="tipo" id="sel" required>
                            <?php foreach ($tipos as $t) { ?>
                                <option value="<?= $t ?>" <?= $trem["tipo"] === $t ? "selected" : "" ?>><?= $t ?></option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="maq">Maquinista:</label><br>
                        <select class="sec" name="maquinista_id" id="maq">
                            <option value="">Sem maquinista</option>
                            <?php while ($m = $maquinistas->fetch_assoc()) { ?>
                                <option value="<?= $m["id_usuario"] ?>" <?= $trem["maquinista_id"] == $m["id_usuario"] ? "selected" : "" ?>>
                                    <?= htmlspecialchars($m["nome_usuario"]) ?>
                                </option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="img">Imagem:</label><br>
                        <select class="sec" name="imagem" id="img">
                            <option value="">Padrão</option>
                            <?php foreach ($imagens as $i) { ?>
                                <option value="<?= htmlspecialchars($i) ?>" <?= $trem["imagem"] === $i ? "selected" : "" ?>><?= htmlspecialchars($i) ?></option>
                            <?php } ?>
                        </select>
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
