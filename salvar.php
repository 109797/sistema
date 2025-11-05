<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método não permitido.';
    exit;
}

$titulo = trim($_POST['titulo'] ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');

if ($titulo === '' || $mensagem === '') {
    http_response_code(400);
    echo 'Por favor, preencha título e mensagem.';
    exit;
}

try {
    $pdo = new PDO('sqlite:' . __DIR__ . DIRECTORY_SEPARATOR . 'banco.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('INSERT INTO sugestao (titulo, mensagem, data) VALUES (:titulo, :mensagem, :data)');
    $stmt->execute([
        ':titulo' => $titulo,
        ':mensagem' => $mensagem,
        ':data' => date('Y-m-d H:i:s'),
    ]);

    echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><title>Sugestão enviada</title><link rel="stylesheet" href="css/styles.css"></head><body>';
    echo '<header><div class="container"><h1>TI Verde</h1></div></header>';
    echo '<main>';
    echo '<section class="hero" style="background:var(--accent-color);padding:40px 0"><div class="container">';
    echo '<h2 class="text-primary">Sugestão enviada com sucesso!</h2>';
    echo '<p class="text-primary">Obrigado por contribuir com a comunidade de TI Verde.</p>';
    echo '<div class="hero-actions" style="margin-top:10px">';
    echo '<a class="btn btn-primary" href="listar.php">Ver sugestões</a>';
    echo '<a class="btn btn-secondary" href="index.php#sugestao">Enviar outra sugestão</a>';
    echo '<a class="btn" href="index.php">Ir para a página inicial</a>';
    echo '</div>';
    echo '</div></section>';
    echo '</main>';
    echo '<footer><div class="container"><p>Site desenvolvido como projeto educacional sobre TI Verde</p></div></footer>';
    echo '<script src="js/menu.js"></script>';
    echo '</body></html>';
} catch (Throwable $e) {
    http_response_code(500);
    echo '<!doctype html><html lang="pt-br"><meta charset="utf-8"><title>Erro</title><body>';
    echo '<h1>Erro ao salvar a sugestão</h1>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    echo '</body></html>';
}