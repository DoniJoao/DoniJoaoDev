<?php
class AdminController extends Controller
{
    // index.php?pagina=admin
    public function painel()
    {
        $this->exigirLogin();
        $this->view('admin');
    }

    // index.php?pagina=admin_perfil
    public function perfil()
    {
        $this->exigirLogin();

        $mensagem_sucesso = null;
        $mensagem_erro    = null;

        if ($this->ehPost()) {
            $usuario_id      = $_SESSION['usuario_id'];
            $senha_atual     = $_POST['senha_atual'] ?? '';
            $nova_senha      = $_POST['nova_senha'] ?? '';
            $confirmar_senha = $_POST['confirmar_senha'] ?? '';

            $usuarioModel = new Usuario($this->db());
            $usuario = $usuarioModel->buscarPorId($usuario_id);

            if (!$usuario || !password_verify($senha_atual, $usuario['senha'])) {
                $mensagem_erro = "A senha atual está incorreta.";
            } elseif ($nova_senha !== $confirmar_senha) {
                $mensagem_erro = "A nova senha e a confirmação não coincidem.";
            } elseif (strlen($nova_senha) < 6) {
                $mensagem_erro = "A nova senha deve ter pelo menos 6 caracteres.";
            } else {
                $novo_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

                if ($usuarioModel->atualizarSenha($usuario_id, $novo_hash)) {
                    $mensagem_sucesso = "Sua senha foi alterada com sucesso!";
                } else {
                    $mensagem_erro = "Erro ao salvar a nova senha no banco de dados.";
                }
            }
        }

        $this->view('admin_perfil', [
            'mensagem_sucesso' => $mensagem_sucesso,
            'mensagem_erro'    => $mensagem_erro,
        ]);
    }
}