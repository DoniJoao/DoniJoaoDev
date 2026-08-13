<div class="container mt-4">
        <h2>Por favor, se tiver alguma sugestão fique a vontade !</h2>
        <form action="enviarComentario.php" method="post">
          <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" required />
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" class="form-control" id="email" name="email" required />
          </div>

          <div class="mb-3">
            <label for="numero" class="form-label">Numero:(opcional)</label>
            <input type="number" class="form-control" id="numero" name="numero"/>
          </div>

          <div class="mb-3">
            <label for="mensagem" class="form-label">Mensagem:</label>
            <textarea class="form-control" id="mensagem" name="mensagem" rows="4" required></textarea>
          </div>
          <button class="btn btn-primary" type="submit">Enviar</button>
        </form>
      </div>