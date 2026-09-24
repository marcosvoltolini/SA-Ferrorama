<?php
session_start();
 
if (isset($_SESSION["id_usuario"])) {
    header("Location: ../index.php");
    exit;
}
 
require_once __DIR__ . "/../infra/conexao.php";
 
$erro = "";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["password"] ?? "";
 
    if ($email === "" || $senha === "") {
        $erro = "Preencha email e senha.";
    } else {
        $stmt = $conexao->prepare(
            "SELECT id_usuario, nome_usuario, senha_usuario, tipo_usuario FROM usuarios WHERE email_usuario = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        $stmt->close();
 
        // Verifica se o usuário existe e se a senha bate com o hash salvo
        if ($usuario && password_verify($senha, $usuario["senha_usuario"])) {
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nome_usuario"] = $usuario["nome_usuario"];
            $_SESSION["tipo_usuario"] = $usuario["tipo_usuario"];
 
            header("Location: ../index.php");
            exit;
        } else {
            $erro = "Email ou senha inválidos.";
        }
    }
}
?>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Red Rush</title>
  <link rel="stylesheet" href="../assets/style/style.css">
</head>
 
<body class="bodi">
 
  <header>
    <nav class="nave">
      <img class="logo" src="../assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
      <h1>Red Rush</h1>
      <img id="gif" src="../assets/imag/trem_gif.gif" alt="gif trem">
    </nav>
  </header>
 
  <main>
    <div class="container">
      <form class="formss" action="" method="POST">
        <h2 id="log">Login</h2>
 
        <?php if ($erro): ?>
          <p class="erro-cadastro"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
 
        <label id="back" for="email">Email</label>
        <br>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        <br>
        <label id="back" for="password">Senha</label>
        <br>
        <input type="password" id="password" name="password" required>
        <br>
        <a href="cadastrar_usuario.php">Cadastre-se</a>
        <br>
        <button id="bot" type="submit">Login</button>
      </form>
    </div>
  </main>
 
  <footer>
 
  </footer>
</body>
 
</html>