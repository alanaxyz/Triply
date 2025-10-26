<?php
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header("Location:  ../index.php");
        exit;
    }
    $usuario_nome = $_SESSION['usuario_nome'] ?? '';
    // Verificar se há parâmetro de busca na URL
    $search_term = '';
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search_term = htmlspecialchars($_GET['search']);
    }
    // Verificar se há parâmetro de busca na URL
    $search_term = '';
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search_term = htmlspecialchars($_GET['search']);
    }

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

// Função para determinar preço médio baseado no destino
function getPrecoMedio($nome) {
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

// Função para determinar duração recomendada
function getDuracao($nome) {
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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/viagens.css">
    <title>Destinos - Triply</title>
</head>
<body>
    <nav class='navbar'>
    <a href="home.php" class="logo">Triply</a>        <span>
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
                    <input type="text" id="destination" placeholder="Para onde você quer ir?" value="<?= $search_term ?>">
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
                        
                        $tipo = getTipoViagem($destino['nome'], $destino['principais_locais'] ?? []);
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
                        $imagem = !empty($destino['imagem']) ? $destino['imagem'] : getImagemPadrao($tipo, $destino['nome']);
                        
                        // Contar atrações e hospedagens
                        $num_atracoes = count($destino['principais_locais'] ?? []);
                        $num_hospedagens = count($destino['hospedagens'] ?? []);
                        
                        // Descrição baseada nas informações disponíveis
                        if ($num_atracoes > 0 && $num_hospedagens > 0) {
                            $descricao = "Explore {$num_atracoes} atrações incríveis com {$num_hospedagens} opções de hospedagem em " . $destino['cidade'] . ".";
                        } elseif ($num_atracoes > 0) {
                            $descricao = "Descubra {$num_atracoes} atrações imperdíveis em " . $destino['cidade'] . ".";
                        } else {
                            $descricao = "Destino maravilhoso em " . $destino['cidade'] . " aguardando sua visita.";
                        }
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
                                        <?= htmlspecialchars($destino['cidade']) ?>, <?= htmlspecialchars($destino['estado']) ?>
                                    </div>
                                </div>
                                <div class="destination-rating">4.5 ★</div>
                            </div>
                            <p class="destination-description">
                                <?= $descricao ?>
                            </p>
                            
                            <div class="destination-details">
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=WTANjzga8hWT&format=png&color=000000" alt="Hospedagens">
                                    Hospedagens: <?= $num_hospedagens ?>+
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=E32iY1r0TxnO&format=png&color=000000" alt="Atrações">
                                    <?= $num_atracoes ?> Atrações
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=34&format=png&color=000000" alt="Tipo">
                                    <?= ucfirst($tipo) ?>
                                </div>
                                <div class="detail-item">
                                    <img src="https://img.icons8.com/?size=100&id=7165&format=png&color=000000" alt="Duração">
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
        // Preencher automaticamente o filtro e aplicar se houver termo de busca
        document.addEventListener('DOMContentLoaded', function() {
            const searchTerm = "<?= $search_term ?>";
            if (searchTerm) {
                document.getElementById('destination').value = searchTerm;
                // Aplicar filtros automaticamente
                setTimeout(() => {
                    applyFilters();
                }, 100);
            }
        });
        
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
            window.location.href = 'grupos.php';
        }
        
        // Aplicar filtros em tempo real
        document.getElementById('destination').addEventListener('input', applyFilters);
        document.getElementById('type').addEventListener('change', applyFilters);
        document.getElementById('price-range').addEventListener('change', applyFilters);
        document.getElementById('duration').addEventListener('change', applyFilters);
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