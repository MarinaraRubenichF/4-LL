-- Autora: Marinara Rübenich
-- Curso: Sistemas de Informação - UFSM
-- Disciplina: LAB II

-- Gerado: 11-Out-2017 às 12:53
-- PHP Versão: 7.0.10
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
