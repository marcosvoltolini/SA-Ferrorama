<?php
require_once __DIR__ . "/../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$tipos = ['Carga', 'Passageiro'];

$nome = '';
$tipo = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $tipo = $_POST['tipo'] ?? '';

    if ($nome === '' || $tipo === '') {
        $erro = 'Preencha o nome e selecione um tipo de trem.';
    } elseif (mb_strlen($nome) > 100) {
        $erro = 'O nome deve ter no máximo 100 caracteres.';
    } elseif (!in_array($tipo, $tipos, true)) {
        $erro = 'Selecione um tipo de trem válido.';
    } else {
        try {
            $check = $conexao->prepare("SELECT 1 FROM trens WHERE nome = ? LIMIT 1");
            $check->bind_param("s", $nome);
            $check->execute();
            $check->store_result();
            $existe = $check->num_rows > 0;
            $check->close();

            if ($existe) {
                $erro = 'Já existe um trem com esse nome.';
            } else {
                $stmt = $conexao->prepare("INSERT INTO trens (nome, tipo) VALUES (?, ?)");
                $stmt->bind_param("ss", $nome, $tipo);
                $stmt->execute();
                $stmt->close();

                $_SESSION['flash_sucesso'] = 'Trem cadastrado com sucesso!';
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if ((int) $e->getCode() === 1062) {
                $erro = 'Já existe um trem com esse nome.';
            } else {
                error_log('Erro ao cadastrar trem: ' . $e->getMessage());
                $erro = 'Não foi possível cadastrar o trem. Tente novamente.';
            }
        }
    }
}

$sucesso = $_SESSION['flash_sucesso'] ?? '';
unset($_SESSION['flash_sucesso']);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de trens</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/style.css">
</head>

<body>
    <header></header>

    <main>
        <div class="flex">
            <div class="adn">
                <div class="senso">
                    <h1>Cadastro de trens</h1>
                </div>

                <div class="adicionar">
                    <h3 class="h">Adicionar novo trem</h3>

                    <?php if ($sucesso): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
                    <?php endif; ?>

                    <?php if ($erro): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                    <?php endif; ?>

                    <form id="form" method="POST" action="">
                        <label for="nome">Nome do trem:</label><br>
                        <input type="text" name="nome" id="nome" maxlength="100"
                               value="<?= htmlspecialchars($nome) ?>" required>
                        <br>

                        <label for="sel">Tipo de trem:</label><br>
                        <select class="sec" name="tipo" id="sel" required>
                            <option value="">Selecione</option>
                            <?php foreach ($tipos as $t): ?>
                                <option value="<?= htmlspecialchars($t) ?>" <?= $tipo === $t ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($t) ?>
                                </option>
                            <?php endforeach; ?>
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