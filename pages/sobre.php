<?php
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../index.php");
        exit;
    }
    $usuario_nome = $_SESSION['usuario_nome'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/sobre.css">
    <title>Sobre - Triply</title>
    
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
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Sobre o Triply</h1>
            <p>Revolucionando a forma como amigos planejam viagens juntos</p>
        </div>
    </section>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <div class="container">
           
            <section class="section">
                <div class="section-header">
                    <h2 class="section-title">Nossa História</h2>
                    <p class="section-subtitle">Como começamos nossa jornada para transformar o planejamento de viagens em grupo</p>
                </div>
                <div class="cards-grid">
                    <div class="card">
                        <div class="card-icon">🚀</div>
                        <h3 class="card-title">O Início</h3>
                        <p>Nascemos da necessidade de organizar viagens entre amigos de forma simples e colaborativa, eliminando a complexidade do planejamento tradicional.</p>
                    </div>
                    <div class="card">
                        <div class="card-icon">💡</div>
                        <h3 class="card-title">A Ideia</h3>
                        <p>Percebemos que cada viagem em grupo era uma oportunidade de criar memórias, mas o planejamento muitas vezes atrapalhava a experiência.</p>
                    </div>
                    <div class="card">
                        <div class="card-icon">🌍</div>
                        <h3 class="card-title">A Solução</h3>
                        <p>Criamos uma plataforma que une pessoas através de experiências de viagem bem planejadas e compartilhadas.</p>
                    </div>
                </div>
            </section>

          
            <section class="section">
                <div class="section-header">
                    <h2 class="section-title">Missão e Visão</h2>
                    <p class="section-subtitle">O que nos move e para onde estamos indo</p>
                </div>
                <div class="mission-vision">
                    <div class="mission-card">
                        <h3>Nossa Missão</h3>
                        <p>Facilitar o planejamento colaborativo de viagens entre amigos e familiares, tornando cada experiência memorável através da organização compartilhada e do controle financeiro transparente. Queremos eliminar as barreiras que impedem as pessoas de viajarem juntas.</p>
                    </div>
                    <div class="vision-card">
                        <h3>Nossa Visão</h3>
                        <p>Ser a plataforma líder em planejamento de viagens colaborativas no Brasil, conectando pessoas através de aventuras memoráveis e bem organizadas. Almejamos criar uma comunidade onde cada viagem seja uma oportunidade de fortalecer laços e criar histórias incríveis.</p>
                    </div>
                </div>
            </section>

           
            <section class="section">
                <div class="section-header">
                    <h2 class="section-title">O Que Oferecemos</h2>
                    <p class="section-subtitle">Recursos pensados para simplificar suas viagens em grupo</p>
                </div>
                <div class="cards-grid">
                    <div class="card">
                        <div class="card-icon">👥</div>
                        <h3 class="card-title">Grupos Colaborativos</h3>
                        <p>Crie grupos privados e convide amigos para planejar juntos cada detalhe da viagem.</p>
                    </div>
                    <div class="card">
                        <div class="card-icon">💰</div>
                        <h3 class="card-title">Controle Financeiro</h3>
                        <p>Acompanhe e gerencie os gastos do grupo com nosso sistema de cofre compartilhado.</p>
                    </div>
                    <div class="card">
                        <div class="card-icon">🏨</div>
                        <h3 class="card-title">Sugestões Inteligentes</h3>
                        <p>Receba recomendações personalizadas de destinos, hospedagens e atividades.</p>
                    </div>
                </div>
            </section

           
            <section class="section">
                <div class="section-header">
                    <h2 class="section-title">Fale Conosco</h2>
                    <p class="section-subtitle">Estamos aqui para ajudar a tornar suas viagens inesquecíveis</p>
                </div>
                <div class="contact-grid">
                    <div class="contact-item">
                        <div class="contact-icon">📧</div>
                        <h3>Email</h3>
                        <p>contato@triply.com</p>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <h3>Telefone</h3>
                        <p>(61) 99999-9999</p>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <h3>Endereço</h3>
                        <p>Brasília - DF, Brasil</p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
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
                <h3>Redes sociais</h3>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/facebook.png" alt="Facebook"></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/instagram.png" alt="Instagram"></a>
                <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/twitter.png" alt="Twitter"></a>
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