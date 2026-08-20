<main class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gerenciar Artigos</h2>
        <div>
            <a href="index.php?pagina=admin_post_criar" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Novo Artigo</a>
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
                            <th class="py-3">Título</th>
                            <th class="py-3">Categoria</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($posts_admin)): ?>
                            <?php foreach ($posts_admin as $post): ?>
                                <tr>
                                    <td class="px-4 text-muted">#<?php echo $post['id']; ?></td>
                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($post['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($post['categoria_nome']); ?></td>
                                    
                                    <td class="text-center">
                                        <!-- No PHP, == 1 verifica se é verdadeiro -->
                                        <?php if ($post['status'] == 1): ?>
                                            <span class="badge bg-success">Publicado</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Rascunho</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="px-4 text-end">
                                        <?php if ($post['status'] == 1): ?>
                                            <!-- Manda status=0 para ocultar -->
                                            <a href="index.php?pagina=admin_post_status&id=<?php echo $post['id']; ?>&status=0" class="btn btn-sm btn-outline-warning" title="Reverter para Rascunho">
                                                <i class="bi bi-eye-slash"></i> Ocultar
                                            </a>
                                        <?php else: ?>
                                            <!-- Manda status=1 para publicar -->
                                            <a href="index.php?pagina=admin_post_status&id=<?php echo $post['id']; ?>&status=1" class="btn btn-sm btn-outline-success" title="Publicar Artigo">
                                                <i class="bi bi-eye"></i> Publicar
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Nenhum artigo encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>