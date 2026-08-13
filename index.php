<?php
// 1. O index.php começa carregando as partes de cima do site
require_once 'app/views/partials/header.php';
require_once 'app/views/partials/nav.php';

// 2. Lógica de Roteamento (Qual página o usuário quer ver?)
// Verifica se existe um "pedido" na URL (ex: index.php?pagina=produtos)
// Se não existir nada, assumimos que a página padrão é o 'blog'
$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 'blog';

// 3. Segurança (Array de Rotas Permitidas)
// Aqui definimos quais páginas existem. Isso impede que um hacker 
// tente acessar arquivos internos mudando a URL.
$paginasPermitidas = [
    'blog'        => 'app/views/pages/blog.php',
    'ferramentas' => 'app/views/pages/tools.php',
    'wallpapers'  => 'app/views/pages/wallpapers.php',
    'produtos'    => 'app/views/pages/produtos.php',
    'contato'     => 'app/views/pages/contato.php'
];

// 4. Injeta o conteúdo do meio
if (array_key_exists($pagina, $paginasPermitidas)) {
    // Se a página existir na nossa lista, nós a carregamos
    require_once $paginasPermitidas[$pagina];
} else {
    // Se o usuário digitar um link inválido (ex: index.php?pagina=hacker)
    echo '<main class="container mt-5"><h2>Erro 404 - Página não encontrada!</h2></main>';
}

// 5. Finaliza a página carregando o rodapé
require_once 'app/views/partials/footer.php';
?>