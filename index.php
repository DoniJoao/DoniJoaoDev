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

// 4. Segurança (Array de Rotas Permitidas)
$paginasPermitidas = [
    'blog'             => 'app/views/pages/blog.php',
    'post'             => 'app/views/pages/post_unico.php',
    'produtos'         => 'app/views/pages/produtos.php',
    'contato'          => 'app/views/pages/contato.php',
    'login'            => 'app/views/pages/login.php',
    'admin'            => 'app/views/pages/admin.php',
    'admin_post_listar'=> 'app/views/pages/admin_post_listar.php',
    'admin_post_criar' => 'app/views/pages/admin_post_criar.php'
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
    elseif ($pagina === 'post') {
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
    // ROTA 3: PRODUTOS
    elseif ($pagina === 'produtos') {
        $database = new Database();
        $db = $database->getConnection();
        
        $produtoModel = new Produto($db);
        $stmt = $produtoModel->listarAtivos();
        
        $produtos = $stmt->fetchAll();
    }
    // ROTA 4: LOGIN
    elseif ($pagina === 'login') {
        // Se o usuário já estiver logado, vai direto pro painel!
        if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
            header("Location: index.php?pagina=admin");
            exit;
        }

        // Verifica se enviou o formulário
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $database = new Database();
            $db = $database->getConnection();
            $usuarioModel = new Usuario($db);

            $usuario = $usuarioModel->buscarPorEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['logado'] = true;
                $_SESSION['usuario_nome'] = $usuario['nome'];
                
                header("Location: index.php?pagina=admin");
                exit;
            } else {
                $erro_login = "E-mail ou senha incorretos!";
            }
        }
    } // <==== AQUI ESTAVA O SEU ERRO! Faltava essa chave para fechar o LOGIN!

    // ROTA: ADMIN (Painel de Controle)
    elseif ($pagina === 'admin') {
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header("Location: index.php?pagina=login");
            exit;
        }
    }
    // ROTA: AÇÃO DE MUDAR STATUS
    elseif ($pagina === 'admin_post_status') {
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header("Location: index.php?pagina=login");
            exit;
        }

        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $novo_status = isset($_GET['status']) ? $_GET['status'] : null;

        if ($id && $novo_status) {
            $database = new Database();
            $db = $database->getConnection();
            $postModel = new Post($db);
            $postModel->mudarStatus($id, $novo_status);
        }

        header("Location: index.php?pagina=admin_post_listar");
        exit;
    }
    // ROTA: LISTAR TODOS OS POSTS (Painel)
    elseif ($pagina === 'admin_post_listar') {
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header("Location: index.php?pagina=login");
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        
        $postModel = new Post($db);
        $stmt = $postModel->listarTodos();
        $posts_admin = $stmt->fetchAll();
    }
    // ROTA: CRIAR NOVO POST
    elseif ($pagina === 'admin_post_criar') {
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header("Location: index.php?pagina=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'];
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo))); 
            
            $resumo = $_POST['resumo'];
            $conteudo = $_POST['conteudo'];
            $categoria_id = $_POST['categoria_id'];
            $status = $_POST['status'];

            $database = new Database();
            $db = $database->getConnection();
            $postModel = new Post($db);

            if ($postModel->criar($titulo, $slug, $resumo, $conteudo, $categoria_id, $status)) {
                $mensagem_sucesso = "Post publicado com sucesso!";
            } else {
                $mensagem_erro = "Erro ao salvar o post. Tente novamente.";
            }
        }
    }

    // Injeta o conteúdo visual da página selecionada
    require_once $paginasPermitidas[$pagina];

} else {
    echo '<main class="container mt-5"><h2>Erro 404 - Página não encontrada!</h2></main>';
}

// 6. Carrega o rodapé
require_once 'app/views/partials/footer.php';
?>