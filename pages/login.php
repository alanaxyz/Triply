<?php
session_start();
require __DIR__ . '/../database/config.php'; // importa a conexão

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (empty($email) || empty($senha)) {
    echo "<script>alert('Preencha todos os campos!'); window.location.href='index.php';</script>";
    exit;
}

try {
    // Prepara a busca do usuário pelo email - CORRIGIDO: usa $db e tabela users
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login válido
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];

        // Gerar um token único para a sessão
        $token = bin2hex(random_bytes(32)); // 64 caracteres
        $_SESSION['token'] = $token; // Armazena o token na sessão

        // Armazenar o token no cookie
        setcookie('auth_token', $token, time() + 3600, '/', '', true, true); // Expira em 1 hora, seguro e HTTPOnly

        header("Location: home.php");
        exit;
    } else {
        echo "<script>alert('E-mail ou senha incorretos!'); window.location.href='../index.php';</script>";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
