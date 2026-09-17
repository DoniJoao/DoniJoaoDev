-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 17/09/2026 às 17:41
-- Versão do servidor: 8.4.7
-- Versão do PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `donijoaodev`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resumo` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conteudo` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem_capa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `titulo`, `slug`, `resumo`, `conteudo`, `imagem_capa`, `status`, `data_criacao`, `data_atualizacao`) VALUES
(1, 'Construindo meu primeiro MVC em PHP', 'construindo-meu-primeiro-mvc-em-php', 'Neste artigo, compartilho os primeiros passos da estruturação do meu projeto pessoal usando PHP puro e o padrão MVC.', '<p>Sair dos tutoriais e construir algo do zero é sempre um desafio. Hoje comecei a estruturar meu MVP usando <strong>PHP</strong> puro, sem frameworks pesados, para realmente entender como as coisas funcionam debaixo dos panos.</p><p>A separação de conceitos entre Models, Views e Controllers faz toda a diferença na organização e manutenção do código.</p>', NULL, 1, '2026-08-14 15:14:16', '2026-09-17 14:12:00'),
(2, 'Expectativa x Realidade do Desenvolvedor Recém-formado', 'expectativa-x-realidade-do-desenvolvedor-rec-m-formado', 'Um pouco sobre a minha visão do mercado de TI após a formatura.', '<p>Ainda estou escrevendo este artigo, logo publicarei mais detalhes sobre as tecnologias que decidi focar, como a stack LAMPP.</p>\r\n\r\n\r\n<h1>TESTANDO !!!<h1/>', NULL, 0, '2026-08-14 15:14:16', '2026-09-17 14:12:07'),
(3, 'Como Liberar Acesso a pasta www do LAMPP', 'como-liberar-acesso-a-pasta-www-do-lampp', 'como abrir permissão para trabalhar com a pasta www da stack LAMPP (linux, apache, mariaDB/mySQL, Pearl e PHP), uma vez que instalar a stack é apenas o primeiro passo.', 'Abra o terminal (pressione `Ctrl + Alt + T`) e execute o comando abaixo para tornar seu usuário o dono da pasta:\r\n\r\n    sudo chown $USER -R /var/www/html\r\n\r\n_Nota: Será solicitada a sua senha do Ubuntu.\r\n\r\n2. Ajustar as Permissões de Leitura e Escrita\r\n\r\nEm seguida, configure as permissões de acesso para que pastas e arquivos possam ser lidos e modificados:\r\n\r\n    sudo chmod 755 -R /var/www/html\r\n\r\nCaso esteja usando um ambiente de desenvolvimento local (como XAMPP) e queira permissão total para evitar qualquer bloqueio futuro, você pode usar a permissão 777:\r\n\r\n    sudo chmod 777 -R /var/www/html\r\n', NULL, 1, '2026-09-17 14:19:39', '2026-09-17 14:20:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `slug`, `descricao`, `preco`, `imagem`, `status`, `data_criacao`) VALUES
(1, 'SSD 1TB NVMe M.2', 'ssd-1tb-nvme-m2', 'SSD de altíssima velocidade para leitura e gravação, ideal para acelerar o boot do sistema operacional e carregamento de projetos no WAMP.', 350.00, NULL, 1, '2026-08-17 17:53:45'),
(2, 'Teclado Mecânico Switch Brown', 'teclado-mecanico-switch-brown', 'Teclado mecânico focado em produtividade. O switch brown oferece feedback tátil sem fazer muito barulho, perfeito para longas sessões de código.', 220.50, NULL, 1, '2026-08-17 17:53:45'),
(3, 'Monitor LG UltraWide 29\"', 'monitor-lg-ultrawide-29', 'Proporção 21:9. Excelente para dividir a tela: VS Code de um lado, navegador com a documentação do PHP do outro.', 980.00, NULL, 1, '2026-08-17 17:53:45'),
(4, 'Memória RAM 16GB DDR4 3200MHz', 'memoria-ram-16gb-ddr4', 'Módulo de memória de alta performance. Essencial para rodar contêineres e bancos de dados locais sem travamentos.', 199.90, NULL, 1, '2026-08-17 17:53:45'),
(5, 'Mouse Vertical Ergonômico', 'mouse-vertical-ergonomico', 'Mouse sem fio focado em ergonomia para prevenir dores no pulso de quem trabalha o dia todo no computador.', 150.00, NULL, 0, '2026-08-17 17:53:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_criacao`) VALUES
(1, 'Doni Joao', 'admin@donijoao.com', '$2y$10$smNO4i/3NIntGx0DpbYI2e0OeK92xCXFEbvOpSoWPcajh8kIRLGli', '2026-08-19 14:55:20');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
