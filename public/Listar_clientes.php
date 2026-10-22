<?php
require "../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$sql = "SELECT * FROM usuarios";

$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>lista de usuarios</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<header>
        <nav class="nave">
            <div class="lg">
            <img class="logo" src="../assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
            </div>
            <div class="red">
            <h1 id="hs">Red Rush</h1>
            </div>
        </nav>
        <nav class="navs">
            <button class="botao"><a id="lk" href="cadastrar_usuario.php">Cadastrar novo cliente</a></button>
            <button class="botao"><a id="lk" href="login.php">Voltar para o home</a></button>
        </nav>
    </header>
<body>

<h1>Lista de usuarios</h1>



<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>email</th>
        <th>Ações</th>
    </tr>

    <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td><?php echo $linha["id_usuario"]; ?></td>
            <td><?php echo $linha["nome_usuario"]; ?></td>
            <td><?php echo $linha["email_usuario"]; ?></td>
            <td>
                <a href="editar_clientes.php?id=<?php echo $linha['id_usuario']; ?>">Editar</a>
                <a href="excluir_clientes.php?id=<?php echo $linha['id_usuario']; ?>" 
                    onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
            </td>
        </tr>
    <?php } ?>

</table>

</body>
</html>
