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
    <title>Site de Viagens</title>
    <link rel="stylesheet" href="styles\home.css" class="css">
</head>
<body>
    <nav class='navbar'>
        <a href="" class="logo">Triply</a>
        <span>
            <a href="">Inicio</a>
            <a href="">Sobre</a>
            <a href="">Viagens</a>
            <a href="">Grupos</a>
        </span>
        <span>
            <div class="login">
                <img src="https://img.icons8.com/?size=100&id=2yC9SZKcXDdX&format=png&color=000000" alt="">
                <p><?= $email ?></p>
            </div>
        </span>
    </nav>
    <div class='main'>
        <div class="carousel-container">
            <div class="carousel">
                <div class="carousel-images" id="carousel">
                    <img src="src\noronha.jpg" alt="Imagem 1">
                    <img src="src\saoluis.jpg" alt="Imagem 2">
                    <img src="src\balneario.webp" alt="Imagem 3">
                    <img src="src\gramado.jpg" alt="Imagem 4">
                </div>
            </div>
            <div class="sidebar">
                <h1>PESQUISE O LUGAR IDEAL PARA O SEU GRUPO:</h1>
                <input type="text" placeholder="Digite o destino"></input>
            </div>
        </div>

        <div class="sugestoes">
            <div class="sugestoes-text">
                <h1>Destinos Populares </h1>
                <p>Explore os destinos mais buscados do Brasil</p>
            </div>
            <div class="sugestoes-cards">
                <div class="card">
                    <h2>Balneario Camboriu </h2>
                    <div class="card-img card-img-1"></div>
                    <div class="card-info">
                        <p>Praias animadas e vida noturna agitada <br>na costa catarinense.</p>
                        <a href="/viagem.php">Saiba mais</a>
                    </div>
                </div>
                <div class="card">
                    <h2>Fernando de Noronha </h2>
                    <div class="card-img card-img-2"></div>
                    <div class="card-info">
                        <p>O paraíso das praias cristalinas e mergulhos incríveis.</p>
                       
                        <a href="/viagem.php">Saiba mais</a>
                    </div>
                </div>
                <div class="card">
                    <h2>Gramado</h2>
                    <div class="card-img card-img-3"></div>
                    <div class="card-info">
                        <p>O charme europeu com gastronomia e atrações encantadoras.</p>
                     
                        <a href="/viagem.php">Saiba mais</a>
                    </div>
                </div>
                <div class="card">
                    <h2>São Luís </h2>
                    <div class="card-img card-img-4"></div>
                    <div class="card-info">
                        <p>A capital histórica com cultura vibrante e sabores do Maranhão.</p>
                        <a href="/viagem.php">Saiba mais</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

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
            <p>Telefone: (61) 99999-97604</p>
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

<script src="script.js"></script>
</body>
</html>