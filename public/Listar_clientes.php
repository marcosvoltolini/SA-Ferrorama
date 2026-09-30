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

<h1>Lista de Pratos</h1>

<a href="cadastrar_prato.php">Cadastrar novo prato</a>
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Categoria</th>
        <th>Preço</th>
        <th>Cadastrado por</th>
        <th>Ações</th>
    </tr>

    <?php while ($linha = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td><?php echo $linha["id"]; ?></td>
            <td><?php echo $linha["nome"]; ?></td>
            <td><?php echo $linha["descricao"]; ?></td>
            <td><?php echo $linha["categoria"]; ?></td>
            <td>R$ <?php echo number_format($linha["preco"], 2, ",", "."); ?></td>
            <td><?php echo $linha["nome_usuario"]; ?></td>
            <td>
                <a href="editar.php?id=<?php echo $linha["id"]; ?>">Editar</a>
|
                <a href="excluir.php?id=<?php echo $linha["id"]; ?>"
                    onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
            </td>
        </tr>
    <?php } ?>

</table>

</body>
</html>