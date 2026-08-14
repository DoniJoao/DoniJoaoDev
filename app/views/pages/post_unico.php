<?php
/** 
 * @var array $post_atual 
 */
?>
<main class="container mt-5">
<!-- o resto do seu HTML continua aqui... -->

<main class="container mt-5">
    
    <!-- Botão de Voltar -->
    <a href="index.php" class="btn btn-outline-secondary mb-4">&larr; Voltar para o Blog</a>

    <article>
        <!-- Categoria e Título -->
        <span class="badge bg-primary mb-2">
            <?php echo htmlspecialchars($post_atual['categoria_nome']); ?>
        </span>
        
        <h1 class="display-4 fw-bold">
            <?php echo htmlspecialchars($post_atual['titulo']); ?>
        </h1>
        
        <!-- Data -->
        <p class="text-muted mb-4">
            Publicado em: <?php echo date('d/m/Y', strtotime($post_atual['data_criacao'])); ?>
        </p>

        <!-- Capa (Só exibe se existir imagem cadastrada) -->
        <?php if (!empty($post_atual['imagem_capa'])): ?>
            <img src="assets/img/<?php echo htmlspecialchars($post_atual['imagem_capa']); ?>" alt="Capa do artigo" class="img-fluid rounded mb-4 w-100" style="max-height: 400px; object-fit: cover;">
        <?php endif; ?>

        <hr class="mb-5">

        <!-- Conteúdo do Artigo (Imprime o HTML salvo no banco) -->
        <div class="conteudo-artigo" style="font-size: 1.1rem; line-height: 1.8;">
            <?php echo $post_atual['conteudo']; ?>
        </div>
    </article>

</main>