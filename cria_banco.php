<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

try {
    $dbPath = __DIR__ . DIRECTORY_SEPARATOR . 'banco.db';
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON');

    $pdo->exec('CREATE TABLE IF NOT EXISTS sugestao (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL,
        mensagem TEXT NOT NULL,
        data TEXT NOT NULL
    )');

    echo '<!doctype html><html lang="pt-br"><meta charset="utf-8"><title>Inicialização do Banco</title><body>';
    echo '<h1>Banco e tabela criados com sucesso.</h1>';
    echo '<p>Arquivo: ' . htmlspecialchars($dbPath) . '</p>';
    echo '<p><a href="listar.php">Ver sugestões cadastradas</a></p>';
    echo '</body></html>';
} catch (Throwable $e) {
    http_response_code(500);
    echo '<!doctype html><html lang="pt-br"><meta charset="utf-8"><title>Erro</title><body>';
    echo '<h1>Erro ao criar banco/tabela</h1>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    echo '</body></html>';
}