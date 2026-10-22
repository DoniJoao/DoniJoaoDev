<?php

class Produto {
    private $conn;
    private $table_name = "produtos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Vitrine Pública (agora puxa o link de afiliado também)
    public function listarAtivos() {
        $query = "SELECT id, nome, slug, descricao, preco, imagem, link_afiliado 
                  FROM " . $this->table_name . " 
                  WHERE status = 1 
                  ORDER BY id DESC"; 

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Painel Admin
    public function listarTodos() {
        $query = "SELECT id, nome, slug, descricao, preco, imagem, link_afiliado, status, data_criacao 
                  FROM " . $this->table_name . " 
                  ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Busca por ID
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Criar Produto
    public function criar($nome, $slug, $descricao, $preco, $imagem, $link_afiliado, $status) {
        $preco = str_replace(',', '.', $preco);
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome, slug, descricao, preco, imagem, link_afiliado, status) 
                  VALUES (:nome, :slug, :descricao, :preco, :imagem, :link_afiliado, :status)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":slug", $slug);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":imagem", $imagem);
        $stmt->bindParam(":link_afiliado", $link_afiliado);
        $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Atualizar Produto
    public function atualizar($id, $nome, $slug, $descricao, $preco, $imagem, $link_afiliado, $status) {
        $preco = str_replace(',', '.', $preco);
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = :nome, slug = :slug, descricao = :descricao, 
                      preco = :preco, imagem = :imagem, link_afiliado = :link_afiliado, status = :status 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":slug", $slug);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":imagem", $imagem);
        $stmt->bindParam(":link_afiliado", $link_afiliado);
        $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function mudarStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deletar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}