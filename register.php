<?php


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
                <a href="/login">Login</a>
            </div>
           
        </span>
    </nav>

      <div class="container">
        
        <div class="card">
            <div class="welcome-section">
                <h1 class="welcome-title">Junte-se à<br><strong>comunidade Triply</strong></h1>
                <p class="welcome-subtitle">Crie sua conta para começar a planejar viagens</p>
            </div>

            <form id="registerForm">
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
                    <input type="password" id="senha" name="senha" required minlength="12">
                    <div class="password-hint">A senha deve conter pelo menos 12 caracteres</div>
                </div>

                <div class="form-group">
                    <label for="confirmar-senha">Confirmar Senha</label>
                    <input type="password" id="confirmar-senha" name="confirmar-senha" required>
                </div>

                <button type="submit" class="btn-submit">Criar Conta</button>

                <div class="login-section">
                    <span class="login-text">Já tem uma conta?</span>
                    <a href="login.php" class="login-link">Faça login</a>
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
                <li><a href="#">Início</a></li>
                <li><a href="#">Sobre</a></li>
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
            e.preventDefault();
            
            const senha = document.getElementById('senha').value;
            const confirmarSenha = document.getElementById('confirmar-senha').value;
            const cpf = document.getElementById('cpf').value.replace(/\D/g, '');
            
            // Limpar estados anteriores
            document.querySelectorAll('.form-group').forEach(group => {
                group.classList.remove('error', 'success');
            });

            let isValid = true;

            // Validação de senha
            if (senha.length < 12) {
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

            if (isValid) {
                // Simular envio bem-sucedido
                this.classList.add('loading');
                document.querySelector('.btn-submit').textContent = 'Criando conta...';
                
                setTimeout(() => {
                    alert('Conta criada com sucesso!');
                    this.submit();
                }, 1000);
            } else {
                alert('Por favor, corrija os campos destacados');
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
