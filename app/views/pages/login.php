<main class="container mt-5">
    <div class="row justify-content-center">
        <!-- Controla a largura do card: ocupa 6 colunas no tablet e 4 no PC -->
        <div class="col-md-6 col-lg-4">
            
            <div class="card shadow-sm mt-5">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Acesso Restrito</h3>

                    <!-- Se o Controlador mandar um erro de login, nós desenhamos este alerta -->
                    <?php if (isset($erro_login)): ?>
                        <div class="alert alert-danger text-center">
                            <?php echo $erro_login; ?>
                        </div>
                    <?php endif; ?>

                    <!-- O formulário envia os dados (POST) para a própria página de login -->
                    <form action="index.php?pagina=login" method="POST">
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <!-- required obriga o usuário a preencher antes de enviar -->
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        
                        <button type="submit" class="btn btn-dark w-100">Entrar no Painel</button>
                        
                    </form>

                </div>
            </div>
            
        </div>
    </div>
</main>