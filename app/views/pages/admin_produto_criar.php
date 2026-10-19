<main class="container mt-5 mb-5" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Novo Produto</h2>
        <a href="index.php?pagina=admin_produto_listar" class="btn btn-outline-secondary">Voltar</a>
    </div>

    <?php if (!empty($mensagem_erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($mensagem_erro); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="index.php?pagina=admin_produto_criar" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nome do Produto</label>
                    <input type="text" name="nome" class="form-control" required placeholder="Ex: Camiseta Dev">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Preço (R$)</label>
                    <input type="text" name="preco" class="form-control" required placeholder="Ex: 49,90">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Imagem do Produto (Max 2MB)</label>
                    <input type="file" name="imagem" class="form-control" accept="image/jpeg, image/png, image/webp">
                    <div class="form-text">Formatos aceitos: JPG, PNG, WEBP.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Status Inicial</label>
                    <select name="status" class="form-select">
                        <option value="0" selected>Rascunho (não aparece no site)</option>
                        <option value="1">Publicado (visível na vitrine)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">Salvar Produto</button>
            </form>
        </div>
    </div>
</main>