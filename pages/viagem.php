<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['token'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_COOKIE['auth_token'])) {
    $cookie_token = $_COOKIE['auth_token'];

    // Verificar se o token da sessão está configurado
    if (isset($_SESSION['token'])) {
        $session_token = $_SESSION['token'];

        // Validar se o token do cookie corresponde ao token da sessão
        if ($cookie_token === $session_token) {
            // O token é válido, o usuário está autenticado
            $response = json_encode(['status' => 'success', 'message' => 'Autenticado com sucesso']);
        } else {
            // O token não corresponde
            echo "Erro: Token inválido!";
            header("Location: login.php");
            exit;
        }
    } else {
        // Nenhum token de sessão configurado
        echo "Erro: Nenhum token de sessão encontrado!";
        header("Location: login.php");
        exit;
    }
} else {
    // Nenhum cookie de autenticação encontrado
    echo "Erro: Cookie de autenticação não encontrado!";
    header("Location: login.php");
    exit;
}
echo "<script>console.log('Resposta do servidor: ', $response);</script>";
$usuario_nome = $_SESSION['usuario_nome'] ?? '';

// Carregar o JSON com os destinos
$json_data = file_get_contents('../scripts/destinos.json');
$destinos = json_decode($json_data, true);

// Verificar se o parâmetro destino foi passado
if (!isset($_GET['destino'])) {
    header("Location: viagens.php");
    exit;
}

$destino_nome = $_GET['destino'];
$destino_encontrado = null;

// Buscar o destino no JSON
foreach ($destinos as $destino) {
    if ($destino['nome'] === $destino_nome) {
        $destino_encontrado = $destino;
        break;
    }
}

// Se não encontrar o destino, redirecionar
if (!$destino_encontrado) {
    header("Location: viagens.php");
    exit;
}

// Funções auxiliares (as mesmas da página viagens.php)
function getTipoViagem($nome, $principais_locais)
{
    $nome_lower = strtolower($nome);
    $locais_str = strtolower(implode(' ', $principais_locais));

    if (
        strpos($nome_lower, 'praia') !== false ||
        strpos($locais_str, 'praia') !== false ||
        strpos($nome_lower, 'ilhabela') !== false ||
        strpos($nome_lower, 'noronha') !== false ||
        strpos($nome_lower, 'porto') !== false ||
        strpos($nome_lower, 'jericoacoara') !== false ||
        strpos($nome_lower, 'maragogi') !== false ||
        strpos($nome_lower, 'tamandaré') !== false
    ) {
        return 'praia';
    } elseif (
        strpos($nome_lower, 'chapada') !== false ||
        strpos($nome_lower, 'serra') !== false ||
        strpos($nome_lower, 'cachoeira') !== false ||
        strpos($nome_lower, 'jalapão') !== false ||
        strpos($nome_lower, 'cataratas') !== false ||
        strpos($nome_lower, 'bonito') !== false
    ) {
        return 'aventura';
    } elseif (
        strpos($nome_lower, 'cristo') !== false ||
        strpos($nome_lower, 'teatro') !== false ||
        strpos($nome_lower, 'museu') !== false ||
        strpos($nome_lower, 'mercado') !== false ||
        strpos($nome_lower, 'manaus') !== false ||
        strpos($nome_lower, 'curitiba') !== false ||
        strpos($nome_lower, 'ouro preto') !== false
    ) {
        return 'cidade';
    } else {
        return 'aventura';
    }
}

function getPrecoMedio($nome)
{
    $precos = [
        'Fernando de Noronha' => 3500,
        'Jericoacoara' => 2800,
        'Bonito' => 2200,
        'Chapada dos Veadeiros' => 800,
        'Lençóis Maranhenses' => 1500,
        'Cataratas do Iguaçu' => 1800,
        'Balneário Camboriú' => 1800,
        'Rio de Janeiro' => 2000,
        'Florianópolis' => 1600,
        'Gramado' => 1900,
        'Porto de Galinhas' => 1700,
        'Manaus' => 1400,
        'Chapada Diamantina' => 900,
        'Jalapão' => 1100
    ];

    return isset($precos[$nome]) ? $precos[$nome] : 1200;
}

function getDuracao($nome)
{
    $duracoes = [
        'Fernando de Noronha' => 7,
        'Jericoacoara' => 5,
        'Bonito' => 4,
        'Chapada dos Veadeiros' => 4,
        'Lençóis Maranhenses' => 5,
        'Cataratas do Iguaçu' => 3,
        'Rio de Janeiro' => 5,
        'Florianópolis' => 6,
        'Gramado' => 4,
        'Porto de Galinhas' => 5,
        'Manaus' => 5,
        'Chapada Diamantina' => 5,
        'Jalapão' => 4
    ];

    return isset($duracoes[$nome]) ? $duracoes[$nome] : 5;
}

function getImagemPadrao($tipo, $nome)
{
    $imagens = [
        'praia' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'aventura' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'cidade' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'montanha' => 'https://images.unsplash.com/photo-1464822759844-d2d137717a1e?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
        'romantico' => 'https://images.unsplash.com/photo-1519677100203-a0e668c92439?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80'
    ];

    return $imagens[$tipo] ?? $imagens['aventura'];
}

// Dados do destino
$tipo = getTipoViagem($destino_encontrado['nome'], $destino_encontrado['principais_locais'] ?? []);
$preco = getPrecoMedio($destino_encontrado['nome']);
$duracao = getDuracao($destino_encontrado['nome']);
$imagem = !empty($destino_encontrado['imagem']) ? $destino_encontrado['imagem'] : getImagemPadrao($tipo, $destino_encontrado['nome']);

// Descrição baseada nas informações disponíveis
$num_atracoes = count($destino_encontrado['principais_locais'] ?? []);
$num_hospedagens = count($destino_encontrado['hospedagens'] ?? []);

if ($num_atracoes > 0 && $num_hospedagens > 0) {
    $descricao = "Explore {$num_atracoes} atrações incríveis com {$num_hospedagens} opções de hospedagem em " . $destino_encontrado['cidade'] . ".";
} elseif ($num_atracoes > 0) {
    $descricao = "Descubra {$num_atracoes} atrações imperdíveis em " . $destino_encontrado['cidade'] . ".";
} else {
    $descricao = "Destino maravilhoso em " . $destino_encontrado['cidade'] . " aguardando sua visita.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($destino_encontrado['nome']) ?> - Triply</title>
    <link rel="stylesheet" href="../styles/viagem.css" class="css">
</head>

<body>
    <nav class='navbar'>
        <a href="home.php" class="logo">Triply</a>

        <!-- Menu Hamburger para Mobile -->
        <div class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Links de Navegação -->
        <div class="nav-links" id="navLinks">
            <span class="nav-main-links">
                <a href="home.php">Inicio</a>
                <a href="sobre.php">Sobre</a>
                <a href="viagens.php">Viagens</a>
                <a href="grupos.php">Grupos</a>
            </span>

        </div>
        <div class="nav-links" id="navLinks">
            <span class="nav-user-section">
                <div class="user-dropdown">
                    <div class="user-info" onclick="toggleDropdown()">
                        <img src="https://img.icons8.com/?size=100&id=2yC9SZKcXDdX&format=png&color=000000" alt="">
                        <p><?= htmlspecialchars($usuario_nome) ?></p>
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
        </div>
    </nav>

    <section class="main">
        <div class="main-hero">
            <div class="hero-image">
                <img src="<?= $imagem ?>" alt="<?= htmlspecialchars($destino_encontrado['nome']) ?>">
                <div class="hero-content">
                    <h1><?= htmlspecialchars($destino_encontrado['nome']) ?></h1>
                    <p><?= $descricao ?></p>
                    <div class="hero-details">
                        <span class="detail-badge">
                            <img src="https://img.icons8.com/?size=100&id=34&format=png&color=000000" alt="Tipo">
                            <?= ucfirst($tipo) ?>
                        </span>
                        <span class="detail-badge">
                            <img src="https://img.icons8.com/?size=100&id=7165&format=png&color=000000" alt="Duração">
                            <?= $duracao ?> dias
                        </span>
                        <span class="detail-badge">
                            <img src="https://img.icons8.com/?size=100&id=WTANjzga8hWT&format=png&color=000000" alt="Hospedagens">
                            <?= $num_hospedagens ?>+ Hospedagens
                        </span>
                    </div>
                    <div class="hero-actions">
                        <button onclick="createGroup('<?= htmlspecialchars($destino_encontrado['nome']) ?>')">Criar grupo</button>
                        <button onclick="window.location.href='viagens.php'" class="btn-secondary">Voltar</button>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <h1>Por que ir para <?= htmlspecialchars($destino_encontrado['nome']) ?>:</h1>

            <div class="card-container">
                <?php if ($num_atracoes > 0): ?>
                    <div class="information-card">
                        <img src="https://img.icons8.com/?size=100&id=E32iY1r0TxnO&format=png&color=000000" alt="Atrações">
                        <h2>Atrações turísticas</h2>
                        <p>Descubra <?= $num_atracoes ?> locais incríveis para visitar, incluindo <?= implode(', ', array_slice($destino_encontrado['principais_locais'], 0, 3)) ?> e muito mais.</p>
                    </div>
                <?php endif; ?>

                <?php if ($num_hospedagens > 0): ?>
                    <div class="information-card">
                        <img src="https://img.icons8.com/?size=100&id=WTANjzga8hWT&format=png&color=000000" alt="Hospedagens">
                        <h2>Opções de hospedagem</h2>
                        <p>Encontre <?= $num_hospedagens ?>+ opções de hospedagem para todos os gostos e orçamentos.</p>
                    </div>
                <?php endif; ?>

                <div class="information-card">
                    <img src="https://img.icons8.com/?size=100&id=7165&format=png&color=000000" alt="Duração">
                    <h2>Duração ideal</h2>
                    <p>Recomendamos <?= $duracao ?> dias para aproveitar tudo que <?= htmlspecialchars($destino_encontrado['nome']) ?> tem a oferecer.</p>
                </div>

                <div class="information-card">
                    <img src="https://img.icons8.com/?size=100&id=11291&format=png&color=000000" alt="Preço">
                    <h2>Investimento</h2>
                    <p>Preço médio por pessoa: R$ <?= number_format($preco, 0, ',', '.') ?> para <?= $duracao ?> dias de viagem.</p>
                </div>
            </div>

            <?php if (!empty($destino_encontrado['principais_locais'])): ?>
                <div class="attractions-section">
                    <h2>Principais Atrações</h2>
                    <div class="attractions-list">
                        <?php
                        $atracoes_limitadas = array_slice($destino_encontrado['principais_locais'], 0, 3);
                        foreach ($atracoes_limitadas as $atracao): ?>
                            <div class="attraction-item">
                                <img src="https://img.icons8.com/?size=100&id=59878&format=png&color=000000" alt="Atração">
                                <span><?= htmlspecialchars($atracao) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($destino_encontrado['principais_locais']) > 3): ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($destino_encontrado['hospedagens'])): ?>
                <div class="accommodation-section">
                    <h2>Opções de Hospedagem</h2>
                    <div class="accommodation-list">
                        <?php
                        $hospedagens_limitadas = array_slice($destino_encontrado['hospedagens'], 0, 3);
                        foreach ($hospedagens_limitadas as $hospedagem): ?>
                            <div class="accommodation-item">
                                <img src="https://img.icons8.com/?size=100&id=59878&format=png&color=000000" alt="Hospedagem">
                                <span><?= htmlspecialchars($hospedagem) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($destino_encontrado['hospedagens']) > 3): ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </section>
    </section>

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
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/facebook-new.png" /></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/instagram-new.png" /></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/twitter.png" /></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/ffffff/youtube-play.png" /></a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Triply. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        const mobileOverlay = document.createElement('div');


        mobileOverlay.className = 'mobile-overlay';
        document.body.appendChild(mobileOverlay);
        menuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            mobileOverlay.classList.toggle('active');
            document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
        });

        mobileOverlay.addEventListener('click', function() {
            navLinks.classList.remove('active');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Fechar menu ao clicar em um link (mobile)
        const navLinksItems = document.querySelectorAll('.nav-main-links a');
        navLinksItems.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    navLinks.classList.remove('active');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        // Dropdown functionality (atualizada)
        function toggleDropdown() {
            const dropdown = document.querySelector('.user-dropdown');
            dropdown.classList.toggle('active');

            if (window.innerWidth <= 768) {
                // No mobile, o dropdown fica sempre visível quando ativo
                return;
            }

            // Para desktop - comportamento original
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
                if (window.innerWidth <= 768) {
                    navLinks.classList.remove('active');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            }
        });

        // Fechar menu ao redimensionar a janela para desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                navLinks.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        function createGroup(destinationName) {
            window.location.href = 'grupos.php';
        }
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
    <script src="../scripts/script.js"></script>
</body>

</html>