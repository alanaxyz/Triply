<?php
session_start();
require __DIR__ . '/database/config.php';

// Processar registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $data_nascimento = $_POST['date'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar-senha'] ?? '';

    // Validações básicas
    if (empty($nome) || empty($sobrenome) || empty($cpf) || empty($data_nascimento) || empty($email) || empty($telefone) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!'); window.location.href='register.php';</script>";
        exit;
    } elseif ($senha !== $confirmar_senha) {
        echo "<script>alert('As senhas não coincidem!'); window.location.href='register.php';</script>";
        exit;
    } elseif (strlen($senha) < 6) {
        echo "<script>alert('A senha deve ter pelo menos 6 caracteres!'); window.location.href='register.php';</script>";
        exit;
    } else {
        try {
            // Verificar se email já existe
            $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            
            if ($stmt->fetch()) {
                echo "<script>alert('Este email já está cadastrado!'); window.location.href='register.php';</script>";
                exit;
            } else {
                
                $stmt = $db->prepare("INSERT INTO users (nome, data_nascimento, email, cpf, telefone, senha) VALUES (:nome, :data_nascimento, :email, :cpf, :telefone, :senha)");
                
                $dados = [
                    ':nome' => $nome . ' ' . $sobrenome, // Junta nome e sobrenome
                    ':data_nascimento' => $data_nascimento,
                    ':email' => $email,
                    ':cpf' => $cpf,
                   
                    ':telefone' => preg_replace('/\D/', '', $telefone), // Remove tudo que não é número
                    ':senha' => password_hash($senha, PASSWORD_DEFAULT)
                ];
                
                if ($stmt->execute($dados)) {
                    echo "<script>alert('Conta criada com sucesso! Faça login para continuar.'); window.location.href='index.php';</script>";
                    exit;
                } else {
                    echo "<script>alert('Erro ao criar conta. Tente novamente.'); window.location.href='register.php';</script>";
                    exit;
                }
            }
        } catch (PDOException $e) {
            echo "<script>alert('Erro: " . addslashes($e->getMessage()) . "'); window.location.href='register.php';</script>";
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="styles\register.css" class="css">

</head>
<body>
    <nav class='navbar'>
    <a href="/index.php">
        <p class="logo">Triply</p>
    </a>
    
        <span>
            <a href="sobre.php">Sobre</a>
            <div class="login">
                <img src="https://img.icons8.com/?size=100&id=2yC9SZKcXDdX&format=png&color=000000" alt="">
                <a href="index.php">Login</a>
            </div>
           
        </span>
    </nav>

      <div class="container">
        
        <div class="card">
            <div class="welcome-section">
                <h1 class="welcome-title">Junte-se à<br><strong>comunidade Triply</strong></h1>
                <p class="welcome-subtitle">Crie sua conta para começar a planejar viagens</p>
            </div>

            <form id="registerForm" method="POST" action="register.php">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="sobrenome">Sobrenome</label>
                        <input type="text" id="sobrenome" name="sobrenome" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" required maxlength="14" placeholder="000.000.000-00">
                </div>

                <div class="form-group">
                    <label for="date">Data de Nascimento</label>
                    <input type="date" id="date" name="date" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="seu@email.com">
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" required placeholder="(00) 00000-0000">
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required minlength="6">
                    <div class="password-hint">A senha deve conter pelo menos 6 caracteres</div>
                </div>

                <div class="form-group">
                    <label for="confirmar-senha">Confirmar Senha</label>
                    <input type="password" id="confirmar-senha" name="confirmar-senha" required>
                </div>

                <button type="submit" class="btn-submit">Criar Conta</button>

                <div class="login-section">
                    <span class="login-text">Já tem uma conta?</span>
                    <a href="index.php" class="login-link">Faça login</a>
                </div>
            </form>
        </div>
    </div>
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
                <li><a href="index.php">Início</a></li>
                <li><a href="sobre.php">Sobre</a></li>
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
            <a href="#"><img src="https://img.icons8.com/?size=100&id=118468&format=png&color=000000"/></a>
            <a href="#"><img src="https://img.icons8.com/?size=100&id=32292&format=png&color=000000"/></a>
            <a href="#"><img src="https://img.icons8.com/?size=100&id=vbST8WV7crEk&format=png&color=000000"/></a>
            </div>
        </div>

        <!-- Direitos autorais -->
        <div class="footer-bottom">
            <p>&copy; 2025 Triply. Todos os direitos reservados.</p>
        </div>
    </footer>
     <script>
        // Máscaras e validações
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            }
            e.target.value = value;
        });

        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = value;
        });

        // Validação do formulário
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const senha = document.getElementById('senha').value;
            const confirmarSenha = document.getElementById('confirmar-senha').value;
            const cpf = document.getElementById('cpf').value.replace(/\D/g, '');
            
            // Limpar estados anteriores
            document.querySelectorAll('.form-group').forEach(group => {
                group.classList.remove('error', 'success');
            });

            let isValid = true;

            // Validação de senha
            if (senha.length < 6) {
                document.getElementById('senha').parentElement.classList.add('error');
                isValid = false;
            }

            if (senha !== confirmarSenha) {
                document.getElementById('confirmar-senha').parentElement.classList.add('error');
                isValid = false;
            }

            // Validação básica de CPF
            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
                document.getElementById('cpf').parentElement.classList.add('error');
                isValid = false;
            }

            // Validar campos obrigatórios
            const requiredFields = document.querySelectorAll('input[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.parentElement.classList.add('error');
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Por favor, corrija os campos destacados');
            } else {
                // Mostrar loading
                this.classList.add('loading');
                document.querySelector('.btn-submit').textContent = 'Criando conta...';
                // O formulário será enviado normalmente
            }
        });

        // Feedback visual em tempo real
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.parentElement.classList.remove('error');
                    this.parentElement.classList.add('success');
                } else {
                    this.parentElement.classList.remove('success');
                }
            });
        });
    </script>
</body>
</html>