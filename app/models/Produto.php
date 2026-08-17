<?php

class Produto {
    private $conn;
    private $table_name = "produtos";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para listar os produtos na vitrine
    public function listarAtivos() {
        // Query atualizada buscando pelo Booleano 1
        $query = "SELECT 
                    id, nome, slug, descricao, preco, imagem 
                  FROM 
                    " . $this->table_name . " 
                  WHERE 
                    status = 1 
                  ORDER BY 
                    id DESC"; 

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}