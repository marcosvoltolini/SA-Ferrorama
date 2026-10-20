<?php   
require "../infra/conexao.php";
require_once __DIR__ . "/verifica_acesso.php";

$dwl = "SELECT * FROM trens";
$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de trens</title>
</head>
<body>  

<h1>Lista de trens</h1> 

<a href ="cadastrar_trens.php">Cadstrar novo trem</a>
<br><br>    

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>tipo</th>
        <th>ações</th>
        </tr>

    <?php while ($linha = mysqli_fetch_assoc($resultado))  ?>
    
        <tr>
            <td><?php echo $linha["id"]; ?></td>
            <td><?php echo $linha["nome"]; ?></td>
            <td><?php echo $linha["tipo"]; ?></td>
            <td>
                <a href="excluir_trens.php?id=<?php echo $linha['id']; ?>" 
                    onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
            </td>
        </tr>