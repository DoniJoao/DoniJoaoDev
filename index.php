<?php
// ============================================================
// FRONT CONTROLLER - só despacha. Nenhuma regra de negócio aqui.
// ============================================================
session_start();

require_once __DIR__ . '/app/config/database.php';

// Autoload: acha a classe sozinho em core/, models/ e controllers/
spl_autoload_register(function ($classe) {
    $pastas = [
        __DIR__ . '/app/core/',
        __DIR__ . '/app/models/',
        __DIR__ . '/app/controllers/',
    ];
    foreach ($pastas as $pasta) {
        $arquivo = $pasta . $classe . '.php';
        if (file_exists($arquivo)) {
            require_once $arquivo;
            return;
        }
    }
});

// ============================================================
// TABELA DE ROTAS: pagina => [Controller, metodo]
// ============================================================
$rotas = [
    'blog'              => ['BlogController',     'index'],
    'post'              => ['BlogController',     'ver'],
    'produtos'          => ['ProdutoController',  'index'],
    'contato'           => ['ContatoController',   'contato'],

    'login'             => ['AuthController',     'login'],
    'logout'            => ['AuthController',     'logout'],

    'admin'             => ['AdminController',    'painel'],
    'admin_perfil'      => ['AdminController',    'perfil'],

    'admin_post_listar' => ['PostAdminController','listar'],
    'admin_post_criar'  => ['PostAdminController','criar'],
    'admin_post_editar' => ['PostAdminController','editar'],
    'admin_post_status' => ['PostAdminController','mudarStatus'],
];

$pagina = $_GET['pagina'] ?? 'blog';

if (!array_key_exists($pagina, $rotas)) {
    http_response_code(404);
    require __DIR__ . '/app/views/partials/header.php';
    require __DIR__ . '/app/views/partials/nav.php';
    echo '<main class="container mt-5"><h2>Erro 404 - Pagina nao encontrada!</h2></main>';
    require __DIR__ . '/app/views/partials/footer.php';
    exit;
}

list($classe, $metodo) = $rotas[$pagina];

$controller = new $classe();
$controller->$metodo();