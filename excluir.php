<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

$dbPath = __DIR__ . DIRECTORY_SEPARATOR . 'banco.db';
if (!file_exists($dbPath)) {
    echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><title>Excluir</title><link rel="stylesheet" href="css/styles.css"></head><body>';
    echo '<main class="content-section"><div class="container"><h2>Banco de dados não encontrado</h2><p>Execute <a href="cria_banco.php">cria_banco.php</a> para inicializar.</p></div></main>';
    echo '</body></html>';
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { $id = isset($_POST['id']) ? (int)$_POST['id'] : 0; }

if ($id <= 0) {
    http_response_code(400);
    echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><title>Erro</title><link rel="stylesheet" href="css/styles.css"></head><body>';
    echo '<main class="content-section"><div class="container"><h2>ID inválido</h2><p>Voltar para <a href="listar.php">listagem</a>.</p></div></main>';
    echo '</body></html>';
    exit;
}

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $pdo->prepare('DELETE FROM sugestao WHERE id = :id');
        $stmt->execute([':id' => $id]);

        // Página de sucesso da exclusão
        echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><title>Excluída</title><link rel="stylesheet" href="css/styles.css"></head><body>';
        echo '<header><div class="container"><h1>TI Verde</h1></div></header>';
        echo '<main><section class="hero" style="background:var(--accent-color);padding:40px 0"><div class="container">';
        echo '<h2>Sugestão excluída com sucesso</h2>';
        echo '</div></section>';
        echo '<section class="content-section"><div class="container">';
        echo '<p>O registro #' . (int)$id . ' foi removido.</p>';
        echo '<p style="display:flex;gap:8px;flex-wrap:wrap">';
        echo '<a class="btn btn-primary" href="listar.php">Ver sugestões</a>';
        echo '<a class="btn btn-secondary" href="index.php#sugestao">Enviar nova sugestão</a>';
        echo '<a class="btn" href="index.php">Ir para a página inicial</a>';
        echo '</p></div></section></main>';
        echo '<footer><div class="container"><p>Site desenvolvido como projeto educacional sobre TI Verde</p></div></footer>';
        echo '</body></html>';
        exit;
    }

    // Buscar título para confirmação
    $stmt = $pdo->prepare('SELECT titulo FROM sugestao WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        http_response_code(404);
        echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><title>Não encontrado</title><link rel="stylesheet" href="css/styles.css"></head><body>';
        echo '<main class="content-section"><div class="container"><h2>Sugestão não encontrada</h2><p>Voltar para <a href="listar.php">listagem</a>.</p></div></main>';
        echo '</body></html>';
        exit;
    }

    $titulo = htmlspecialchars($row['titulo']);
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Excluir sugestão #<?php echo $id; ?> - TI Verde</title>
        <link rel="stylesheet" href="css/styles.css">
        <style>
            .confirm-card { background:#fff; border-radius:10px; padding:18px; box-shadow:0 2px 10px rgba(0,0,0,0.08); }
        </style>
    </head>
    <body>
        <header>
            <div class="container">
                <h1>TI Verde</h1>
                <button class="hamburger"><span></span><span></span><span></span></button>
                <nav>
                    <ul>
                        <li><a href="index.php">Início</a></li>
                        <li><a href="ods12.html">ODS 12</a></li>
                        <li><a href="dados.html">Dados</a></li>
                        <li><a href="listar.php" class="nav-button">Ver Sugestões</a></li>
                        <li><a href="index.php#sugestao" class="nav-button">Enviar Sugestão</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <section class="hero" style="background:var(--accent-color);padding:40px 0">
                <div class="container">
                    <h2>Excluir sugestão #<?php echo $id; ?></h2>
                </div>
            </section>
            <section class="content-section">
                <div class="container">
                    <div class="confirm-card">
                        <p>Tem certeza que deseja excluir a sugestão:</p>
                        <p><strong><?php echo $titulo; ?></strong></p>
                        <form method="post" style="margin-top:12px; display:flex; gap:8px; flex-wrap:wrap">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <button type="submit" class="btn btn-danger">Excluir definitivamente</button>
                            <a class="btn btn-secondary" href="mensagem.php?id=<?php echo $id; ?>">Cancelar</a>
                        </form>
                    </div>
                </div>
            </section>
        </main>

        <footer>
            <div class="container">
                <p>Site desenvolvido como projeto educacional sobre TI Verde</p>
            </div>
        </footer>
        <script src="js/menu.js"></script>
    </body>
    </html>
    <?php
} catch (Throwable $e) {
    http_response_code(500);
    echo '<!doctype html><html lang="pt-br"><meta charset="utf-8"><title>Erro</title><body>';
    echo '<h1>Erro ao excluir</h1>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    echo '</body></html>';
}