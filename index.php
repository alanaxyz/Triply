<?php

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="index.css" class="css">
</head>
<body>
    <nav class='navbar'>
    <a href="">
        <p class="logo">Triply</p>
    </a>
    
        <span>
            <a href="sobre.php">Sobre</a>
            <div class="register">
                <img src="https://img.icons8.com/?size=100&id=Z6wAIySfvC7I&format=png&color=000000" alt="">
                <a href="/register.php">Cadastre-se</a>
            </div>
        </span>
    </nav>

    <div class="main">
            <div class="main-content main-1">
                <span>
                    <h1 class="main-text">
                        Encontre sua próxima <strong>aventura</strong> com amigos.
                    </h1>
                    <p class="main-text">Descubra destinos incríveis e planeje cada detalhe da viagem juntos.</p>
                </span>
                    
                <div class="main-form">
                    <div class = "form-text">
                            <h1>
                                Bem vindo ao
                                <br><strong>Triply!</strong>
                            </h1>
                        </div>
                    <form action="login.php" method="post">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha">
                        <a href="">Esqueceu sua senha?</a>
                        <span>
                            <button type ="submit" class="entrar">Entrar</button>
                            <p>Não possui cadastro?</p>
                            <button type="button" onclick="window.location.href='register.php'" class="registro">Registre-se</button>
                        </span>
                    </form>
                </div>
       </div>
       <div class="main-container main-2">
        <img src="src\saoluis.jpg" alt="">
             <h1 class="main-conteinar-text-2">
                    <strong>Veja, planeje e viaje</strong>
                </h1>
            <section class="card-inicio-container">
                    <section>
                        <div class="card-inicio">
                            <h1>Veja</h1>
                                <p>Explore destinos incriveis com fotos
                                    descrições e dicas exclusivas.
                                </p>
                        </div>
                        <div class="card-inicio card-destaque-2">
                            <h1>Planeje</h1>
                            <p>
                            A diversão começa no planejamento, descubra lugares novos e experiências únicas com seus amigos.
                        </p>
                        </div>
                        <div class="card-inicio">
                            <h1>Viaje</h1>
                            <p>
                                Transforme seus planos em realidade e viva experiências
                                unicas ao redor do Brasil.
                            </p>
                        </div>
                    </section>
                     <div class="container">
                    <div class="center">
                    <button class="btn">
                        <svg width="180px" height="60px" viewBox="0 0 180 60" class="border">
                        <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
                        <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
                        </svg>
                        <span><p>Explore destinos</p></span>
                    </button>
                    </div>
                </div>
            </section>
       </div>
       <div class="main-container main-3">
            <img src="src\balneario.webp" alt="">

             <section class="main-conteinar-text-3">
                 <h1>
                    <strong>Forme grupos <br> com seus amigos</strong>
                </h1>
               
             </section>
            <section class="card-inicio-container">
                
                <div class="card-inicio ">
                    <h1>Crie um grupo</h1>
                    <p>Junte seus amigos em um só lugar para organizar a próxima viagem de forma prática e divertida</p>
                </div>
                <div class="card-inicio card-destaque-3">
                    <h1>Convide Amigos</h1>
                    <p>Envie convites e traga quem você quiser para participar do planejamento junto com você</p>
                </div>
                <div class="card-inicio">
                    <h1>Compartilhe planos</h1>
                    <p>Defina destinos, hospedagens e passeios em grupo, deixando tudo transparente e colaborativo</p>
                </div>
                 
            </section>
       </div>
    </div>
     <div class="main-container main-4">
         <img src="src\lencois_maranhenses.jpg" alt="">
                <section class="main-conteinar-text-4">
                    <h1>
                        <strong>Gerencie seus gastos</strong>
                    </h1>

                </section>
            <section class="card-inicio-container ">
                <div class="card-inicio ">
                    <h1>Planeje seus gastos</h1>
                    <p>Organize os valores antes mesmo da viagem começar</p>
                </div>
                <div class="card-inicio card-destaque-4">
                    <h1>Divida desespesas em grupo</h1>
                    <p>Compartilhe custos de forma justa e transparente com todos os amigos</p>
                </div>
                <div class="card-inicio">
                    <h1>Acompanhe tudo em tempo real</h1>
                    <p>Veja o resumo dos gastos a qualquer momento e evite surpresas no fim da viagem</p>
                </div>
            </section>
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