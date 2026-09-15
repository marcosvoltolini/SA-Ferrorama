<?php
require '../conexao.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $tipo = intval($_POST['tipo'] ?? 0);

    if ($nome === '' || $tipo === 0) {
        $mensagem = '<p style="color:red;">Preencha o nome e selecione um tipo de sensor.</p>';
    } else {
        $stmt = $conn->prepare("INSERT INTO sensores (nome, tipo) VALUES (?, ?)");
        $stmt->bind_param("si", $nome, $tipo);

        if ($stmt->execute()) {
            $mensagem = '<p style="color:green;">Sensor adicionado com sucesso!</p>';
        } else {
            $mensagem = '<p style="color:red;">Erro ao adicionar sensor: ' . htmlspecialchars($stmt->error) . '</p>';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensores</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
</head>

<body>
    <header>

    </header>

    <main>
        <div class="flex">
            <div class="dash">
                <div class="coisa">
                    <div class="bmv">
                        <h3>Bem vindo ADM </h3>
                        <img id="icon" src="../assets/imag/person2.webp" alt="Person">
                    </div>

                    <div class="board">
                        <div class="dsh">
                            <ol>Dashboard 1</ol>
                        </div>

                        <div class="dsh">
                            <ol>Dashboard 2</ol>
                        </div>

                        <div class="dsh">
                            <ol>Dashboard 3</ol>
                        </div>

                        <div class="dsh">
                            <ol>Dashboard