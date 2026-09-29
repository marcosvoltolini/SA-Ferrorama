<?php
require_once __DIR__ . "/../infra/conexao.php";

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $tipo = intval($_POST['tipo'] ?? 0);

    if ($nome === '' || $tipo === 0) {
        $mensagem = '<p style="color:red;">Preencha o nome/código e selecione um tipo de trem.</p>';
    } else {
        $stmt = $conn->prepare("INSERT INTO trens (nome, tipo) VALUES (?, ?)");
        $stmt->bind_param("si", $nome, $tipo);

        if ($stmt->execute()) {
            $mensagem = '<p style="color:green;">Trem cadastrado com sucesso!</p>';
        } else {
            $mensagem = '<p style="color:red;">Erro ao cadastrar trem: ' . htmlspecialchars($stmt->error) . '</p>';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trens</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header></header>

    <main>
        <div class="flex">
            <div class="dash">
                <div class="coisa">
                    <div class="bmv">
                        <h3>Bem vindo ADM </h3>
                        <img id="icon" src="../assets/imag/person2.webp" alt="Person">
                    </div>

                    <div class="board">
                        <div class="dsh"><ol>Dashboard 1</ol></div>
                        <div class="dsh"><ol>Dashboard 2</ol></div>
                        <div class="dsh"><ol>Dashboard 3</ol></div>
                        <div class="dsh"><ol>Dashboard 4</ol></div>
                        <div class="dsh5"><ol>Dashboard 5</ol></div>
                        <div class="dsh"><ol>Dashboard 6</ol></div>
                    </div>
                </div>
            </div>

            <div class="adn">
                <div class="senso">
                    <h1>Cadastro de trens</h1>
                </div>

                <div class="adicionar">
                    <h3 class="h">Adicionar novo trem</h3>

                    <?= $mensagem ?>

                    <form id="form" method="POST" action="">
                        Nome/código do trem: <br>
                        <input type="text" name="nome" id="nome" required> <br>
                        Tipo de trem: <br>
                        <select class="sec" name="tipo" id="sel" required>
                            <option value="0">Selecione</option>
                            <option value="1">Carga</option>
                            <option value="2">Passageiro</option>
                        </select> <br><br>
                        <button type="submit">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer></footer>
</body>

</html>