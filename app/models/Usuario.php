<?php

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para buscar um usuário pelo E-mail
    public function buscarPorEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        // Segurança: bindParam impede SQL Injection
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->fetch(); // Retorna os dados do usuário ou "false" se não achar
    }
    // Busca o usuário pelo ID
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualiza a senha (espera receber o hash pronto)
    public function atualizarSenha($id, $senha_hash) {
        $query = "UPDATE " . $this->table_name . " SET senha = :senha WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":senha", $senha_hash);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }
}