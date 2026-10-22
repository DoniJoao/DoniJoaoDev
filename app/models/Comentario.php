<?php

class Comentario {
    private $conn;
    private $table_name = "comentarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lista apenas os comentários aprovados (status = 1) de um post específico
    public function listarAprovadosPorPost($post_id) {
        $query = "SELECT nome, mensagem, data_criacao 
                  FROM " . $this->table_name . " 
                  WHERE post_id = :post_id AND status = 1 
                  ORDER BY data_criacao ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Cria um novo comentário (nasce como pendente: status = 0)
    public function criar($post_id, $nome, $email, $mensagem) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (post_id, nome, email, mensagem, status, data_criacao) 
                  VALUES (:post_id, :nome, :email, :mensagem, 0, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":mensagem", $mensagem);
        return $stmt->execute();
    }

    // --- MÉTODOS DO PAINEL ADMIN ---

    // Lista TODOS os comentários para o admin moderar
    public function listarTodos() {
        $query = "SELECT c.id, c.nome, c.email, c.mensagem, c.status, c.data_criacao, p.titulo as post_titulo 
                  FROM " . $this->table_name . " c
                  INNER JOIN posts p ON c.post_id = p.id
                  ORDER BY c.status ASC, c.data_criacao DESC"; // Pendentes primeiro
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
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