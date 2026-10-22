<main class="container mt-5 mb-5" style="max-width: 800px;">
    
    <div class="mb-4">
        <a href="index.php" class="btn btn-sm btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Voltar para o Blog</a>
        
        <h1 class="fw-bold"><?php echo htmlspecialchars($post_atual['titulo']); ?></h1>
        <p class="text-muted">Publicado em <?php echo date('d/m/Y', strtotime($post_atual['data_criacao'])); ?></p>
        
        <!-- Imagem de Capa Principal -->
        <?php if (!empty($post_atual['imagem_capa'])): ?>
            <img src="<?php echo BASE_URL; ?>assets/img/posts/<?php echo $post_atual['imagem_capa']; ?>" class="img-fluid rounded shadow-sm mb-4 w-100" alt="<?php echo htmlspecialchars($post_atual['titulo']); ?>" style="max-height: 450px; object-fit: cover;">
        <?php endif; ?>
    </div>

    <!-- Conteúdo (não usar htmlspecialchars aqui, pois aceita HTML puro) -->
    <div class="conteudo-post" style="font-size: 1.1rem; line-height: 1.8;">
        <?php echo $post_atual['conteudo']; ?>
    </div>

        <hr class="my-5">

    <!-- Área de Comentários -->
    <section class="comentarios mt-5">
        <h4 class="fw-bold mb-4">Comentários (<?php echo isset($comentarios) ? count($comentarios) : 0; ?>)</h4>

        <!-- Mensagens de Feedback -->
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success">Seu comentário foi enviado e está aguardando moderação. Obrigado!</div>
        <?php elseif (isset($_GET['erro'])): ?>
            <div class="alert alert-danger">
                <?php 
                    if ($_GET['erro'] == 'vazio') echo "Preencha todos os campos obrigatórios.";
                    elseif ($_GET['erro'] == 'rapido') echo "Aguarde 1 minuto antes de enviar outro comentário.";
                    else echo "Ocorreu um erro ao enviar seu comentário. Tente novamente.";
                ?>
            </div>
        <?php endif; ?>

        <!-- Lista de Comentários -->
        <div class="lista-comentarios mb-5">
            <?php if (empty($comentarios)): ?>
            <p class="text-muted fst-italic">Nenhum comentário ainda. Seja o primeiro a comentar!</p>
            <?php else: ?>
            <?php foreach ($comentarios as $comentario): ?>
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold mb-0 text-primary"><?php echo htmlspecialchars($comentario['nome']); ?></h6>
                                <small class="text-muted"><?php echo date('d/m/Y \à\s H:i', strtotime($comentario['data_criacao'])); ?></small>
                            </div>
                            <p class="mb-0" style="white-space: pre-wrap;"><?php echo htmlspecialchars($comentario['mensagem']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Formulário de Comentário -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="card-title mb-4">Deixe seu comentário</h5>
                <form action="index.php?pagina=comentario_enviar" method="POST">
                    <!-- Campos ocultos para o PHP saber de qual post é o comentário -->
                    <input type="hidden" name="post_id" value="<?php echo $post_atual['id']; ?>">
                    <input type="hidden" name="slug" value="<?php echo $post_atual['slug']; ?>">

                    <!-- Honeypot (Armadilha para bots) - Fica invisível para humanos -->
                    <div style="display: none;">
                        <label>Não preencha este campo se você for humano</label>
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nome (obrigatório)</label>
                            <input type="text" name="nome" class="form-control" required maxlength="100">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">E-mail (não será publicado)</label>
                            <input type="email" name="email" class="form-control" required maxlength="150">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Comentário</label>
                        <textarea name="mensagem" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-chat-dots"></i> Enviar Comentário</button>
                    <div class="form-text mt-2">Seu comentário passará por aprovação antes de ser publicado.</div>
                </form>
            </div>
        </div>
    </section>
    
</main>