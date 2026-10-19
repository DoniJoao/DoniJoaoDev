<?php

class ProdutoAdminController extends Controller
{
    // Lista todos os produtos no painel
    public function listar() {
        $this->exigirLogin();

        $produtoModel = new Produto($this->db());
        $produtos_admin = $produtoModel->listarTodos()->fetchAll();

        $this->view('admin_produto_listar', ['produtos_admin' => $produtos_admin]);
    }

    // Tela de criar novo produto + processamento
    public function criar() {
        $this->exigirLogin();
        $mensagem_erro = null;

        if ($this->ehPost()) {
            $nome      = $_POST['nome'];
            $slug      = $this->gerarSlug($nome);
            $descricao = $_POST['descricao'];
            $preco     = $_POST['preco'];
            $status    = $_POST['status'];
            $imagem    = ''; // Padrão vazio

            // --- LÓGICA DE UPLOAD DA IMAGEM ---
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $arquivo = $_FILES['imagem'];
                $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
                $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
                $tamanhoMaximo = 2 * 1024 * 1024; // 2MB

                if (!in_array($extensao, $extensoesPermitidas)) {
                    $mensagem_erro = "Formato de imagem inválido. Use JPG, PNG ou WEBP.";
                } elseif ($arquivo['size'] > $tamanhoMaximo) {
                    $mensagem_erro = "A imagem é muito grande. O limite é 2MB.";
                } else {
                    // Cria um nome único para o arquivo
                    $novoNome = uniqid('produto_') . '.' . $extensao;
                    $pastaDestino = __DIR__ . '/../../assets/img/produtos/';
                    
                    // Cria a pasta se ela não existir
                    if (!is_dir($pastaDestino)) {
                        mkdir($pastaDestino, 0777, true);
                    }

                    if (move_uploaded_file($arquivo['tmp_name'], $pastaDestino . $novoNome)) {
                        $imagem = $novoNome; // Salva apenas o nome no banco
                    } else {
                        $mensagem_erro = "Erro ao salvar o arquivo de imagem no servidor.";
                    }
                }
            }

            // Se não houver erro no upload, tenta salvar no banco
            if ($mensagem_erro === null) {
                $produtoModel = new Produto($this->db());
                if ($produtoModel->criar($nome, $slug, $descricao, $preco, $imagem, $status)) {
                    $this->redirect('index.php?pagina=admin_produto_listar');
                } else {
                    $mensagem_erro = "Erro ao salvar o produto no banco de dados.";
                }
            }
        }

        $this->view('admin_produto_criar', ['mensagem_erro' => $mensagem_erro]);
    }

    // Tela de editar produto + processamento
    public function editar() {
        $this->exigirLogin();
        $mensagem_erro = null;
        $id = $_GET['id'] ?? null;

        if ($id === null) {
            $this->redirect('index.php?pagina=admin_produto_listar');
        }

        $produtoModel = new Produto($this->db());
        $produto_atual = $produtoModel->buscarPorId($id);

        if (!$produto_atual) {
            $this->redirect('index.php?pagina=admin_produto_listar');
        }

        if ($this->ehPost()) {
            $nome      = $_POST['nome'];
            $slug      = $this->gerarSlug($nome);
            $descricao = $_POST['descricao'];
            $preco     = $_POST['preco'];
            $status    = $_POST['status'];
            $imagem    = $produto_atual['imagem']; // Mantém a imagem antiga por padrão

            // --- LÓGICA DE UPLOAD (Só roda se enviar uma NOVA imagem) ---
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $arquivo = $_FILES['imagem'];
                $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
                $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
                $tamanhoMaximo = 2 * 1024 * 1024;

                if (!in_array($extensao, $extensoesPermitidas)) {
                    $mensagem_erro = "Formato de imagem inválido.";
                } elseif ($arquivo['size'] > $tamanhoMaximo) {
                    $mensagem_erro = "A imagem é muito grande (Max 2MB).";
                } else {
                    $novoNome = uniqid('produto_') . '.' . $extensao;
                    $pastaDestino = __DIR__ . '/../../assets/img/produtos/';
                    
                    if (!is_dir($pastaDestino)) {
                        mkdir($pastaDestino, 0777, true);
                    }

                    if (move_uploaded_file($arquivo['tmp_name'], $pastaDestino . $novoNome)) {
                        // Deleta a imagem antiga do disco se ela existir e não for vazia
                        if (!empty($produto_atual['imagem']) && file_exists($pastaDestino . $produto_atual['imagem'])) {
                            unlink($pastaDestino . $produto_atual['imagem']);
                        }
                        $imagem = $novoNome; // Atualiza o nome
                    } else {
                        $mensagem_erro = "Erro ao salvar a nova imagem.";
                    }
                }
            }

            if ($mensagem_erro === null) {
                if ($produtoModel->atualizar($id, $nome, $slug, $descricao, $preco, $imagem, $status)) {
                    $this->redirect('index.php?pagina=admin_produto_listar');
                } else {
                    $mensagem_erro = "Erro ao atualizar o produto no banco.";
                }
            }
            
            // Se deu erro no banco, atualiza os dados na tela para não perder o que foi digitado
            $produto_atual['nome'] = $nome;
            $produto_atual['descricao'] = $descricao;
            $produto_atual['preco'] = $preco;
        }

        $this->view('admin_produto_editar', [
            'produto_atual' => $produto_atual,
            'mensagem_erro' => $mensagem_erro
        ]);
    }

    // Mudar status
    public function mudarStatus() {
        $this->exigirLogin();
        $id = $_GET['id'] ?? null;
        $status = $_GET['status'] ?? null;

        if ($id !== null && $status !== null) {
            $produtoModel = new Produto($this->db());
            $produtoModel->mudarStatus($id, $status);
        }

        $this->redirect('index.php?pagina=admin_produto_listar');
    }

    // Deletar
    public function deletar() {
        $this->exigirLogin();
        $id = $_GET['id'] ?? null;

        if ($id !== null) {
            $produtoModel = new Produto($this->db());
            $produto = $produtoModel->buscarPorId($id);
            
            // Deleta o arquivo físico antes de deletar o banco
            if ($produto && !empty($produto['imagem'])) {
                $pasta = __DIR__ . '/../../assets/img/produtos/';
                if (file_exists($pasta . $produto['imagem'])) {
                    unlink($pasta . $produto['imagem']);
                }
            }

            $produtoModel->deletar($id);
        }

        $this->redirect('index.php?pagina=admin_produto_listar');
    }
}