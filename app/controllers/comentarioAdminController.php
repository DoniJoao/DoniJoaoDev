<?php

class ComentarioAdminController extends Controller
{
    public function listar() {
        $this->exigirLogin();

        $comentarioModel = new Comentario($this->db());
        $comentarios_admin = $comentarioModel->listarTodos()->fetchAll();

        $this->view('admin_comentario_listar', ['comentarios_admin' => $comentarios_admin]);
    }

    public function mudarStatus() {
        $this->exigirLogin();
        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? null;

        if ($id !== null && $status !== null) {
            $comentarioModel = new Comentario($this->db());
            $comentarioModel->mudarStatus($id, $status);
        }

        $this->redirect('index.php?pagina=admin_comentario_listar');
    }

    public function deletar() {
        $this->exigirLogin();
        $id = $_GET['id'] ?? null;

        if ($id !== null) {
            $comentarioModel = new Comentario($this->db());
            $comentarioModel->deletar($id);
        }

        $this->redirect('index.php?pagina=admin_comentario_listar');
    }
}