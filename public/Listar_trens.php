<?php
include 'conexao.php';

$sql = "SELECT * FROM trens";
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Erro na consulta: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Trens</title>
</head>
<body>
    <header>
        <nav class="nave">
            <img class="logo" src="../assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
            <div class="red">
                <h1 id="hs"><a href="../index.php">Red Rush</a></h1>
            </div>
        </nav>
        <nav class="navs">
            <button class="botao"><a id="lk" href="Rota_trem.php">Rota dos trens</a></button>
            <button class="botao"><a id="lk" href="Horario_trem.php">Trens disponiveis</a></button>
            <button class="botao"><a id="lk" href="Horario_trem.php">Horários</a></button>
        </nav>
    </header>

    <h2>Lista de Trens</h2>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Modelo</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($trem = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= htmlspecialchars($trem['id']) ?></td>
                        <td><?= htmlspecialchars($trem['nome']) ?></td>
                        <td><?= htmlspecialchars($trem['modelo']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum trem cadastrado.</p>
    <?php endif; ?>
</body>
</html>
<?php mysqli_close($conn); ?>