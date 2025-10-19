<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location:  ../index.php");
    exit;
}
$usuario_nome = $_SESSION['usuario_nome'] ?? '';

// Carregar o JSON com os destinos
$json_data = file_get_contents('../scripts/destinos.json');
$destinos = json_decode($json_data, true);

// Função para determinar o tipo de viagem baseado no nome/local
function getTipoViagem($nome, $principais_locais) {
    $nome_lower = strtolower($nome);
    $locais_str = strtolower(implode(' ', $principais_locais));
    
    if (strpos($nome_lower, 'praia') !== false || 
        strpos($locais_str, 'praia') !== false ||
        strpos($nome_lower, 'ilhabela') !== false ||
        strpos($nome_lower, 'noronha') !== false ||
        strpos($nome_lower, 'porto') !== false ||
        strpos($nome_lower, 'jericoacoara') !== false ||
        strpos($nome_lower, 'maragogi') !== false ||
        strpos($nome_lower, 'tamandaré') !== false) {
        return 'praia';
    } elseif (strpos($nome_lower, 'chapada') !== false || 
               strpos($nome_lower, 'serra') !== false ||
               strpos($nome_lower, 'cachoeira') !== false ||
               strpos($nome_lower, 'jalapão') !== false ||
               strpos($nome_lower, 'cataratas') !== false ||
               strpos($nome_lower, 'bonito') !== false) {
        return 'aventura';
    } elseif (strpos($nome_lower, 'cristo') !== false || 
               strpos($nome_lower, 'teatro') !== false ||
               strpos($nome_lower, 'museu') !== false ||
               strpos($nome_lower, 'mercado') !== false ||
               strpos($nome_lower, 'manaus') !== false ||
               strpos($nome_lower, 'curitiba') !== false ||
               strpos($nome_lower, 'ouro preto') !== false) {
        return 'cidade';
    } else {
        return 'aventura';
    }
}

// Função para obter imagem padrão baseada no tipo
function getImagemPadrao($tipo, $nome) {
    $imagens = [
        'praia' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'aventura' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'cidade' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'montanha' => 'https://images.unsplash.com/photo-1464822759844-d2d137717a1e?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'romantico' => 'https://images.unsplash.com/photo-1519677100203-a0e668c92439?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80'
    ];
    
    return $imagens[$tipo] ?? $imagens['aventura'];
}

// Selecionar 4 destinos aleatórios
$destinos_aleatorios = [];
$indices_aleatorios = array_rand($destinos, min(4, count($destinos)));

// Garantir que seja um array mesmo quando há apenas 1 elemento
if (!is_array($indices_aleatorios)) {
    $indices_aleatorios = [$indices_aleatorios];
}

foreach ($indices_aleatorios as $indice) {
    $destinos_aleatorios[] = $destinos[$indice];
}

// Gerar descrições curtas baseadas no tipo e características
function gerarDescricaoCurta($destino) {
    $tipo = getTipoViagem($destino['nome'], $destino['principais_locais'] ?? []);
    $cidade = $destino['cidade'];
    $estado = $destino['estado'];
    
    $descricoes = [
        'praia' => [
            "Praias paradisíacas e águas cristalinas em $cidade.",
            "Destino de praia com cenários incríveis no $estado.",
            "Paraíso litorâneo com belas praias em $cidade."
        ],
        'aventura' => [
            "Aventura e natureza exuberante em $cidade.",
            "Para os amantes de ecoturismo e trilhas no $estado.",
            "Cenários naturais deslumbrantes em $cidade."
        ],
        'cidade' => [
            "Cultura, história e gastronomia em $cidade.",
            "Destino urbano com atrações culturais no $estado.",
            "Experiência urbana única em $cidade."
        ]
    ];
    
    $tipo_desc = $tipo;
    if (!isset($descricoes[$tipo])) {
        $tipo_desc = 'aventura';
    }
    
    $opcoes = $descricoes[$tipo_desc];
    return $opcoes[array_rand($opcoes)];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Viagens</title>
    <link rel="stylesheet" href="../styles/home.css" class="css">
</head>
<body>
    <nav class='navbar'>
        <a href="../index.php" class="logo">Triply</a>
        <span>
            <a href="">Inicio</a>
            <a href="sobre.php">Sobre</a>
            <a href="viagens.php">Viagens</a>
            <a href="grupos.php">Grupos</a>
        </span>
        <span>
            <div class="user-dropdown">
                <div class="user-info" onclick="toggleDropdown()">
                    <img src="https://img.icons8.com/?size=100&id=2yC9SZKcXDdX&format=png&color=000000" alt="">
                    <p><?= $usuario_nome?></p>
                    <span class="dropdown-arrow">▼</span>
                </div>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="logout.php" class="dropdown-item logout-item">
                        <img src="https://img.icons8.com/?size=100&id=2444&format=png&color=000000" alt="" class="dropdown-icon">
                        Sair
                    </a>
                </div>
            </div>
        </span>
    </nav>
    <div class='main'>
        <div class="carousel-container">
            <div class="carousel">
                <div class="carousel-images" id="carousel">
                    <img src="../src/saoluis.jpg" alt="Imagem 1">
                    <img src="../src/noronha.jpg" alt="Imagem 2">
                    <img src="../src/balneario.webp" alt="Imagem 3">
                    <img src="../src/gramado.jpg" alt="Imagem 4">
                </div>
            </div>
            <div class="sidebar">
                <h1>PESQUISE O LUGAR IDEAL PARA O SEU GRUPO:</h1>
                <input type="text" placeholder="Digite o destino" id="searchInput">
                <button onclick="searchDestination()">Buscar</button>
            </div>
        </div>

        <div class="sugestoes">
            <div class="sugestoes-text">
                <h1>Destinos Populares</h1>
                <p>Explore os destinos mais buscados do Brasil</p>
                <small><em>Destaques atualizados a cada visita</em></small>
            </div>
            <div class="sugestoes-cards">
                <?php foreach ($destinos_aleatorios as $destino): 
                    if (empty($destino['nome'])) continue;
                    
                    $tipo = getTipoViagem($destino['nome'], $destino['principais_locais'] ?? []);
                    $imagem = !empty($destino['imagem']) ? $destino['imagem'] : getImagemPadrao($tipo, $destino['nome']);
                    $descricao = gerarDescricaoCurta($destino);
                ?>
                <div class="card">
                    <div class="card-img" style="background-image: url('<?= $imagem ?>')"></div>
                    <div class="card-info">
                        <h2><?= htmlspecialchars($destino['nome']) ?></h2>
                        <p><?= $descricao ?></p>
                        <a href="viagem.php?destino=<?= urlencode($destino['nome']) ?>">Saiba mais</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

   <footer>
        <div class="footer-container">
            <div class="footer-logo">
                <h2>Triply</h2>
                <p>Veja, planeje e viaje.</p>
            </div>

            <div class="footer-links">
                <h3>Links rápidos</h3>
                <ul>
                    <li><a href="home.php">Início</a></li>
                    <li><a href="sobre.php">Sobre</a></li>
                    <li><a href="viagens.php">Viagens</a></li>
                    <li><a href="grupos.php">Grupos</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h3>Contato</h3>
                <p>Email: contato@triply.com</p>
                <p>Telefone: (61) 99999-9999</p>
                <p>Endereço: Brasília - DF</p>
            </div>

            <div class="footer-social">
                <h3>Siga nossas redes sociais</h3>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/facebook-new.png"/></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/instagram-new.png"/></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/twitter.png"/></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/youtube-play.png"/></a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Triply. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // Carrossel automático
        let currentIndex = 0;
        const images = document.querySelectorAll('.carousel-images img');
        const totalImages = images.length;

        function showNextImage() {
            currentIndex = (currentIndex + 1) % totalImages;
            updateCarousel();
        }

        function updateCarousel() {
            const carousel = document.getElementById('carousel');
            carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        // Mudar imagem a cada 5 segundos
        setInterval(showNextImage, 5000);

       // Função de busca
        function searchDestination() {
            const searchTerm = document.getElementById('searchInput').value.trim();
            if (searchTerm) {
                window.location.href = 'viagens.php?search=' + encodeURIComponent(searchTerm);
            } else {
                window.location.href = 'viagens.php';
            }
        }

        // Permitir busca com Enter
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchDestination();
            }
        });

        // Dropdown functionality
        function toggleDropdown() {
            const dropdown = document.querySelector('.user-dropdown');
            dropdown.classList.toggle('active');
            
            // Criar overlay para fechar ao clicar fora
            if (dropdown.classList.contains('active')) {
                const overlay = document.createElement('div');
                overlay.className = 'dropdown-overlay';
                overlay.onclick = closeDropdown;
                document.body.appendChild(overlay);
            } else {
                closeDropdown();
            }
        }

        function closeDropdown() {
            const dropdown = document.querySelector('.user-dropdown');
            dropdown.classList.remove('active');
            
            const overlay = document.querySelector('.dropdown-overlay');
            if (overlay) {
                overlay.remove();
            }
        }

        // Fechar dropdown ao pressionar ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDropdown();
            }
        });
    </script>
</body>
</html>