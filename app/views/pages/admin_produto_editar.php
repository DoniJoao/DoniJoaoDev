<main class="container mt-5 mb-5" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Produto</h2>
        <a href="index.php?pagina=admin_produto_listar" class="btn btn-outline-secondary">Voltar</a>
    </div>

    <?php if (!empty($mensagem_erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($mensagem_erro); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <!-- O ENCTYPE é obrigatório para upload de arquivos -->
            <form action="index.php?pagina=admin_produto_editar&id=<?php echo $produto_atual['id']; ?>" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nome do Produto</label>
                    <input type="text" name="nome" class="form-control" required value="<?php echo htmlspecialchars($produto_atual['nome']); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Preço (R$)</label>
                    <!-- O str_replace abaixo transforma o ponto do banco em vírgula para exibir no input -->
                    <input type="text" name="preco" class="form-control" required value="<?php echo str_replace('.', ',', $produto_atual['preco']); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="4" required><?php echo htmlspecialchars($produto_atual['descricao']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Link de Afiliado (Opcional)</label>
                    <input type="url" name="link_afiliado" class="form-control" value="<?php echo htmlspecialchars($produto_atual['link_afiliado'] ?? ''); ?>" placeholder="Ex: https://mercadolivre.com.br/...">
                    <div class="form-text">O botão "Tenho Interesse" na vitrine apontará para este link.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Imagem Atual</label>
                    <?php if (!empty($produto_atual['imagem'])): ?>
                        <div class="mb-2">
                            <img src="<?php echo BASE_URL; ?>assets/img/produtos/<?php echo $produto_atual['imagem']; ?>" style="max-height: 100px;" class="img-thumbnail" alt="Imagem do produto">
                        </div>
                    <?php else: ?>
                        <p class="text-muted small">Nenhuma imagem cadastrada.</p>
                    <?php endif; ?>
                    
                    <input type="file" name="imagem" class="form-control" accept="image/jpeg, image/png, image/webp">
                    <div class="form-text">Deixe em branco para manter a imagem atual.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="0" <?php echo $produto_atual['status'] == 0 ? 'selected' : ''; ?>>Rascunho (não aparece no site)</option>
                        <option value="1" <?php echo $produto_atual['status'] == 1 ? 'selected' : ''; ?>>Publicado (visível na vitrine)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">Atualizar Produto</button>
            </form>
        </div>
    </div>
</main>