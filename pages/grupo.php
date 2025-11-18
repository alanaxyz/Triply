<?php
session_start();
require_once '../database/config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'] ?? '';

// Verificar se o ID do grupo foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: grupos.php");
    exit;
}

$grupo_id = $_GET['id'];

// Processar contribuição
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'contribuir') {
    try {
        $valor = floatval($_POST['valor']);
        $observacao = $_POST['observacao'] ?? '';
        
        // Validar valor
        if ($valor < 1 || $valor > 10000) {
            throw new Exception("Valor deve estar entre R$ 1,00 e R$ 10.000,00");
        }
        
        // Verificar se o usuário é membro do grupo
        $stmt_membro = $db->prepare("
            SELECT 1 FROM usuario_grupo 
            WHERE usuario_id = ? AND grupo_id = ?
        ");
        $stmt_membro->execute([$usuario_id, $grupo_id]);
        
        if (!$stmt_membro->fetch()) {
            throw new Exception("Você não é membro deste grupo");
        }
        
        // Inserir contribuição no banco
        $stmt_contribuicao = $db->prepare("
            INSERT INTO contribuicoes (grupo_id, usuario_id, valor)
            VALUES (?, ?, ?)
        ");
        
        $stmt_contribuicao->execute([
            $grupo_id,
            $usuario_id,
            $valor
        ]);
        
        // Registrar atividade
        $descricao_atividade = "contribuiu com R$ " . number_format($valor, 2, ',', '.') . 
                              ($observacao ? " - " . htmlspecialchars($observacao) : "");
        
        $stmt_atividade = $db->prepare("
            INSERT INTO atividades (grupo_id, usuario_id, tipo, descricao)
            VALUES (?, ?, 'contribuicao', ?)
        ");
        
        $stmt_atividade->execute([
            $grupo_id,
            $usuario_id,
            $descricao_atividade
        ]);
        
        // Mensagem de sucesso
        $_SESSION['contribuicao_sucesso'] = true;
        
        // Redirecionar para evitar reenvio do formulário
        header("Location: grupo.php?id=" . $grupo_id);
        exit;
        
    } catch (Exception $e) {
        error_log("Erro ao processar contribuição: " . $e->getMessage());
        $_SESSION['erro_contribuicao'] = $e->getMessage();
    }
}

// Verificar se há mensagens de sucesso ou erro
$contribuicao_sucesso = $_SESSION['contribuicao_sucesso'] ?? false;
$erro_contribuicao = $_SESSION['erro_contribuicao'] ?? null;

// Limpar mensagens da sessão
unset($_SESSION['contribuicao_sucesso']);
unset($_SESSION['erro_contribuicao']);

// Função para buscar imagem do destino no JSON
function buscarImagemDestino($destino) {
    $caminho_json = '../scripts/destinos.json';
    
    if (!file_exists($caminho_json)) {
        return "https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80";
    }
    
    $json_data = file_get_contents($caminho_json);
    $destinos = json_decode($json_data, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return "https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80";
    }
    
    // Normalizar o destino buscado (remover acentos, converter para minúsculas)
    $destino_normalizado = normalizarTexto($destino);
    
    // Tentar encontrar por palavras-chave
    foreach ($destinos as $destino_data) {
        if (isset($destino_data['nome'])) {
            $nome_destino_normalizado = normalizarTexto($destino_data['nome']);
            
            // Verificar se alguma palavra do destino do grupo existe no nome do destino do JSON
            $palavras_destino = explode(' ', $destino_normalizado);
            $palavras_json = explode(' ', $nome_destino_normalizado);
            
            foreach ($palavras_destino as $palavra) {
                if (strlen($palavra) > 2) {
                    foreach ($palavras_json as $palavra_json) {
                        if (strpos($palavra_json, $palavra) !== false || strpos($palavra, $palavra_json) !== false) {
                            return $destino_data['imagem'] ?? "https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80";
                        }
                    }
                }
            }
            
            // Verificar correspondência direta com parte do nome
            if (strpos($nome_destino_normalizado, $destino_normalizado) !== false || 
                strpos($destino_normalizado, $nome_destino_normalizado) !== false) {
                return $destino_data['imagem'] ?? "https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80";
            }
        }
    }
    
    // Fallback para imagem padrão
    return "https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80";
}

// Função para normalizar texto (remover acentos e caracteres especiais)
function normalizarTexto($texto) {
    // Converter para minúsculas
    $texto = strtolower($texto);
    
    // Remover acentos usando uma abordagem mais compatível
    $acentos = array(
        'á', 'à', 'â', 'ã', 'ä', 'é', 'è', 'ê', 'ë', 'í', 'ì', 'î', 'ï',
        'ó', 'ò', 'ô', 'õ', 'ö', 'ú', 'ù', 'û', 'ü', 'ç', 'ñ'
    );
    $sem_acentos = array(
        'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i',
        'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'c', 'n'
    );
    
    $texto = str_replace($acentos, $sem_acentos, $texto);
    
    // Remover caracteres especiais, manter apenas letras, números e espaços
    $texto = preg_replace('/[^a-z0-9\s]/', '', $texto);
    
    // Remover espaços extras
    $texto = trim(preg_replace('/\s+/', ' ', $texto));
    
    return $texto;
}

// Buscar dados do grupo
$grupo = [];
$membros = [];
$total_arrecadado = 0;

try {
    // Buscar informações do grupo
    $stmt_grupo = $db->prepare("
        SELECT g.*, u.nome as criador_nome 
        FROM grupos g 
        LEFT JOIN users u ON g.criador_id = u.id 
        WHERE g.id = ?
    ");
    $stmt_grupo->execute([$grupo_id]);
    $grupo = $stmt_grupo->fetch();

    if (!$grupo) {
        header("Location: grupos.php");
        exit;
    }

    // Buscar imagem do destino
    $imagem_destino = buscarImagemDestino($grupo['destino']);

    // Buscar membros do grupo
    $stmt_membros = $db->prepare("
        SELECT u.id, u.nome, u.email, ug.data_entrada,
               CASE WHEN u.id = g.criador_id THEN 'admin' ELSE 'membro' END as role
        FROM usuario_grupo ug
        INNER JOIN users u ON ug.usuario_id = u.id
        INNER JOIN grupos g ON ug.grupo_id = g.id
        WHERE ug.grupo_id = ?
        ORDER BY 
            CASE WHEN u.id = g.criador_id THEN 1 ELSE 2 END,
            ug.data_entrada
    ");
    $stmt_membros->execute([$grupo_id]);
    $membros = $stmt_membros->fetchAll();

    // Calcular dias restantes
    $data_inicio = new DateTime($grupo['data_inicio']);
    $hoje = new DateTime();
    $dias_restantes = $hoje->diff($data_inicio)->days;
    if ($dias_restantes < 0) $dias_restantes = 0;

    // Buscar total arrecadado
    try {
        $stmt_arrecadado = $db->prepare("
            SELECT COALESCE(SUM(valor), 0) as total_arrecadado 
            FROM contribuicoes 
            WHERE grupo_id = ?
        ");
        $stmt_arrecadado->execute([$grupo_id]);
        $result_arrecadado = $stmt_arrecadado->fetch();
        $total_arrecadado = $result_arrecadado['total_arrecadado'];
    } catch (Exception $e) {
        $total_arrecadado = 0;
    }

    // Calcular porcentagem do progresso
    $porcentagem = $grupo['orcamento_total'] > 0 ? 
        round(($total_arrecadado / $grupo['orcamento_total']) * 100) : 0;

} catch (PDOException $e) {
    error_log("Erro ao carregar grupo: " . $e->getMessage());
    header("Location: grupos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/grupo.css">
    <title><?= htmlspecialchars($grupo['nome_grupo']) ?> - Triply</title>
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

    <!-- Cabeçalho do Grupo -->
    <div class="group-header">
        <img src="<?= $imagem_destino ?>" alt="<?= htmlspecialchars($grupo['destino']) ?>" class="group-header-image">
        <div class="group-header-content">
            <h1 class="group-title"><?= htmlspecialchars($grupo['nome_grupo']) ?></h1>
            <p class="group-subtitle">Próxima viagem: <?= date('d/m/Y', strtotime($grupo['data_inicio'])) ?> a <?= date('d/m/Y', strtotime($grupo['data_fim'])) ?></p>
            <div class="group-stats">
                <div class="stat-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A2.01 2.01 0 0 0 18.06 7h-1.24c-.77 0-1.47.46-1.79 1.17L12.5 13H10v-2c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1v2H2v6h6v-2h2v2h10zm-6-2H8v-4h2v4zm-7-9c0-.55.45-1 1-1h3c.55 0 1 .45 1 1v3H7v-3z"/>
                    </svg>
                    <span><?= count($membros) ?>/<?= $grupo['numero_maximo_membros'] ?> membros</span>
                </div>
                <div class="stat-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2C13.1 2 14 2.9 14 4s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm-2 18c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm-12 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm12 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm-6 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm-6 0c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                    </svg>
                    <span>Meta: R$ <?= number_format($grupo['orcamento_total'], 2, ',', '.') ?></span>
                </div>
                <div class="stat-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/>
                    </svg>
                    <span><?= $dias_restantes ?> dias restantes</span>
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
                            <button onclick="abrirModalContribuicao()">Contribuir</button>
                        </h2>
                        <div class="progress-container">
                            <div class="progress-info">
                                <span>Arrecadado: R$ <?= number_format($total_arrecadado, 2, ',', '.') ?></span>
                                <span>Meta: R$ <?= number_format($grupo['orcamento_total'], 2, ',', '.') ?></span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?= $porcentagem ?>%"></div>
                            </div>
                            <div class="progress-percentage"><?= $porcentagem ?>% concluído</div>
                        </div>
                        <p id="ultima-contribuicao">
                            <?php
                            // Buscar última contribuição
                            try {
                                $stmt_ultima = $db->prepare("
                                    SELECT u.nome, c.valor, c.data_contribuicao 
                                    FROM contribuicoes c 
                                    INNER JOIN users u ON c.usuario_id = u.id 
                                    WHERE c.grupo_id = ? 
                                    ORDER BY c.data_contribuicao DESC 
                                    LIMIT 1
                                ");
                                $stmt_ultima->execute([$grupo_id]);
                                $ultima_contribuicao = $stmt_ultima->fetch();
                                
                                if ($ultima_contribuicao) {
                                    $data_contribuicao = new DateTime($ultima_contribuicao['data_contribuicao']);
                                    $diferenca = $hoje->diff($data_contribuicao);
                                    $dias_atras = $diferenca->days;
                                    
                                    echo "Última contribuição: {$ultima_contribuicao['nome']} - R$ " . 
                                         number_format($ultima_contribuicao['valor'], 2, ',', '.') . 
                                         " (há {$dias_atras} " . ($dias_atras == 1 ? 'dia' : 'dias') . ")";
                                } else {
                                    echo "Nenhuma contribuição ainda";
                                }
                            } catch (Exception $e) {
                                echo "Nenhuma contribuição ainda";
                            }
                            ?>
                        </p>
                    </div>
                    
                    <!-- Membros do Grupo -->
                    <div class="section">
                        <h2 class="section-title">
                            Membros do Grupo
                            <button onclick="abrirModalConvite()">Convidar</button>
                        </h2>
                        <div class="members-grid">
                            <?php foreach ($membros as $membro): ?>
                                <div class="member-card">
                                    <img src="https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000" alt="<?= htmlspecialchars($membro['nome']) ?>" class="member-avatar">
                                    <div class="member-name"><?= htmlspecialchars($membro['nome']) ?></div>
                                    <div class="member-role <?= $membro['role'] === 'admin' ? 'admin' : '' ?>">
                                        <?= $membro['role'] === 'admin' ? 'Administrador' : 'Membro' ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <!-- Espaços vazios para novos membros -->
                            <?php for ($i = count($membros); $i < $grupo['numero_maximo_membros']; $i++): ?>
                                <div class="member-card" style="background-color: #f8f9fa; opacity: 0.7;">
                                    <div style="width: 60px; height: 60px; border-radius: 50%; background-color: #666; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center;">
                                        <svg viewBox="0 0 24 24" width="30" height="30" fill="white">
                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                        </svg>
                                    </div>
                                    <div style="font-weight: 600;">Vaga disponível</div>
                                    <div style="font-size: 12px; color: #666;">Convide alguém</div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    
                    <!-- Atividades Recentes -->
                    <div class="section">
                        <h2 class="section-title">Atividades Recentes</h2>
                        <ul class="activity-list" id="lista-atividades">
                            <?php
                            // Buscar atividades
                            try {
                                $stmt_atividades = $db->prepare("
                                    SELECT a.*, u.nome 
                                    FROM atividades a 
                                    INNER JOIN users u ON a.usuario_id = u.id 
                                    WHERE a.grupo_id = ? 
                                    ORDER BY a.data_atividade DESC 
                                    LIMIT 10
                                ");
                                $stmt_atividades->execute([$grupo_id]);
                                $atividades = $stmt_atividades->fetchAll();
                                
                                if (count($atividades) > 0) {
                                    foreach ($atividades as $atividade) {
                                        $data_atividade = new DateTime($atividade['data_atividade']);
                                        $diferenca = $hoje->diff($data_atividade);
                                        
                                        if ($diferenca->days == 0) {
                                            $tempo = 'hoje';
                                        } elseif ($diferenca->days == 1) {
                                            $tempo = 'há 1 dia';
                                        } else {
                                            $tempo = 'há ' . $diferenca->days . ' dias';
                                        }
                                        
                                        echo "
                                        <li class='activity-item'>
                                            <img src='https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000' alt='{$atividade['nome']}' class='activity-avatar'>
                                            <div class='activity-content'>
                                                <div class='activity-text'><strong>{$atividade['nome']}</strong> {$atividade['descricao']}</div>
                                                <div class='activity-time'>{$tempo}</div>
                                            </div>
                                        </li>";
                                    }
                                } else {
                                    // Atividades padrão se não houver no banco
                                    echo "
                                    <li class='activity-item'>
                                        <img src='https://img.icons8.com/?size=100&id=fUUEbUbXhzOA&format=png&color=000000' alt='Sistema' class='activity-avatar'>
                                        <div class='activity-content'>
                                            <div class='activity-text'><strong>Sistema</strong> Grupo criado com sucesso!</div>
                                            <div class='activity-time'>hoje</div>
                                        </div>
                                    </li>";
                                }
                            } catch (Exception $e) {
                                echo "<li class='activity-item'>Nenhuma atividade recente</li>";
                            }
                            ?>
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
                                <span class="info-value"><?= htmlspecialchars($grupo['destino']) ?></span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Data da Viagem:</span>
                                <span class="info-value"><?= date('d/m/Y', strtotime($grupo['data_inicio'])) ?> a <?= date('d/m/Y', strtotime($grupo['data_fim'])) ?></span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Código do Grupo:</span>
                                <span class="info-value"><?= $grupo['codigo'] ?? 'GRUPO-' . $grupo_id ?></span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Criado em:</span>
                                <span class="info-value"><?= date('d/m/Y', strtotime($grupo['data_criacao'])) ?></span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Criado por:</span>
                                <span class="info-value"><?= htmlspecialchars($grupo['criador_nome']) ?></span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Status:</span>
                                <span class="info-value" style="color: #59a55f; font-weight: 600;">Ativo</span>
                            </li>
                            <?php if (!empty($grupo['descricao'])): ?>
                            <li class="info-item">
                                <span class="info-label">Descrição:</span>
                                <span class="info-value"><?= htmlspecialchars($grupo['descricao']) ?></span>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    
                    <!-- Ações Rápidas -->
                    <div class="section">
                        <h2 class="section-title">Ações Rápidas</h2>
                        <div class="action-buttons">
                            <button class="btn-large btn-primary" onclick="abrirModalContribuicao()">Adicionar ao Cofre</button>
                            <button class="btn-large btn-secondary" onclick="abrirModalAtividade()">Sugerir Atividade</button>
                            <button class="btn-large btn-outline" onclick="compartilharGrupo()">Compartilhar Grupo</button>
                            <button class="btn-large btn-outline" onclick="abrirConfiguracoes()">Configurações</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Contribuição -->
    <div id="modalContribuicao" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Fazer Contribuição</h2>
                <button class="close-modal" onclick="fecharModalContribuicao()">&times;</button>
            </div>
            
            <div id="successMessage" class="success-message">
                Contribuição realizada com sucesso!
            </div>
            
            <form id="formContribuicao" method="POST">
                <input type="hidden" name="grupo_id" value="<?= $grupo_id ?>">
                <input type="hidden" name="usuario_id" value="<?= $usuario_id ?>">
                <input type="hidden" name="acao" value="contribuir">
                
                <div class="form-group">
                    <label for="valor">Valor da Contribuição (R$)</label>
                    <div class="input-with-icon">
                        <span class="input-icon">R$</span>
                        <input type="number" 
                               id="valor" 
                               name="valor" 
                               class="form-control" 
                               min="1" 
                               max="10000" 
                               step="0.01"
                               placeholder="0,00"
                               required>
                    </div>
                    <small style="color: #666; margin-top: 5px; display: block;">
                        Valor mínimo: R$ 1,00 | Valor máximo: R$ 10.000,00
                    </small>
                </div>
                
                <div class="form-group">
                    <label for="observacao">Observação (opcional)</label>
                    <textarea id="observacao" 
                              name="observacao" 
                              class="form-control" 
                              rows="3" 
                              placeholder="Alguma observação sobre esta contribuição..."></textarea>
                </div>
                
                <button type="submit" class="btn-submit" id="btnSubmit">
                    Confirmar Contribuição
                </button>
            </form>
        </div>
    </div>

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
                <li><a href="home.php">Início</a></li>
                <li><a href="sobre.php">Sobre</a></li>
                <li><a href="viagens.php">Viagens</a></li>
                <li><a href="grupos.php">Grupos</a></li>
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
            <p>&copy; 2025 Triply. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        const mobileOverlay = document.createElement('div');

        mobileOverlay.className = 'mobile-overlay';
        document.body.appendChild(mobileOverlay);
      
        //faz o menu aparecer
    menuToggle.addEventListener('click', function() {
        navLinks.classList.toggle('active');
        mobileOverlay.classList.toggle('active');
        document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
     });
        //  faz o menu sumir
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
        // Funções do Modal de Contribuição
        function abrirModalContribuicao() {
            const modal = document.getElementById('modalContribuicao');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            
            // Resetar formulário
            document.getElementById('formContribuicao').reset();
            document.getElementById('successMessage').style.display = 'none';
        }

        function fecharModalContribuicao() {
            const modal = document.getElementById('modalContribuicao');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Fechar modal ao clicar fora
        window.onclick = function(event) {
            const modal = document.getElementById('modalContribuicao');
            if (event.target === modal) {
                fecharModalContribuicao();
            }
        }

        // Validação do formulário
        document.getElementById('formContribuicao').addEventListener('submit', function(e) {
            const valor = parseFloat(document.getElementById('valor').value);
            const btnSubmit = document.getElementById('btnSubmit');
            
            if (!valor || valor < 1 || valor > 10000) {
                e.preventDefault();
                alert('Por favor, insira um valor entre R$ 1,00 e R$ 10.000,00');
                return;
            }
            
            // Mostrar loading
            btnSubmit.disabled = true;
            btnSubmit.textContent = 'Processando...';
            btnSubmit.classList.add('loading');
        });

        // Formatação do valor em tempo real
        document.getElementById('valor').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            
            if (value.length > 2) {
                value = value.replace(/(\d+)(\d{2})/, '$1.$2');
            }
            
            e.target.value = value;
        });

        // Funções para os outros modais
        function abrirModalConvite() {
            alert('Funcionalidade de convite será implementada em breve!');
        }

        function abrirModalAtividade() {
            alert('Funcionalidade de atividade será implementada em breve!');
        }

        function compartilharGrupo() {
            const codigo = '<?= $grupo['codigo'] ?? "GRUPO-" . $grupo_id ?>';
            if (navigator.share) {
                navigator.share({
                    title: '<?= htmlspecialchars($grupo['nome_grupo']) ?>',
                    text: 'Junte-se ao meu grupo de viagem no Triply! Código: ' + codigo,
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(codigo).then(() => {
                    alert('Código do grupo copiado: ' + codigo);
                });
            }
        }

        function abrirConfiguracoes() {
            alert('Configurações do grupo serão implementadas em breve!');
        }

        // Dropdown functionality
        function toggleDropdown() {
            const dropdown = document.querySelector('.user-dropdown');
            dropdown.classList.toggle('active');
            
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

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDropdown();
            }
        });

        // Atualizar progresso
        document.addEventListener('DOMContentLoaded', function() {
            const progressFill = document.querySelector('.progress-fill');
            const progressPercentage = document.querySelector('.progress-percentage');
            
            function updateProgress(value, total) {
                const percentage = Math.round((value / total) * 100);
                progressFill.style.width = `${percentage}%`;
                progressPercentage.textContent = `${percentage}% concluído`;
            }
            
            updateProgress(<?= $total_arrecadado ?>, <?= $grupo['orcamento_total'] ?>);
        });

        // Mostrar mensagem de sucesso se houver
        <?php if ($contribuicao_sucesso): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.createElement('div');
            successMessage.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #d4edda;
                color: #155724;
                padding: 15px 20px;
                border-radius: 8px;
                border: 1px solid #c3e6cb;
                z-index: 1001;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            `;
            successMessage.textContent = '✅ Contribuição realizada com sucesso!';
            document.body.appendChild(successMessage);
            
            setTimeout(() => {
                successMessage.remove();
            }, 5000);
        });
        <?php endif; ?>

        // Mostrar mensagem de erro se houver
        <?php if ($erro_contribuicao): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const errorMessage = document.createElement('div');
            errorMessage.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #f8d7da;
                color: #721c24;
                padding: 15px 20px;
                border-radius: 8px;
                border: 1px solid #f5c6cb;
                z-index: 1001;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            `;
            errorMessage.textContent = '❌ <?= addslashes($erro_contribuicao) ?>';
            document.body.appendChild(errorMessage);
            
            setTimeout(() => {
                errorMessage.remove();
            }, 5000);
        });
        <?php endif; ?>
    </script>
</body>
</html>