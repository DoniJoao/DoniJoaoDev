-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 22/10/2026 às 19:36
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
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `resumo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conteudo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem_capa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `posts`
--

INSERT INTO `posts` (`id`, `titulo`, `slug`, `resumo`, `conteudo`, `imagem_capa`, `status`, `data_criacao`, `data_atualizacao`) VALUES
(7, 'Construindo meu primeiro MVC em PHP', 'construindo-meu-primeiro-mvc-em-php', 'Começar um projeto independente não é nada fácil, buscando não reinventar a roda, decidi criar o meu próprio blog com uma arquitetura inventada do zero.', '<p>Sair dos tutoriais e construir algo do zero é sempre um desafio. Há algum tempo, comecei a estruturar meu MVP usando <strong>PHP</strong> puro, sem frameworks pesados, para realmente entender(ou relembrar) como as coisas funcionam debaixo dos panos com a stack do Apache.</p>\r\n<p>Já havia feito um projeto caprichado em PHP no 3º semestre da faculdade com o Professor Junior Gonçalves, o Volta ao Mundo.</p>\r\n<p>onde nós tivemos de desenvolver um site php, não precisava ser completamente do zero, 1 vez que o professor disponibilizou o molde dele para a gente dar o pontapé inicial.</p>\r\n<p>Além da personalização, era nosso função garantir uma serie de requisitos por conta própria, como comentários, segurança, responsividade com banco de dados e 1 ou + funções extras únicas.</p>\r\n<p>este blog é quase uma repetição dele, mas com a separação de conceitos entre Models, Views e Controllers, que faz toda a diferença na organização e manutenção do código.</p>\r\n<p>o pulo do gato foi quando publicamos no github Pages, meu primeiro site na web.</p>\r\n<p>meu olhos brilhavam de ver meu projeto no ar para todos verem e interagir</p>\r\n<p>ao final daquele projeto tive a certeza absoluta de que queria seguir carreira como programador/desenvolvedor</p>\r\n<p>este projeto é como um retorno as raízes, desenvolver algo meu, na stack que mais me empenhei, onde ja tive um resultado real e demonstravel</p>\r\n<p>não tenha medo de dar um passo atras, as vezes é preciso para dar um pulo maior a frente !</p>\r\n\r\n<p>teste</p>', 'post_6ad6613cd073e.jpg', 1, '2026-10-19 15:28:12', '2026-10-19 15:32:31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_afiliado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `slug`, `descricao`, `preco`, `imagem`, `link_afiliado`, `status`, `data_criacao`) VALUES
(7, 'Mouse Vertical Ergonômico', 'mouse-vertical-ergon-mico', 'Mouse sem fio focado em ergonomia para prevenir dores no pulso de quem trabalha o dia todo no computador.', 42.69, 'produto_6ada618b523c2.png', 'https://www.mercadolivre.com.br/p/MLB59019868?matt_tool=38524122&pdp_filters=item_id:MLB5776728534&ua=oVen1soZ4gHR5SFXmXgEGcWlGMAew2noFbylpBTQHcYaZaE#origin=share&sid=share&wid=MLB5776728534&action=copy', 1, '2026-10-22 16:17:29'),
(8, 'Teclado Completo C3', 'teclado-completo-c3', 'o Teclado ABNT-2 completo da C3 é um dos melhores que já utilizei, gosto dele pelo custo-beneficio.', 28.30, 'produto_6ada622490dc5.png', 'https://www.mercadolivre.com.br/p/MLB39786007?matt_tool=38524122&pdp_filters=item_id:MLB4623753271&ua=yAi7nYYp9A_h0JmkFBtElOm1l3URAlCIIGwSxjJNnMjk15E#origin=share&sid=share&wid=MLB4623753271&action=copy', 1, '2026-10-22 16:21:08'),
(9, 'Monitor Fmaxx 19 com HDMI e VGA ', 'monitor-fmaxx-19-com-hdmi-e-vga', 'Tela BBB.\r\nbonita, boa e Barata.\r\ntem mehlores opções eu admito, mas é uma tela decente.\r\ntem como fazer ajuste ergonômico ( me incomoda muito quando um monitor não tem isso )\r\ne tem uma otima qualidade para um tela que custa menos de 300R$.', 199.90, 'produto_6ada6411cea93.png', 'https://www.mercadolivre.com.br/p/MLB29902763?matt_tool=38524122&pdp_filters=item_id:MLB5371536654&ua=euEYv-xdCY9VD2U-iJ4eS-dkwMh3hLU8ZAj7jdN0fu3i0l8#origin=share&sid=share&wid=MLB5371536654&action=copy', 1, '2026-10-22 16:29:21');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_criacao`) VALUES
(1, 'Doni Joao', 'admin@donijoao.com', '$2y$10$SOchxU6Owl/7Q1tFghpwtOrc51BerXh055ikXVo9nNpvZEEcgu6Au', '2026-08-19 14:55:20');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
