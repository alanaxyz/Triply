<?php
session_start();
require __DIR__ . '/config.php';
try {
    // Criar tabela users
    $sql1 = "CREATE TABLE IF NOT EXISTS users (
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
    $db->exec($sql1);

    // Criar tabela grupos (AGORA COM codigo incluído)
    $sql2 = "CREATE TABLE IF NOT EXISTS grupos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome_grupo TEXT NOT NULL,
        destino TEXT NOT NULL,
        descricao TEXT,
        data_inicio TEXT NOT NULL,
        data_fim TEXT NOT NULL,
        orcamento_total REAL NOT NULL,
        numero_maximo_membros INTEGER NOT NULL,
        criador_id INTEGER NOT NULL,
        codigo TEXT,
        data_criacao TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (criador_id) REFERENCES users(id)
    )";
    $db->exec($sql2);

    // Criar tabela de relacionamento (MUITOS para MUITOS)
    $sql3 = "CREATE TABLE IF NOT EXISTS usuario_grupo (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario_id INTEGER NOT NULL,
        grupo_id INTEGER NOT NULL,
        data_entrada TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES users(id),
        FOREIGN KEY (grupo_id) REFERENCES grupos(id),
        UNIQUE(usuario_id, grupo_id)
    )";
    $db->exec($sql3);

    // Tabela para contribuições ao cofre
    $sql4 = "CREATE TABLE IF NOT EXISTS contribuicoes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        grupo_id INTEGER NOT NULL,
        usuario_id INTEGER NOT NULL,
        valor REAL NOT NULL,
        data_contribuicao TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (grupo_id) REFERENCES grupos(id),
        FOREIGN KEY (usuario_id) REFERENCES users(id)
    )";
    $db->exec($sql4);

    // Tabela para atividades do grupo
    $sql5 = "CREATE TABLE IF NOT EXISTS atividades (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        grupo_id INTEGER NOT NULL,
        usuario_id INTEGER NOT NULL,
        tipo TEXT NOT NULL,
        descricao TEXT NOT NULL,
        data_atividade TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (grupo_id) REFERENCES grupos(id),
        FOREIGN KEY (usuario_id) REFERENCES users(id)
    )";
    $db->exec($sql5);

    echo "✅ Todas as tabelas criadas com sucesso!<br>";
    
    // Verificar se as tabelas foram criadas
    $tables = ['users', 'grupos', 'usuario_grupo', 'contribuicoes', 'atividades'];
    foreach ($tables as $table) {
        $stmt = $db->query("SELECT COUNT(*) as count FROM sqlite_master WHERE type='table' AND name='$table'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['count'] > 0) {
            echo "✅ Tabela '$table' criada com sucesso!<br>";
            
            // Se for a tabela grupos, verificar e adicionar coluna codigo se necessário
            if ($table === 'grupos') {
                // Verificar se a coluna codigo existe
                $stmt_columns = $db->query("PRAGMA table_info(grupos)");
                $columns = $stmt_columns->fetchAll(PDO::FETCH_COLUMN, 1);
                
                if (!in_array('codigo', $columns)) {
                    // Adicionar coluna codigo SEM UNIQUE inicialmente
                    $db->exec("ALTER TABLE grupos ADD COLUMN codigo TEXT");
                    echo "✅ Coluna 'codigo' adicionada à tabela grupos<br>";
                }
                
                // Agora gerar códigos para grupos existentes
                $stmt_grupos = $db->query("SELECT COUNT(*) as total FROM grupos WHERE codigo IS NULL OR codigo = ''");
                $result_grupos = $stmt_grupos->fetch(PDO::FETCH_ASSOC);
                
                if ($result_grupos['total'] > 0) {
                    // Gerar códigos únicos para grupos existentes
                    $db->exec("UPDATE grupos SET codigo = 'GRUPO-' || id WHERE codigo IS NULL OR codigo = ''");
                    echo "✅ Códigos gerados para " . $result_grupos['total'] . " grupos<br>";
                    
                    // Agora adicionar constraint UNIQUE após preencher todos os códigos
                    try {
                        $db->exec("CREATE UNIQUE INDEX idx_grupos_codigo ON grupos(codigo)");
                        echo "✅ Índice único criado para a coluna codigo<br>";
                    } catch (PDOException $e) {
                        echo "⚠️ Aviso: Não foi possível criar índice único para codigo (pode haver duplicatas)<br>";
                    }
                } else {
                    echo "✅ Todos os grupos já possuem código<br>";
                }
            }
        } else {
            echo "❌ Erro ao criar tabela '$table'<br>";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ Erro durante o setup: " . $e->getMessage();
    echo "<br>Detalhes: " . $e->getMessage();
}
?>
