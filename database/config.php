<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/app.db';

if (!is_dir(dirname($dbPath))) {
    mkdir(dirname($dbPath), 0777, true);
}

try {
    $db = new PDO("sqlite:$dbPath");

    // Configurações recomendadas
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Erros como exceções
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch associativo
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Usa prepared statements reais

    // Validação de conexão
    // (executa uma query leve apenas para confirmar)
    $db->query('SELECT 1');

} catch (PDOException $e) {
    // Log de erro — idealmente redirecionar para um handler central
    error_log("Erro na conexão com SQLite: " . $e->getMessage());
    die("Falha ao conectar ao banco de dados.");
}


// $host = "127.0.0.1";
// $porta = "3306";
// $banco = "projeto"; 
// $usuario = "root";
// $senha = "123456";

// try {
//     $dsn = "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8";
//     $db = new PDO($dsn, $usuario, $senha);
//     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
//     $sql = "CREATE TABLE IF NOT EXISTS users (
//         id INT AUTO_INCREMENT PRIMARY KEY,
//         nome VARCHAR(255) NOT NULL,
//         data_nascimento DATE NOT NULL,
//         email VARCHAR(255) UNIQUE NOT NULL,
//         cpf VARCHAR(14) UNIQUE NOT NULL,
//         telefone VARCHAR(20) NOT NULL,
//         senha VARCHAR(255) NOT NULL,
//         data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//         data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
//     )";
    
//     $db->exec($sql);

// } catch (PDOException $e) {
//     echo "❌ Erro de conexão: " . $e->getMessage();
// }
?>
 