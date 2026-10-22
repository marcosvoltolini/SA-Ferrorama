<?php
session_start();

if (isset($_SESSION["id_usuario"])) {
    $tipo = $_SESSION["tipo_usuario"] ?? "";

    if ($tipo === "administrador") {
        header("Location: ../dashboard_admin.php");
    } elseif ($tipo === "funcionario") {
        header("Location: ../dashboard_funcionario.php");
    } else {
        header("Location: ../index.php");
    }
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

        if ($usuario && password_verify($senha, $usuario["senha_usuario"])) {
            session_regenerate_id(true); 

            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nome_usuario"] = $usuario["nome_usuario"];
            $_SESSION["tipo_usuario"] = $usuario["tipo_usuario"];

            if ($usuario["tipo_usuario"] === "administrador") {
                header("Location: ../dashboard_admin.php");
            } elseif ($usuario["tipo_usuario"] === "funcionario") {
                header("Location: ../dashboard_funcionario.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        } else {
            $erro = "Email ou senha inválidos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

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
<<<<<<< HEAD
      <h1 id="hs"><a href="../index.php">Red Rush</a></h1>
=======
                <h1 id="hs"><a href="../index.php">Red Rush</a></h1>
>>>>>>> 55e8007e2b674d31c8244e9c0565cce0ad64a142
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
        <br>
        <button id="bot" type="submit">Login</button>
      </form>
    </div>
  </main>

  <footer>

  </footer>
</body>

</html>