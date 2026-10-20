<?php
session_start();

$host = 'localhost';
$db   = 'sa_ferrorama';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trem_id = filter_input(INPUT_POST, 'trem_id', FILTER_VALIDATE_INT);
    $nome = trim((string) filter_input(INPUT_POST, 'nome'));
    $origem = trim((string) filter_input(INPUT_POST, 'origem'));
    $destino = trim((string) filter_input(INPUT_POST, 'destino'));
    $distancia = filter_input(INPUT_POST, 'distancia_km', FILTER_VALIDATE_FLOAT);
    $duracao = filter_input(INPUT_POST, 'duracao_min', FILTER_VALIDATE_INT);

    if (!$trem_id || $nome === '' || $origem === '' || $destino === '' || $distancia === false || $duracao === false) {
        $mensagem = '<div style="color:red;">Preencha todos os campos corretamente.</div>';
    } else {
        $sql = 'INSERT INTO rotas (trem_id, nome, origem, destino, distancia_km, duracao_min) VALUES (:trem_id, :nome, :origem, :destino, :distancia_km, :duracao_min)';

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':trem_id' => $trem_id,
                ':nome' => $nome,
                ':origem' => $origem,
                ':destino' => $destino,
                ':distancia_km' => $distancia,
                ':duracao_min' => $duracao,
            ]);

            $mensagem = '<div style="color:green;">Rota adicionada com sucesso!</div>';
        } catch (PDOException $e) {
            $mensagem = '<div style="color:red;">Erro ao salvar a rota: ' . $e->getMessage() . '</div>';
        }
    }
}

$stmtTrens = $pdo->query('SELECT id, nome FROM trens ORDER BY nome ASC');
$trens = $stmtTrens->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Rota</title>
    <link rel="stylesheet" href="../assets/style/style.css">
</head>
<body>
    <div class="container">
        <h2>Adicionar rota para os trens</h2>

        <?php if ($mensagem): ?>
            <div class="mensagem"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="trem_id">Trem</label>
            <select name="trem_id" id="trem_id" required>
                <option value="">Selecione o trem</option>
                <?php foreach ($trens as $trem): ?>
                    <option value="<?php echo (int) $trem['id']; ?>"><?php echo htmlspecialchars($trem['nome']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="nome">Nome da rota</label>
            <input type="text" name="nome" id="nome" placeholder="Ex.: Linha Central" required>

            <label for="origem">Origem</label>
            <input type="text" name="origem" id="origem" placeholder="Ex.: São Paulo" required>

            <label for="destino">Destino</label>
            <input type="text" name="destino" id="destino" placeholder="Ex.: Rio de Janeiro" required>

            <label for="distancia_km">Distância (km)</label>
            <input type="number" step="0.01" min="0" name="distancia_km" id="distancia_km" placeholder="Ex.: 350.5" required>

            <label for="duracao_min">Duração estimada (minutos)</label>
            <input type="number" min="1" name="duracao_min" id="duracao_min" placeholder="Ex.: 180" required>

            <button type="submit">Salvar rota</button>
        </form>
    </div>
</body>
</html>
