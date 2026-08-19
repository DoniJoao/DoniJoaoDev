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
}