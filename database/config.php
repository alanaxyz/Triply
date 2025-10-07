<?php

$host = "127.0.0.1";
$porta = "3306";
$banco = "projeto"; 
$usuario = "root";
$senha = "123456";

try {
    $dsn = "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8";
    $db = new PDO($dsn, $usuario, $senha);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
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

} catch (PDOException $e) {
    echo "❌ Erro de conexão: " . $e->getMessage();
}
?>