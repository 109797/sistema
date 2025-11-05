<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

$dbPath = __DIR__ . DIRECTORY_SEPARATOR . 'banco.db';
if (!file_exists($dbPath)) {
    echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><title>Sugestão</title><link rel="stylesheet" href="css/styles.css"></head><body>';
    echo '<main class="content-section"><div class="container"><h2>Banco de dados não encontrado</h2><p>Execute <a href="cria_banco.php">cria_banco.php</a> para inicializar.</p></div></main>';
    echo '</body></html>';
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
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

    $stmt = $pdo->prepare('SELECT id, titulo, mensagem, data FROM sugestao WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        http_response_code(404);
        echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><title>Não encontrado</title><link rel="stylesheet" href="css/styles.css"></head><body>';
        echo '<main class="content-section"><div class="container"><h2>Sugestão não encontrada</h2><p>Voltar para <a href="listar.php">listagem</a>.</p></div></main>';
        echo '</body></html>';
        exit;
    }

    $titulo   = htmlspecialchars($row['titulo']);
    $mensagem = nl2br(htmlspecialchars($row['mensagem']));
    $data     = htmlspecialchars($row['data']);
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sugestão #<?php echo (int)$row['id']; ?> - TI Verde</title>
        <link rel="stylesheet" href="css/styles.css">
        <style>
            .detail-hero { background: var(--accent-color); padding: 40px 0; }
            .detail-card {
                background: #fff; border-radius: 10px; padding: 18px; 
                box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            }
            .detail-meta { color: #555; margin-bottom: 12px; }
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
                        <li class="dropdown">
                            <div class="dropbtn-mobile">Práticas Sustentáveis</div>
                            <div class="dropdown-content">
                                <a href="eficiencia-energetica.html">Eficiência Energética</a>
                                <a href="reciclagem-e-lixo.html">Reciclagem de E-lixo</a>
                                <a href="cloud-sustentavel.html">Cloud Computing</a>
                                <a href="datacenters-verdes.html">Data Centers Verdes</a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <main>
            <section class="hero detail-hero">
                <div class="container">
                    <h2>Sugestão #<?php echo (int)$row['id']; ?></h2>
                    <p class="detail-meta">Enviada em <?php echo $data; ?></p>
                </div>
            </section>

            <section class="content-section">
                <div class="container">
                    <div class="detail-card">
                        <h3><?php echo $titulo; ?></h3>
                        <p><?php echo $mensagem; ?></p>
                    </div>
                    <p style="margin-top:14px; display:flex; gap:8px; flex-wrap:wrap">
                        <a class="btn btn-secondary" href="listar.php">Voltar para a listagem</a>
                        <a class="btn btn-primary" href="index.php#sugestao">Enviar nova sugestão</a>
                        <a class="btn btn-danger" href="excluir.php?id=<?php echo (int)$row['id']; ?>">Excluir sugestão</a>
                    </p>
                </div>
            </section>
        </main>

        <footer>
            <div class="container">
                <p>Site desenvolvido como projeto educacional sobre TI Verde</p>
                <p>
                    <a href="https://github.com/seu-usuario/projeto-ti-verde" target="_blank">
                        <object data="img/github.svg" type="image/svg+xml" class="github-icon"></object>
                        Repositório no GitHub
                    </a>
                </p>
            </div>
        </footer>
        <script src="js/menu.js"></script>
    </body>
    </html>
    <?php
} catch (Throwable $e) {
    http_response_code(500);
    echo '<!doctype html><html lang="pt-br"><meta charset="utf-8"><title>Erro</title><body>';
    echo '<h1>Erro ao carregar sugestão</h1>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    echo '</body></html>';
}