<?php
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
    header("Location:  ../index.php");
    exit;
}
    $usuario_nome = $_SESSION['usuario_nome'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/grupo.css">
    <title>Criar Grupo</title>
</head>
<body>
     <nav class='navbar'>
        <a href="../index.php" class="logo">Triply</a>
        <span>
            <a href="home.php">Inicio</a>
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

    <!-- Cabeçalho do Grupo -->
    <div class="group-header">
        <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80" alt="Balneário Camboriú" class="group-header-image">
        <div class="group-header-content">
            <h1 class="group-title">Balneário Camboriú</h1>
            <p class="group-subtitle">Próxima viagem: 15 a 22 de Dezembro de 2025</p>
            <div class="group-stats">
                <div class="stat-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.01 2.01 0 0 0 18.06 7h-1.24c-.77 0-1.47.46-1.79 1.17L12.5 13H10v-2c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1v2H2v6h6v-2h2v2h10zm-6-2H8v-4h2v4zm-7-9c0-.55.45-1 1-1h3c.55 0 1 .45 1 1v3H7v-3z"/>
                    </svg>
                    <span>5/8 membros</span>
                </div>
                <div class="stat-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C13.1 2 14 2.9 14 4s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm-2 18c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm-12 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm12 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm-6 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm-6 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                    </svg>
                    <span>Meta: R$ 2.500,00</span>
                </div>
                <div class="stat-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                    <span>120 dias restantes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <div class="container">
            <div class="content-grid">
                <!-- Coluna principal -->
                <div class="main-column">
                    <!-- Progresso do Cofre -->
                    <div class="section">
                        <h2 class="section-title">
                            Progresso do Cofre
                            <button>Contribuir</button>
                        </h2>
                        <div class="progress-container">
                            <div class="progress-info">
                                <span>Arrecadado: R$ 1.200,00</span>
                                <span>Meta: R$ 2.500,00</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 48%"></div>
                            </div>
                            <div class="progress-percentage">48% concluído</div>
                        </div>
                        <p>Última contribuição: Alana - R$ 200,00 (há 3 dias)</p>
                    </div>
                    
                    <!-- Membros do Grupo -->
                    <div class="section">
                        <h2 class="section-title">
                            Membros do Grupo
                            <button>Convidar</button>
                        </h2>
                        <div class="members-grid">
                            <!-- Membro 1 -->
                            <div class="member-card">
                                <img src="https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000" alt="João Silva" class="member-avatar">
                                <div class="member-name">Alana</div>
                                <div class="member-role admin">Administrador</div>
                            </div>
                            
                            <!-- Membro 2 -->
                            <div class="member-card">
                                <img src="https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000" alt="Maria Santos" class="member-avatar">
                                <div class="member-name">Jennefer</div>
                                <div class="member-role">Membro</div>
                            </div>
                            
                            <!-- Membro 3 -->
                            <div class="member-card">
                                <img src="https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000" alt="Pedro Oliveira" class="member-avatar">
                                <div class="member-name">Artur</div>
                                <div class="member-role">Membro</div>
                            </div>
                            
                            <!-- Membro 4 -->
                            <div class="member-card">
                                <img src="https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000" alt="Ana Costa" class="member-avatar">
                                <div class="member-name">Vinicius</div>
                                <div class="member-role">Membro</div>
                            </div>
                            
                            <!-- Membro 5 -->
                            <div class="member-card">
                                <img src="https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000" alt="Carlos Lima" class="member-avatar">
                                <div class="member-name">Luiz</div>
                                <div class="member-role">Membro</div>
                            </div>
                            
                            <!-- Espaço vazio para novos membros -->
                            <div class="member-card" style="background-color: var(--light-gray); opacity: 0.7;">
                                <div style="width: 60px; height: 60px; border-radius: 50%; background-color: var(--gray); margin: 0 auto 10px; display: flex; align-items: center; justify-content: center;">
                                    <svg viewBox="0 0 24 24" width="30" height="30" fill="white">
                                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                    </svg>
                                </div>
                                <div style="font-weight: 600;">Vaga disponível</div>
                                <div style="font-size: 12px; color: var(--gray);">Convide alguém</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Atividades Recentes -->
                    <div class="section">
                        <h2 class="section-title">Atividades Recentes</h2>
                        <ul class="activity-list">
                            <li class="activity-item">
                                <img src="https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000" alt="João Silva" class="activity-avatar">
                                <div class="activity-content">
                                    <div class="activity-text"><strong>Alana</strong> adicionou R$ 200,00 ao cofre do grupo</div>
                                    <div class="activity-time">há 3 dias</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <img src="https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000" alt="Maria Santos" class="activity-avatar">
                                <div class="activity-content">
                                    <div class="activity-text"><strong>Jennefer</strong> sugeriu um novo restaurante para o roteiro</div>
                                    <div class="activity-time">há 5 dias</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <img src="https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000" alt="Pedro Oliveira" class="activity-avatar">
                                <div class="activity-content">
                                    <div class="activity-text"><strong>Artur</strong> confirmou presença na viagem</div>
                                    <div class="activity-time">há 1 semana</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <img src="https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000" alt="Ana Costa" class="activity-avatar">
                                <div class="activity-content">
                                    <div class="activity-text"><strong>Luiz</strong> compartilhou fotos de hospedagens</div>
                                    <div class="activity-time">há 1 semana</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Coluna lateral -->
                <div class="sidebar">
                    <!-- Informações do Grupo -->
                    <div class="section">
                        <h2 class="section-title">Informações do Grupo</h2>
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">Destino:</span>
                                <span class="info-value">Balneário Camboriú, SC</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Data da Viagem:</span>
                                <span class="info-value">15 a 22 de Dez/2025</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Código do Grupo:</span>
                                <span class="info-value">A7B9C</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Criado em:</span>
                                <span class="info-value">15 de Março de 2025</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Status:</span>
                                <span class="info-value" style="color: var(--secondary); font-weight: 600;">Ativo</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Ações Rápidas -->
                    <div class="section">
                        <h2 class="section-title">Ações Rápidas</h2>
                        <div class="action-buttons">
                            <button class="btn-large btn-primary">Adicionar ao Cofre</button>
                            <button class="btn-large btn-secondary">Sugerir Atividade</button>
                            <button class="btn-large btn-outline">Compartilhar Grupo</button>
                            <button class="btn-large btn-outline">Configurações</button>
                        </div>
                    </div>
                    
                    <!-- Próximos Passos -->
                    <div class="section">
                        <h2 class="section-title">Próximos Passos</h2>
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">Definir hospedagem:</span>
                                <span class="info-value">Pendente</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Comprar passagens:</span>
                                <span class="info-value">30 dias</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Alugar carro:</span>
                                <span class="info-value">60 dias</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
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

    <script>
        // Aqui você pode adicionar interatividade específica para a página de detalhes
        document.addEventListener('DOMContentLoaded', function() {
            // Exemplo: Atualizar progresso em tempo real
            const progressFill = document.querySelector('.progress-fill');
            const progressPercentage = document.querySelector('.progress-percentage');
            
            // Simulação de atualização de progresso (em uma aplicação real, isso viria do backend)
            function updateProgress(value, total) {
                const percentage = Math.round((value / total) * 100);
                progressFill.style.width = `${percentage}%`;
                progressPercentage.textContent = `${percentage}% concluído`;
            }
            
            // Inicializar com valores atuais
            updateProgress(1200, 2500);
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