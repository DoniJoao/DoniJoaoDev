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

     public function ver() {
     $slug = $_GET['slug'] ?? '';
     $postModel = new Post($this->db());
     $post_atual = $postModel->buscarPorSlug($slug);

     if (!$post_atual) {
         $this->redirect('index.php');
     }

     // --- INÍCIO DA BUSCA DE COMENTÁRIOS ---
     $comentarioModel = new Comentario($this->db());
     $comentarios = $comentarioModel->listarAprovadosPorPost($post_atual['id'])->fetchAll();
     // --- FIM ---

     $this->view('post_unico', [
         'post_atual' => $post_atual,
         'comentarios' => $comentarios
     ]);
    }
}