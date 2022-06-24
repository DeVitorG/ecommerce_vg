create database vendas;

USE vendas;

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.00',
  `telefone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ativo` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `nome_produto` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` decimal(9,2) NOT NULL DEFAULT 0.00,
  `ativo` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `data_venda` date NOT NULL,
  `metodo_pag` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_parc` int(11) NOT NULL DEFAULT 1,
  `id_produto` int(11) DEFAULT NULL,
  `ativos` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_venda`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


