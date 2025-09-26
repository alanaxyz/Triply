<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre | Revolução em Viagens Colaborativas</title>
    <style>
        /* Reset Radical */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --neon-blue: #00f5ff;
            --neon-pink: #ff00ff;
            --neon-green: #39ff14;
            --dark-space: #0a0a12;
            --cosmic-purple: #6a00ff;
            --stardust: #e0e0e0;
            --black-hole: #000011;
        }

        body {
            background: var(--dark-space);
            color: var(--stardust);
            font-family: 'Orbitron', monospace;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Efeito de Partículas Cósmicas */
        .cosmic-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: 
                radial-gradient(circle at 20% 80%, var(--cosmic-purple) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, var(--neon-blue) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, var(--neon-pink) 0%, transparent 50%);
            animation: cosmicFloat 20s infinite alternate;
        }

        @keyframes cosmicFloat {
            0% { transform: scale(1) rotate(0deg); }
            100% { transform: scale(1.1) rotate(1deg); }
        }

        /* Navegação Holográfica */
        .hologram-nav {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 1000;
        }

        .nav-orbit {
            width: 80px;
            height: 80px;
            border: 2px solid var(--neon-blue);
            border-radius: 50%;
            position: relative;
            animation: orbitSpin 10s linear infinite;
        }

        .nav-item {
            position: absolute;
            width: 40px;
            height: 40px;
            background: var(--black-hole);
            border: 1px solid var(--neon-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: var(--neon-green);
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background: var(--neon-green);
            color: var(--black-hole);
            transform: scale(1.2);
        }

        .nav-item:nth-child(1) { top: -20px; left: 50%; transform: translateX(-50%); }
        .nav-item:nth-child(2) { right: -20px; top: 50%; transform: translateY(-50%); }
        .nav-item:nth-child(3) { bottom: -20px; left: 50%; transform: translateX(-50%); }
        .nav-item:nth-child(4) { left: -20px; top: 50%; transform: translateY(-50%); }

        @keyframes orbitSpin {
            100% { transform: rotate(360deg); }
        }

        /* Header Quântico */
        .quantum-header {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .title-matrix {
            font-size: clamp(3rem, 8vw, 8rem);
            font-weight: 900;
            background: linear-gradient(45deg, var(--neon-blue), var(--neon-pink), var(--neon-green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: matrixFlow 3s infinite alternate;
            text-transform: uppercase;
            letter-spacing: 0.2em;
        }

        @keyframes matrixFlow {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        .subtitle-neon {
            font-size: clamp(1rem, 3vw, 1.5rem);
            margin-top: 2rem;
            text-shadow: 0 0 10px var(--neon-blue);
            animation: neonPulse 2s infinite alternate;
        }

        @keyframes neonPulse {
            from { text-shadow: 0 0 10px var(--neon-blue); }
            to { text-shadow: 0 0 20px var(--neon-blue), 0 0 30px var(--neon-blue); }
        }

        /* Seções Holográficas */
        .hologram-section {
            min-height: 100vh;
            padding: 4rem 2rem;
            position: relative;
            border-bottom: 1px solid rgba(0, 245, 255, 0.1);
        }

        .holo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .holo-card {
            background: rgba(10, 10, 18, 0.8);
            border: 1px solid var(--neon-pink);
            border-radius: 20px;
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .holo-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 0, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .holo-card:hover::before {
            left: 100%;
        }

        .holo-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 0, 255, 0.2);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 20px currentColor;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--neon-green);
        }

        /* Timeline Quântica */
        .quantum-timeline {
            position: relative;
            max-width: 800px;
            margin: 4rem auto;
        }

        .timeline-node {
            position: relative;
            margin: 3rem 0;
            padding-left: 3rem;
        }

        .node-dot {
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 20px;
            background: var(--neon-blue);
            border-radius: 50%;
            box-shadow: 0 0 20px var(--neon-blue);
        }

        .node-content {
            background: rgba(10, 10, 18, 0.9);
            border: 1px solid var(--neon-blue);
            padding: 2rem;
            border-radius: 15px;
            position: relative;
        }

        .node-content::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 20px;
            width: 0;
            height: 0;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-right: 10px solid var(--neon-blue);
        }

        /* Equipe Interdimensional */
        .team-portal {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .portal-member {
            text-align: center;
            perspective: 1000px;
        }

        .member-holo {
            width: 150px;
            height: 150px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--neon-blue), var(--neon-pink));
            position: relative;
            animation: holoSpin 6s infinite linear;
        }

        .member-holo::before {
            content: '';
            position: absolute;
            inset: 5px;
            background: var(--dark-space);
            border-radius: 50%;
            z-index: 1;
        }

        .member-avatar {
            position: absolute;
            inset: 5px;
            border-radius: 50%;
            background: var(--black-hole);
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--neon-green);
        }

        @keyframes holoSpin {
            100% { transform: rotate(360deg); }
        }

        /* Estatísticas Dinâmicas */
        .stats-wormhole {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            max-width: 800px;
            margin: 4rem auto;
        }

        .wormhole-stat {
            text-align: center;
            padding: 2rem;
            border: 1px solid var(--neon-green);
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 900;
            color: var(--neon-green);
            text-shadow: 0 0 10px currentColor;
            margin-bottom: 0.5rem;
        }

        /* Contato Futurista */
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .contact-beam {
            text-align: center;
            padding: 2rem;
            border: 1px solid var(--neon-blue);
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .contact-beam:hover {
            background: rgba(0, 245, 255, 0.1);
            transform: scale(1.05);
        }

        /* Scroll Personalizado */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--black-hole);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--neon-pink);
            border-radius: 4px;
        }

        /* Responsividade Extrema */
        @media (max-width: 768px) {
            .hologram-nav {
                top: 1rem;
                right: 1rem;
            }
            
            .nav-orbit {
                width: 60px;
                height: 60px;
            }
            
            .nav-item {
                width: 30px;
                height: 30px;
                font-size: 0.6rem;
            }

            .holo-grid {
                grid-template-columns: 1fr;
            }

            .quantum-timeline {
                margin: 2rem auto;
            }
        }

        /* Efeitos Especiais */
        .glitch-text {
            position: relative;
            display: inline-block;
        }

        .glitch-text::before,
        .glitch-text::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .glitch-text::before {
            left: 2px;
            text-shadow: -2px 0 var(--neon-pink);
            clip: rect(44px, 450px, 56px, 0);
            animation: glitch-anim 5s infinite linear alternate-reverse;
        }

        .glitch-text::after {
            left: -2px;
            text-shadow: -2px 0 var(--neon-blue);
            clip: rect(44px, 450px, 56px, 0);
            animation: glitch-anim2 5s infinite linear alternate-reverse;
        }

        @keyframes glitch-anim {
            0% { clip: rect(42px, 9999px, 44px, 0); }
            5% { clip: rect(12px, 9999px, 59px, 0); }
            10% { clip: rect(48px, 9999px, 29px, 0); }
            15% { clip: rect(42px, 9999px, 73px, 0); }
            20% { clip: rect(63px, 9999px, 27px, 0); }
            25% { clip: rect(34px, 9999px, 55px, 0); }
            30% { clip: rect(86px, 9999px, 73px, 0); }
            35% { clip: rect(20px, 9999px, 20px, 0); }
            40% { clip: rect(26px, 9999px, 60px, 0); }
            45% { clip: rect(25px, 9999px, 66px, 0); }
            50% { clip: rect(57px, 9999px, 98px, 0); }
            55% { clip: rect(5px, 9999px, 46px, 0); }
            60% { clip: rect(82px, 9999px, 31px, 0); }
            65% { clip: rect(54px, 9999px, 27px, 0); }
            70% { clip: rect(28px, 9999px, 99px, 0); }
            75% { clip: rect(45px, 9999px, 69px, 0); }
            80% { clip: rect(23px, 9999px, 85px, 0); }
            85% { clip: rect(54px, 9999px, 84px, 0); }
            90% { clip: rect(45px, 9999px, 47px, 0); }
            95% { clip: rect(37px, 9999px, 20px, 0); }
            100% { clip: rect(4px, 9999px, 91px, 0); }
        }

        @keyframes glitch-anim2 {
            0% { clip: rect(65px, 9999px, 100px, 0); }
            5% { clip: rect(52px, 9999px, 74px, 0); }
            10% { clip: rect(79px, 9999px, 85px, 0); }
            15% { clip: rect(75px, 9999px, 5px, 0); }
            20% { clip: rect(67px, 9999px, 61px, 0); }
            25% { clip: rect(14px, 9999px, 79px, 0); }
            30% { clip: rect(1px, 9999px, 66px, 0); }
            35% { clip: rect(86px, 9999px, 30px, 0); }
            40% { clip: rect(23px, 9999px, 98px, 0); }
            45% { clip: rect(85px, 9999px, 72px, 0); }
            50% { clip: rect(71px, 9999px, 75px, 0); }
            55% { clip: rect(2px, 9999px, 48px, 0); }
            60% { clip: rect(30px, 9999px, 16px, 0); }
            65% { clip: rect(59px, 9999px, 50px, 0); }
            70% { clip: rect(41px, 9999px, 62px, 0); }
            75% { clip: rect(2px, 9999px, 82px, 0); }
            80% { clip: rect(47px, 9999px, 73px, 0); }
            85% { clip: rect(3px, 9999px, 27px, 0); }
            90% { clip: rect(26px, 9999px, 55px, 0); }
            95% { clip: rect(42px, 9999px, 97px, 0); }
            100% { clip: rect(38px, 9999px, 49px, 0); }
        }
    </style>
</head>
<body>
    <!-- Fundo Cósmico -->
    <div class="cosmic-bg"></div>

    <!-- Navegação Orbital -->
    <nav class="hologram-nav">
        <div class="nav-orbit">
            <a href="home.php" class="nav-item">🏠</a>
            <a href="sobre.php" class="nav-item">⚡</a>
            <a href="viagens.php" class="nav-item">🌍</a>
            <a href="grupos.php" class="nav-item">👥</a>
        </div>
    </nav>

    <!-- Header Quântico -->
    <header class="quantum-header">
        <div>
            <h1 class="title-matrix glitch-text" data-text="REVOLUÇÃO">REVOLUÇÃO</h1>
            <p class="subtitle-neon">Na forma como amigos transformam sonhos em realidade</p>
        </div>
    </header>

    <!-- Missão Interdimensional -->
    <section class="hologram-section">
        <div class="holo-grid">
            <div class="holo-card">
                <div class="card-icon">🚀</div>
                <h3 class="card-title">Missão Quântica</h3>
                <p>Dissolver as barreiras do planejamento tradicional e criar um ecossistema onde cada viagem seja uma experiência coletiva perfeita.</p>
            </div>
            <div class="holo-card">
                <div class="card-icon">🌌</div>
                <h3 class="card-title">Visão Cósmica</h3>
                <p>Ser o portal definitivo para conexões humanas através de aventuras memoráveis, onde a tecnologia serve à emoção.</p>
            </div>
        </div>
    </section>

    <!-- Timeline da Evolução -->
    <section class="hologram-section">
        <h2 style="text-align: center; margin-bottom: 4rem; color: var(--neon-pink);">Evolução Temporal</h2>
        <div class="quantum-timeline">
            <div class="timeline-node">
                <div class="node-dot"></div>
                <div class="node-content">
                    <h3>Fase Alfa</h3>
                    <p>Nascimento da ideia em uma viagem entre amigos onde o caos reinou supremo.</p>
                </div>
            </div>
            <div class="timeline-node">
                <div class="node-dot"></div>
                <div class="node-content">
                    <h3>Fase Beta</h3>
                    <p>Protótipo quântico desenvolvido com feedback de viajantes reais.</p>
                </div>
            </div>
            <div class="timeline-node">
                <div class="node-dot"></div>
                <div class="node-content">
                    <h3>Fase Ômega</h3>
                    <p>Lançamento interdimensional da plataforma completa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Diferenciais Revolucionários -->
    <section class="hologram-section">
        <h2 style="text-align: center; margin-bottom: 4rem; color: var(--neon-green);">Tecnologia do Futuro</h2>
        <div class="holo-grid">
            <div class="holo-card">
                <div class="card-icon">🤖</div>
                <h3 class="card-title">IA Emocional</h3>
                <p>Algoritmos que entendem desejos do grupo e sugerem experiências personalizadas.</p>
            </div>
            <div class="holo-card">
                <div class="card-icon">💰</div>
                <h3 class="card-title">Economia Quântica</h3>
                <p>Sistema de cofre que se adapta dinamicamente às metas do grupo.</p>
            </div>
            <div class="holo-card">
                <div class="card-icon">🔮</div>
                <h3 class="card-title">Previsão Temporal</h3>
                <p>Antecipa necessidades do grupo baseado em padrões de viagem.</p>
            </div>
        </div>
    </section>

    <!-- Estatísticas Dinâmicas -->
    <section class="hologram-section">
        <div class="stats-wormhole">
            <div class="wormhole-stat">
                <div class="stat-number">15.7K</div>
                <p>Realidades Transformadas</p>
            </div>
            <div class="wormhole-stat">
                <div class="stat-number">92%</div>
                <p>Índice de Magia</p>
            </div>
            <div class="wormhole-stat">
                <div class="stat-number">∞</div>
                <p>Possibilidades Criadas</p>
            </div>
        </div>
    </section>

    <!-- Equipe Interdimensional -->
    <section class="hologram-section">
        <h2 style="text-align: center; margin-bottom: 4rem; color: var(--neon-blue);">Navegadores do Tempo</h2>
        <div class="team-portal">
            <div class="portal-member">
                <div class="member-holo">
                    <div class="member-avatar">👁️</div>
                </div>
                <h3>Visionário</h3>
                <p>Arquiteto de Realidades</p>
            </div>
            <div class="portal-member">
                <div class="member-holo">
                    <div class="member-avatar">⚡</div>
                </div>
                <h3>Alquimista</h3>
                <p>Mestre das Energias</p>
            </div>
            <div class="portal-member">
                <div class="member-holo">
                    <div class="member-avatar">🔮</div>
                </div>
                <h3>Oráculo</h3>
                <p>Vidente Digital</p>
            </div>
        </div>
    </section>

    <!-- Contato do Futuro -->
    <section class="hologram-section">
        <h2 style="text-align: center; margin-bottom: 4rem; color: var(--neon-pink);">Canais de Transmissão</h2>
        <div class="contact-grid">
            <div class="contact-beam">
                <div class="card-icon">📡</div>
                <h3>Transmissão Quântica</h3>
                <p>contato@realidade.com</p>
            </div>
            <div class="contact-beam">
                <div class="card-icon">🌐</div>
                <h3>Portal Dimensional</h3>
                <p>@viagensquanticas</p>
            </div>
            <div class="contact-beam">
                <div class="card-icon">⚡</div>
                <h3>Energia Vital</h3>
                <p>(61) 9 9999-9999</p>
            </div>
        </div>
    </section>

    <script>
        // Sistema de Partículas Interativas
        document.addEventListener('mousemove', (e) => {
            const particles = document.createElement('div');
            particles.style.position = 'fixed';
            particles.style.left = e.clientX + 'px';
            particles.style.top = e.clientY + 'px';
            particles.style.width = '4px';
            particles.style.height = '4px';
            particles.style.background = `hsl(${Math.random() * 360}, 100%, 50%)`;
            particles.style.borderRadius = '50%';
            particles.style.pointerEvents = 'none';
            particles.style.zIndex = '9999';
            particles.style.animation = `floatAway 1s forwards`;
            
            document.body.appendChild(particles);
            
            setTimeout(() => {
                particles.remove();
            }, 1000);
        });

        const style = document.createElement('style');
        style.textContent = `
            @keyframes floatAway {
                0% {
                    transform: scale(1);
                    opacity: 1;
                }
                100% {
                    transform: translate(${Math.random() * 100 - 50}px, ${Math.random() * 100 - 50}px) scale(0);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Efeito de Digitação Dinâmico
        const titles = document.querySelectorAll('.card-title');
        titles.forEach(title => {
            const text = title.textContent;
            title.textContent = '';
            let i = 0;
            
            const typeWriter = setInterval(() => {
                if (i < text.length) {
                    title.textContent += text.charAt(i);
                    i++;
                } else {
                    clearInterval(typeWriter);
                }
            }, 100);
        });

        // Sistema de Gravidade nos Cards
        const cards = document.querySelectorAll('.holo-card');
        document.addEventListener('mousemove', (e) => {
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const angleY = (x - centerX) / 25;
                const angleX = (centerY - y) / 25;
                
                card.style.transform = `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg)`;
            });
        });
    </script>
</body>
</html>