<?php
/**
 * Classe-mãe de todos os controllers.
 * Guarda o que se repetia em TODAS as rotas do index antigo:
 * conexão, redirect, checagem de login e renderização da view.
 */
abstract class Controller
{
    private $conexao = null;

    /** Conexão preguiçosa: só abre o banco quando alguém pede. */
    protected function db()
    {
        if ($this->conexao === null) {
            $database = new Database();
            $this->conexao = $database->getConnection();
        }
        return $this->conexao;
    }

    /** Renderiza header + nav + página + footer. Cada item de $dados vira variável na view. */
    protected function view($pagina, $dados = [])
    {
        extract($dados);
        require __DIR__ . '/../views/partials/header.php';
        require __DIR__ . '/../views/partials/nav.php';
        require __DIR__ . '/../views/pages/' . $pagina . '.php';
        require __DIR__ . '/../views/partials/footer.php';
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    /** Porteiro das páginas do painel. */
    protected function exigirLogin()
    {
        if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            $this->redirect('index.php?pagina=login');
        }
    }

    protected function ehPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /** Estava duplicado no criar e no editar. */
    protected function gerarSlug($titulo)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $titulo), '-'));
    }
}