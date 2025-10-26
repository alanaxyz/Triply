<?php
declare(strict_types=1);

$dbPath = __DIR__ . '/app.db';

if (!is_dir(dirname($dbPath))) {
    mkdir(dirname($dbPath), 0777, true);
}

try {
    $db = new PDO("sqlite:$dbPath");
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 

    $db->query('SELECT 1');

} catch (PDOException $e) {
    
    error_log("Erro na conexão com SQLite: " . $e->getMessage());
    die("Falha ao conectar ao banco de dados.");
}

?>
 