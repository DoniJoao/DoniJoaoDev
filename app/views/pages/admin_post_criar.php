<main class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Criar Novo Artigo</h2>
        <a href="index.php?pagina=admin" class="btn btn-outline-secondary">Voltar ao Painel</a>
    </div>

    <!-- Exibe mensagens de sucesso ou erro -->
    <?php if (isset($mensagem_sucesso)): ?>
        <div class="alert alert-success"><?php echo $mensagem_sucesso; ?></div>
    <?php endif; ?>
    <?php if (isset($mensagem_erro)): ?>
        <div class="alert alert-danger"><?php echo $mensagem_erro; ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="index.php?pagina=admin_post_criar" method="POST">
                
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold">Título do Post</label>
                        <input type="text" name="titulo" class="form-control" required placeholder="Ex: Como criar um MVP rápido">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Categoria</label>
                        <select name="categoria_id" class="form-select" required>
                            <!-- Lembrando: 1 e 2 são os IDs que temos no banco de dados -->
                            <option value="1">Back-end</option>
                            <option value="2">Front-end</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Resumo (Para a página inicial)</label>
                    <textarea name="resumo" class="form-control" rows="2" required placeholder="Uma breve descrição que vai aparecer nos cards do blog..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Conteúdo Completo (Aceita HTML)</label>
                    <textarea name="conteudo" class="form-control" rows="8" required placeholder="Escreva o conteúdo do seu post aqui..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select w-25">
                        <option value="publicado">Publicado (Visível para todos)</option>
                        <option value="rascunho">Rascunho (Apenas no banco)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Salvar Postagem</button>
            </form>
        </div>
    </div>
</main>