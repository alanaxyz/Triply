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

                    <img src="" alt="">
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
                    <input type="text" id="groupName" placeholder="Ex: Viagem para Balneário Camboriú" required>
                </div>
                
                <div class="form-group">
                    <label for="groupDestination">Destino</label>
                    <input type="text" id="groupDestination" placeholder="Ex: Balneário Camboriú, SC" required>
                </div>
                
                <div class="form-group">
                    <label for="groupDescription">Descrição (opcional)</label>
                    <textarea id="groupDescription" placeholder="Descreva o propósito desta viagem..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="travelDates">Datas da Viagem</label>
                    <div class="date-inputs">
                        <input type="date" id="startDate" required>
                        <input type="date" id="endDate" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="groupBudget">Orçamento Total (R$)</label>
                    <input type="number" id="groupBudget" placeholder="Ex: 2500" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="maxMembers">Número Máximo de Membros</label>
                    <select id="maxMembers" required>
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

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <!-- Conteúdo do footer mantido igual -->
        </div>
    </footer>

    <script>
        // Função para abrir o modal de criação de grupo
        function openCreateGroupModal() {
            document.getElementById('createGroupModal').classList.add('active');
        }
        
        // Função para fechar o modal de criação de grupo
        function closeCreateGroupModal() {
            document.getElementById('createGroupModal').classList.remove('active');
            // Limpar o formulário
            document.getElementById('createGroupForm').reset();
        }
        
        // Função para criar o grupo (submeter o formulário)
        document.getElementById('createGroupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Coletar dados do formulário
            const groupName = document.getElementById('groupName').value;
            const destination = document.getElementById('groupDestination').value;
            const description = document.getElementById('groupDescription').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const budget = document.getElementById('groupBudget').value;
            const maxMembers = document.getElementById('maxMembers').value;
            
            // Aqui você faria a requisição para o backend para criar o grupo
            // Por enquanto, vamos apenas simular o sucesso
            
            // Simular criação do grupo
            console.log('Criando grupo:', {
                name: groupName,
                destination: destination,
                description: description,
                startDate: startDate,
                endDate: endDate,
                budget: budget,
                maxMembers: maxMembers
            });
            
            // Fechar o modal
            closeCreateGroupModal();
            
            // Mostrar mensagem de sucesso
            alert('Grupo criado com sucesso!');
            
            // Alternar para o estado com grupos
            toggleState(true);
        });
        
        // Fechar modal ao clicar fora dele
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('createGroupModal');
            if (e.target === modal) {
                closeCreateGroupModal();
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
        
        function viewGroupDetails(groupId) {
            alert(`Visualizando detalhes do grupo ${groupId}`);
        }
        
        // Inicialização
        document.addEventListener('DOMContentLoaded', function() {
            toggleState(false);
            document.querySelector('.join-btn').disabled = true;
            
            // Definir data mínima como hoje
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('startDate').min = today;
            document.getElementById('endDate').min = today;
        });
    </script>
</body>
</html>