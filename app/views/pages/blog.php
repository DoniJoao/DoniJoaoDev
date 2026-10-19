<main class="container mt-5">
  <div class="mb-4">
    <h1>Doni Joao TI</h1>
    <h3 class="text-muted">Desenvolvimento de Software e Tecnologia</h3>
  </div>

  <hr>

  <div class="row">
        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        
                        <!-- Imagem de Capa no Topo do Card -->
                        <?php if (!empty($post['imagem_capa'])): ?>
                            <img src="<?php echo BASE_URL; ?>assets/img/posts/<?php echo $post['imagem_capa']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($post['titulo']); ?>" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($post['titulo']); ?></h5>
                            <p class="card-text text-muted small mb-3">
                                <?php echo date('d/m/Y', strtotime($post['data_criacao'])); ?>
                            </p>
                            <p class="card-text"><?php echo htmlspecialchars($post['resumo']); ?></p>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0 pb-3">
                            <a href="index.php?pagina=post&slug=<?php echo $post['slug']; ?>" class="btn btn-outline-primary w-100">Ler Artigo</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center text-muted">
                <p>Nenhum artigo publicado ainda.</p>
            </div>
        <?php endif; ?>
    </div>
</main>