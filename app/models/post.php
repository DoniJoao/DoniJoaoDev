<?php

class Post {
    // Variável que vai guardar a conexão com o banco
    private $conn;
    private $table_name = "posts";

    // O construtor é chamado automaticamente quando você cria um "novo Post"
    // Ele exige que você passe a conexão do banco para ele (Injeção de Dependência)
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para buscar os posts que aparecerão na página inicial
    public function listarPublicados() {
        // Escrevemos a query SQL. 
        // Usamos um LEFT JOIN para buscar também o NOME da categoria lá da outra tabela!
        $query = "SELECT 
                    c.nome as categoria_nome, 
                    p.id, p.titulo, p.slug, p.resumo, p.imagem_capa, p.data_criacao
                  FROM 
                    " . $this->table_name . " p
                  LEFT JOIN 
                    categorias c ON p.categoria_id = c.id
                  WHERE 
                    p.status = 'publicado'
                  ORDER BY 
                    p.data_criacao DESC";

        // O PDO "prepara" a query. Isso evita ataques de SQL Injection.
        $stmt = $this->conn->prepare($query);

        // Executa a busca no banco de dados
        $stmt->execute();

        // Retorna os dados para quem pediu (nosso index.php)
        return $stmt;
    }
    // Método para buscar um único post pelo SLUG
    public function buscarPorSlug($slug) {
        $query = "SELECT 
                    c.nome as categoria_nome, 
                    p.* 
                  FROM 
                    " . $this->table_name . " p
                  LEFT JOIN 
                    categorias c ON p.categoria_id = c.id
                  WHERE 
                    p.slug = :slug AND p.status = 'publicado'
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        // Segurança: bindParam impede SQL Injection na URL
        $stmt->bindParam(":slug", $slug);
        
        $stmt->execute();

        // Como esperamos apenas UM post, usamos fetch() em vez de fetchAll()
        return $stmt->fetch();
    }
}