<?php
class AuthController extends Controller
{
    public function login()
    {
        // Já logado? Vai direto pro painel.
        if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
            $this->redirect('index.php?pagina=admin');
        }

        $erro_login = null;

        if ($this->ehPost()) {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $usuarioModel = new Usuario($this->db());
            $usuario = $usuarioModel->buscarPorEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                session_regenerate_id(true); // evita fixação de sessão
                $_SESSION['logado']       = true;
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_id']   = $usuario['id'];

                $this->redirect('index.php?pagina=admin');
            }

            $erro_login = "E-mail ou senha incorretos!";
        }

        $this->view('login', ['erro_login' => $erro_login]);
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('index.php?pagina=login');
    }
}