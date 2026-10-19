<?php

class Produto {
    private $conn;
    private $table_name = "produtos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Mantido exatamente como você tinha (Vitrine)
    public function listarAtivos() {
        $query = "SELECT id, nome, slug, descricao, preco, imagem 
                  FROM " . $this->table_name . " 
                  WHERE status = 1 
                  ORDER BY id DESC"; 

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // NOVO: Lista todos (para o painel admin, publicados e rascunhos)
    public function listarTodos() {
        $query = "SELECT id, nome, slug, descricao, preco, imagem, status, data_criacao 
                  FROM " . $this->table_name . " 
                  ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // NOVO: Busca por ID (para a tela de editar)
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // NOVO: Criar Produto
    public function criar($nome, $slug, $descricao, $preco, $imagem, $status) {
        // Converte a vírgula do padrão brasileiro para ponto antes de salvar no banco
        $preco = str_replace(',', '.', $preco);

        $query = "INSERT INTO " . $this->table_name . " 
                  (nome, slug, descricao, preco, imagem, status) 
                  VALUES (:nome, :slug, :descricao, :preco, :imagem, :status)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":slug", $slug);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":imagem", $imagem);
        $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // NOVO: Atualizar Produto
    public function atualizar($id, $nome, $slug, $descricao, $preco, $imagem, $status) {
        // Converte a vírgula
        $preco = str_replace(',', '.', $preco);

        $query = "UPDATE " . $this->table_name . " 
                  SET nome = :nome, slug = :slug, descricao = :descricao, 
                      preco = :preco, imagem = :imagem, status = :status 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":slug", $slug);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":imagem", $imagem);
        $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // NOVO: Mudar Status (Publicar / Ocultar)
    public function mudarStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // NOVO: Deletar Produto
    public function deletar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}