/doni-ti
│
├── /assets              (Tudo que vai para o navegador do usuário)
│   ├── /css             (Seus estilos customizados, se houver)
│   ├── /js              (Scripts de interação)
│   └── /img             (A sua foto de perfil, capa, imagens dos produtos)
│
├── /config              (Configurações do servidor)
│   └── database.php     (Arquivo com os dados de acesso ao MySQL/MariaDB)
│
├── /models              (As "Regras de Negócio" e Banco de Dados)
│   ├── Produto.php      (Classe para buscar, salvar e deletar produtos)
│   └── Post.php         (Classe para gerenciar as postagens do blog)
│
├── /views               (O visual, mas de forma inteligente)
│   ├── /partials        (Os "pedaços" que se repetem: header.php, nav.php, footer.php)
│   └── /pages           (O conteúdo do meio: home.php, blog.php, contato.php)
│
└── index.php            (O "Porteiro" do seu site - Front Controller)