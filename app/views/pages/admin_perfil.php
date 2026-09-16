<main class="container mt-5 mb-5" style="max-width: 600px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Meu Perfil</h2>
        <a href="index.php?pagina=admin" class="btn btn-outline-secondary">Voltar ao Painel</a>
    </div>

    <!-- Mensagens de Feedback -->
    <?php if (isset($mensagem_sucesso)): ?>
        <div class="alert alert-success"><?php echo $mensagem_sucesso; ?></div>
    <?php endif; ?>
    <?php if (isset($mensagem_erro)): ?>
        <div class="alert alert-danger"><?php echo $mensagem_erro; ?></div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="card-title mb-4">Alterar Senha</h5>
            
            <form action="index.php?pagina=admin_perfil" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Senha Atual</label>
                    <input type="password" name="senha_atual" class="form-control" required placeholder="Digite a senha atual">
                </div>
                
                <hr class="my-4">

                <div class="mb-3">
                    <label class="form-label fw-bold">Nova Senha</label>
                    <input type="password" name="nova_senha" class="form-control" required placeholder="Mínimo 6 caracteres">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Confirmar Nova Senha</label>
                    <input type="password" name="confirmar_senha" class="form-control" required placeholder="Repita a nova senha">
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2"><i class="bi bi-shield-lock"></i> Atualizar Senha</button>
            </form>
        </div>
    </div>
</main>