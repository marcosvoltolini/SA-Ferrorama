<?php
require_once 'conexao.php';

try {
    // Consulta os dados da tabela 'usuarios' do banco 'sa_ferrorama'
    $stmt = $pdo->query('SELECT * FROM usuarios');
    $usuarios = $stmt->fetchAll();
} catch (\PDOException $e) {
    echo "Erro ao consultar o banco de dados: " . $e->getMessage();
    exit;
}
?>




<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Lista de Usuários</title>
  <!-- Importação do CSS externo -->
  <link rel="stylesheet" href="estilos.css">
</head>
<body>

  <h1>Usuários Cadastrados</h1>

  <?php if (empty($usuarios)): ?>
    <p>Nenhum usuário encontrado.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Data de Cadastro</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop para percorrer cada usuário do banco -->
        <?php foreach ($usuarios as $usuario): ?>
          <tr>
            <td><?= htmlspecialchars($usuario['id']) ?></td>
            <td><?= htmlspecialchars($usuario['nome']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td><?= date('d/m/Y', strtotime($usuario['data_cadastro'])) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

</body>
</html>