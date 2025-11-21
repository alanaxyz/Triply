<?php
session_start();
require __DIR__ . '/../database/config.php';

// Função para validar CPF
function validarCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;

    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;
    if ($cpf[9] != $digito1) return false;

    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;

    return $cpf[10] == $digito2;
}

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

    // Campos vazios
    if (empty($nome) || empty($sobrenome) || empty($cpf) || empty($data_nascimento) || empty($email) || empty($telefone) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!'); window.location.href='register.php';</script>";
        exit;
    }

    // Verifica senhas
    if ($senha !== $confirmar_senha) {
        echo "<script>alert('As senhas não coincidem!'); window.location.href='register.php';</script>";
        exit;
    }

    if (strlen($senha) < 6) {
        echo "<script>alert('A senha deve ter pelo menos 6 caracteres!'); window.location.href='register.php';</script>";
        exit;
    }

    // Email deve terminar com domínio específico
    $dominios_validos = ['gmail.com', 'outlook.com', 'hotmail.com', 'yahoo.com'];
    $termina = strtolower(substr(strrchr($email, "@"), 1));

    if (!in_array($termina, $dominios_validos)) {
        echo "<script>alert('O email deve terminar com @gmail.com, @outlook.com, @hotmail.com ou @yahoo.com'); window.location.href='register.php';</script>";
        exit;
    }

    // Validação de telefone
    $telefone_limpo = preg_replace('/\D/', '', $telefone);

    if (strlen($telefone_limpo) !== 11) {
        echo "<script>alert('Telefone deve conter exatamente 11 dígitos!'); window.location.href='register.php';</script>";
        exit;
    }

    $ddd = substr($telefone_limpo, 0, 2);
    $primeiro_digito = substr($telefone_limpo, 2, 1);

    if ($ddd[0] == '0') {
        echo "<script>alert('O DDD não pode começar com 0!'); window.location.href='register.php';</script>";
        exit;
    }

    if ($primeiro_digito != '9') {
        echo "<script>alert('O telefone deve começar com 9 após o DDD!'); window.location.href='register.php';</script>";
        exit;
    }

    // Validação de CPF
    if (!validarCPF($cpf)) {
        echo "<script>alert('CPF inválido!'); window.location.href='register.php';</script>";
        exit;
    }

    try {
        // Verifica se email já existe
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            echo "<script>alert('Este email já está cadastrado!'); window.location.href='register.php';</script>";
            exit;
        }

        // Verifica se CPF já existe
        $cpf_limpo = preg_replace('/\D/', '', $cpf);
        $stmt = $db->prepare("SELECT id FROM users WHERE cpf = :cpf");
        $stmt->execute([':cpf' => $cpf_limpo]);
        if ($stmt->fetch()) {
            echo "<script>alert('Este CPF já está cadastrado!'); window.location.href='register.php';</script>";
            exit;
        }

        // Criar o hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT, ['cost' => 12]);

        // Inserir usuário no banco de dados
        $stmt = $db->prepare("INSERT INTO users (nome, data_nascimento, email, cpf, telefone, senha) 
                            VALUES (:nome, :data_nascimento, :email, :cpf, :telefone, :senha)");

        $dados = [
            ':nome' => $nome . ' ' . $sobrenome,
            ':data_nascimento' => $data_nascimento,
            ':email' => $email,
            ':cpf' => $cpf_limpo,
            ':telefone' => $telefone_limpo,
            ':senha' => $senha_hash
        ];

        if ($stmt->execute($dados)) {
            $user_id = $db->lastInsertId();

            // Recuperar dados do usuário
            $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute([':id' => $user_id]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Salvar dados na sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];

            echo "<script>alert('Conta criada com sucesso!'); window.location.href='home.php';</script>";
            exit;
        } else {
            echo "<script>alert('Erro ao criar conta. Tente novamente.'); window.location.href='register.php';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erro: " . htmlspecialchars($e->getMessage()) . "'); window.location.href='register.php';</script>";
        exit;
    }
}


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../styles/register.css">
</head>

<body>

    <nav class='navbar'>
        <a href="../index.php">
            <p class="logo">Triply</p>
        </a>
        <span>
            <a href="sobre.php">Sobre</a>
            <div class="login">
                <img src="https://img.icons8.com/?size=100&id=2yC9SZKcXDdX&format=png&color=000000" alt="">
                <a href="../index.php">Login</a>
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
                    <input type="text" id="cpf" name="cpf" required maxlength="14">
                </div>

                <div class="form-group">
                    <label for="date">Data de Nascimento</label>
                    <input type="date" id="date" name="date" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" required maxlength="15">
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required minlength="6">
                </div>

                <div class="form-group">
                    <label for="confirmar-senha">Confirmar Senha</label>
                    <input type="password" id="confirmar-senha" name="confirmar-senha" required>
                </div>

                <button type="submit" class="btn-submit">Criar Conta</button>

            </form>

        </div>
    </div>

    <script>
        // ================= EMAIL ==================
        function validarEmail(email) {
            return /@(gmail|outlook|hotmail|yahoo)\.com$/.test(email.toLowerCase());
        }

        // ================ TELEFONE =================
        // Deve ter 11 dígitos (ex: (61) 9 9999-9999)
        document.getElementById('telefone').addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '');

            if (v.length > 11) v = v.slice(0, 11);

            v = v.replace(/(\d{2})(\d)/, '($1) $2');
            v = v.replace(/(\d{1})(\d{4})(\d{4})$/, '$1 $2-$3');

            e.target.value = v;
        });

        // Melhor validação JS igual ao PHP
        function validarTelefone(tel) {
            let nums = tel.replace(/\D/g, '');
            if (nums.length !== 11) return false;
            if (nums[0] === "0") return false;
            if (nums[2] !== "9") return false;
            return true;
        }

        // =============== CPF ======================
        function validarCPF(cpf) {
            cpf = cpf.replace(/\D/g, '');
            if (cpf.length !== 11) return false;
            if (/^(\d)\1+$/.test(cpf)) return false;

            let soma = 0;
            for (let i = 0; i < 9; i++) soma += cpf[i] * (10 - i);
            let resto = soma % 11;
            let d1 = resto < 2 ? 0 : 11 - resto;
            if (d1 != cpf[9]) return false;

            soma = 0;
            for (let i = 0; i < 10; i++) soma += cpf[i] * (11 - i);
            resto = soma % 11;
            let d2 = resto < 2 ? 0 : 11 - resto;

            return d2 == cpf[10];
        }

        document.getElementById('cpf').addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d)/, '$1.$2');
            v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = v;
        });

        // ============ SUBMIT FINAL ============
        document.getElementById('registerForm').addEventListener('submit', function(e) {

            const email = document.getElementById('email').value;
            const telefone = document.getElementById('telefone').value;
            const cpf = document.getElementById('cpf').value;

            if (!validarEmail(email)) {
                alert("Email inválido!.");
                e.preventDefault();
                return;
            }

            if (!validarTelefone(telefone)) {
                alert("Telefone inválido!.");
                e.preventDefault();
                return;
            }

            if (!validarCPF(cpf)) {
                alert("CPF inválido!");
                e.preventDefault();
                return;
            }
        });
    </script>

</body>

</html>