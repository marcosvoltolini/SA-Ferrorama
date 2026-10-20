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
    <h1>Lista de Trens</h1>

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