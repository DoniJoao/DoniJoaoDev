<main class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Puxando o nome do administrador direto da Sessão -->
        <h2>Painel de Controle</h2>
        <a href="index.php?pagina=logout" class="btn btn-outline-danger">Sair (Logout)</a>
    </div>

    <div class="alert alert-success">
        Olá, <strong><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></strong>! Bem-vindo de volta ao seu painel.
    </div>

    <div class="row mt-5">
        <!-- Card: Gerenciar Blog -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h4 class="card-title"><i class="bi bi-file-earmark-text"></i> Meu Blog</h4>
                    <p class="card-text text-muted">Crie novos artigos, edite os rascunhos ou exclua postagens antigas.</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <a href="index.php?pagina=admin_post_criar" class="btn btn-primary w-100 mb-2">Novo Artigo</a>
                    <button class="btn btn-outline-secondary w-100" disabled>Listar Artigos (Em breve)</button>
                </div>
            </div>
        </div>

        <!-- Card: Gerenciar Produtos -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h4 class="card-title"><i class="bi bi-box-seam"></i> Minha Vitrine</h4>
                    <p class="card-text text-muted">Adicione novos produtos para venda ou altere preços e descrições.</p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <button class="btn btn-success w-100 mb-2" disabled>Novo Produto (Em breve)</button>
                    <button class="btn btn-outline-secondary w-100" disabled>Listar Produtos (Em breve)</button>
                </div>
            </div>
        </div>
    </div>
</main>