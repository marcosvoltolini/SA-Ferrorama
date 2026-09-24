<?php
require_once __DIR__ . "/verifica_admin.php";
require_once __DIR__ . "/../infra/conexao.php.php";

$erro = "";
$sucesso = "";


if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $nome = trim($_POST["nome_usuario"] ?? "");
    $email = trim($_POST["email_usuario"] ?? "");
    $senha = $_POST["senha_usuario"] ?? "";
    $senha_corfirma = $_POST["senha_confirma"] ?? "";
    $tipo_enviado = $_POST["tipo_usuario"] ?? "comum";
    $tipo = in_array($tipo_enviado, ["comum", "administrador"], true) ? $tipo_enviado : "comum";

    if ($nome === "" || $email === "" || $senha === ""){
        $erro = "Preencher todos os campos";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Digite email válido.";
    } elseif(strlen($senha) < 6) {
        $erro = "Senha tem menos de 6 caracteres.";
    } elseif($senha !== $senha_corfirma) {
        $erro = "Senhas diferentes.";
    } else {
        $stmt = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email_usuario =?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0){
            $erro = "Este email já é cadastrado";
        }else{
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $insert = $conexao->prepare(
                "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, tipo_usuario)VALUES (?,?,?,?)"
            );
            $insert->bind_param("ssss", $nome, $email, $hash, $tipo);

            if($insert->execute()) {
                $sucesso = "Usuario cadastrado com sucesso";
            }else {
                $erro = "Erro ao cadastrar: " . $conexao->error;
            }
            $insert->close();
        }
        $stmt->close();
    }
}
?>
