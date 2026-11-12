<?php
session_start();

$eh_comum = ($_SESSION["tipo_usuario"] ?? "") === "comum";

if (!$eh_comum) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . "/infra/conexao.php";

$partidas = $conexao->query(
    "SELECT trens.nome AS trem, rotas.origem, rotas.destino,
            TIME_FORMAT(rotas.horario_partida, '%H:%i') AS partida,
            TIME_FORMAT(SEC_TO_TIME((TIME_TO_SEC(rotas.horario_partida) + rotas.duracao_min * 60) % 86400), '%H:%i') AS chegada
     FROM rotas
     JOIN trens ON trens.id = rotas.trem_id
     ORDER BY rotas.horario_partida
     LIMIT 8"
);

//clima
$latitude = -26.3044;
$longitude = -48.8487;

$url = "https://api.open-meteo.com/v1/forecast?latitude=$latitude&longitude=$longitude&current=temperature_2m,weather_code&timezone=America%2FSao_Paulo";

$resposta = @file_get_contents($url);

$clima = null;
$erro_clima = false;

if ($resposta !== false) {

    $dados_clima = json_decode($resposta, true);

    if (isset($dados_clima["current"])) {

        $clima = $dados_clima["current"];

        $temperatura = $clima["temperature_2m"];
        $codigo = $clima["weather_code"];
        $horario = $clima["time"];

        if ($codigo == 0) {
            $condicao = "Céu limpo";
        } elseif ($codigo <= 3) {
            $condicao = "Parcialmente nublado";
        } elseif ($codigo <= 48) {
            $condicao = "Neblina";
        } elseif ($codigo <= 67) {
            $condicao = "Chuva";
        } elseif ($codigo <= 77) {
            $condicao = "Neve";
        } elseif ($codigo <= 82) {
            $condicao = "Pancadas de chuva";
        } elseif ($codigo <= 86) {
            $condicao = "Pancadas de neve";
        } else {
            $condicao = "Trovoadas";
        }

    } else {
        $erro_clima = true;
    }

} else {
    $erro_clima = true;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Rush! - Cliente</title>
    <link rel="stylesheet" href="assets/imag/style/style.css">
</head>

<body>
    <header>
        <nav class="nave">
            <div class="lg">
                <img class="logo" src="assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
            </div>
            <div class="red">
                <h1 id="hs">Red Rush</h1>
            </div>
        </nav>
        <nav class="navs">
            <a id="lk" href="public/Listar_trens.php">Trens</a>
            <a id="lk" href="public/Listar_rotas.php">Rotas</a>
            <a id="lk" href="public/Horario_trem.php">Horários</a>
            <a id="lk" href="public/logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <div class="bem">
            <img class="trem" src="assets/imag/trem.png" alt="trem">
            <h1 id="bvd">Bem Vindo!</h1>
        </div>

        <div class="adn">
            <h3>Próximas partidas</h3>
            <?php if ($partidas->num_rows == 0) { ?>
                <p>Nenhuma rota cadastrada ainda.</p>
            <?php } else { ?>
                <table border="1" align="center" cellpadding="6">
                    <tr>
                        <th>Trem</th>
                        <th>Rota</th>
                        <th>Partida</th>
                        <th>Chegada</th>
                    </tr>
                    <?php while ($p = $partidas->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($p["trem"]) ?></td>
                            <td><?= htmlspecialchars($p["origem"]) ?> - <?= htmlspecialchars($p["destino"]) ?></td>
                            <td><?= $p["partida"] ?></td>
                            <td><?= $p["chegada"] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </div>

        <div class="card-clima">

            <h2>Clima atual</h2>

            <?php if (!$erro_clima) { ?>

                <div class="temperatura">
                <?= $temperatura ?> °C
                </div>

                <p class="condicao">
                    <?= htmlspecialchars($condicao) ?>
                </p>

                <p>📍 Joinville - SC</p>

                <p class="atualizacao">
                    Última atualização:
                    <?= date("d/m/Y H:i", strtotime($horario)) ?>
                </p>

            <?php } else { ?>

                <p>Não foi possível carregar as informações do clima.</p>

            <?php } ?>

        </div>

        

    </main>

    <footer>

    </footer>
</body>

</html>
