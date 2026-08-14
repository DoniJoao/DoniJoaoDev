<main class="container mt-5">
  <div class="mb-4">
    <h1>Doni Joao TI</h1>
    <h3 class="text-muted">Desenvolvimento de Software e Tecnologia</h3>
  </div>

  <hr>

  <div class="row mt-4">
    <?php 
    // Verifica se existe alguma postagem no array
    if (!empty($posts)): 
        // Para cada postagem no banco, executa o HTML abaixo
        foreach ($posts as $post): 
    ?>
          <div class="col-md-6 mb-4">
            <!-- A classe h-100 garante que todos os cards fiquem da mesma altura -->
            <div class="card shadow-sm h-100">
              <div class="card-body d-flex flex-column">
                
                <!-- Exibindo a Categoria (Vinda do JOIN) -->
                <span class="badge bg-secondary mb-2" style="width: fit-content;">
                    <?php echo htmlspecialchars($post['categoria_nome']); ?>
                </span>
                
                <!-- Exibindo o Título -->
                <h5 class="card-title"><?php echo htmlspecialchars($post['titulo']); ?></h5>
                
                <!-- Exibindo o Resumo -->
                <p class="card-text text-muted"><?php echo htmlspecialchars($post['resumo']); ?></p>
                
                <!-- Formatando a Data para o padrão Brasileiro -->
                <p class="card-text"><small class="text-muted">
                    Publicado em: <?php echo date('d/m/Y', strtotime($post['data_criacao'])); ?>
                </small></p>
                
                <!-- O Botão já aponta para o SLUG do banco! mt-auto joga o botão pro fundo do card -->
                <a href="index.php?pagina=post&slug=<?php echo $post['slug']; ?>" class="btn btn-primary mt-auto">Ler artigo completo</a>
              
              </div>
            </div>
          </div>
    <?php 
        endforeach; 
    else: 
    ?>
        <div class="col-12">
            <div class="alert alert-info">Ainda não há nenhuma postagem publicada.</div>
        </div>
    <?php endif; ?>
  </div>
</main>