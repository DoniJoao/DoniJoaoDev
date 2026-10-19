<main class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gerenciar Produtos</h2>
        <div>
            <a href="index.php?pagina=admin_produto_criar" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Novo Produto</a>
            <a href="index.php?pagina=admin" class="btn btn-outline-secondary">Voltar</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="py-3">Imagem</th>
                            <th class="py-3">Nome</th>
                            <th class="py-3">Preço</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($produtos_admin)): ?>
                            <?php foreach ($produtos_admin as $prod): ?>
                                <tr>
                                    <td class="px-4 text-muted">#<?php echo $prod['id']; ?></td>
                                    
                                    <td>
                                        <?php if (!empty($prod['imagem'])): ?>
                                            <img src="<?php echo BASE_URL; ?>assets/img/produtos/<?php echo $prod['imagem']; ?>" style="height: 40px; width: 40px; object-fit: cover;" class="rounded border">
                                        <?php else: ?>
                                            <span class="badge bg-light text-secondary border">Sem foto</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($prod['nome']); ?></td>
                                    <td>R$ <?php echo number_format($prod['preco'], 2, ',', '.'); ?></td>
                                    
                                    <td class="text-center">
                                        <?php if ($prod['status'] == 1): ?>
                                            <a href="index.php?pagina=admin_produto_editar&id=<?php echo $prod['id']; ?>" class="badge bg-success text-decoration-none">
                                                Publicado <i class="bi bi-pencil-fill ms-1" style="font-size: 0.75rem;"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="index.php?pagina=admin_produto_editar&id=<?php echo $prod['id']; ?>" class="badge bg-secondary text-decoration-none">
                                                Rascunho <i class="bi bi-pencil-fill ms-1" style="font-size: 0.75rem;"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="px-4 text-end">
                                        <?php if ($prod['status'] == 1): ?>
                                            <a href="index.php?pagina=admin_produto_status&id=<?php echo $prod['id']; ?>&status=0" class="btn btn-sm btn-outline-warning" title="Ocultar">
                                                <i class="bi bi-eye-slash"></i> Ocultar
                                            </a>
                                        <?php else: ?>
                                            <a href="index.php?pagina=admin_produto_status&id=<?php echo $prod['id']; ?>&status=1" class="btn btn-sm btn-outline-success" title="Publicar">
                                                <i class="bi bi-eye"></i> Publicar
                                            </a>
                                        <?php endif; ?>

                                        <a href="index.php?pagina=admin_produto_deletar&id=<?php echo $prod['id']; ?>" class="btn btn-sm btn-outline-danger" title="Excluir Produto" onclick="return confirm('Tem certeza que deseja excluir este produto? A imagem também será apagada.');">
                                            <i class="bi bi-trash"></i> Excluir
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Nenhum produto encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>