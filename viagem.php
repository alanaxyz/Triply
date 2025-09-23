<?php
    session_start();

    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    } else {
        $email = "";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viagem</title>
    <link rel="stylesheet" href="styles\viagem.css" class="css">
</head>
<body>
    <nav class='navbar'>
        <a href="" class="logo">Triply</a>
        <span>
            <a href="/home.php">Inicio</a>
            <a href="">Sobre</a>
            <a href="">Viagens</a>
            <a href="grupos.php">Grupos</a>
        </span>
        <span>
            <div class="login">
                <img src="https://img.icons8.com/?size=100&id=2yC9SZKcXDdX&format=png&color=000000" alt="">
                <p><?= $email ?></p>
            </div>
        </span>
    </nav>

    <section class="main">
        <div class="main-img">
            <img src="src/balneario.webp" alt="">
            <h1>Balneário Camboriú</h1>
            <p>O destino que une belas praias, vida noturna agitada e um dos maiores complexos de turismo e entretenimento do Brasil.</p>
            <button onclick="window.location.href='grupos.php'">Criar grupo</button>
        </div>
        
        <section class="content">
            <h1>Por que ir para Balneario Camboriu:</h1>
            <div class="card-container">
                <div class="information-card">
                    <img src="https://img.icons8.com/?size=100&id=o0ldnQeFqY58&format=png&color=000000" alt="">
                        <h2> Praias famosas</h2>
                        <p>Balneário Camboriú combina praias lindas, vida noturna agitada e opções de lazer para todos os gostos.</p>
                </div>
                <div class="information-card">
                <img src="https://img.icons8.com/?size=100&id=5BIXAbzEYy1i&format=png&color=000000" alt="">
                    <h2> Atrações turísticas</h2>
                    <p>Balneário Camboriú oferece teleférico, mirantes e passeios que revelam cenários incríveis da cidade.</p>
                </div>
                <div class="information-card">
                    <img src="https://img.icons8.com/?size=100&id=mt9s3gAo1N3S&format=png&color=000000" alt="">
                    <h2> Vida noturna</h2>
                    <p>A cidade é famosa por bares e baladas animadas, garantindo diversão até o amanhecer.</p>
                </div>
            </div>    
        </section>
        
    </section>
    


    <footer>
        <div class="footer-container">
            <!-- Logo / Nome -->
            <div class="footer-logo">
            <h2>Triply</h2>
            <p>Veja, planeje e viaje.</p>
            </div>

            <!-- Links rápidos -->
            <div class="footer-links">
            <h3>Links rápidos</h3>
            <ul>
                <li><a href="#">Início</a></li>
                <li><a href="#">Sobre</a></li>
                <li><a href="#">Serviços</a></li>
                <li><a href="#">Contato</a></li>
            </ul>
            </div>

            <!-- Contato -->
            <div class="footer-contact">
            <h3>Contato</h3>
            <p>Email: contato@triply.com</p>
            <p>Telefone: (61) 99999-9999</p>
            <p>Endereço: Brasília - DF</p>
            </div>

            <!-- Redes sociais -->
            <div class="footer-social">
            <h3>Siga nossas redes sociais</h3>
            <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/facebook-new.png"/></a>
            <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/instagram-new.png"/></a>
            <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/twitter.png"/></a>
            <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/youtube-play.png"/></a>
            </div>
        </div>

        <!-- Direitos autorais -->
        <div class="footer-bottom">
            <p>&copy; 2025 Viagens. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="../script.js"></script>
</body>
</html>