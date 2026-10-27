<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Listar_trens.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);
$nome = trim($_POST["nome"] ?? "");
$tipo = $_POST["tipo"] ?? "";
$maquinista = $_POST["maquinista_id"] ?? "";
$imagem = $_POST["imagem"] ?? "";

$tipos = ["Carga", "Passageiro"];
$imagens = array_diff(scandir(__DIR__ . "/../assets/imag"), [".", ".."]);
$erro = "";

if ($id === 0 || $nome === "") {
    $erro = "Preencha o nome do trem.";
} elseif (mb_strlen($nome) > 100) {
    $erro = "O nome deve ter no máximo 100 caracteres.";
} elseif (!in_array($tipo, $tipos, true)) {
    $erro = "Selecione um tipo de trem válido.";
} elseif ($imagem !== "" && !in_array($imagem, $imagens, true)) {
    $erro = "Imagem inválida.";
} else {
    $check = $conexao->prepare("SELECT 1 FROM trens WHERE nome = ? AND id <> ?");
    $check->bind_param("si", $nome, $id);
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
             AND id_usuario NOT IN (SELECT maquinista_id FROM trens WHERE maquinista_id IS NOT NULL AND id <> ?)"
        );
        $check->bind_param("ii", $maquinista, $id);
        $check->execute();
        $valido = $check->get_result()->fetch_assoc();
        $check->close();

        if (!$valido) {
            $erro = "Maquinista inválido ou já associado a outro trem.";
        }
    }
}

if ($erro !== "") {
    $_SESSION["msg"] = $erro;
    $_SESSION["cor"] = "red";
    header("Location: editar_trens.php?id=" . $id);
    exit;
}

if ($maquinista === "") {
    $maquinista = null;
}
if ($imagem === "") {
    $imagem = null;
}

$stmt = $conexao->prepare("UPDATE trens SET nome = ?, tipo = ?, maquinista_id = ?, imagem = ? WHERE id = ?");
$stmt->bind_param("ssisi", $nome, $tipo, $maquinista, $imagem, $id);
$stmt->execute();
$stmt->close();

$_SESSION["msg"] = "Trem atualizado com sucesso!";
$_SESSION["cor"] = "green";
header("Location: Listar_trens.php");
exit;
