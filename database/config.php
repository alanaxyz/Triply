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

} catch (PDOException $e) {
    echo "❌ Erro de conexão: " . $e->getMessage();
}
?>
