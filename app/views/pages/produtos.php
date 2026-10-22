<?php
/** 
 * @var array $produtos 
 */
?>
<main class="container mt-5">
  <!-- INÍCIO DO DEBUG -->
<!-- <div class="alert alert-danger">
<!--   <strong>Debug de Produtos:</strong><br>
<!--   <pre><?php print_r($produtos); ?></pre>
<!--</div>
  <!-- FIM DO DEBUG -->

  <div class="text-center mb-5">
    <h1 class="display-5 fw-bold">Vitrine do Desenvolvedor</h1>
    <p class="text-muted">Equipamentos e acessórios que eu recomendo para o seu setup.</p>
  </div>

  <hr class="mb-5">

  <div class="row">
    <?php if (!empty($produtos)): ?>
        <?php foreach ($produtos as $produto): ?>
          <!-- col-md-4 coloca 3 cards por linha no computador -->
          <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100 border-0 bg-light">
              
              <!-- Se no futuro você adicionar foto, ela entra aqui -->
              <?php if (!empty($produto['imagem'])): ?>
                <img src="<?php echo BASE_URL; ?>assets/img/produtos/<?php echo $produto['imagem']; ?>" class="card-img-top" alt="Falha ao carregar a imagem do produto" style="height: 150px; object-fit: cover;">
              <?php else: ?>
                <!-- Um espaço reservado bonitinho caso não tenha imagem -->
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 150px; opacity: 0.2;">
                    <span>Sem Foto</span>
                </div>
              <?php endif; ?>

              <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold text-dark">
                    <?php echo htmlspecialchars($produto['nome']); ?>
                </h5>
                
                <!-- Formatando o preço com padrão Brasileiro (Vírgula e Ponto) -->
                <h3 class="text-success my-3">
                    R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                </h3>
                
                <p class="card-text text-muted small">
                    <?php echo htmlspecialchars($produto['descricao']); ?>
                </p>
                
                <?php if (!empty($produto['link_afiliado'])): ?>
                  <!-- Se tiver link, abre em nova aba -->
                  <a href="<?php echo htmlspecialchars($produto['link_afiliado']); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary w-100">
                      Tenho Interesse <i class="bi bi-box-arrow-up-right ms-1"></i>
                  </a>
                <?php else: ?>
                  <!-- Se não tiver link cadastrado, mostra um botão desabilitado -->
                  <button class="btn btn-outline-secondary w-100" disabled>Sem link</button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center mt-5">
            <div class="alert alert-warning">Nenhum produto disponível no momento. Volte mais tarde!</div>
        </div>
    <?php endif; ?>
  </div>
</main>