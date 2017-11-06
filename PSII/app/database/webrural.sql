-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11-Out-2017 às 12:53
-- Versão do servidor: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webrural`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `experimentos`
--

CREATE TABLE `experimentos` (
  `exp_id` int(4) NOT NULL,
  `exp_usr_id` int(3) NOT NULL,
  `exp_nome` varchar(30) NOT NULL,
  `exp_desc` varchar(200) NOT NULL,
  `exp_dt_hr` datetime NOT NULL,
  `exp_local` varchar(70) NOT NULL,
  `exp_cultura` varchar(30) NOT NULL,
  `exp_num_lin` int(3) NOT NULL,
  `exp_num_col` int(3) NOT NULL,
  `exp_espac` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Detalha todos os experimentos realizados';

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `lgn_id` int(2) NOT NULL,
  `lgn_usr_id` int(4) NOT NULL,
  `lgn_usuario` varchar(20) NOT NULL,
  `lgn_senha` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Grava os logins dos usuários';

-- --------------------------------------------------------

--
-- Estrutura da tabela `medidas`
--

CREATE TABLE `medidas` (
  `med_id` int(4) NOT NULL,
  `med_id_exp` int(4) NOT NULL,
  `med_id_planta` int(4) NOT NULL,
  `med_alt_planta` float NOT NULL,
  `med_larg_folha` float NOT NULL,
  `med_tam_folha` float NOT NULL,
  `med_fenologia` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Descreve todas as medidas de uma planta';

-- --------------------------------------------------------

--
-- Estrutura da tabela `parcelas`
--

CREATE TABLE `parcelas` (
  `par_id` int(4) NOT NULL,
  `par_nome` varchar(30) NOT NULL,
  `par_desc` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Descreve as parcelas existentes';

-- --------------------------------------------------------

--
-- Estrutura da tabela `planta`
--

CREATE TABLE `planta` (
  `plt_id` int(5) NOT NULL,
  `plt_nome` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Descreve as plantas';

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `usr_id` int(4) NOT NULL,
  `usr_nome` varchar(15) NOT NULL,
  `usr_sobrenome` varchar(20) NOT NULL,
  `usr_email` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Detalha os usuários';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `experimentos`
--
ALTER TABLE `experimentos`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`lgn_id`),
  ADD UNIQUE KEY `usuario` (`lgn_usuario`),
  ADD KEY `id` (`lgn_id`);

--
-- Indexes for table `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`med_id`);

--
-- Indexes for table `parcelas`
--
ALTER TABLE `parcelas`
  ADD PRIMARY KEY (`par_id`);

--
-- Indexes for table `planta`
--
ALTER TABLE `planta`
  ADD PRIMARY KEY (`plt_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `experimentos`
--
ALTER TABLE `experimentos`
  MODIFY `exp_id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `lgn_id` int(2) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `medidas`
--
ALTER TABLE `medidas`
  MODIFY `med_id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parcelas`
--
ALTER TABLE `parcelas`
  MODIFY `par_id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `planta`
--
ALTER TABLE `planta`
  MODIFY `plt_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usr_id` int(4) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
