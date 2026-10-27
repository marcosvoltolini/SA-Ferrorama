<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$tipos = ["Carga", "Passageiro"];
$imagens = array_diff(scandir(__DIR__ . "/../assets/imag"), [".", ".."]);

$maquinistas = mysqli_query(
    $conexao,
    "SELECT id_usuario, nome_usuario FROM usuarios
     WHERE tipo_usuario = 'funcionario'
     AND id_usuario NOT IN (SELECT maquinista_id FROM trens WHERE maquinista_id IS NOT NULL)
     ORDER BY nome_usuario"
);

$nome = "";
$tipo = "";
$maquinista = "";
$imagem = "";
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $tipo = $_POST["tipo"] ?? "";
    $maquinista = $_POST["maquinista_id"] ?? "";
    $imagem = $_POST["imagem"] ?? "";

    if ($nome === "" || $tipo === "") {
        $erro = "Preencha o nome e selecione um tipo de trem.";
    } elseif (mb_strlen($nome) > 100) {
        $erro = "O nome deve ter no máximo 100 caracteres.";
    } elseif (!in_array($tipo, $tipos, true)) {
        $erro = "Selecione um tipo de trem válido.";
    } elseif ($imagem !== "" && !in_array($imagem, $imagens, true)) {
        $erro = "Imagem inválida.";
    } else {
        $check = $conexao->prepare("SELECT 1 FROM trens WHERE nome = ?");
        $check->bind_param("s", $nome);
        $check->execute();
        $existe = $check->get_result()->fetch_assoc();
        $check->close();

        if ($existe) {
            $erro = "Já existe um trem com esse nome.";
        }

        if ($erro === "" && $maquinista !== "") {
            $check = $conexao->prepare(
                "SELECT 1 FROM usuarios
                 WHERE id_usuario = ? AND tipo_usuario = 'funcionario'
                 AND id_usuario NOT IN (SELECT maquinista_id FROM trens WHERE maquinista_id IS NOT NULL)"
            );
            $check->bind_param("i", $maquinista);
            $check->execute();
            $valido = $check->get_result()->fetch_assoc();
            $check->close();

            if (!$valido) {
                $erro = "Maquinista inválido ou já associado a outro trem.";
            }
        }

        if ($erro === "") {
            if ($maquinista === "") {
                $maquinista = null;
            }
            if ($imagem === "") {
                $imagem = null;
            }

            $stmt = $conexao->prepare("INSERT INTO trens (nome, tipo, maquinista_id, imagem) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $nome, $tipo, $maquinista, $imagem);
            $stmt->execute();
            $stmt->close();

            $_SESSION["msg"] = "Trem cadastrado com sucesso!";
            $_SESSION["cor"] = "green";
            header("Location: Listar_trens.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de trens</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main>
        <div class="flex">
            <div class="adn">
                <div class="adicionar">
                    <h3 class="h">Adicionar novo trem</h3>

                    <?php if ($erro) { ?>
                        <p style="color: red"><?= htmlspecialchars($erro) ?></p>
                    <?php } ?>

                    <form id="form" method="POST" action="">
                        <label for="nome">Nome do trem:</label><br>
                        <input type="text" name="nome" id="nome" maxlength="100" value="<?= htmlspecialchars($nome) ?>" required>
                        <br>

                        <label for="sel">Tipo de trem:</label><br>
                        <select class="sec" name="tipo" id="sel" required>
                            <option value="">Selecione</option>
                            <?php foreach ($tipos as $t) { ?>
                                <option value="<?= $t ?>" <?= $tipo === $t ? "selected" : "" ?>><?= $t ?></option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="maq">Maquinista:</label><br>
                        <select class="sec" name="maquinista_id" id="maq">
                            <option value="">Sem maquinista</option>
                            <?php while ($m = mysqli_fetch_assoc($maquinistas)) { ?>
                                <option value="<?= $m["id_usuario"] ?>" <?= $maquinista == $m["id_usuario"] ? "selected" : "" ?>>
                                    <?= htmlspecialchars($m["nome_usuario"]) ?>
                                </option>
                            <?php } ?>
                        </select>
                        <br>

                        <label for="img">Imagem:</label><br>
                        <select class="sec" name="imagem" id="img">
                            <option value="">Padrão</option>
                            <?php foreach ($imagens as $i) { ?>
                                <option value="<?= htmlspecialchars($i) ?>" <?= $imagem === $i ? "selected" : "" ?>><?= htmlspecialchars($i) ?></option>
                            <?php } ?>
                        </select>
                        <br><br>

                        <button type="submit">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer></footer>
</body>

</html>
