<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

$dbPath = __DIR__ . DIRECTORY_SEPARATOR . 'banco.db';

if (!file_exists($dbPath)) {
    echo '<!doctype html><html lang="pt-br"><head><meta charset="utf-8"><title>Listar sugestões</title><link rel="stylesheet" href="css/styles.css"></head><body>';
    echo '<header><div class="container"><h1>TI Verde</h1></div></header>';
    echo '<main><section class="content-section"><div class="container">';
    echo '<h2>Banco de dados não encontrado</h2>';
    echo '<p>Por favor, execute <a class="btn-link" href="cria_banco.php">cria_banco.php</a> para inicializar.</p>';
    echo '</div></section></main>';
    echo '<footer><div class="container"><p>Site desenvolvido como projeto educacional sobre TI Verde</p></div></footer>';
    echo '</body></html>';
    exit;
}

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT id, titulo, mensagem, data FROM sugestao ORDER BY id DESC');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sugestões TI Verde</title>
        <link rel="stylesheet" href="css/styles.css">
        <style>
            .suggestions-hero {
                background: var(--accent-color);
                padding: 40px 0;
            }
            .suggestions-hero h2 { margin-bottom: 8px; }
            .suggestions-intro { color: #444; }
            .table-responsive { overflow-x: auto; }
            .suggestions-table {
                width: 100%;
                border-collapse: collapse;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                overflow: hidden;
            }
            .suggestions-table th, .suggestions-table td {
                padding: 12px 14px;
                border-bottom: 1px solid #eee;
                text-align: left;
                vertical-align: top;
            }
            .suggestions-table thead th {
                background: var(--secondary-color);
                color: #073b23;
                font-weight: 600;
            }
            .suggestions-table tbody tr:nth-child(even) { background: #fafafa; }
            .badge-id {
                display: inline-block;
                background: var(--primary-color);
                color: #fff;
                padding: 4px 10px;
                border-radius: 999px;
                font-size: 0.85rem;
            }
            .btn-link { display: inline-block; color: var(--primary-color); }
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
                        <li><a href="listar.php" class="nav-button active">Ver Sugestões</a></li>
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
            <section class="hero suggestions-hero">
                <div class="container">
                    <h2>Sugestões da Comunidade</h2>
                    <p class="suggestions-intro">Veja as dicas de TI Verde enviadas pelos visitantes.</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary" href="#lista">Ver Sugestões</a>
                        <a class="btn btn-secondary" href="index.php#sugestao">Enviar Sugestão</a>
                    </div>
                </div>
            </section>

            <section class="content-section" id="lista">
                <div class="container">
                    <?php if (!$rows) { ?>
                        <p>Nenhuma sugestão cadastrada ainda.</p>
                        <p><a class="btn-link" href="index.php">Voltar para a página inicial</a></p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="suggestions-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Mensagem</th>
                                        <th>Data</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rows as $r) { 
                                        $id = (int)$r['id'];
                                        $titulo = htmlspecialchars($r['titulo']);
                                        $mensagem = htmlspecialchars($r['mensagem']);
                                        $snippet = strlen($mensagem) > 140 ? substr($mensagem, 0, 140) . '…' : $mensagem;
                                    ?>
                                        <tr>
                                            <td><span class="badge-id">#<?php echo $id; ?></span></td>
                                            <td><a class="suggestion-link" href="mensagem.php?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></td>
                                            <td><a class="suggestion-link" href="mensagem.php?id=<?php echo $id; ?>"><?php echo nl2br($snippet); ?></a></td>
                                            <td><?php echo htmlspecialchars($r['data']); ?></td>
                                            <td>
                                                <a class="btn btn-danger btn-sm" href="excluir.php?id=<?php echo $id; ?>">Excluir</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <p style="margin-top:16px"><a class="btn-link" href="index.php">Voltar para a página inicial</a></p>
                    <?php } ?>
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
    echo '<h1>Erro ao listar sugestões</h1>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    echo '</body></html>';
}