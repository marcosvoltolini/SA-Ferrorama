<?php
session_start();

$eh_funcionario = ($_SESSION["tipo_usuario"] ?? "") === "funcionario";

if (!$eh_funcionario) {
    header("Location: index.php");
    exit;
}

require_once __DIR__ . "/infra/conexao.php";

$id = $_SESSION["id_usuario"];

$stmt = $conexao->prepare("SELECT id, nome, tipo FROM trens WHERE maquinista_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$trem = $stmt->get_result()->fetch_assoc();

$rotas = [];
if ($trem) {
    $stmt = $conexao->prepare(
        "SELECT nome,
                TIME_FORMAT(horario_partida, '%H:%i') AS partida,
                TIME_FORMAT(SEC_TO_TIME((TIME_TO_SEC(horario_partida) + duracao_min * 60) % 86400), '%H:%i') AS chegada
         FROM rotas WHERE trem_id = ? ORDER BY horario_partida"
    );
    $stmt->bind_param("i", $trem["id"]);
    $stmt->execute();
    $rotas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

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
    <title>Red Rush! - Funcionario</title>
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
            <a id="lk" href="public/Listar_sensor.php">Sensores</a>
            <a id="lk" href="public/Listar_clientes.php">Clientes</a>
            <a id="lk" href="public/logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <div class="bem">
            <img class="trem" src="assets/imag/trem.png" alt="trem">
            <h1 id="bvd">Bem Vindo!</h1>
        </div>

        <div class="adn">
            <h3>Seu trem</h3>
            <?php if (!$trem) { ?>
                <p>Você ainda não foi associado a nenhum trem como maquinista.</p>
            <?php } else { ?>
                <p><?= htmlspecialchars($trem["nome"]) ?> (<?= htmlspecialchars($trem["tipo"]) ?>)</p>
                <?php foreach ($rotas as $r) { ?>
                    <p><?= htmlspecialchars($r["nome"]) ?>: <?= $r["partida"] ?> - <?= $r["chegada"] ?></p>
                <?php } ?>
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

        <div class="cep-card">
    <h2>Consultar CEP</h2>
 
    <form id="cep-form" autocomplete="off">
        <label for="cep-cep">CEP</label>
        <input type="text" id="cep-cep" maxlength="9" placeholder="00000-000" inputmode="numeric">
        <button type="submit" id="cep-btn">Buscar</button>
 
        <div id="cep-msg" role="status"></div>
 
        <label for="cep-logradouro">Logradouro</label>
        <input type="text" id="cep-logradouro" readonly>
 
        <label for="cep-bairro">Bairro</label>
        <input type="text" id="cep-bairro" readonly>
 
        <label for="cep-cidade">Cidade</label>
        <input type="text" id="cep-cidade" readonly>
 
        <label for="cep-uf">Estado (UF)</label>
        <input type="text" id="cep-uf" readonly>
    </form>
</div>
<script>
    (function () {
        var form = document.getElementById("cep-form");
        var campoCep = document.getElementById("cep-cep");
        var btn = document.getElementById("cep-btn");
        var msg = document.getElementById("cep-msg");
        var campos = {
            logradouro: document.getElementById("cep-logradouro"),
            bairro: document.getElementById("cep-bairro"),
            cidade: document.getElementById("cep-cidade"),
            uf: document.getElementById("cep-uf")
        };
 
        function mostrar(texto, tipo) {
            msg.textContent = texto;
            msg.className = tipo ? "cep-" + tipo : "";
        }
 
        function limpar() {
            for (var k in campos) campos[k].value = "";
        }
 
        // máscara 00000-000 enquanto digita
        campoCep.addEventListener("input", function () {
            var n = campoCep.value.replace(/\D/g, "").slice(0, 8);
            campoCep.value = n.length > 5 ? n.slice(0, 5) + "-" + n.slice(5) : n;
        });
 
        // fetch com tempo limite de 6s
        function buscar(url) {
            var ctrl = new AbortController();
            var t = setTimeout(function () { ctrl.abort(); }, 6000);
            return fetch(url, { signal: ctrl.signal }).finally(function () { clearTimeout(t); });
        }
 
        // Retorna objeto padronizado, ou null se o CEP não existir. Lança erro se a API falhar.
        function consultarViaCep(cep) {
            return buscar("https://viacep.com.br/ws/" + cep + "/json/").then(function (r) {
                if (!r.ok) throw new Error("http " + r.status);
                return r.json();
            }).then(function (d) {
                if (d.erro) return null; // pode vir true ou "true"
                return { cep: d.cep, logradouro: d.logradouro, bairro: d.bairro, cidade: d.localidade, uf: d.uf };
            });
        }
 
        function consultarBrasilApi(cep) {
            return buscar("https://brasilapi.com.br/api/cep/v1/" + cep).then(function (r) {
                if (r.status === 404) return null;
                if (!r.ok) throw new Error("http " + r.status);
                return r.json();
            }).then(function (d) {
                if (!d) return null;
                return { cep: d.cep, logradouro: d.street, bairro: d.neighborhood, cidade: d.city, uf: d.state };
            });
        }
 
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            limpar();
 
            var cep = campoCep.value.replace(/\D/g, "");
 
            // 1) validação de formato
            if (cep.length !== 8 || /^(\d)\1{7}$/.test(cep)) {
                mostrar("CEP inválido. Digite 8 números, por exemplo 89201-000.", "erro");
                return;
            }
 
            btn.disabled = true;
            mostrar("Consultando...", "");
 
            // 2) ViaCEP; se a comunicação falhar, tenta a BrasilAPI
            consultarViaCep(cep).catch(function () {
                return consultarBrasilApi(cep);
            }).then(function (end) {
                // 3) CEP bem formado, mas sem resultado
                if (!end) {
                    mostrar("CEP não encontrado.", "erro");
                    return;
                }
                campoCep.value = cep.slice(0, 5) + "-" + cep.slice(5);
                campos.logradouro.value = end.logradouro || "";
                campos.bairro.value = end.bairro || "";
                campos.cidade.value = end.cidade || "";
                campos.uf.value = end.uf || "";
                mostrar(end.logradouro ? "Endereço encontrado." : "CEP encontrado (sem logradouro: CEP geral da cidade).", "ok");
            }).catch(function () {
                // 4) as duas APIs falharam
                mostrar("Não foi possível consultar o CEP agora. Verifique sua conexão e tente novamente.", "erro");
            }).finally(function () {
                btn.disabled = false;
            });
        });
    })();
</script>

    </main>

    <footer>

    </footer>
</body>

</html>
