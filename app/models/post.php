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
                  WHERE p.status = 1
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
                    p.slug = :slug AND p.status = 1
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        
        // Segurança: bindParam impede SQL Injection na URL
        $stmt->bindParam(":slug", $slug);
        
        $stmt->execute();

        // Como esperamos apenas UM post, usamos fetch() em vez de fetchAll()
        return $stmt->fetch();
    }
    // Método para criar um novo post no banco
    public function criar($titulo, $slug, $resumo, $conteudo, $categoria_id, $status) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (titulo, slug, resumo, conteudo, categoria_id, status, data_criacao) 
                  VALUES 
                  (:titulo, :slug, :resumo, :conteudo, :categoria_id, :status, NOW())";

        $stmt = $this->conn->prepare($query);

        // Segurança: O bindParam limpa os dados e evita ataques de SQL Injection
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":slug", $slug);
        $stmt->bindParam(":resumo", $resumo);
        $stmt->bindParam(":conteudo", $conteudo);
        $stmt->bindParam(":categoria_id", $categoria_id);
        $stmt->bindParam(":status", $status);

        // Executa e retorna true se der certo, ou false se falhar
        return $stmt->execute();
    }
    // Busca TODOS os posts para o painel admin
    public function listarTodos() {
        $query = "SELECT p.id, p.titulo, p.status, c.nome as categoria_nome, p.data_criacao 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN categorias c ON p.categoria_id = c.id 
                  ORDER BY p.id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Altera o status de um post específico
    public function mudarStatus($id, $novo_status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $novo_status);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }
}