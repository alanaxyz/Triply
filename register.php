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
    <a href="">
        <p class="logo">Triply</p>
    </a>
    
        <span>
            <a href="">Sobre</a>
            <div class="login">
                <img src="https://img.icons8.com/?size=100&id=2yC9SZKcXDdX&format=png&color=000000" alt="">
                <a href="">Login</a>
            </div>
            <div class="register">
                <img src="https://img.icons8.com/?size=100&id=Z6wAIySfvC7I&format=png&color=000000" alt="">
                <a href="">Cadastre-se</a>
            </div>
        </span>
    </nav>

    <div class="main-container">
        <div class="main-content">
            <div class="main-form cadastro-form">
                <div class = "form-text">
                        <h1>
                            Bem vindo ao
                            <br><strong>Triply!</strong>
                        </h1>
                    </div>
                <form action="login.php" method="post">
                    <span>
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome">
                    </span>
                     <span>
                        <label for="sobrenome">Sobrenome</label>
                        <input type="text" id="sobrenome" name="sobrenome">
                    </span>
                    <span>
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf">
                    </span>
                    <span>
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email">
                    </span>
                    <span>
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha">
                    </span>
                    <span>
                        <label for="confirmar-senha">Confirmar Senha</label>
                        <input type="password" id="confirmar-senha" name="confirmar-senha">
                        <p>As senhas devem conter 12 caracteres</p>
                    </span>
                     <span>
                        <label for="date">Data de Nascimento</label>
                        <input type="date" id="date" name="date">
                    </span>
                    <span>
                        <label for="sexo">Sexo</label>
                        <input type="password" id="sexo" name="sexo">
                    </span>
                    <span>
                        <button type ="submit" class="entrar">Registrar</button>
                    </span>
                </form>
            </div>
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
</body>
</html>
