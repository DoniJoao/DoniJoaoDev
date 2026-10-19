<main class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Artigo</h2>
        <a href="index.php?pagina=admin_post_listar" class="btn btn-outline-secondary">Voltar</a>
    </div>

    <!-- Exibe mensagens de sucesso ou erro -->
    <?php if (isset($mensagem_erro) && !empty($mensagem_erro)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($mensagem_erro); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <!-- ENCTYPE obrigatório para upload -->
            <form action="index.php?pagina=admin_post_editar&id=<?php echo $post_atual['id']; ?>" method="POST" enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Título do Post</label>
                    <input type="text" name="titulo" class="form-control" required value="<?php echo htmlspecialchars($post_atual['titulo']); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Resumo (Para a página inicial)</label>
                    <textarea name="resumo" class="form-control" rows="2" required><?php echo htmlspecialchars($post_atual['resumo']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Imagem de Capa Atual</label>
                    <?php if (!empty($post_atual['imagem_capa'])): ?>
                        <div class="mb-2">
                            <img src="<?php echo BASE_URL; ?>assets/img/posts/<?php echo $post_atual['imagem_capa']; ?>" style="max-height: 150px;" class="img-thumbnail" alt="Capa do post">
                        </div>
                    <?php else: ?>
                        <p class="text-muted small">Nenhuma imagem de capa cadastrada.</p>
                    <?php endif; ?>
                    
                    <input type="file" name="imagem_capa" class="form-control" accept="image/jpeg, image/png, image/webp">
                    <div class="form-text">Deixe em branco para manter a imagem atual. (Max 2MB)</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Conteúdo Completo (Aceita HTML)</label>
                    <textarea name="conteudo" class="form-control" rows="12" required><?php echo htmlspecialchars($post_atual['conteudo']); ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select w-25">
                        <option value="0" <?php echo $post_atual['status'] == 0 ? 'selected' : ''; ?>>Rascunho</option>
                        <option value="1" <?php echo $post_atual['status'] == 1 ? 'selected' : ''; ?>>Publicado (Visível)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Atualizar Postagem</button>
            </form>
        </div>
    </div>
</main>