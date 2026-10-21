<?php

require "../infra/conexao.php";

$id = $_POST["id"];
$nome = $_POST["nome"];
$tipo = $_POST["tipo"];

$sql = "UPDATE trens SET nome='$nome',tipo='$tipo' WHERE id = '$id'";

mysqli_query($conexao, $sql);
header("Location: listar_trens.php");