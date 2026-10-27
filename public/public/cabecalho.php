<?php
$tipo_logado = $_SESSION["tipo_usuario"] ?? "";

if ($tipo_logado === "administrador") {
    $home = "../dashboard_admin.php";
} elseif ($tipo_logado === "funcionario") {
    $home = "../dashboard_funcionario.php";
} else {
    $home = "../dashboard_comum.php";
}
?>
<header>
    <nav class="nave">
        <div class="lg">
            <img class="logo" src="../assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
        </div>
        <div class="red">
            <h1 id="hs"><a href="../index.php">Red Rush</a></h1>
        </div>
    </nav>
    <nav class="navs">
        <a id="lk" href="<?= $home ?>">Início</a>
        <a id="lk" href="Listar_trens.php">Trens</a>
        <a id="lk" href="Listar_rotas.php">Rotas</a>
        <a id="lk" href="Horario_trem.php">Horários</a>
        <?php if ($tipo_logado !== "comum") { ?>
            <a id="lk" href="Listar_sensor.php">Sensores</a>
            <a id="lk" href="Listar_clientes.php"><?= $tipo_logado === "administrador" ? "Usuários" : "Clientes" ?></a>
        <?php } ?>
        <a id="lk" href="logout.php">Sair</a>
    </nav>
</header>

<?php if (isset($_SESSION["msg"])) { ?>
    <p style="color: <?= $_SESSION["cor"] ?>"><?= htmlspecialchars($_SESSION["msg"]) ?></p>
    <?php unset($_SESSION["msg"]); unset($_SESSION["cor"]); ?>
<?php } ?>
