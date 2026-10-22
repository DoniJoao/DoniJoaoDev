<main class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Moderar Comentários</h2>
        <a href="index.php?pagina=admin" class="btn btn-outline-secondary">Voltar ao Painel</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Data</th>
                            <th class="py-3">Autor / Post</th>
                            <th class="py-3" style="width: 40%;">Comentário</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($comentarios_admin)): ?>
                            <?php foreach ($comentarios_admin as $comentario): ?>
                                <!-- Deixa a linha inteira cinza clara se for spam -->
                                <tr class="<?php echo $comentario['status'] == 2 ? 'table-secondary text-muted' : ''; ?>">
                                    
                                    <td class="px-4 text-muted small">
                                        <?php echo date('d/m/Y H:i', strtotime($comentario['data_criacao'])); ?>
                                    </td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark"><?php echo htmlspecialchars($comentario['nome']); ?></div>
                                        <div class="small text-muted"><?php echo htmlspecialchars($comentario['email']); ?></div>
                                        <div class="small mt-1">
                                            No post: <a href="index.php?pagina=post&slug=<?php echo $comentario['post_slug'] ?? '#'; ?>" target="_blank" class="text-decoration-none">
                                                <?php echo htmlspecialchars($comentario['post_titulo']); ?>
                                            </a>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div style="max-height: 100px; overflow-y: auto; white-space: pre-wrap; font-size: 0.9rem;">
                                            <?php echo htmlspecialchars($comentario['mensagem']); ?>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if ($comentario['status'] == 1): ?>
                                            <span class="badge bg-success">Aprovado</span>
                                        <?php elseif ($comentario['status'] == 2): ?>
                                            <span class="badge bg-danger">Spam</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Pendente</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="px-4 text-end">
                                        <?php if ($comentario['status'] != 1): ?>
                                            <a href="index.php?pagina=admin_comentario_status&id=<?php echo $comentario['id']; ?>&status=1" class="btn btn-sm btn-outline-success mb-1" title="Aprovar Comentário">
                                                <i class="bi bi-check-lg"></i> Aprovar
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($comentario['status'] != 2): ?>
                                            <a href="index.php?pagina=admin_comentario_status&id=<?php echo $comentario['id']; ?>&status=2" class="btn btn-sm btn-outline-warning mb-1" title="Marcar como Spam">
                                                <i class="bi bi-shield-x"></i> Spam
                                            </a>
                                        <?php endif; ?>

                                        <a href="index.php?pagina=admin_comentario_deletar&id=<?php echo $comentario['id']; ?>" class="btn btn-sm btn-outline-danger mb-1" title="Excluir Comentário" onclick="return confirm('Tem certeza que deseja excluir este comentário permanentemente?');">
                                            <i class="bi bi-trash"></i> Excluir
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Nenhum comentário recebido ainda.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>