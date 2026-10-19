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
    
</main>