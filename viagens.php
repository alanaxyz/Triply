<?php
session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    $email = "";
}

// Carregar o JSON com os destinos
$json_data = file_get_contents('destinos.json'); // Coloque seu JSON em um arquivo separado
$destinos = json_decode($json_data, true);

// Função para determinar o tipo de viagem baseado no nome/local
function getTipoViagem($nome) {
    $nome_lower = strtolower($nome);
    
    if (strpos($nome_lower, 'praia') !== false || 
        strpos($nome_lower, 'ilhabela') !== false ||
        strpos($nome_lower, 'noronha') !== false ||
        strpos($nome_lower, 'porto') !== false ||
        strpos($nome_lower, 'jericoacoara') !== false) {
        return 'praia';
    } elseif (strpos($nome_lower, 'chapada') !== false || 
               strpos($nome_lower, 'serra') !== false ||
               strpos($nome_lower, 'cachoeira') !== false ||
               strpos($nome_lower, 'jalapão') !== false) {
        return 'aventura';
    } elseif (strpos($nome_lower, 'cristo') !== false || 
               strpos($nome_lower, 'cidade') !== false ||
               strpos($nome_lower, 'histórico') !== false ||
               strpos($nome_lower, 'teatro') !== false) {
        return 'cidade';
    } else {
        return 'aventura';
    }
}

// Função para determinar preço médio baseado no destino
function getPrecoMedio($nome) {
    $precos = [
        'Fernando de Noronha' => 3500,
        'Jericoacoara' => 2800,
        'Bonito' => 2200,
        'Chapada dos Veadeiros' => 800,
        'Lençóis Maranhenses' => 1500,
        'Cataratas do Iguaçu' => 1800,
        'Balneário Camboriú' => 1800
    ];
    
    return isset($precos[$nome]) ? $precos[$nome] : 1200;
}

// Função para determinar duração recomendada
function getDuracao($nome) {
    $duracoes = [
        'Fernando de Noronha' => 7,
        'Jericoacoara' => 5,
        'Bonito' => 4,
        'Chapada dos Veadeiros' => 4,
        'Lençóis Maranhenses' => 5,
        'Cataratas do Iguaçu' => 3
    ];
    
    return isset($duracoes[$nome]) ? $duracoes[$nome] : 5;
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
                <p><?= htmlspecialchars($email) ?></p>
            </div>
        </span>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Descubra Destinos Incríveis</h1>
            <p>Encontre os melhores lugares para sua próxima aventura com informações detalhadas</p>
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
                    <?php foreach ($destinos as $destino): 
                        if (empty($destino['nome'])) continue;
                        
                        $tipo = getTipoViagem($destino['nome']);
                        $preco = getPrecoMedio($destino['nome']);
                        $duracao = getDuracao($destino['nome']);
                        
                        // Determinar categoria de preço
                        if ($preco <= 1000) {
                            $categoria_preco = 'economico';
                        } elseif ($preco <= 3000) {
                            $categoria_preco = 'medio';
                        } else {
                            $categoria_preco = 'premium';
                        }
                        
                        // Determinar categoria de duração
                        if ($duracao <= 4) {
                            $categoria_duracao = 'curta';
                        } elseif ($duracao <= 7) {
                            $categoria_duracao = 'media';
                        } else {
                            $categoria_duracao = 'longa';
                        }
                        
                        // Imagem padrão se não tiver
                        $imagem = !empty($destino['imagem']) ? $destino['imagem'] : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80';
                        
                        // Contar atrações e hospedagens
                        $num_atracoes = count($destino['principais_locais'] ?? []);
                        $num_hospedagens = count($destino['hospedagens'] ?? []);
                    ?>
                    <div class="destination-card" 
                         data-type="<?= $tipo ?>" 
                         data-price="<?= $categoria_preco ?>" 
                         data-duration="<?= $categoria_duracao ?>"
                         data-name="<?= htmlspecialchars(strtolower($destino['nome'])) ?>">
                        <img src="<?= $imagem ?>" alt="<?= htmlspecialchars($destino['nome']) ?>" class="destination-image">
                        <div class="destination-content">
                            <div class="destination-header">
                                <div>
                                    <h3 class="destination-title"><?= htmlspecialchars($destino['nome']) ?></h3>
                                    <div class="destination-location">
                                        <?= htmlspecialchars($destino['cidade'] ?? '') ?>, <?= htmlspecialchars($destino['estado'] ?? '') ?>
                                    </div>
                                </div>
                                <div class="destination-rating">4.5 ★</div>
                            </div>
                            <p class="destination-description">
                                <?= $num_atracoes > 0 ? 
                                    'Destino incrível com ' . $num_atracoes . ' atrações principais e ' . $num_hospedagens . ' opções de hospedagem.' : 
                                    'Destino maravilhoso aguardando mais informações.' 
                                ?>
                            </p>
                            
                            <div class="destination-details">
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=WTANjzga8hWT&format=png&color=000000" alt="">
                                    Hospedagens: <?= $num_hospedagens ?>+
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=E32iY1r0TxnO&format=png&color=000000" alt="">
                                    <?= $num_atracoes ?> Atrações
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=34&format=png&color=000000" alt="">
                                    Tipo: <?= ucfirst($tipo) ?>
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=7165&format=png&color=000000" alt="">
                                    <?= $duracao ?> dias
                                </div>
                            </div>
                            
                            <div class="destination-price">
                                <div class="price-label">Preço médio por pessoa</div>
                                <div class="price-value">R$ <?= number_format($preco, 0, ',', '.') ?></div>
                                <div class="price-period">para <?= $duracao ?> dias</div>
                            </div>
                            
                            <div class="destination-actions">
                                <button class="btn-destination btn-details" 
                                        onclick="viewDestination('<?= htmlspecialchars($destino['nome']) ?>')">
                                    Ver Detalhes
                                </button>
                                <button class="btn-destination btn-create-group" 
                                        onclick="createGroup('<?= htmlspecialchars($destino['nome']) ?>')">
                                    Criar Grupo
                                </button>
                                <button class="btn-destination btn-details" onclick="window.location.href='viagem.php'">Ver Detalhes</button>
                                <button class="btn-destination btn-create-group" onclick="window.location.href='grupos.php'">Criar Grupo</button>
                            </div>
                        </div>
                    </div>

                    <div class="destination-card" data-type="praia" data-price="premium" data-duration="media">
                        <img src="https://images.unsplash.com/photo-1483729558449-99ef09a8c325?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Fernando de Noronha" class="destination-image">
                        <div class="destination-content">
                            <div class="destination-header">
                                <div>
                                    <h3 class="destination-title">Rio de Janeiro</h3>
                                    <div class="destination-location">
                                        RJ, Brasil
                                    </div>
                                </div>
                                <div class="destination-rating">4.9 ★</div>
                            </div>
                            <p class="destination-description">Paraíso ecológico com praias paradisíacas e vida marinha exuberante.</p>
                            
                            <div class="destination-details">
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=WTANjzga8hWT&format=png&color=000000" alt="">
                                    Pousadas: 50+
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=E32iY1r0TxnO&format=png&color=000000" alt="">
                                    15 Praias
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=34&format=png&color=000000" alt="">
                                    Melhor época: Abr-Out
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=7165&format=png&color=000000" alt="">
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
                                    <img src="https://img.icons8.com/?size=100&id=WTANjzga8hWT&format=png&color=000000" alt="">
                                    Pousadas: 80+
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=E32iY1r0TxnO&format=png&color=000000" alt="">
                                    40 Cachoeiras
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=34&format=png&color=000000" alt="">
                                    Melhor época: Mai-Set
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=7165&format=png&color=000000" alt="">
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
                    <?php endforeach; ?>
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
                
                // Filtro por nome do destino
                if (destinationFilter) {
                    const cardName = card.dataset.name;
                    if (!cardName.includes(destinationFilter)) {
                        show = false;
                    }
                }
                
                // Filtro por tipo
                if (typeFilter && card.dataset.type !== typeFilter) {
                    show = false;
                }
                
                // Filtro por preço
                if (priceFilter && card.dataset.price !== priceFilter) {
                    show = false;
                }
                
                // Filtro por duração
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
        
        function viewDestination(destinationName) {
            // Redirecionar para página de detalhes com o nome do destino
            window.location.href = 'viagem.php?destino=' + encodeURIComponent(destinationName);
        }
        
        function createGroup(destinationName) {
            // Redirecionar para criar grupo com o destino selecionado
            window.location.href = 'criar_grupo.php?destino=' + encodeURIComponent(destinationName);
        }
        
        // Aplicar filtros em tempo real
        document.getElementById('destination').addEventListener('input', applyFilters);
        document.getElementById('type').addEventListener('change', applyFilters);
        document.getElementById('price-range').addEventListener('change', applyFilters);
        document.getElementById('duration').addEventListener('change', applyFilters);
    </script>
</body>
</html>