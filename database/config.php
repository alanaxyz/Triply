<?php
$host = "127.0.0.1";
$porta = "3306";
$banco = "projeto"; 
$usuario = "root";
$senha = "123456";

try {
    $dsn = "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8";

    $conn = new PDO($dsn, $usuario, $senha);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✅ Conectado com sucesso ao banco MySQL!";
} catch (PDOException $e) {
    echo "❌ Erro de conexão: " . $e->getMessage();
}
?>
