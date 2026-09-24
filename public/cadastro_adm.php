<?php
require_once __DIR__ . "/verifica_admin.php";
require_once __DIR__ . "/../infra/conexao.php";
 
$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome_usuario"] ??  "");
    $email = trim($_POST["email_usuario"] ?? "");
    $senha = $_POST["senha_usuario"] ?? "";
    $senha_confirmada = $_POST["senha_confirmada"] ?? "";   
    $tipo_enviado = $_POST ["tipo_usuario"] ?? "comum";
    $tipo = in_array($tipo_enviado, ["comum", "administrador"], true) ? $tipo_enviado : "comum";
} 

if ($nome === "" || $email ===  "" || $senha === "") {
    $erro = "Preencher todos os campos.";
}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = "Digite email valido.";

}elseif (strlen($senha !== "senha_confirmada")) {
    $erro = "As senhas estão diferentes.";
} else {
    $stmt = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email_usuario = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $erro ="Este email já está cadastrado.";
    }else{ 
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $insert = $conexao-> prepare(
            "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, tipo_usuario) VALUES (?,?,?,?)"
        );
        $insert->bind_param("ssss", $nome, $email, $hash, $tipo);

        if ($insert->execute()){
            $Sucesso = "usuario cadastrado com sucesso como: " . htmlspecialchars($tipo) . ".";
        } else {
            $erro = "Erro ao cadastrar:" . $conexao->error;
        }
        $insert->close();
    }
    $stmt->close();
}
?>
