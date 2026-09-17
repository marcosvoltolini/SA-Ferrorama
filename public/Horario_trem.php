<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red Rush!</title>
    <link rel="stylesheet" href="../assets/style/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <header>
        <nav class="nave">
            <img class="logo" src="../assets/imag/Logo_red_rush.png" alt="Red Rush Logo">
            <h1 id="hs"><a href="../index.php">Red Rush</a></h1>
            <span id="burguer" class="material-icons">menu</span>
        </nav>
        <nav class="navs">
            <button class="botao"><a id="lk" href="public/Rota_trem.php">Rota dos trens</a></button>
            <button class="botao"><a id="lk" href="public/Horario_trem.php">Trens disponiveis</a></button>
        </nav>
    </header>

    <main>
    <div class= "bensgrand">
            <div class= "bens">
            <img  src="../assets/imag/jacobite.png" alt="jacobite">
            <h1 class= fanfas>Jacobite</h1>
            <h4>07:30</h4>          
    </div>
            <div class= "bens">
                <img src="../assets/imag/Rocky.png" alt="rocky">
                <h1 class= fanfas>Rocky</h1>
                <h4>08:00</h4>
            </div>

            <div class= bens>
                <img src="../assets/imag/orient.png" alt="orinet">
                <h5 class= fanfas>Venice Simplon-Orient-Express</h5>
                <h4>09:20</h4>

            </div>

            <div class= "bens">
                <img src="../assets/imag/bernina.png" alt="bernina">
                <h3 class= fanfas>Bernina Express</h3>
                <h4>07:20</h4>
            </div>
   
        
    </main>

    <footer>

    </footer>
</body>

</html>
