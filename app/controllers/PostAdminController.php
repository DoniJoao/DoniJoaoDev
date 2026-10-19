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
    public function criar() {
        $this->exigirLogin();
        $mensagem_erro = null;

        if ($this->ehPost()) {
            $titulo   = $_POST['titulo'];
            $slug     = $this->gerarSlug($titulo);
            $resumo   = $_POST['resumo'];
            $conteudo = $_POST['conteudo'];
            $status   = $_POST['status'];
            $imagem_capa = ''; // Padrão

            // --- UPLOAD DA IMAGEM DE CAPA ---
            if (isset($_FILES['imagem_capa']) && $_FILES['imagem_capa']['error'] === UPLOAD_ERR_OK) {
                $arquivo = $_FILES['imagem_capa'];
                $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
                $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
                $tamanhoMaximo = 2 * 1024 * 1024;

                if (!in_array($extensao, $extensoesPermitidas)) {
                    $mensagem_erro = "Formato de imagem inválido.";
                } elseif ($arquivo['size'] > $tamanhoMaximo) {
                    $mensagem_erro = "A imagem é muito grande. O limite é 2MB.";
                } else {
                    $novoNome = uniqid('post_') . '.' . $extensao;
                    $pastaDestino = __DIR__ . '/../../assets/img/posts/';
                    
                    if (!is_dir($pastaDestino)) {
                        mkdir($pastaDestino, 0777, true);
                    }

                    if (move_uploaded_file($arquivo['tmp_name'], $pastaDestino . $novoNome)) {
                        $imagem_capa = $novoNome;
                    } else {
                        $mensagem_erro = "Erro ao salvar a imagem no servidor.";
                    }
                }
            }

            if ($mensagem_erro === null) {
                $postModel = new Post($this->db());
                if ($postModel->criar($titulo, $slug, $resumo, $conteudo, $imagem_capa, $status)) {
                    $this->redirect('index.php?pagina=admin_post_listar');
                } else {
                    $mensagem_erro = "Erro ao salvar o post no banco de dados.";
                }
            }
        }

        $this->view('admin_post_criar', ['mensagem_erro' => $mensagem_erro]);
    }

    // index.php?pagina=admin_post_editar&id=X
    public function editar() {
        $this->exigirLogin();
        $mensagem_erro = null;
        $id = $_GET['id'] ?? null;

        if ($id === null) {
            $this->redirect('index.php?pagina=admin_post_listar');
        }

        $postModel = new Post($this->db());
        $post_atual = $postModel->buscarPorId($id);

        if (!$post_atual) {
            $this->redirect('index.php?pagina=admin_post_listar');
        }

        if ($this->ehPost()) {
            $titulo   = $_POST['titulo'];
            $slug     = $this->gerarSlug($titulo);
            $resumo   = $_POST['resumo'];
            $conteudo = $_POST['conteudo'];
            $status   = $_POST['status'];
            $imagem_capa = $post_atual['imagem_capa']; // Mantém a antiga

            // --- UPLOAD DA IMAGEM DE CAPA ---
            if (isset($_FILES['imagem_capa']) && $_FILES['imagem_capa']['error'] === UPLOAD_ERR_OK) {
                $arquivo = $_FILES['imagem_capa'];
                $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
                $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
                $tamanhoMaximo = 2 * 1024 * 1024;

                if (!in_array($extensao, $extensoesPermitidas)) {
                    $mensagem_erro = "Formato de imagem inválido.";
                } elseif ($arquivo['size'] > $tamanhoMaximo) {
                    $mensagem_erro = "A imagem é muito grande. O limite é 2MB.";
                } else {
                    $novoNome = uniqid('post_') . '.' . $extensao;
                    $pastaDestino = __DIR__ . '/../../assets/img/posts/';
                    
                    if (!is_dir($pastaDestino)) {
                        mkdir($pastaDestino, 0777, true);
                    }

                    if (move_uploaded_file($arquivo['tmp_name'], $pastaDestino . $novoNome)) {
                        if (!empty($post_atual['imagem_capa']) && file_exists($pastaDestino . $post_atual['imagem_capa'])) {
                            unlink($pastaDestino . $post_atual['imagem_capa']);
                        }
                        $imagem_capa = $novoNome;
                    } else {
                        $mensagem_erro = "Erro ao salvar a nova imagem.";
                    }
                }
            }

            if ($mensagem_erro === null) {
                if ($postModel->atualizar($id, $titulo, $slug, $resumo, $conteudo, $imagem_capa, $status)) {
                    $this->redirect('index.php?pagina=admin_post_listar');
                } else {
                    $mensagem_erro = "Erro ao atualizar o post no banco.";
                }
            }
            
            $post_atual['titulo'] = $titulo;
            $post_atual['resumo'] = $resumo;
            $post_atual['conteudo'] = $conteudo;
        }

        $this->view('admin_post_editar', [
            'post_atual' => $post_atual,
            'mensagem_erro' => $mensagem_erro
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
    public function deletar() {
        $this->exigirLogin();
        $id = $_GET['id'] ?? null;

        if ($id !== null) {
            $postModel = new Post($this->db());
            $post = $postModel->buscarPorId($id);
            
            // Deleta a imagem física antes
            if ($post && !empty($post['imagem_capa'])) {
                $pasta = __DIR__ . '/../../assets/img/posts/';
                if (file_exists($pasta . $post['imagem_capa'])) {
                    unlink($pasta . $post['imagem_capa']);
                }
            }

            $postModel->deletar($id);
        }

        $this->redirect('index.php?pagina=admin_post_listar');
    }
}