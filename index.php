<?php
// 1. Carrega os arquivos de Banco de Dados e Models PRIMEIRO
require_once 'app/config/database.php';
require_once 'app/models/Post.php';

// 2. Carrega as partes de cima do site
require_once 'app/views/partials/header.php';
require_once 'app/views/partials/nav.php';

// 3. Lógica de Roteamento
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'blog';

// 4. Segurança (Array de Rotas Permitidas)
$paginasPermitidas = [
    'blog'        => 'app/views/pages/blog.php',
    'post'        => 'app/views/pages/post_unico.php',
    'ferramentas' => 'app/views/pages/tools.php',
    'wallpapers'  => 'app/views/pages/wallpapers.php',
    'produtos'    => 'app/views/pages/produtos.php',
    'contato'     => 'app/views/pages/contato.php'
    // A página de leitura do post individual vai entrar aqui depois!
];

// 5. O Maestro: Conecta Model e View
if (array_key_exists($pagina, $paginasPermitidas)) {
    
   // Se a página for o blog, buscamos todos os posts
    if ($pagina === 'blog') {
        $database = new Database();
        $db = $database->getConnection();
        
        $postModel = new Post($db);
        $stmt = $postModel->listarPublicados();
        $posts = $stmt->fetchAll(); 
    }
    // Se a página for um post único, buscamos apenas ele
    elseif ($pagina === 'post') {
        $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
        
        $database = new Database();
        $db = $database->getConnection();
        
        $postModel = new Post($db);
        $post_atual = $postModel->buscarPorSlug($slug);

        // Se o usuário digitar um slug inválido na URL, voltamos para o index
        if (!$post_atual) {
            header("Location: index.php");
            exit;
        }
    }

    // Injeta o conteúdo do meio (agora a view do blog "enxerga" a variável $posts)
    require_once $paginasPermitidas[$pagina];

} else {
    echo '<main class="container mt-5"><h2>Erro 404 - Página não encontrada!</h2></main>';
}

// 6. Carrega o rodapé
require_once 'app/views/partials/footer.php';
?>