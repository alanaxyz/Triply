<?php

session_start();
require __DIR__ . '/database/config.php';

try {
    
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        data_nascimento DATE NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        cpf VARCHAR(14) UNIQUE NOT NULL,
        telefone VARCHAR(20) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    $db->exec($sql);
    
    echo "✅ Tabela 'users' criada com sucesso!<br>";
    
    // Verificar se a tabela foi criada e tem dados
    $stmt = $db->query("SELECT COUNT(*) as total FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "📊 Total de usuários cadastrados: " . $result['total'] . "<br>";
    
    echo "<br>🎉 Setup concluído com sucesso!";
    echo "<br><a href='register.php'>Ir para página de registro</a>";
    
} catch (PDOException $e) {
    echo "❌ Erro durante o setup: " . $e->getMessage();
}
?>