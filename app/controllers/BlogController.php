<?php
class BlogController extends Controller
{
    // index.php?pagina=blog
    public function index()
    {
        $postModel = new Post($this->db());
        $posts = $postModel->listarPublicados()->fetchAll();

        $this->view('blog', ['posts' => $posts]);
    }

    // index.php?pagina=post&slug=...
    public function ver()
    {
        $slug = $_GET['slug'] ?? '';

        $postModel = new Post($this->db());
        $post_atual = $postModel->buscarPorSlug($slug);

        if (!$post_atual) {
            $this->redirect('index.php');
        }

        $this->view('post_unico', ['post_atual' => $post_atual]);
    }
}