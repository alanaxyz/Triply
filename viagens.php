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
    <link rel="stylesheet" href="./styles/viagens.css">
    <title>Grupos</title>
</head>
<body>
    <nav class='navbar'>
        <a href="" class="logo">Triply</a>
        <span>
            <a href="/home.php">Inicio</a>
            <a href="sobre.php">Sobre</a>
            <a href="viagens.php">Viagens</a>
            <a href="grupos.php">Grupos</a>
        </span>
        <span>
            <div class="login">
                <img src="https://img.icons8.com/?size=100&id=2yC9SZKcXDdX&format=png&color=000000" alt="">
                <p><?= $email ?></p>
            </div>
        </span>
    </nav>
  <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Descubra Destinos Incríveis</h1>
            <p>Encontre os melhores lugares para sua próxima aventura com informações detalhadas e preços médios</p>
        </div>
    </section>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <div class="container">
            <!-- Filtros -->
            <section class="filters-section">
                <div class="filters-header">
                    <h2 class="filters-title">Filtrar Destinos</h2>
                </div>
                <div class="filters-grid">
                    <div class="filter-group">
                        <label for="destination">Destino</label>
                        <input type="text" id="destination" placeholder="Para onde você quer ir?">
                    </div>
                    
                    <div class="filter-group">
                        <label for="type">Tipo de Viagem</label>
                        <select id="type">
                            <option value="">Todos os tipos</option>
                            <option value="praia">Praia</option>
                            <option value="montanha">Montanha</option>
                            <option value="cidade">Cidade</option>
                            <option value="aventura">Aventura</option>
                            <option value="romantico">Romântico</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="price-range">Faixa de Preço</label>
                        <select id="price-range">
                            <option value="">Qualquer preço</option>
                            <option value="economico">Econômico (até R$ 1.000)</option>
                            <option value="medio">Médio (R$ 1.000 - R$ 3.000)</option>
                            <option value="premium">Premium (acima de R$ 3.000)</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="duration">Duração</label>
                        <select id="duration">
                            <option value="">Qualquer duração</option>
                            <option value="curta">Curta (2-4 dias)</option>
                            <option value="media">Média (5-7 dias)</option>
                            <option value="longa">Longa (8+ dias)</option>
                        </select>
                    </div>
                </div>
                <div class="filter-actions">
                    <button class="btn-filter btn-apply" onclick="applyFilters()">Aplicar Filtros</button>
                    <button class="btn-filter btn-reset" onclick="resetFilters()">Limpar Filtros</button>
                </div>
            </section>

            <!-- Grid de Destinos -->
            <section class="destinations-section">
                <h2 style="font-size: 28px; margin-bottom: 30px; text-align: center;">Destinos Populares</h2>
                
                <div class="destinations-grid">
                    <!-- Destino 1 - Balneário Camboriú -->
                    <div class="destination-card" data-type="praia" data-price="medio" data-duration="media">
                        <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Balneário Camboriú" class="destination-image">
                        <div class="destination-content">
                            <div class="destination-header">
                                <div>
                                    <h3 class="destination-title">Balneário Camboriú</h3>
                                    <div class="destination-location">
                                        Santa Catarina, Brasil
                                    </div>
                                </div>
                                <div class="destination-rating">4.7 ★</div>
                            </div>
                            <p class="destination-description">Conhecida como o Dubai brasileiro, com praias incríveis e uma vida noturna vibrante.</p>
                            
                            <div class="destination-details">
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                                    </svg>
                                    Hotéis: 150+
                                </div>
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                    25 Atrações
                                </div>
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                                        <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                    </svg>
                                    Melhor época: Dez-Mar
                                </div>
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                                    </svg>
                                    Custo médio: 5 dias
                                </div>
                            </div>
                            
                            <div class="destination-price">
                                <div class="price-label">Preço médio por pessoa</div>
                                <div class="price-value">R$ 1.800</div>
                                <div class="price-period">para 5 dias</div>
                            </div>
                            
                            <div class="destination-actions">
                                <button class="btn-destination btn-details" onclick="window.location.href='viagem.php'">Ver Detalhes</button>
                                <button class="btn-destination btn-create-group" onclick="window.location.href='grupos.php'">Criar Grupo</button>
                            </div>
                        </div>
                    </div>

                    <!-- Destino 2 - Fernando de Noronha -->
                    <div class="destination-card" data-type="praia" data-price="premium" data-duration="media">
                        <img src="https://images.unsplash.com/photo-1483729558449-99ef09a8c325?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Fernando de Noronha" class="destination-image">
                        <div class="destination-content">
                            <div class="destination-header">
                                <div>
                                    <h3 class="destination-title">Fernando de Noronha</h3>
                                    <div class="destination-location">
                                        Pernambuco, Brasil
                                    </div>
                                </div>
                                <div class="destination-rating">4.9 ★</div>
                            </div>
                            <p class="destination-description">Paraíso ecológico com praias paradisíacas e vida marinha exuberante.</p>
                            
                            <div class="destination-details">
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                                    </svg>
                                    Pousadas: 50+
                                </div>
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                    15 Praias
                                </div>
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                                        <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                    </svg>
                                    Melhor época: Abr-Out
                                </div>
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                                    </svg>
                                    Custo médio: 7 dias
                                </div>
                            </div>
                            
                            <div class="destination-price">
                                <div class="price-label">Preço médio por pessoa</div>
                                <div class="price-value">R$ 3.500</div>
                                <div class="price-period">para 7 dias</div>
                            </div>
                            
                            <div class="destination-actions">
                                <button class="btn-destination btn-details" onclick="window.location.href='viagem.php'">Ver Detalhes</button>
                                <button class="btn-destination btn-create-group" onclick="window.location.href='grupos.php'">Criar Grupo</button>
                            </div>
                        </div>
                    </div>

                    <!-- Destino 3 - Chapada dos Veadeiros -->
                    <div class="destination-card" data-type="aventura" data-price="economico" data-duration="media">
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Chapada dos Veadeiros" class="destination-image">
                        <div class="destination-content">
                            <div class="destination-header">
                                <div>
                                    <h3 class="destination-title">Chapada dos Veadeiros</h3>
                                    <div class="destination-location">
                                        Goiás, Brasil
                                    </div>
                                </div>
                                <div class="destination-rating">4.6 ★</div>
                            </div>
                            <p class="destination-description">Paraíso do ecoturismo com cachoeiras cristalinas e trilhas incríveis.</p>
                            
                            <div class="destination-details">
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M17 3H7c-1.1 0-1.99.9-1.99 2L5 21l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                                    </svg>
                                    Pousadas: 80+
                                </div>
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                    40 Cachoeiras
                                </div>
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                                        <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                                    </svg>
                                    Melhor época: Mai-Set
                                </div>
                                <div class="detail-item">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                                    </svg>
                                    Custo médio: 4 dias
                                </div>
                            </div>
                            
                            <div class="destination-price">
                                <div class="price-label">Preço médio por pessoa</div>
                                <div class="price-value">R$ 800</div>
                                <div class="price-period">para 4 dias</div>
                            </div>
                            
                            <div class="destination-actions">
                                <button class="btn-destination btn-details" onclick="window.location.href='viagem.php'">Ver Detalhes</button>
                                <button class="btn-destination btn-create-group" onclick="window.location.href='grupos.php'">Criar Grupo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>



    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <!-- Conteúdo do footer mantido igual -->
        </div>
    </footer>

   <script>
        // Funções de filtro
        function applyFilters() {
            const destinationFilter = document.getElementById('destination').value.toLowerCase();
            const typeFilter = document.getElementById('type').value;
            const priceFilter = document.getElementById('price-range').value;
            const durationFilter = document.getElementById('duration').value;
            
            const cards = document.querySelectorAll('.destination-card');
            
            cards.forEach(card => {
                let show = true;
                
                if (destinationFilter) {
                    const title = card.querySelector('.destination-title').textContent.toLowerCase();
                    if (!title.includes(destinationFilter)) {
                        show = false;
                    }
                }
                
                if (typeFilter && card.dataset.type !== typeFilter) {
                    show = false;
                }
                
                if (priceFilter && card.dataset.price !== priceFilter) {
                    show = false;
                }
                
                if (durationFilter && card.dataset.duration !== durationFilter) {
                    show = false;
                }
                
                card.style.display = show ? 'block' : 'none';
            });
        }
        
        function resetFilters() {
            document.getElementById('destination').value = '';
            document.getElementById('type').value = '';
            document.getElementById('price-range').value = '';
            document.getElementById('duration').value = '';
            
            const cards = document.querySelectorAll('.destination-card');
            cards.forEach(card => {
                card.style.display = 'block';
            });
        }
        
        function viewDestination(destinationId) {
            alert(`Visualizando detalhes do destino ${destinationId}`);
        }
        
        function createGroupFromDestination(destinationId) {
            const destinationTitle = document.querySelector(`.destination-card:nth-child(${destinationId}) .destination-title`).textContent;
            alert(`Criando grupo para: ${destinationTitle}`);
        }
        
        document.getElementById('destination').addEventListener('input', applyFilters);
    </script>
</body>
</html>