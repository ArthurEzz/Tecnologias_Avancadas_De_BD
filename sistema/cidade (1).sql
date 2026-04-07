-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07-Abr-2026 às 16:13
-- Versão do servidor: 10.4.25-MariaDB
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cidade`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(3) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `end` varchar(60) NOT NULL,
  `tel` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `end`, `tel`) VALUES
(1, 'Miguel Jose das neves', 'RUA BRASIL 674', '14997061355'),
(2, 'Fatec Ourinhos', 'Av. Vitalina Marcusso, 1400', '14997061355'),
(3, 'LIKE UP COMUNICACOES', 'NOVE DE JULHO, 582, 10° ANDAR E SALA 101', '3333333'),
(4, 'jose franisco', 'brasil', '897878787'),
(5, 'LIKE UP COMUNICACOES', 'NOVE DE JULHO, 582, 10° ANDAR E SALA 101', '334455'),
(6, 'Miguel Jose das neves', 'RUA BRASIL 674', '14997061355'),
(7, 'Fatec Ourinhos', 'Av. Vitalina Marcusso, 1400', ''),
(8, 'LIKE UP COMUNICACOES', 'NOVE DE JULHO, 582, 10° ANDAR E SALA 101', '55555'),
(9, 'Miguel Jose das neves', 'RUA BRASIL 674', '14997061355'),
(10, 'Miguel Jose das neves', 'RUA BRASIL 674', '14997061355'),
(11, 'Fatec Ourinhos', 'Av. Vitalina Marcusso, 1400', ''),
(12, 'Fatec Ourinhos', 'Av. Vitalina Marcusso, 1400', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
