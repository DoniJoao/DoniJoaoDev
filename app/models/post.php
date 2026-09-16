<?php

class Post {
    private $conn;
    private $table_name = "posts";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Busca apenas posts publicados (status = 1) para a vitrine/home
    public function listarPublicados() {
        $query = "SELECT id, titulo, slug, resumo, imagem_capa, data_criacao 
                  FROM " . $this->table_name . " 
                  WHERE status = 1 
                  ORDER BY data_criacao DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Busca um único post pelo SLUG para a página de leitura
    public function buscarPorSlug($slug) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE slug = :slug AND status = 1 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":slug", $slug);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cria um novo post no banco
    public function criar($titulo, $slug, $resumo, $conteudo, $status) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (titulo, slug, resumo, conteudo, status, data_criacao) 
                  VALUES 
                  (:titulo, :slug, :resumo, :conteudo, :status, NOW())";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":slug", $slug);
        $stmt->bindParam(":resumo", $resumo);
        $stmt->bindParam(":conteudo", $conteudo);
        $stmt->bindParam(":status", $status);

        return $stmt->execute();
    }

    // Busca TODOS os posts (publicados e rascunhos) para o painel admin
    public function listarTodos() {
        $query = "SELECT id, titulo, status, data_criacao 
                  FROM " . $this->table_name . " 
                  ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Altera o status de um post (Publicado / Rascunho)
    public function mudarStatus($id, $novo_status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $novo_status);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    // Busca um único post pelo ID para preencher o formulário de edição
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Salva as alterações feitas no post
    public function atualizar($id, $titulo, $slug, $resumo, $conteudo, $status) {
        $query = "UPDATE " . $this->table_name . " 
                  SET titulo = :titulo, slug = :slug, resumo = :resumo, 
                      conteudo = :conteudo, status = :status
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':resumo', $resumo);
        $stmt->bindParam(':conteudo', $conteudo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}