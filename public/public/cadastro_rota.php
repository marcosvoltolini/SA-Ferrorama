<?php
$raiz = "../";
require_once __DIR__ . "/../infra/auth.php";
exigir_perfil(["administrador", "funcionario"]);

$id = (int) ($_GET["id"] ?? 0);
$rota = [
    "trem_id" => "", "nome" => "", "origem" => "", "destino" => "",
    "horario_partida" => "", "duracao_min" => "", "distancia_km" => "", "imagem_mapa" => "",
];

if ($id > 0) {
    $stmt = $conexao->prepare(
        "SELECT trem_id, nome, origem, destino, horario_partida, duracao_min, distancia_km, imagem_mapa FROM rotas WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $rota = $stmt->get_result()->fetch_assoc();
    if (!$rota) {
        flash("erro", "Rota não encontrada.");
        redirecionar("Listar_rotas.php");
    }
    $rota["horario_partida"] = fmt_hora($rota["horario_partida"]);
}

$trens = todos_os_trens($conexao);
$imagens = lista_imagens();
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    csrf_validar();

    $trem_id = (int) ($_POST["trem_id"] ?? 0);
    $nome = trim($_POST["nome"] ?? "");
    $origem = trim($_POST["origem"] ?? "");
    $destino = trim($_POST["destino"] ?? "");
    $partida = trim($_POST["horario_partida"] ?? "");
    $duracao = (int) ($_POST["duracao_min"] ?? 0);
    $texto_distancia = str_replace(",", ".", trim($_POST["distancia_km"] ?? ""));
    $distancia = $texto_distancia === "" ? null : (float) $texto_distancia;
    $mapa = $_POST["imagem_mapa"] ?? "";

    $rota = [
        "trem_id" => $trem_id, "nome" => $nome, "origem" => $origem, "destino" => $destino,
        "horario_partida" => $partida, "duracao_min" => $duracao ?: "",
        "distancia_km" => $texto_distancia, "imagem_mapa" => $mapa,
    ];

    if (!in_array($trem_id, array_map("intval", array_column($trens, "id")), true)) {
        $erro = "Selecione um trem válido.";
    } elseif ($nome === "" || $origem === "" || $destino === "") {
        $erro = "Preencha nome, origem e destino.";
    } elseif (mb_strlen($nome) > 100 || mb_strlen($origem) > 100 || mb_strlen($destino) > 100) {
        $erro = "Nome, origem e destino devem ter no máximo 100 caracteres.";
    } elseif (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $partida)) {
        $erro = "Informe um horário de partida válido.";
    } elseif ($duracao < 1 || $duracao > 10080) {
        $erro = "Informe a duração em minutos (entre 1 e 10080).";
    } elseif ($texto_distancia !== "" && (!is_numeric($texto_distancia) || $distancia < 0)) {
        $erro = "Distância inválida.";
    } elseif ($mapa !== "" && !in_array($mapa, $imagens, true)) {
        $erro = "Imagem inválida.";
    } else {
        $mapa = $mapa === "" ? null : $mapa;
        try {
            if ($id > 0) {
                $stmt = $conexao->prepare(
                    "UPDATE rotas SET trem_id = ?, nome = ?, origem = ?, destino = ?, horario_partida = ?, duracao_min = ?, distancia_km = ?, imagem_mapa = ? WHERE id = ?"
                );
                $stmt->bind_param("issssidsi", $trem_id, $nome, $origem, $destino, $partida, $duracao, $distancia, $mapa, $id);
            } else {
                $stmt = $conexao->prepare(
                    "INSERT INTO rotas (trem_id, nome, origem, destino, horario_partida, duracao_min, distancia_km, imagem_mapa) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->bind_param("issssids", $trem_id, $nome, $origem, $destino, $partida, $duracao, $distancia, $mapa);
            }
            $stmt->execute();

            flash("ok", $id > 0 ? "Rota atualizada com sucesso!" : "Rota cadastrada com sucesso!");
            redirecionar("Listar_rotas.php");
        } catch (mysqli_sql_exception $e) {
            $erro = "Não foi possível salvar a rota.";
        }
    }
}

$titulo = $id > 0 ? "Editar rota" : "Cadastrar rota";
require __DIR__ . "/../includes/topo.php";
?>
<h2><?= h($titulo) ?></h2>

<?php if (!$trens) { ?>
    <p style="color: red">Antes de cadastrar uma rota é preciso ter um trem. <a href="cadastro_trem.php">Cadastrar trem</a></p>
<?php } ?>
<?php if ($erro) { ?>
    <p style="color: red"><?= h($erro) ?></p>
<?php } ?>

<form class="formss" style="display: inline-block; text-align: left" method="POST" action="">
    <?= csrf_campo() ?>

    <label for="trem_id">Trem:</label><br>
    <select class="sec" name="trem_id" id="trem_id" required>
        <option value="">Selecione</option>
        <?php foreach ($trens as $t) { ?>
            <option value="<?= $t["id"] ?>" <?= (string) $rota["trem_id"] === (string) $t["id"] ? "selected" : "" ?>><?= h($t["nome"]) ?></option>
        <?php } ?>
    </select>
    <br><br>

    <label for="nome">Nome da rota:</label><br>
    <input type="text" name="nome" id="nome" maxlength="100" value="<?= h($rota["nome"]) ?>" required>
    <br><br>

    <label for="origem">Origem:</label><br>
    <input type="text" name="origem" id="origem" maxlength="100" value="<?= h($rota["origem"]) ?>" required>
    <br><br>

    <label for="destino">Destino:</label><br>
    <input type="text" name="destino" id="destino" maxlength="100" value="<?= h($rota["destino"]) ?>" required>
    <br><br>

    <label for="horario_partida">Horário de partida:</label><br>
    <input type="time" name="horario_partida" id="horario_partida" value="<?= h($rota["horario_partida"]) ?>" required>
    <br><br>

    <label for="duracao_min">Duração (minutos):</label><br>
    <input type="number" name="duracao_min" id="duracao_min" min="1" max="10080" value="<?= h($rota["duracao_min"]) ?>" required>
    <br><br>

    <label for="distancia_km">Distância (km), opcional:</label><br>
    <input type="text" name="distancia_km" id="distancia_km" value="<?= h($rota["distancia_km"]) ?>">
    <br><br>

    <label for="imagem_mapa">Imagem do mapa:</label><br>
    <select class="sec" name="imagem_mapa" id="imagem_mapa">
        <option value="">Nenhuma</option>
        <?php foreach ($imagens as $i) { ?>
            <option value="<?= h($i) ?>" <?= $rota["imagem_mapa"] === $i ? "selected" : "" ?>><?= h($i) ?></option>
        <?php } ?>
    </select>
    <br><br>

    <button class="botao" type="submit" <?= $trens ? "" : "disabled" ?>>Salvar</button>
    <a href="Listar_rotas.php">Cancelar</a>
</form>
<?php require __DIR__ . "/../includes/rodape.php"; ?>
