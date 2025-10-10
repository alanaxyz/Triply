<?php
session_start();
require __DIR__ . '/config.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        data_nascimento TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        cpf TEXT UNIQUE NOT NULL,
        telefone TEXT NOT NULL,
        senha TEXT NOT NULL,
        data_criacao TEXT DEFAULT CURRENT_TIMESTAMP,
        data_atualizacao TEXT DEFAULT CURRENT_TIMESTAMP
    )";

    $db->exec($sql);
    
    echo "✅ Tabela 'users' criada com sucesso!<br>";
    
    // Verificar se a tabela foi criada e tem dados
    $stmt = $db->query("SELECT COUNT(*) AS total FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "📊 Total de usuários cadastrados: " . $result['total'] . "<br>";
    
    echo "<br>🎉 Setup concluído com sucesso!";
    echo "<br><a href='register.php'>Ir para página de registro</a>";
    
} catch (PDOException $e) {
    echo "❌ Erro durante o setup: " . $e->getMessage();
}
?>
