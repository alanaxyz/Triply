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
    <link rel="stylesheet" href="./styles/grupos.css">
    <title>Grupos</title>
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


    <!-- Conteúdo Principal -->
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>Seus Grupos de Viagem</h1>
                <p>Junte-se a grupos existentes ou crie o seu próprio para planejar sua próxima aventura com amigos</p>
            </div>
            
            <!-- Estado sem grupos (ativo por padrão) -->
            <div id="emptyState" class="state-container active">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9h10v2H7z"/>
                        </svg>
                    </div>
                    <h2>Você ainda não está em nenhum grupo</h2>
                    <p>Junte-se a um grupo existente usando um código de convite ou crie um novo grupo para começar a planejar sua viagem.</p>
                    
                    <div class="code-input-section">
                        <h3>Entrar em um grupo existente</h3>
                        <div class="code-inputs">
                            <input type="text" maxlength="1" id="code1" oninput="moveFocus(1)">
                            <input type="text" maxlength="1" id="code2" oninput="moveFocus(2)">
                            <input type="text" maxlength="1" id="code3" oninput="moveFocus(3)">
                            <input type="text" maxlength="1" id="code4" oninput="moveFocus(4)">
                            <input type="text" maxlength="1" id="code5" oninput="moveFocus(5)">
                        </div>
                        <button class="join-btn" onclick="joinGroup()">Entrar no Grupo</button>
                        <p class="hint">Digite o código de 5 letras que você recebeu</p>
                    </div>
                    
                    <div class="divider">
                        <span>ou</span>
                    </div>
                    
                    <button class="create-group-btn" onclick="createGroup()">Criar Novo Grupo</button>
                </div>
            </div>
            
            <!-- Estado com grupos (inicialmente oculto) -->
            <div id="groupsState" class="state-container">
                <div class="groups-grid">
                    <!-- Grupo 1 -->
                    <div class="group-card">
                        <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Balneário Camboriú" class="group-image">
                        <div class="group-content">
                            <div class="group-header">
                                <div>
                                    <h3 class="group-title">Balneário Camboriú</h3>
                                    <div class="group-members">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.01 2.01 0 0 0 18.06 7h-1.24c-.77 0-1.47.46-1.79 1.17L12.5 13H10v-2c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1v2H2v6h6v-2h2v2h10zm-6-2H8v-4h2v4zm-7-9c0-.55.45-1 1-1h3c.55 0 1 .45 1 1v3H7v-3z"/>
                                        </svg>
                                        <span>5/8 membros</span>
                                    </div>
                                </div>
                            </div>
                            <div class="group-progress">
                                <div class="progress-label">
                                    <span>Cofre do grupo</span>
                                    <span>R$ 1.200,00 / R$ 2.500,00</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 48%"></div>
                                </div>
                            </div>
                            <div class="group-actions">
                                <button class="btn-outline" onclick="viewGroupDetails(1)">Detalhes</button>
                                <button class="btn-primary" onclick="window.location.href='grupo.php'">Entrar</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo 2 -->
                    <div class="group-card">
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Chapada dos Veadeiros" class="group-image">
                        <div class="group-content">
                            <div class="group-header">
                                <div>
                                    <h3 class="group-title">Chapada dos Veadeiros</h3>
                                    <div class="group-members">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.01 2.01 0 0 0 18.06 7h-1.24c-.77 0-1.47.46-1.79 1.17L12.5 13H10v-2c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1v2H2v6h6v-2h2v2h10zm-6-2H8v-4h2v4zm-7-9c0-.55.45-1 1-1h3c.55 0 1 .45 1 1v3H7v-3z"/>
                                        </svg>
                                        <span>3/6 membros</span>
                                    </div>
                                </div>
                            </div>
                            <div class="group-progress">
                                <div class="progress-label">
                                    <span>Cofre do grupo</span>
                                    <span>R$ 800,00 / R$ 1.800,00</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 44%"></div>
                                </div>
                            </div>
                            <div class="group-actions">
                                <button class="btn-outline" onclick="viewGroupDetails(2)">Detalhes</button>
                                <button class="btn-primary" onclick="window.location.href='grupo.php'">Entrar</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grupo 3 -->
                    <div class="group-card">
                        <img src="https://images.unsplash.com/photo-1483729558449-99ef09a8c325?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Fernando de Noronha" class="group-image">
                        <div class="group-content">
                            <div class="group-header">
                                <div>
                                    <h3 class="group-title">Fernando de Noronha</h3>
                                    <div class="group-members">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.01 2.01 0 0 0 18.06 7h-1.24c-.77 0-1.47.46-1.79 1.17L12.5 13H10v-2c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1v2H2v6h6v-2h2v2h10zm-6-2H8v-4h2v4zm-7-9c0-.55.45-1 1-1h3c.55 0 1 .45 1 1v3H7v-3z"/>
                                        </svg>
                                        <span>7/10 membros</span>
                                    </div>
                                </div>
                            </div>
                            <div class="group-progress">
                                <div class="progress-label">
                                    <span>Cofre do grupo</span>
                                    <span>R$ 3.500,00 / R$ 5.000,00</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 70%"></div>
                                </div>
                            </div>
                            <div class="group-actions">
                                <button class="btn-outline" onclick="viewGroupDetails(3)">Detalhes</button>
                                <button class="btn-primary" onclick="window.location.href='grupo.php'">Entrar</button>
                            </div>
                        </div>
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
        function toggleState(hasGroups) {
            document.getElementById('emptyState').classList.toggle('active', !hasGroups);
            document.getElementById('groupsState').classList.toggle('active', hasGroups);
        }
        
        function moveFocus(currentIndex) {
            const currentInput = document.getElementById(`code${currentIndex}`);
            
            if (currentInput.value.length === 1) {
                currentInput.classList.add('filled');
                
                if (currentIndex < 5) {
                    document.getElementById(`code${currentIndex + 1}`).focus();
                }
            } else {
                currentInput.classList.remove('filled');
            }
            
            checkCodeCompletion();
        }
        
        function checkCodeCompletion() {
            let codeComplete = true;
            for (let i = 1; i <= 5; i++) {
                if (document.getElementById(`code${i}`).value.length === 0) {
                    codeComplete = false;
                    break;
                }
            }
            
            document.querySelector('.join-btn').disabled = !codeComplete;
        }
        
        function joinGroup() {
            let code = '';
            for (let i = 1; i <= 5; i++) {
                code += document.getElementById(`code${i}`).value;
            }
            
            alert(`Tentando entrar no grupo com código: ${code}`);
            
            setTimeout(() => {
                toggleState(true);
            }, 1000);
        }
        
        function createGroup() {
           
            setTimeout(() => {
                toggleState(true);
            }, 1000);
        }

        
        document.addEventListener('DOMContentLoaded', function() {
            toggleState(false);
            
            document.querySelector('.join-btn').disabled = true;
        });
    </script>
</body>
</html>