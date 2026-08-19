<?php
// 1. INICIA A SESSÃO (Tem que ser a primeira linha de código útil!)
session_start();
// 1. Carrega os arquivos de Banco de Dados e Models PRIMEIRO
require_once 'app/config/database.php';
require_once 'app/models/Post.php';
require_once 'app/models/Produto.php';
require_once 'app/models/Usuario.php';

    // Captura a página da URL
    $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'blog';

    // ==========================================
    // AÇÃO: LOGOUT (Intercepta antes de tudo!)
    // ==========================================
    if ($pagina === 'logout') {
        session_destroy(); // Rasga o crachá
        header("Location: index.php?pagina=login"); // Manda pro login
        exit; // O "exit" é vital! Ele manda o PHP parar a leitura do arquivo aqui mesmo.
    }
    // ==========================================

// 2. Carrega as partes de cima do site
require_once 'app/views/partials/header.php';
require_once 'app/views/partials/nav.php';

// 3. Lógica de Roteamento
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'blog';

// 4. Segurança (Array de Rotas Permitidas)
$paginasPermitidas = [
    'blog'        => 'app/views/pages/blog.php',
    'post'        => 'app/views/pages/post_unico.php',
    'produtos'    => 'app/views/pages/produtos.php',
    'contato'     => 'app/views/pages/contato.php',
    'login'       => 'app/views/pages/login.php',
    'admin'       => 'app/views/pages/admin.php',
    // A página de leitura do post individual vai entrar aqui depois!
];

// 5. O Maestro: Conecta Model e View
if (array_key_exists($pagina, $paginasPermitidas)) {
    
    // ROTA 1: BLOG
    if ($pagina === 'blog') {
        $database = new Database();
        $db = $database->getConnection();
        
        $postModel = new Post($db);
        $stmt = $postModel->listarPublicados();
        $posts = $stmt->fetchAll(); 
    }
    // ROTA 2: POST INDIVIDUAL
    else if ($pagina === 'post') {
        $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
        
        $database = new Database();
        $db = $database->getConnection();
        
        $postModel = new Post($db);
        $post_atual = $postModel->buscarPorSlug($slug);

        if (!$post_atual) {
            header("Location: index.php");
            exit;
        }
    }
    // ROTA 3: PRODUTOS (É aqui que a mágica acontece!)
    else if ($pagina === 'produtos') {
        $database = new Database();
        $db = $database->getConnection();
        
        $produtoModel = new Produto($db);
        $stmt = $produtoModel->listarAtivos();
        
        $produtos = $stmt->fetchAll(); // Aqui nós CRIAMOS a variável
    }

    // ROTA: LOGIN
    elseif ($pagina === 'login') {
        // Se o usuário já estiver logado, não precisa ver o login, vai direto pro painel!
        if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
            header("Location: index.php?pagina=admin");
            exit;
        }

        // Verifica se o usuário clicou no botão "Entrar" (enviou o formulário via POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $database = new Database();
            $db = $database->getConnection();
            $usuarioModel = new Usuario($db);

            // Busca o usuário no banco
            $usuario = $usuarioModel->buscarPorEmail($email);

            // A mágica acontece aqui: 
            // 1. Verifica se o e-mail existe ($usuario)
            // 2. password_verify pega a senha digitada e compara com o Hash gigante do banco
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                
                // Credenciais corretas! Criamos o "crachá" na Sessão
                $_SESSION['logado'] = true;
                $_SESSION['usuario_nome'] = $usuario['nome'];
                
                // Manda o usuário para a página de administração
                header("Location: index.php?pagina=admin");
                exit;

            } else {
                // Se errar a senha ou e-mail, criamos a variável que acende o alerta vermelho na tela
                $erro_login = "E-mail ou senha incorretos!";
            }
            }
            // ROTA: ADMIN (Painel de Controle)
        elseif ($pagina === 'admin') {
            // O Porteiro: Se NÃO existir o crachá de logado, manda pro login!
            if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
                header("Location: index.php?pagina=login");
                exit;
            }
        }
    }
    // Injeta o conteúdo do meio na tela
    require_once $paginasPermitidas[$pagina];

} else {
    echo '<main class="container mt-5"><h2>Erro 404 - Página não encontrada!</h2></main>';
}
// 6. Carrega o rodapé
require_once 'app/views/partials/footer.php';
?>