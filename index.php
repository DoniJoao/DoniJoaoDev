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
    'admin_post_criar' => 'app/views/pages/admin_post_criar.php',
    'admin_post_status' => 'app/views/pages/admin_post_listar.php',
    'admin_post_editar' => 'app/views/pages/admin_post_editar.php',
    'admin_perfil'     => 'app/views/pages/admin_perfil.php'
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
                $_SESSION['usuario_id'] = $usuario['id'];
                
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

        if ($id !== null && $novo_status !== null) {
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
            $status = $_POST['status'];

            $database = new Database();
            $db = $database->getConnection();
            $postModel = new Post($db);

            if ($postModel->criar($titulo, $slug, $resumo, $conteudo, $status)) {
                $mensagem_sucesso = "Post publicado com sucesso!";
            } else {
                $mensagem_erro = "Erro ao salvar o post. Tente novamente.";
            }
        }
    }
    // ROTA: EDITAR POST (O Motor)
    elseif ($pagina === 'admin_post_editar') {
        // Bloqueio de segurança
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header("Location: index.php?pagina=login");
            exit;
        }

        // Pega o ID da URL
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Se não tem ID válido, expulsa de volta pra listagem
        if (!$id) {
            header("Location: index.php?pagina=admin_post_listar");
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $postModel = new Post($db);

        // Se o formulário foi enviado (Botão de Salvar clicado)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'];
            // Gera um novo slug baseado no título editado
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo))); 
            
            $resumo = $_POST['resumo'];
            $conteudo = $_POST['conteudo'];
            $status = $_POST['status'];

            if ($postModel->atualizar($id, $titulo, $slug, $resumo, $conteudo, $status)) {
                $mensagem_sucesso = "Artigo atualizado com sucesso!";
            } else {
                $mensagem_erro = "Erro ao atualizar o artigo. Tente novamente.";
            }
        }

        // Busca os dados atuais do post no banco para preencher o formulário
        $post_atual = $postModel->buscarPorId($id);

        // Se tentou editar um post que foi apagado ou não existe
        if (!$post_atual) {
            header("Location: index.php?pagina=admin_post_listar");
            exit;
        }
        elseif ($pagina === 'admin_perfil') {
        // Proteção da página
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header("Location: index.php?pagina=login");
            exit;
        }

        $usuario_id = $_SESSION['usuario_id']; // Pega o ID da sessão que arrumamos ali em cima

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $senha_atual = $_POST['senha_atual'];
            $nova_senha = $_POST['nova_senha'];
            $confirmar_senha = $_POST['confirmar_senha'];

            $database = new Database();
            $db = $database->getConnection();
            $usuarioModel = new Usuario($db);

            // Busca os dados do usuário para checar a senha antiga
            $usuario = $usuarioModel->buscarPorId($usuario_id);

            // Validações
            if (password_verify($senha_atual, $usuario['senha'])) {
                if ($nova_senha === $confirmar_senha) {
                    if (strlen($nova_senha) >= 6) {
                        
                        $novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                        
                        if ($usuarioModel->atualizarSenha($usuario_id, $novo_hash)) {
                            $mensagem_sucesso = "Sua senha foi alterada com sucesso!";
                        } else {
                            $mensagem_erro = "Erro ao salvar a nova senha no banco de dados.";
                        }
                    } else {
                        $mensagem_erro = "A nova senha deve ter pelo menos 6 caracteres.";
                    }
                } else {
                    $mensagem_erro = "A nova senha e a confirmação não coincidem.";
                }
            } else {
                $mensagem_erro = "A senha atual está incorreta.";
            }
        }
    }

    // Injeta o conteúdo visual da página selecionada
    require_once $paginasPermitidas[$pagina];
    }

    // Injeta o conteúdo visual da página selecionada
    require_once $paginasPermitidas[$pagina];

} else {
    echo '<main class="container mt-5"><h2>Erro 404 - Página não encontrada!</h2></main>';
}

// 6. Carrega o rodapé
require_once 'app/views/partials/footer.php';
?>