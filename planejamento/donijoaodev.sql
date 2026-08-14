-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 14/08/2026 às 16:57
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
CREATE DATABASE IF NOT EXISTS `donijoaodev` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `donijoaodev`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `slug`, `data_criacao`) VALUES
(1, 'Geral', 'geral', '2026-08-14 13:57:09'),
(2, 'PHP & Back-end', 'php-backend', '2026-08-14 13:57:09'),
(3, 'Carreira & TI', 'carreira-ti', '2026-08-14 13:57:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria_id` int DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resumo` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conteudo` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem_capa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('rascunho','publicado') COLLATE utf8mb4_unicode_ci DEFAULT 'rascunho',
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_posts_categorias` (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
--
-- Banco de dados: `expedicao_db`
--
CREATE DATABASE IF NOT EXISTS `expedicao_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `expedicao_db`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `coletas`
--

DROP TABLE IF EXISTS `coletas`;
CREATE TABLE IF NOT EXISTS `coletas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `registrado_por` int DEFAULT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `documento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `placa_veiculo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `assinatura` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_coletas_pedidos` (`pedido_id`),
  KEY `fk_coletas_registrado_por` (`registrado_por`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `coletas`
--

INSERT INTO `coletas` (`id`, `pedido_id`, `registrado_por`, `nome`, `documento`, `placa_veiculo`, `assinatura`, `created_at`) VALUES
(1, 4, 3, 'Marcos Antunes', '123.456.789-00', 'ABC1D23', NULL, '2026-08-05 19:42:57');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque_lotes`
--

DROP TABLE IF EXISTS `estoque_lotes`;
CREATE TABLE IF NOT EXISTS `estoque_lotes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo_produto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lote` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_estoque_produto_lote` (`codigo_produto`,`lote`),
  KEY `codigo_produto` (`codigo_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `estoque_lotes`
--

INSERT INTO `estoque_lotes` (`id`, `codigo_produto`, `lote`, `saldo`) VALUES
(1, 'VNT-40', 'LOTE-26D133', 10),
(2, 'AQ-200', 'LOTE-25D3851', 5),
(3, 'EX-300', 'LOTE-26D200', 8),
(4, 'LMP-100', 'LOTE-26D250', 40),
(5, 'FAN-500', 'LOTE-26D310', 12),
(6, 'AQ-200', 'LOTE-26D400', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

DROP TABLE IF EXISTS `itens_pedido`;
CREATE TABLE IF NOT EXISTS `itens_pedido` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `codigo_produto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lote` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qtd_solicitada` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `codigo_produto` (`codigo_produto`),
  KEY `fk_itens_pedido_lote` (`codigo_produto`,`lote`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `pedido_id`, `codigo_produto`, `lote`, `qtd_solicitada`) VALUES
(1, 1, 'VNT-40', 'LOTE-26D133', 3),
(2, 1, 'AQ-200', 'LOTE-25D3851', 1),
(3, 2, 'EX-300', 'LOTE-26D200', 2),
(4, 2, 'LMP-100', 'LOTE-26D250', 10),
(5, 3, 'FAN-500', 'LOTE-26D310', 3),
(6, 4, 'AQ-200', 'LOTE-26D400', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendente',
  `separado` tinyint(1) DEFAULT '0',
  `volumes_finais` int DEFAULT '0',
  `separado_por` int DEFAULT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `coletado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_separado_por` (`separado_por`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente`, `status`, `separado`, `volumes_finais`, `separado_por`, `data_criacao`, `atualizado_em`, `coletado`) VALUES
(1, 'Indústria de Alimentos Jampac', 'Pendente', 0, 0, NULL, '2026-08-04 13:21:54', '2026-08-05 19:42:56', 0),
(2, 'Metalúrgica Rio Verde Ltda', 'Em Separação', 0, 0, 2, '2026-08-05 19:42:56', '2026-08-05 19:42:56', 0),
(3, 'Distribuidora Solar Norte', 'Separado', 1, 3, 2, '2026-08-05 19:42:56', '2026-08-05 19:42:56', 0),
(4, 'Comércio Nova Era ME', 'Coletado', 1, 2, 2, '2026-08-05 19:42:56', '2026-08-05 19:42:56', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `codigo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`codigo`, `nome`, `descricao`) VALUES
('AQ-200', 'Aquecedor Industrial 20cm', 'Aquecedor 20 centimetros'),
('EX-300', 'Exaustor Industrial 30cm', 'Exaustor 30 centimetros'),
('FAN-500', 'Ventilador de Teto 50cm', 'Ventilador de Teto 50cm'),
('LMP-100', 'Lâmpada LED 100W', 'Lâmpada LED 100W'),
('VNT-40', 'Ventilador Industrial 40cm', 'Ventilador Industrial 40cm');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expira_em` datetime DEFAULT NULL,
  `funcao` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Operador',
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_usuarios_usuario` (`usuario`),
  UNIQUE KEY `uk_usuarios_token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `senha`, `token`, `token_expira_em`, `funcao`, `ativo`, `created_at`) VALUES
(1, 'Carla Menezes', 'carla.admin', '$2b$12$S6vG4ZTMNFAJiER0CnT.J.ipTHQqxMQvtKaNnz7vgzfBAwCe7DRpO', NULL, NULL, 'Administrador', 1, '2026-08-05 19:42:56'),
(2, 'João Pereira', 'joao.separador', '$2b$12$S6vG4ZTMNFAJiER0CnT.J.ipTHQqxMQvtKaNnz7vgzfBAwCe7DRpO', NULL, NULL, 'Separador', 1, '2026-08-05 19:42:56'),
(3, 'Ricardo Souza', 'ricardo.motorista', '$2b$12$S6vG4ZTMNFAJiER0CnT.J.ipTHQqxMQvtKaNnz7vgzfBAwCe7DRpO', NULL, NULL, 'Motorista', 1, '2026-08-05 19:42:56');

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `coletas`
--
ALTER TABLE `coletas`
  ADD CONSTRAINT `fk_coletas_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_coletas_registrado_por` FOREIGN KEY (`registrado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `estoque_lotes`
--
ALTER TABLE `estoque_lotes`
  ADD CONSTRAINT `estoque_lotes_ibfk_1` FOREIGN KEY (`codigo_produto`) REFERENCES `produtos` (`codigo`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `fk_itens_pedido_lote` FOREIGN KEY (`codigo_produto`,`lote`) REFERENCES `estoque_lotes` (`codigo_produto`, `lote`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itens_pedido_ibfk_2` FOREIGN KEY (`codigo_produto`) REFERENCES `produtos` (`codigo`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_separado_por` FOREIGN KEY (`separado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;
--
-- Banco de dados: `varejoqualitas`
--
CREATE DATABASE IF NOT EXISTS `varejoqualitas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `varejoqualitas`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Ventiladores'),
(2, 'Aquecedores');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int DEFAULT '0',
  `categoria_id` int DEFAULT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `estoque`, `categoria_id`, `imagem`) VALUES
(1, 'Ventilador Q300M Branco', 'Ventilador doméstico de alta eficiência Qualitas', 349.90, 10, 1, '/VarejoQualitas/database/img/Q400-2.jpg'),
(2, 'Ventilador Q400M Branco', 'Ventilador comercial potente Qualitas', 399.90, 5, 1, '/VarejoQualitas/database/img/Q400-0.jpg'),
(3, 'Aquecedor Doméstico', 'Aquecedor portátil para ambientes menores', 119.90, 8, 2, '/VarejoQualitas/app/views/img/aquecedor.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
