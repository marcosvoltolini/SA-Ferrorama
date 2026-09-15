<?php
include "../conexao.php";

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $usuario = $_POST["usuario"];
    $pais = $_POST["pais"];
    $email = $_POST["email"];
    $celular = $_POST["celular"];
    $senha = $_POST["senha"];

    if ($nome == "" || $usuario == "" || $pais == "" || $email == "" || $celular == "" || $senha == "") {
        $erro = "Preencha todos os campos!";
    } else {

        $senha_criptografada = md5($senha);

        // Monta o comando SQL para inserir no banco
        $sql = "INSERT INTO usuarios (nome, usuario, pais, email, celular, senha) VALUES ('$nome', '$usuario', '$pais', '$email', '$celular', '$senha_criptografada')";

        $resultado = mysqli_query($conexao, $sql);

        if ($resultado) {
            $sucesso = "Cadastro realizado com sucesso!";
        } else {
            $erro = "Erro ao cadastrar: " . mysqli_error($conexao);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Red Rush</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bodi">

    <header>
        <nav class="nave">
            <img class="logo" src="../assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
            <h1>Red Rush</h1>
            <p>ADM page</p>
        </nav>
    </header>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <main>
        <div class="container">

            
            <?php if ($erro != "") { ?>
                <p style="color: red;"><?php echo $erro; ?></p>
            <?php } ?>

            <?php if ($sucesso != "") { ?>
                <p style="color: green;"><?php echo $sucesso; ?></p>
            <?php } ?>

            <form class="formsss" action="cadastro.php" method="POST">
                <div class="bim">
                    <h2 id="log">Cadastro</h2>
                </div>
                <br>
                <div class="Config">
                    <label id="back" for="nome">Nome completo</label>
                    <br>
                    <input type="text" id="nome" name="nome" required>
                    <br>
                    <label id="back" for="usuario">Nome de usuario</label>
                    <br>
                    <input type="text" id="usuario" name="usuario" required>
                    <br>
                    <label id="back" for="pais">País</label>
                    <br>
                    <input type="text" id="pais" name="pais" required>
                    <br>
                    <label id="back" for="email">Email</label>
                    <br>
                    <input type="email" id="email" name="email" required>
                    <br>
                    <label id="back" for="celular">Numero de celular</label>
                    <br>
                    <input type="text" id="celular" name="celular" required>
                    <br>
                    <label id="back" for="senha">Senha</label>
                    <br>
                    <input type="password" id="senha" name="senha" required>
                    <br>
                    <div class="check">
                        <br>
                    </div>
                    <button id="bot" type="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>