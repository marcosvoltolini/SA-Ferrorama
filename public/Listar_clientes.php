<?php
require "../infra/conexao.php";

$sql = "SELECT * FROM usuarios";

$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>lista de usuarios</title>
</head>
<body>

<h1>Lista de usuarios</h1>

<a href="cadastrar_usuario.php">Cadastrar novo usuario</a>
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>email</th>
        <th>senha</th>
    </tr>

    <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td><?php echo $linha["id_usuario"]; ?></td>
            <td><?php echo $linha["nome_usuario"]; ?></td>
            <td><?php echo $linha["email_usuario"]; ?></td>
            <td><?php echo $linha["senha_usuario"]; ?></td>
            <td>
                <a href="excluir.php?id=<?php echo $linha["id_usuario"]; ?>"
                    onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
            </td>
        </tr>
    <?php } ?>

</table>

</body>
</html>