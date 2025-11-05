# Projeto: Software e ODS 9 (Indústria, Inovação e Infraestrutura)

Foco educacional em como o desenvolvimento de software e soluções digitais colaboram diretamente para o ODS 9: fortalecer a inovação, construir infraestrutura resiliente e promover industrialização inclusiva e sustentável.

## Sobre o Projeto

Este projeto foi desenvolvido para demonstrar, com exemplos práticos, como softwares contribuem para o ODS 9. A abordagem cobre desde arquitetura e automação até observabilidade e melhoria contínua, alinhando inovação tecnológica com infraestrutura resiliente.

## Tecnologias Utilizadas

- PHP 8.x com SQLite (PDO)
- HTML5, CSS3 e JavaScript
- Chart.js para visualização de dados

## Estrutura do Projeto

- `index.php` – Página inicial com formulário de sugestões
- `salvar.php`, `listar.php`, `mensagem.php`, `excluir.php` – Fluxo completo (CRUD) de sugestões
- `css/` – Estilos e paleta de cores
- `js/` – Scripts e dados
- `img/` – Recursos visuais
- `cria_banco.php` – Inicialização do banco SQLite

## Como Software colabora com o ODS 9

- Infraestrutura digital resiliente: serviços em camadas, APIs estáveis e monitoramento ativo (observabilidade) reduzem falhas e aumentam disponibilidade.
- Automação e eficiência: CI/CD, scripts e orquestração diminuem custo operacional e aumentam a qualidade em escala.
- Inovação aberta: padrões, componentes reutilizáveis e dados abertos aceleram pesquisa e desenvolvimento.
- Otimização e manutenção preditiva: análise de dados, dashboards e alertas antecipam problemas em operações e infraestrutura.
- Escalabilidade sustentável: uso racional de recursos computacionais e design eficiente promove crescimento com menor impacto.

## Funcionalidades do Sistema

- Enviar, listar, detalhar e excluir sugestões (CRUD) com PHP + SQLite
- Validações de entrada, sanitização e prepared statements (segurança)
- Interface com navegação clara e estilos consistentes

## Como Usar

1. Clone este repositório
2. Siga o guia abaixo para instalar e configurar o XAMPP (Windows)
3. Acesse `http://localhost/verde/`

## Guia de Instalação e Configuração (XAMPP no Windows)

### 1) Baixar e instalar o XAMPP
- Vá até `https://www.apachefriends.org/` e baixe a versão do XAMPP compatível com seu Windows.
- Execute o instalador e aceite as opções padrão (incluindo Apache e PHP).
- Após instalar, abra o `XAMPP Control Panel`.

### 2) Iniciar serviços necessários
- No `XAMPP Control Panel`, clique em `Start` em `Apache`.
- (Opcional) Inicie `MySQL` se precisar, mas este projeto usa `SQLite`.

### 3) Colocar o projeto no htdocs
- Copie a pasta do projeto para `d:\xampp\htdocs\`.
- O caminho final deve ficar: `d:\xampp\htdocs\verde`.

### 4) Ativar SQLite (se necessário)
- Este projeto usa `PDO SQLite`. Em muitos XAMPPs isso já vem ativo. Se aparecer erro como `could not find driver`:
  - Abra `d:\xampp\php\php.ini`.
  - Garanta que as linhas abaixo NÃO estão comentadas (sem `;` no início):
    - `extension=pdo_sqlite`
    - `extension=sqlite3`
  - Salve e reinicie o `Apache` pelo `XAMPP Control Panel`.

### 5) Inicializar o banco de dados
- No navegador, acesse `http://localhost/verde/cria_banco.php` para criar `banco.db` e a tabela `sugestao`.
- Você verá a mensagem de sucesso com link para `listar.php`.

### 6) Entrar no sistema
- Página inicial: `http://localhost/verde/`.
- Enviar sugestão: use o formulário em `index.php` (seção "Envie sua dica de TI Verde").
- Ver sugestões: clique em `Ver Sugestões` ou acesse `http://localhost/verde/listar.php`.
- Detalhar sugestão: clique no título da sugestão para abrir `mensagem.php?id=...`.
- Excluir sugestão: use o botão `Excluir` em `listar.php`.

### 7) Alternativa: servidor PHP embutido
- Se preferir não usar Apache/XAMPP, você pode usar o servidor embutido do PHP:
  - Abra o PowerShell em `d:\xampp\htdocs\verde`.
  - Execute: `php -S 127.0.0.1:8080 -t .`
  - Acesse: `http://127.0.0.1:8080/`

### 8) Solução de problemas
- `Not Found` ao acessar `http://localhost/`: certifique-se de usar `http://localhost/verde/` (o projeto está em um subdiretório).
- `Banco de dados não encontrado` em `listar.php`: acesse `cria_banco.php` primeiro para criar `banco.db`.
- `could not find driver`: habilite `pdo_sqlite` e `sqlite3` no `php.ini` e reinicie `Apache`.
- Cache do navegador: faça `Ctrl+F5` para atualizar se mudanças não aparecerem.

## Observação sobre Deploy

GitHub Pages não executa PHP. Para publicar online, utilize hospedagem com suporte a PHP ou mantenha o front estático e conecte a um backend externo.

## Compatibilidade

- Chrome (recomendado)
- Firefox
- Edge
- Safari

## Licença

Este projeto é de código aberto e pode ser usado livremente para fins educacionais.