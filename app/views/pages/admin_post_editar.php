<main class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Artigo #<?php echo $post_atual['id']; ?></h2>
        <a href="index.php?pagina=admin_post_listar" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <!-- Alertas de Sucesso ou Erro após salvar -->
    <?php if (isset($mensagem_sucesso)): ?>
        <div class="alert alert-success shadow-sm"><i class="bi bi-check-circle-fill"></i> <?php echo $mensagem_sucesso; ?></div>
    <?php endif; ?>

    <?php if (isset($mensagem_erro)): ?>
        <div class="alert alert-danger shadow-sm"><i class="bi bi-exclamation-triangle-fill"></i> <?php echo $mensagem_erro; ?></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <!-- A action aponta para a mesma URL com o ID para processar o formulário corretamente -->
            <form action="index.php?pagina=admin_post_editar&id=<?php echo $post_atual['id']; ?>" method="POST">
                
                <div class="mb-3">
                    <label for="titulo" class="form-label fw-bold">Título do Artigo</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($post_atual['titulo']); ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label fw-bold">Slug (URL Amigável)</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="<?php echo htmlspecialchars($post_atual['slug']); ?>" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label fw-bold">Status de Publicação</label>
                        <select class="form-select" id="status" name="status">
                            <!-- O PHP marca com 'selected' o status atual salvo no banco -->
                            <option value="1" <?php echo ($post_atual['status'] == 1) ? 'selected' : ''; ?>>Publicado</option>
                            <option value="0" <?php echo ($post_atual['status'] == 0) ? 'selected' : ''; ?>>Rascunho</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="resumo" class="form-label fw-bold">Resumo</label>
                    <textarea class="form-control" id="resumo" name="resumo" rows="3" required><?php echo htmlspecialchars($post_atual['resumo']); ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="conteudo" class="form-label fw-bold">Conteúdo Completo</label>
                    <!-- Textareas não usam atributo 'value', o texto vai entre as tags de abertura e fechamento -->
                    <textarea class="form-control" id="conteudo" name="conteudo" rows="12" required><?php echo htmlspecialchars($post_atual['conteudo']); ?></textarea>
                </div>

                <hr class="text-muted mb-4">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-bold">
                        <i class="bi bi-save"></i> Salvar Alterações
                    </button>
                </div>

            </form>
        </div>
    </div>
</main>