<?php

require_once __DIR__ . "/../infra/conexao.php";

$id = $_GET["id"];
$sql = "SELECT * FROM trens WHERE id = $id";
$resultado = mysqli_query($conexao, $sql );
$tipos = ['Carga', 'Passageiro'];

$trem =mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Trem</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
            <button class="botao"><a id="lk" href="cadastro_trem.php">Cadastrar trem</a></button>
            <button class="botao"><a id="lk" href="Rota_trem.php">Rota dos trens</a></button>
            <button class="botao"><a id="lk" href="Horario_trem.php">Horários</a></button>

        </nav>
    </header>
    <main>
        <h2>Editando o trem <?php echo $trem["nome"]?>!</h2>
        <form action="atualizar_trem.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $trem["id"]?>">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo $trem["nome"]?>">
            <br>
            <label for="sel">Tipo de trem:</label><br>
                        <select class="sec" name="tipo" id="sel" required>
                            <option value="">Selecione</option>
                            <?php foreach ($tipos as $t): ?>
                                <option value="<?= htmlspecialchars($t) ?>" <?= $tipos === $t ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($t) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <br><br>
            <button type="submit">Atualizar</button>
        </form>

    </main>
    <footer>

    </footer>


</body>

</html>