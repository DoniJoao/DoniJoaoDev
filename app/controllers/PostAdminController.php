<?php
class PostAdminController extends Controller
{
    // index.php?pagina=admin_post_listar
    public function listar()
    {
        $this->exigirLogin();

        $postModel = new Post($this->db());
        $posts_admin = $postModel->listarTodos()->fetchAll();

        $this->view('admin_post_listar', ['posts_admin' => $posts_admin]);
    }

    // index.php?pagina=admin_post_criar
    public function criar()
    {
        $this->exigirLogin();

        $mensagem_sucesso = null;
        $mensagem_erro    = null;

        if ($this->ehPost()) {
            $titulo   = $_POST['titulo']   ?? '';
            $resumo   = $_POST['resumo']   ?? '';
            $conteudo = $_POST['conteudo'] ?? '';
            $status   = $_POST['status']   ?? 'rascunho';
            $slug     = $this->gerarSlug($titulo);

            $postModel = new Post($this->db());

            if ($postModel->criar($titulo, $slug, $resumo, $conteudo, $status)) {
                $mensagem_sucesso = "Post publicado com sucesso!";
            } else {
                $mensagem_erro = "Erro ao salvar o post. Tente novamente.";
            }
        }

        $this->view('admin_post_criar', [
            'mensagem_sucesso' => $mensagem_sucesso,
            'mensagem_erro'    => $mensagem_erro,
        ]);
    }

    // index.php?pagina=admin_post_editar&id=X
    public function editar()
    {
        $this->exigirLogin();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if (!$id) {
            $this->redirect('index.php?pagina=admin_post_listar');
        }

        $postModel = new Post($this->db());

        $mensagem_sucesso = null;
        $mensagem_erro    = null;

        if ($this->ehPost()) {
            $titulo   = $_POST['titulo']   ?? '';
            $resumo   = $_POST['resumo']   ?? '';
            $conteudo = $_POST['conteudo'] ?? '';
            $status   = $_POST['status']   ?? 'rascunho';
            $slug     = $this->gerarSlug($titulo);

            if ($postModel->atualizar($id, $titulo, $slug, $resumo, $conteudo, $status)) {
                $mensagem_sucesso = "Artigo atualizado com sucesso!";
            } else {
                $mensagem_erro = "Erro ao atualizar o artigo. Tente novamente.";
            }
        }

        $post_atual = $postModel->buscarPorId($id);

        if (!$post_atual) {
            $this->redirect('index.php?pagina=admin_post_listar');
        }

        $this->view('admin_post_editar', [
            'post_atual'       => $post_atual,
            'mensagem_sucesso' => $mensagem_sucesso,
            'mensagem_erro'    => $mensagem_erro,
        ]);
    }

    // index.php?pagina=admin_post_status&id=X&status=Y  -> só age e redireciona
    public function mudarStatus()
    {
        $this->exigirLogin();

        $id          = $_GET['id']     ?? null;
        $novo_status = $_GET['status'] ?? null;

        if ($id !== null && $novo_status !== null) {
            $postModel = new Post($this->db());
            $postModel->mudarStatus((int) $id, $novo_status);
        }

        $this->redirect('index.php?pagina=admin_post_listar');
    }
}