<?php
session_start();
require_once '../database/config.php';

if (!isset($db)) {
    die("Erro: Conexão com o banco de dados não estabelecida.");
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'] ?? '';

// Função para gerar código aleatório de 5 dígitos (letras e números)
function gerarCodigoGrupo($db) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $tentativas = 0;
    $max_tentativas = 10;
    
    do {
        $codigo = '';
        for ($i = 0; $i < 5; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        
        // Verificar se o código já existe
        $stmt = $db->prepare("SELECT id FROM grupos WHERE codigo = ?");
        $stmt->execute([$codigo]);
        $existe = $stmt->fetch();
        
        $tentativas++;
        
        // Se não existe ou atingiu o máximo de tentativas, usar este código
        if (!$existe || $tentativas >= $max_tentativas) {
            return $codigo;
        }
    } while ($tentativas < $max_tentativas);
    
    // Fallback: código com timestamp
    return 'G' . substr(time(), -4);
}

// Buscar grupos do usuário (agora através da tabela usuario_grupo)
$grupos_usuario = [];
try {
    $stmt = $db->prepare("
        SELECT g.*, ug.data_entrada 
        FROM grupos g
        INNER JOIN usuario_grupo ug ON g.id = ug.grupo_id
        WHERE ug.usuario_id = ?
        ORDER BY ug.data_entrada DESC
    ");
    $stmt->execute([$usuario_id]);
    $grupos_usuario = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Erro ao buscar grupos: " . $e->getMessage());
}

// Processar o formulário se for uma requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (ob_get_length()) ob_clean();
    
    // Se for criação de grupo
    if (isset($_POST['groupName'])) {
        // Validar e sanitizar os dados
        $nome_grupo = trim($_POST['groupName']);
        $destino = trim($_POST['groupDestination']);
        $descricao = trim($_POST['groupDescription'] ?? '');
        $data_inicio = $_POST['startDate'];
        $data_fim = $_POST['endDate'];
        $orcamento_total = floatval($_POST['groupBudget']);
        $numero_maximo_membros = intval($_POST['maxMembers']);
        
        // Validações básicas
        $errors = [];
        
        if (empty($nome_grupo)) $errors[] = "Nome do grupo é obrigatório";
        if (empty($destino)) $errors[] = "Destino é obrigatório";
        if (empty($data_inicio) || empty($data_fim)) $errors[] = "Datas da viagem são obrigatórias";
        if ($data_inicio > $data_fim) $errors[] = "Data de início não pode ser maior que data de fim";
        if ($orcamento_total <= 0) $errors[] = "Orçamento deve ser maior que zero";
        if ($numero_maximo_membros <= 0) $errors[] = "Número de membros deve ser maior que zero";
        
        if (empty($errors)) {
            try {
                // Gerar código único para o grupo
                $codigo_grupo = gerarCodigoGrupo($db);
                
                // Iniciar transação para garantir que ambos os inserts funcionem
                $db->beginTransaction();
                
                // 1. Inserir o grupo (agora com código gerado)
                $sql_grupo = "INSERT INTO grupos (
                    nome_grupo, destino, descricao, data_inicio, data_fim, 
                    orcamento_total, numero_maximo_membros, criador_id, codigo
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                $stmt_grupo = $db->prepare($sql_grupo);
                $stmt_grupo->execute([
                    $nome_grupo, $destino, $descricao, $data_inicio, $data_fim,
                    $orcamento_total, $numero_maximo_membros, $usuario_id, $codigo_grupo
                ]);
                
                $grupo_id = $db->lastInsertId();
                
                // 2. Inserir na tabela usuario_grupo (o criador automaticamente entra no grupo)
                $sql_usuario_grupo = "INSERT INTO usuario_grupo (usuario_id, grupo_id) VALUES (?, ?)";
                $stmt_usuario_grupo = $db->prepare($sql_usuario_grupo);
                $stmt_usuario_grupo->execute([$usuario_id, $grupo_id]);
                
                // Commit da transação
                $db->commit();
                
                // Resposta de sucesso com o código gerado
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Grupo criado com sucesso! Código: ' . $codigo_grupo,
                    'grupo_id' => $grupo_id,
                    'codigo_grupo' => $codigo_grupo
                ]);
                exit;
                
            } catch (PDOException $e) {
                // Rollback em caso de erro
                $db->rollBack();
                error_log("Erro ao criar grupo: " . $e->getMessage());
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao criar grupo: ' . $e->getMessage()
                ]);
                exit;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Erros de validação',
                'errors' => $errors
            ]);
            exit;
        }
    }
    
    // Se for entrada em grupo por código
    if (isset($_POST['codigo_grupo'])) {
        $codigo = strtoupper(trim($_POST['codigo_grupo']));
        
        try {
            // Buscar grupo pelo código
            $stmt = $db->prepare("SELECT id FROM grupos WHERE codigo = ?");
            $stmt->execute([$codigo]);
            $grupo = $stmt->fetch();
            
            if ($grupo) {
                // Verificar se usuário já está no grupo
                $stmt_check = $db->prepare("SELECT id FROM usuario_grupo WHERE usuario_id = ? AND grupo_id = ?");
                $stmt_check->execute([$usuario_id, $grupo['id']]);
                
                if ($stmt_check->fetch()) {
                    echo json_encode(['success' => false, 'message' => 'Você já está neste grupo']);
                } else {
                    // Adicionar usuário ao grupo
                    $stmt_join = $db->prepare("INSERT INTO usuario_grupo (usuario_id, grupo_id) VALUES (?, ?)");
                    $stmt_join->execute([$usuario_id, $grupo['id']]);
                    
                    echo json_encode(['success' => true, 'message' => 'Entrou no grupo com sucesso!']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Código inválido']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erro ao entrar no grupo: ' . $e->getMessage()]);
        }
        exit;
    }
}

// Determinar qual estado mostrar
$tem_grupos = !empty($grupos_usuario);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/grupos.css">
    <title>Grupos</title>
</head>
<body>
    <nav class='navbar'>
            <a href="home.php" class="logo">Triply</a>
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
    </nav>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <div class="container">
            <div class="page-header">
                <h1>Seus Grupos de Viagem</h1>
                <p>Junte-se a grupos existentes ou crie o seu próprio para planejar sua próxima aventura com amigos</p>
            </div>
            
            <!-- Estado sem grupos -->
            <div id="emptyState" class="state-container <?= !$tem_grupos ? 'active' : '' ?>">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <img src="" alt="">
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
                    
                    <button class="create-group-btn" onclick="openCreateGroupModal()">Criar Novo Grupo</button>
                </div>
            </div>
            
            <!-- Estado com grupos -->
            <div id="groupsState" class="state-container <?= $tem_grupos ? 'active' : '' ?>">
                <div class="groups-header">
                    <div class="groups-header-actions">
                        <button class="create-group-btn" onclick="openCreateGroupModal()">+ Criar Novo Grupo</button>
                        <button class="join-existing-btn" onclick="openJoinGroupModal()">Entrar em Grupo Existente</button>
                    </div>
                </div>
                <div class="groups-grid">
                    <?php if ($tem_grupos): ?>
                        <?php foreach ($grupos_usuario as $grupo): 
                            // Buscar número de membros do grupo
                            $stmt_membros = $db->prepare("SELECT COUNT(*) as total_membros FROM usuario_grupo WHERE grupo_id = ?");
                            $stmt_membros->execute([$grupo['id']]);
                            $membros = $stmt_membros->fetch();
                            $total_membros = $membros['total_membros'];
                        ?>
                            <div class="group-card">
                                <div class="group-image-placeholder">
                                  <!-- colocar a url da imagem agui-->
                                </div>
                                <div class="group-content">
                                    <div class="group-header">
                                        <div>
                                            <h3 class="group-title"><?= htmlspecialchars($grupo['nome_grupo']) ?></h3>
                                            <p class="group-destination"><?= htmlspecialchars($grupo['destino']) ?></p>
                                            <div class="group-members">
                                                <span><?= $total_membros ?>/<?= $grupo['numero_maximo_membros'] ?> membros</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="group-dates">
                                        <span><?= date('d/m/Y', strtotime($grupo['data_inicio'])) ?> - <?= date('d/m/Y', strtotime($grupo['data_fim'])) ?></span>
                                    </div>
                                    <div class="group-progress">
                                        <div class="progress-label">
                                            <span>Cofre do grupo</span>
                                            <span>R$ 0,00 / R$ <?= number_format($grupo['orcamento_total'], 2, ',', '.') ?></span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <?php if (!empty($grupo['descricao'])): ?>
                                        <div class="group-description">
                                            <p><?= htmlspecialchars($grupo['descricao']) ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <div class="group-actions">
                                        <button class="btn-outline" onclick="viewGroupDetails(<?= $grupo['id'] ?>)">Detalhes</button>
                                        <button class="btn-primary" onclick="window.location.href='grupo.php?id=<?= $grupo['id'] ?>'">Entrar</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-groups-message">
                            <p>Você ainda não está em nenhum grupo.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal para criar grupo -->
    <div id="createGroupModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeCreateGroupModal()">&times;</button>
            <h2 class="modal-title">Criar Novo Grupo</h2>
            <form id="createGroupForm">
                <div class="form-group">
                    <label for="groupName">Nome do Grupo</label>
                    <input type="text" id="groupName" name="groupName" placeholder="Ex: Viagem para Balneário Camboriú" required>
                </div>
                
                <div class="form-group">
                    <label for="groupDestination">Destino</label>
                    <input type="text" id="groupDestination" name="groupDestination" placeholder="Ex: Balneário Camboriú, SC" required>
                </div>
                
                <div class="form-group">
                    <label for="groupDescription">Descrição (opcional)</label>
                    <textarea id="groupDescription" name="groupDescription" placeholder="Descreva o propósito desta viagem..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="travelDates">Datas da Viagem</label>
                    <div class="date-inputs">
                        <input type="date" id="startDate" name="startDate" required>
                        <input type="date" id="endDate" name="endDate" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="groupBudget">Orçamento Total (R$)</label>
                    <input type="number" id="groupBudget" name="groupBudget" placeholder="Ex: 2500" min="1" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="maxMembers">Número Máximo de Membros</label>
                    <select id="maxMembers" name="maxMembers" required>
                        <option value="">Selecione</option>
                        <option value="2">2 pessoas</option>
                        <option value="4">4 pessoas</option>
                        <option value="6">6 pessoas</option>
                        <option value="8">8 pessoas</option>
                        <option value="10">10 pessoas</option>
                        <option value="12">12 pessoas</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeCreateGroupModal()">Cancelar</button>
                    <button type="submit" class="btn-create">Criar Grupo</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para entrar em grupo existente -->
    <div id="joinGroupModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeJoinGroupModal()">&times;</button>
            <h2 class="modal-title">Entrar em Grupo Existente</h2>
            <div class="code-input-section">
                <div class="code-inputs">
                    <input type="text" maxlength="1" id="joinCode1" oninput="moveJoinFocus(1)">
                    <input type="text" maxlength="1" id="joinCode2" oninput="moveJoinFocus(2)">
                    <input type="text" maxlength="1" id="joinCode3" oninput="moveJoinFocus(3)">
                    <input type="text" maxlength="1" id="joinCode4" oninput="moveJoinFocus(4)">
                    <input type="text" maxlength="1" id="joinCode5" oninput="moveJoinFocus(5)">
                </div>
                <button class="join-btn" onclick="joinExistingGroup()">Entrar no Grupo</button>
                <p class="hint">Digite o código de 5 letras que você recebeu</p>
            </div>
        </div>
    </div>

    <script>
        // Função para abrir o modal de criação de grupo
        function openCreateGroupModal() {
            document.getElementById('createGroupModal').style.display = 'block';
        }
        
        // Função para fechar o modal de criação de grupo
        function closeCreateGroupModal() {
            document.getElementById('createGroupModal').style.display = 'none';
            document.getElementById('createGroupForm').reset();
        }
        
        // Função para abrir o modal de entrar em grupo existente
        function openJoinGroupModal() {
            document.getElementById('joinGroupModal').style.display = 'block';
            document.getElementById('joinCode1').focus();
        }
        
        // Função para fechar o modal de entrar em grupo existente
        function closeJoinGroupModal() {
            document.getElementById('joinGroupModal').style.display = 'none';
            // Limpar todos os campos
            for (let i = 1; i <= 5; i++) {
                document.getElementById(`joinCode${i}`).value = '';
                document.getElementById(`joinCode${i}`).classList.remove('filled');
            }
        }
        
        // Funções para os inputs do estado sem grupos
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
            
            document.querySelector('#emptyState .join-btn').disabled = !codeComplete;
        }
        
        // Funções para os inputs do modal de entrar em grupo
        function moveJoinFocus(currentIndex) {
            const currentInput = document.getElementById(`joinCode${currentIndex}`);
            
            if (currentInput.value.length === 1) {
                currentInput.classList.add('filled');
                
                if (currentIndex < 5) {
                    document.getElementById(`joinCode${currentIndex + 1}`).focus();
                }
            } else {
                currentInput.classList.remove('filled');
            }
            
            checkJoinCodeCompletion();
        }
        
        function checkJoinCodeCompletion() {
            let codeComplete = true;
            for (let i = 1; i <= 5; i++) {
                if (document.getElementById(`joinCode${i}`).value.length === 0) {
                    codeComplete = false;
                    break;
                }
            }
            
            document.querySelector('#joinGroupModal .join-btn').disabled = !codeComplete;
        }
        
        // JavaScript para enviar o formulário de criação de grupo
        document.getElementById('createGroupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Coletar dados do formulário
            const formData = new FormData(this);
            
            console.log('Enviando dados:', {
                groupName: document.getElementById('groupName').value,
                groupDestination: document.getElementById('groupDestination').value,
                groupDescription: document.getElementById('groupDescription').value,
                startDate: document.getElementById('startDate').value,
                endDate: document.getElementById('endDate').value,
                groupBudget: document.getElementById('groupBudget').value,
                maxMembers: document.getElementById('maxMembers').value
            });
            
            // Mostrar loading
            const submitBtn = document.querySelector('.btn-create');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Criando...';
            submitBtn.disabled = true;
            
            // Enviar via AJAX para a MESMA PÁGINA
            fetch('grupos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Status da resposta:', response.status);
                // Verificar se a resposta é JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    return response.text().then(text => {
                        throw new Error('Resposta não é JSON: ' + text.substring(0, 100));
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Resposta JSON:', data);
                if (data.success) {
                    let mensagem = data.message;
                    if (data.codigo_grupo) {
                        mensagem += '\n\nCódigo do grupo: ' + data.codigo_grupo + 
                                   '\n\nCompartilhe este código com seus amigos!';
                    }
                    alert(mensagem);
                    closeCreateGroupModal();
                    // Recarregar a página para mostrar o novo grupo
                    window.location.reload();
                } else {
                    let errorMessage = 'Erro: ' + data.message;
                    if (data.errors && data.errors.length > 0) {
                        errorMessage += '\n' + data.errors.join('\n');
                    }
                    alert(errorMessage);
                }
            })
            .catch(error => {
                console.error('Erro completo:', error);
                alert('Erro ao criar grupo: ' + error.message);
            })
            .finally(() => {
                // Restaurar botão
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
        
        // Função para entrar em grupo por código (quando não tem grupos)
        function joinGroup() {
            let code = '';
            for (let i = 1; i <= 5; i++) {
                code += document.getElementById(`code${i}`).value;
            }
            
            if (code.length !== 5) {
                alert('Digite um código válido de 5 letras');
                return;
            }
            
            // Mostrar loading
            const joinBtn = document.querySelector('#emptyState .join-btn');
            const originalText = joinBtn.textContent;
            joinBtn.textContent = 'Entrando...';
            joinBtn.disabled = true;
            
            // Enviar código via AJAX
            const formData = new FormData();
            formData.append('codigo_grupo', code);
            
            fetch('grupos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Recarregar a página
                    window.location.reload();
                } else {
                    alert('Erro: ' + data.message);
                    // Limpar campos do código
                    for (let i = 1; i <= 5; i++) {
                        document.getElementById(`code${i}`).value = '';
                        document.getElementById(`code${i}`).classList.remove('filled');
                    }
                    document.getElementById('code1').focus();
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao entrar no grupo');
            })
            .finally(() => {
                // Restaurar botão
                joinBtn.textContent = originalText;
                joinBtn.disabled = false;
            });
        }
        
        // Função para entrar em grupo existente (quando já tem grupos)
        function joinExistingGroup() {
            let code = '';
            for (let i = 1; i <= 5; i++) {
                code += document.getElementById(`joinCode${i}`).value;
            }
            
            if (code.length !== 5) {
                alert('Digite um código válido de 5 letras');
                return;
            }
            
            // Mostrar loading
            const joinBtn = document.querySelector('#joinGroupModal .join-btn');
            const originalText = joinBtn.textContent;
            joinBtn.textContent = 'Entrando...';
            joinBtn.disabled = true;
            
            // Enviar código via AJAX
            const formData = new FormData();
            formData.append('codigo_grupo', code);
            
            fetch('grupos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeJoinGroupModal();
                    // Recarregar a página
                    window.location.reload();
                } else {
                    alert('Erro: ' + data.message);
                    // Limpar campos do código
                    for (let i = 1; i <= 5; i++) {
                        document.getElementById(`joinCode${i}`).value = '';
                        document.getElementById(`joinCode${i}`).classList.remove('filled');
                    }
                    document.getElementById('joinCode1').focus();
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao entrar no grupo');
            })
            .finally(() => {
                // Restaurar botão
                joinBtn.textContent = originalText;
                joinBtn.disabled = false;
            });
        }
        
        // Fechar modal ao clicar fora dele
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('createGroupModal');
            if (e.target === modal) {
                closeCreateGroupModal();
            }
            
            const joinModal = document.getElementById('joinGroupModal');
            if (e.target === joinModal) {
                closeJoinGroupModal();
            }
        });
        
        // Validação das datas (data final não pode ser anterior à data inicial)
        document.getElementById('startDate').addEventListener('change', function() {
            const endDate = document.getElementById('endDate');
            if (this.value && endDate.value && this.value > endDate.value) {
                endDate.value = '';
            }
            endDate.min = this.value;
        });
        
        // Funções existentes mantidas
        function toggleState(hasGroups) {
            document.getElementById('emptyState').classList.toggle('active', !hasGroups);
            document.getElementById('groupsState').classList.toggle('active', hasGroups);
        }
        
        function viewGroupDetails(groupId) {
            alert(`Visualizando detalhes do grupo ${groupId}`);
            // Aqui você pode redirecionar para uma página de detalhes ou abrir um modal
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
        
        // Inicialização
        document.addEventListener('DOMContentLoaded', function() {
            // Desabilitar botões inicialmente
            document.querySelector('#emptyState .join-btn').disabled = true;
            document.querySelector('#joinGroupModal .join-btn').disabled = true;
            
            // Definir data mínima como hoje
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('startDate').min = today;
            document.getElementById('endDate').min = today;
        });
    </script>
</body>
</html>