<?php

class ComentarioController extends Controller
{
    public function enviar() {
        if (!$this->ehPost()) {
            $this->redirect('index.php');
        }

        // 1. PROTEÇÃO HONEYPOT (Bots preenchem o campo invisível, humanos não)
        if (!empty($_POST['website'])) {
            // Se o bot preencheu o campo escondido, finge que deu certo e bloqueia silenciosamente.
            $this->redirect('index.php');
        }

        $post_id  = $_POST['post_id'] ?? null;
        $slug     = $_POST['slug'] ?? '';
        $nome     = trim($_POST['nome'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $mensagem = trim($_POST['mensagem'] ?? '');

        if (!$post_id || empty($nome) || empty($email) || empty($mensagem)) {
            $this->redirect("index.php?pagina=post&slug={$slug}&erro=vazio");
        }

        // 2. PROTEÇÃO DE LIMITE (Evita flood de 1 minuto por comentário)
        $agora = time();
        if (isset($_SESSION['ultimo_comentario']) && ($agora - $_SESSION['ultimo_comentario']) < 60) {
            $this->redirect("index.php?pagina=post&slug={$slug}&erro=rapido");
        }

        $comentarioModel = new Comentario($this->db());
        if ($comentarioModel->criar($post_id, $nome, $email, $mensagem)) {
            $_SESSION['ultimo_comentario'] = $agora; // Salva o horário
            $this->redirect("index.php?pagina=post&slug={$slug}&sucesso=1");
        } else {
            $this->redirect("index.php?pagina=post&slug={$slug}&erro=banco");
        }
    }
}