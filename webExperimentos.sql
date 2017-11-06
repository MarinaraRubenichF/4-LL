-- UFSM
-- Projeto de Software II
-- Marinara Rübenich Fumagalli
-- 2017/2

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
-- Estrutura da tabela `bloco`
--

CREATE TABLE `bloco` (
  `blc_id` int(4) NOT NULL,
  `blc_nome` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `bloco`
--

INSERT INTO `bloco` (`blc_id`, `blc_nome`) VALUES
(1, 'B1'),
(2, 'B2'),
(3, 'B3'),
(4, 'B4'),
(5, 'B5'),
(6, 'B6'),
(7, 'B7'),
(8, 'B8'),
(9, 'B9'),
(10, 'B10'),
(11, 'B11'),
(12, 'B12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cultura`
--

CREATE TABLE `cultura` (
  `clt_id` int(4) NOT NULL,
  `clt_nome` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cultura`
--

INSERT INTO `cultura` (`clt_id`, `clt_nome`) VALUES
(1, 'Milho'),
(2, 'Soja'),
(3, 'Trigo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `experimentos`
--

CREATE TABLE `experimentos` (
  `exp_id` int(4) NOT NULL,
  `exp_usr_id` int(4) DEFAULT NULL,
  `exp_nome` varchar(30) NOT NULL,
  `exp_desc` varchar(200) NOT NULL,
  `exp_dt_hr` datetime NOT NULL,
  `exp_lcl_id` int(4) NOT NULL,
  `exp_clt_id` int(4) NOT NULL,
  `exp_num_lin` int(3) NOT NULL,
  `exp_num_col` int(3) NOT NULL,
  `exp_num_plts` int(10) NOT NULL,
  `exp_tip_id` int(5) NOT NULL,
  `exp_espac` float NOT NULL,
  `exp_imagem` varchar(80) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Detalha todos os experimentos realizados';

--
-- Extraindo dados da tabela `experimentos`
--

INSERT INTO `experimentos` (`exp_id`, `exp_usr_id`, `exp_nome`, `exp_desc`, `exp_dt_hr`, `exp_lcl_id`, `exp_clt_id`, `exp_num_lin`, `exp_num_col`, `exp_num_plts`, `exp_tip_id`, `exp_espac`, `exp_imagem`) VALUES
(1, 1, 'Experimento 1', 'Primeiro experimento Teste.', '2017-10-25 01:03:00', 1, 2, 3, 2, 2, 1, 0.2, 'download.png'),
(2, 1, 'Experimento 2', 'Novo teste', '2017-10-25 01:33:00', 1, 1, 4, 4, 2, 1, 0.5, 'Milho2.jpg'),
(3, 2, 'Experimento 3', 'Teste 3.', '2017-10-27 23:46:00', 1, 3, 2, 2, 2, 1, 0.03, ''),
(4, 1, 'Experimento 4', 'Teste 4', '2017-10-28 01:13:00', 1, 2, 3, 2, 2, 1, 0.06, ''),
(5, 2, 'Experimento 5', 'Teste 5.', '2017-10-28 01:16:00', 1, 2, 2, 2, 2, 1, 0.05, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fenologia`
--

CREATE TABLE `fenologia` (
  `fen_id` int(4) NOT NULL,
  `fen_fenologia` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `fenologia`
--

INSERT INTO `fenologia` (`fen_id`, `fen_fenologia`) VALUES
(1, 'V1'),
(2, 'V2'),
(3, 'V3'),
(4, 'V4'),
(5, 'V5'),
(6, 'V6'),
(7, 'V7'),
(8, 'V8'),
(9, 'V9'),
(10, 'V10'),
(11, 'V11'),
(12, 'V12'),
(13, 'V13'),
(14, 'V14'),
(15, 'V15'),
(16, 'V16'),
(17, 'V17'),
(18, 'V18'),
(19, 'V19'),
(20, 'V20'),
(21, 'V21'),
(22, 'V22'),
(23, 'V23'),
(24, 'V24'),
(25, 'V25'),
(26, 'R1'),
(27, 'R2'),
(28, 'R3'),
(29, 'R4'),
(30, 'R5'),
(31, 'R6');

-- --------------------------------------------------------

--
-- Estrutura da tabela `local`
--

CREATE TABLE `local` (
  `lcl_id` int(4) NOT NULL,
  `lcl_nome` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `local`
--

INSERT INTO `local` (`lcl_id`, `lcl_nome`) VALUES
(1, 'UFSM - Irriga');

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `lgn_id` int(2) NOT NULL,
  `lgn_usr_nome` varchar(50) NOT NULL,
  `lgn_usuario` varchar(20) NOT NULL,
  `lgn_senha` varchar(50) NOT NULL,
  `frontpage_id` int(4) NOT NULL,
  `system_unit_id` int(4) DEFAULT NULL,
  `active` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Grava os logins dos usuários';

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`lgn_id`, `lgn_usr_nome`, `lgn_usuario`, `lgn_senha`, `frontpage_id`, `system_unit_id`, `active`) VALUES
(1, 'Admin PSII', 'admin', '21232f297a57a5a743894a0e4a801fc3', 10, NULL, 'Y'),
(2, 'User', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 7, NULL, 'Y'),
(3, 'Mirta', 'mirta', 'e10adc3949ba59abbe56e057f20f883e', 10, NULL, 'Y'),
(4, 'Laudenir', 'laudenir', '5f422e7267f776665465e192651302aa', 10, NULL, 'Y');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medidas`
--

CREATE TABLE `medidas` (
  `med_id` int(4) NOT NULL,
  `med_exp_id` int(4) NOT NULL,
  `med_blc_id` int(5) NOT NULL,
  `med_par_id` int(4) NOT NULL,
  `med_plt_id` int(4) NOT NULL,
  `med_alt_planta` float NOT NULL,
  `med_larg_folha` float NOT NULL,
  `med_tam_folha` float NOT NULL,
  `med_fen_id` int(4) NOT NULL,
  `med_data` date DEFAULT NULL,
  `med_imagem` varchar(80) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Descreve todas as medidas de uma planta';

--
-- Extraindo dados da tabela `medidas`
--

INSERT INTO `medidas` (`med_id`, `med_exp_id`, `med_blc_id`, `med_par_id`, `med_plt_id`, `med_alt_planta`, `med_larg_folha`, `med_tam_folha`, `med_fen_id`, `med_data`, `med_imagem`) VALUES
(1, 1, 1, 1, 1, 0.2, 0.05, 0.1, 1, '2017-11-01', 'Milho.jpg'),
(2, 1, 1, 1, 2, 0.5, 0.15, 0.2, 1, '2017-10-25', 'Milho2.jpg'),
(3, 2, 3, 1, 1, 0.1, 0.1, 0.1, 2, NULL, 'Milho.jpg'),
(4, 4, 2, 2, 3, 1.23, 0.5, 0.3, 2, NULL, 'Soja.jpg'),
(5, 4, 2, 3, 10, 1, 0.3, 0.2, 4, NULL, 'Soja.jpg'),
(6, 2, 3, 2, 12, 1, 0.5, 0.8, 7, NULL, 'download.png'),
(7, 1, 2, 1, 10, 2, 1, 1.5, 10, NULL, 'Soja.jpg'),
(8, 4, 4, 2, 12, 2, 1, 1.3, 7, NULL, ''),
(9, 2, 3, 3, 11, 3, 2, 2.1, 17, NULL, 'download.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `parcelas`
--

CREATE TABLE `parcelas` (
  `par_id` int(4) NOT NULL,
  `par_nome` varchar(30) NOT NULL,
  `par_desc` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Descreve as parcelas existentes';

--
-- Extraindo dados da tabela `parcelas`
--

INSERT INTO `parcelas` (`par_id`, `par_nome`, `par_desc`) VALUES
(1, '1', 'Primeira Parcela teste.'),
(2, '2', 'parcela de teste'),
(3, '3', 'Parcela de teste2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `planta`
--

CREATE TABLE `planta` (
  `plt_id` int(5) NOT NULL,
  `plt_nome` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Descreve as plantas';

--
-- Extraindo dados da tabela `planta`
--

INSERT INTO `planta` (`plt_id`, `plt_nome`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4'),
(5, '5'),
(6, '6'),
(7, '7'),
(8, '8'),
(9, '9'),
(10, '10'),
(11, '11'),
(12, '12'),
(13, '13'),
(14, '14'),
(15, '15'),
(16, '16'),
(17, '17'),
(18, '18'),
(19, '19'),
(20, '20'),
(21, '21'),
(22, '22'),
(23, '23'),
(24, '24'),
(25, '25'),
(26, '26'),
(27, '27'),
(28, '28'),
(29, '29'),
(30, '30'),
(31, '31'),
(32, '32'),
(33, '33'),
(34, '34'),
(35, '35'),
(36, '36'),
(37, '37'),
(38, '38'),
(39, '39'),
(40, '40'),
(41, '41'),
(42, '42'),
(43, '43'),
(44, '44'),
(45, '45'),
(46, '46'),
(47, '47'),
(48, '48');

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_access_log`
--

CREATE TABLE `system_access_log` (
  `id` int(11) NOT NULL,
  `sessionid` text,
  `login` text,
  `login_time` timestamp NULL DEFAULT NULL,
  `logout_time` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `system_access_log`
--

INSERT INTO `system_access_log` (`id`, `sessionid`, `login`, `login_time`, `logout_time`) VALUES
(1, 'mroe64l5kgsu72k12ivi2vn3b1', 'admin', '2017-10-18 00:33:50', '2017-10-18 00:41:36'),
(2, '3tkd8rps72i452uubltu5e97a4', 'admin', '2017-10-18 00:41:40', '2017-10-18 03:00:52'),
(3, 'omrse7aed3s6mevmbba70khgo1', 'admin', '2017-10-18 03:00:58', '2017-10-18 04:25:45'),
(4, 'ku4kr254qtjf0kpb64esv7bba5', 'admin', '2017-10-18 04:25:53', '2017-10-18 04:30:03'),
(5, '40tmbg2n4ihl4o83lne49ebmr2', 'admin', '2017-10-18 04:30:14', '2017-10-18 04:32:11'),
(6, 'e5mqn6rm6ei72anl79f0p9or74', 'admin', '2017-10-18 04:32:14', '2017-10-18 06:07:33'),
(7, '1kk52a0jgdvperthpm72fajj05', 'admin', '2017-10-18 06:07:37', '2017-10-18 06:14:27'),
(8, '7oteg9dn4e46iqaenkcqka6ne7', 'admin', '2017-10-18 06:14:29', '2017-10-18 06:40:55'),
(9, 'db1fko3bf6ecbsnc1il2vce1n7', 'admin', '2017-10-18 06:40:57', '2017-10-18 06:43:41'),
(10, 'qg0unjd9hugo0jolk20afm4dc1', 'admin', '2017-10-18 06:43:44', '2017-10-18 06:51:12'),
(11, 't0kg2m1pfm3bvmlouk3fgbtq07', 'admin', '2017-10-18 06:51:14', '2017-10-18 12:03:31'),
(12, 'c2di7a6a0o0pt7h2luvtpbkqt6', 'admin', '2017-10-18 19:14:05', '2017-10-18 19:15:34'),
(13, '188n4qv9uqbru0r0dc9878m2o6', 'admin', '2017-10-19 03:44:24', '2017-10-19 04:52:57'),
(14, 'o9nes0nlji9qcui1m4458vaeh4', 'admin', '2017-10-19 04:53:00', '2017-10-19 05:10:58'),
(15, '1di2usslsmgdes73bbleetqj87', 'admin', '2017-10-19 13:54:43', '2017-10-19 13:55:21'),
(16, 'fecrtnuuedrkui4qiga4jadsa2', 'admin', '2017-10-19 16:01:46', '2017-10-19 16:58:11'),
(17, 'idcfo9fqom3q71ohanei0uuv92', 'admin', '2017-10-19 17:00:30', '2017-10-20 02:21:04'),
(18, 't1hd6hfs57bkjmssrlu7nipv92', 'admin', '2017-10-24 00:45:32', '2017-10-24 03:35:32'),
(19, 'ue7og8c4ssceg1m7ojpicug412', 'admin', '2017-10-24 03:35:34', NULL),
(20, '2rrse7sgeap5dnm2skgharblr5', 'admin', '2017-10-24 21:15:56', '2017-10-24 21:48:26'),
(21, 'kkq60nefuf1p9k2toegf0v0ka0', 'admin', '2017-10-24 21:48:29', '2017-10-24 23:37:13'),
(22, 'fqth9qs699t12ufng2sccraod1', 'admin', '2017-10-24 23:37:15', '2017-10-24 23:51:32'),
(23, '18sef70utdnlq5hthtb4vt1er1', 'admin', '2017-10-24 23:51:33', '2017-10-25 00:05:01'),
(24, '32nimfdhrc3gc1e69opeclphb6', 'admin', '2017-10-25 00:14:31', '2017-10-25 00:56:34'),
(25, 'ugm8rtmc3v678m7kqcb33mtba4', 'admin', '2017-10-25 01:01:32', '2017-10-25 04:29:13'),
(26, 'sc0qq7pfmcn8cfntcvderduov0', 'admin', '2017-10-25 04:29:15', '2017-10-25 04:30:17'),
(27, '7pj5tdkm8bi5co825o8u167l71', 'admin', '2017-10-25 04:30:19', '2017-10-25 04:32:28'),
(28, '8a0qpq4hervmk1oa5clklsim33', 'admin', '2017-10-25 04:32:29', '2017-10-25 04:32:59'),
(29, 'fs9ooqbv2optvd91khq7ot8oj6', 'admin', '2017-10-25 04:33:00', '2017-10-25 04:36:06'),
(30, 'd4b6mp83nr92hrdj7aomvqhor4', 'admin', '2017-10-25 04:36:08', '2017-10-25 04:36:39'),
(31, 'mu6pc6putvps777nn3jra5idl2', 'admin', '2017-10-25 04:36:41', '2017-10-25 04:49:54'),
(32, '3hn190jneb5fr87vandqmc9cd6', 'admin', '2017-10-25 04:49:55', '2017-10-25 04:50:51'),
(33, 'ooddrv6uu1eros8i2qfm7jnln0', 'admin', '2017-10-25 04:50:53', '2017-10-25 05:14:46'),
(34, 'le1pnkvjrtk2nhlt4r3ccelj76', 'admin', '2017-10-25 05:14:48', NULL),
(35, 'u4dd8lpk7mtgtau7i9624iod90', 'admin', '2017-10-25 17:46:45', '2017-10-25 18:40:52'),
(36, '3buvv3874lqhbadosqoveimpo0', 'admin', '2017-10-25 18:40:58', '2017-10-25 23:01:31'),
(37, 'so9s5agudlh8t1hvrcdcmc30q5', 'admin', '2017-10-25 23:01:33', '2017-10-26 00:27:01'),
(38, '3p09cdv67lb6h3ujik4l6js0e0', 'admin', '2017-10-26 00:27:02', '2017-10-26 00:39:31'),
(39, 'd1thmbc4ga2c9c1f6mbf1a4os4', 'admin', '2017-10-26 00:39:39', '2017-10-26 00:50:36'),
(40, 'uv8o00uopl3l5kahj23r7k8471', 'admin', '2017-10-26 00:50:37', '2017-10-26 02:16:21'),
(41, '2unthk7rnmngbktg2uj1h2hum6', 'admin', '2017-10-26 02:16:23', '2017-10-26 05:05:34'),
(42, 'nrurlqu23i925al5vo9lnt8004', 'admin', '2017-10-26 05:05:36', '2017-10-26 05:09:24'),
(43, 'bop3gh8rq62ooaa65d2n6667l0', 'admin', '2017-10-26 05:09:26', '2017-10-26 05:44:52'),
(44, 'dhtjjgfqm5ejjlc323js9jsck6', 'admin', '2017-10-26 18:27:23', '2017-10-26 18:27:26'),
(45, '2r1guupi1d4lv032fmvtp4v1r2', 'admin', '2017-10-26 18:27:37', '2017-10-26 18:40:17'),
(46, 'qb0b2r37br56vg9u5hhcbucg92', 'user', '2017-10-26 18:40:25', '2017-10-26 18:41:02'),
(47, 'u23lq7nidof855l48an2fklen6', 'admin', '2017-10-26 18:41:04', '2017-10-27 22:51:31'),
(48, 'g62at659sau7o2cuoao1c1vrk2', 'admin', '2017-10-27 22:51:36', '2017-10-27 23:00:00'),
(49, '8c7f453abvt0e64r2r63eu8lg1', 'admin', '2017-10-27 23:01:57', '2017-10-27 23:39:26'),
(50, 'c9u0gph7pbj3uq5o6m3vpsgo15', 'mirta', '2017-10-27 23:47:41', '2017-10-27 23:49:30'),
(51, '1di13ifn02bj1mf7p0k20hu7e3', 'mirta', '2017-10-27 23:49:43', '2017-10-28 00:00:12'),
(52, '7jrgf81dahljkmnk3e610blgt7', 'admin', '2017-10-28 00:00:15', '2017-10-28 01:55:04'),
(53, 'ofpor25sqjvojla8vvma845qr6', 'user', '2017-10-28 01:55:10', '2017-10-28 01:55:20'),
(54, 'k44n09q5cjafrgleebfepqmgd1', 'admin', '2017-10-28 01:55:21', '2017-10-28 01:55:41'),
(55, 'shlikm727v9ootttlocrv8u995', 'user', '2017-10-28 01:55:45', '2017-10-28 02:59:47'),
(56, 'anqgipkt7doud6od6koh65anp6', 'admin', '2017-10-28 02:59:49', '2017-10-28 02:59:59'),
(57, 'nrvqko725cksgabhp50bh9ebj2', 'user', '2017-10-28 03:00:04', '2017-10-28 03:05:18'),
(58, 'aij9f51l5tgb43n0cc7afqklj7', 'admin', '2017-10-28 03:05:20', '2017-10-28 04:19:49'),
(59, 'nknogjac5j996gp2t57qtkdjb5', 'user', '2017-10-28 04:19:54', '2017-10-28 05:14:07'),
(60, 'q0a20kqm14ij8j6kon8qkgfa91', 'admin', '2017-10-28 05:14:09', '2017-10-28 05:39:45'),
(61, 'ppt8jjd7icjqfg577i7rch5ul5', 'user', '2017-10-28 05:39:51', '2017-10-28 05:44:23'),
(62, 'uj46503pe5t5033hgehoo5rsq3', 'admin', '2017-10-28 05:44:25', '2017-10-28 05:44:36'),
(63, 'vv4dtaknrng5n1ek8vplntupt5', 'user', '2017-10-28 05:44:45', '2017-10-28 05:56:47'),
(64, '8fm2fhpug2qpcbinpaoih02in1', 'admin', '2017-10-28 05:56:49', '2017-10-28 06:01:18'),
(65, '5qbaeb02mj3hrt8ojq67ua50k4', 'user', '2017-10-28 06:01:26', '2017-10-28 06:01:55'),
(66, 'dg3jf61q0c0ierm66smeaj2gh0', 'admin', '2017-10-28 06:01:57', '2017-10-28 06:06:20'),
(67, 'rdn3sepkbrbom4mdm4rtd7jsj6', 'admin', '2017-10-28 06:06:22', '2017-10-28 06:12:40'),
(68, 'vo76426f0nervtjruj7h7g02q1', 'user', '2017-10-28 06:12:47', '2017-10-28 06:16:29'),
(69, 'htaiaoqn5s1lfmmqf3kqnr3ep6', 'user', '2017-10-28 06:16:35', '2017-10-28 06:28:35'),
(70, 'tdatulskdjmdn17hhi72ji40f4', 'user', '2017-10-28 06:40:53', '2017-10-28 06:42:49'),
(71, 'n4qijv97i4c30nj5m264pgbut5', 'admin', '2017-10-28 06:42:52', '2017-10-28 06:46:43'),
(72, '47ijkthgah48mtg6rtqldpl220', 'admin', '2017-10-28 06:46:45', '2017-10-28 06:49:19'),
(73, '1bpe1a9ubfg4r4g0jok1cg97p5', 'admin', '2017-10-28 06:49:21', '2017-10-28 07:03:58'),
(74, 'n6hq45ioecpda7e7qemdr5h5e5', 'admin', '2017-10-28 07:04:00', '2017-10-28 07:04:27'),
(75, 'ip4dk48rvkbf5q29buii0h7dr4', 'admin', '2017-10-28 07:04:29', '2017-10-28 07:05:10'),
(76, '2ep80gl8revq0i4kaverbf1er3', 'admin', '2017-10-28 07:05:12', NULL),
(77, 'lr8o33luk0so86lcbqqptvjcm3', 'admin', '2017-10-30 16:39:51', '2017-10-30 16:54:06'),
(78, '8mbv5salusfrnq2gtfpc21nhl1', 'admin', '2017-10-30 16:54:08', NULL),
(79, 'hunfij84fea0j8idn0vjveikc1', 'admin', '2017-10-31 22:54:43', '2017-11-01 00:27:54'),
(80, '3q78kf79goofdq4uj5nka8n395', 'admin', '2017-11-01 00:27:56', NULL),
(81, 'tpiaing53fb588chofbpanune0', 'admin', '2017-11-01 02:52:21', '2017-11-01 04:28:37'),
(82, 'ufi01fpe2k9eh66d2v4iigbdt2', 'admin', '2017-11-01 04:28:39', '2017-11-01 06:28:16'),
(83, 'v9v7lclgmjckpu65bgbj0rhq14', 'admin', '2017-11-01 05:56:02', '2017-11-01 06:05:50'),
(84, '0k1262pnmsk0btcr41r0dpnh32', 'admin', '2017-11-01 06:28:19', '2017-11-01 06:29:56'),
(85, 'bvnooov8utmpih4t2gb423d0u7', 'admin', '2017-11-01 06:29:57', '2017-11-01 06:47:39'),
(86, '31gd58kigsf9onaknlv0ui2nv5', 'admin', '2017-11-01 06:47:45', '2017-11-01 06:47:49'),
(87, '3hp2ngqehp4qd4b0n6ujuj3er3', 'admin', '2017-11-01 07:06:48', '2017-11-01 07:46:25'),
(88, '5284ges4fm4emf76id50movne4', 'admin', '2017-11-01 07:19:43', NULL),
(89, 'ho2jdhh5q6nj50t1i70s7h8a42', 'admin', '2017-11-01 07:46:27', '2017-11-01 16:16:20'),
(90, 'sa75681mrkf9j01lakq6hoek43', 'admin', '2017-11-01 16:16:22', '2017-11-01 17:36:32'),
(91, '556tlskh4majrdgedoi6nr3ta0', 'admin', '2017-11-01 17:36:46', '2017-11-02 16:41:46'),
(92, 'hh7qmi6g1b4ucfaso89r1feiu2', 'admin', '2017-11-01 22:38:24', '2017-11-01 22:41:08'),
(93, '4oh36eld7qppsd4huic8ee4da4', 'admin', '2017-11-02 16:42:00', '2017-11-06 22:25:37'),
(94, 'tlgck6dav6t4q98ic82rjmrn15', 'admin', '2017-11-02 16:42:34', NULL),
(95, 'j72oi277bibh7q6f97b7fnik80', 'admin', '2017-11-06 22:26:57', '2017-11-06 22:27:03'),
(96, 'qe7h3sqb6f42tb9m4esam1g6m1', 'admin', '2017-11-06 22:27:56', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_document`
--

CREATE TABLE `system_document` (
  `id` int(11) NOT NULL,
  `system_user_id` int(11) DEFAULT NULL,
  `title` text,
  `description` text,
  `category_id` int(11) DEFAULT NULL,
  `submission_date` date DEFAULT NULL,
  `archive_date` date DEFAULT NULL,
  `filename` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `system_document`
--

INSERT INTO `system_document` (`id`, `system_user_id`, `title`, `description`, `category_id`, `submission_date`, `archive_date`, `filename`) VALUES
(1, 1, 'Notas', 'Lab II', 1, '2017-10-18', '2017-10-25', 'NotasT1T2_site.pdf'),
(2, 1, 'Teste2', 'Testeteste', 2, '2017-10-27', '2017-11-04', 'BaseCasosTruco.ods');

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_document_category`
--

CREATE TABLE `system_document_category` (
  `id` int(11) NOT NULL,
  `descricao` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `system_document_category`
--

INSERT INTO `system_document_category` (`id`, `descricao`) VALUES
(1, 'Exp 1'),
(2, 'Exp 2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_document_group`
--

CREATE TABLE `system_document_group` (
  `id` int(11) NOT NULL,
  `document_id` int(11) DEFAULT NULL,
  `system_group_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `system_document_group`
--

INSERT INTO `system_document_group` (`id`, `document_id`, `system_group_id`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_document_user`
--

CREATE TABLE `system_document_user` (
  `id` int(11) NOT NULL,
  `document_id` int(11) DEFAULT NULL,
  `system_user_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `system_document_user`
--

INSERT INTO `system_document_user` (`id`, `document_id`, `system_user_id`) VALUES
(1, 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_group`
--

CREATE TABLE `system_group` (
  `id` int(4) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `system_group`
--

INSERT INTO `system_group` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Standard');

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_group_program`
--

CREATE TABLE `system_group_program` (
  `id` int(11) NOT NULL,
  `system_group_id` int(11) DEFAULT NULL,
  `system_program_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `system_group_program`
--

INSERT INTO `system_group_program` (`id`, `system_group_id`, `system_program_id`) VALUES
(88, 1, 42),
(87, 1, 40),
(86, 1, 39),
(85, 1, 36),
(84, 1, 35),
(83, 1, 30),
(82, 1, 29),
(81, 1, 28),
(80, 1, 27),
(79, 1, 26),
(78, 1, 25),
(77, 1, 24),
(76, 1, 23),
(75, 1, 22),
(74, 1, 21),
(73, 1, 15),
(72, 1, 14),
(71, 1, 13),
(70, 1, 12),
(69, 1, 11),
(68, 1, 34),
(67, 1, 33),
(66, 1, 10),
(65, 1, 9),
(64, 1, 8),
(63, 1, 7),
(62, 1, 6),
(61, 1, 5),
(60, 1, 4),
(59, 1, 3),
(58, 1, 2),
(57, 1, 1),
(56, 1, 37),
(55, 1, 38),
(54, 1, 41),
(50, 2, 42),
(49, 2, 41),
(48, 2, 40),
(47, 2, 39),
(46, 2, 38),
(45, 2, 37),
(44, 2, 36),
(43, 2, 35),
(42, 2, 34),
(41, 2, 33),
(40, 2, 32),
(39, 2, 31),
(38, 2, 13),
(37, 2, 12),
(36, 2, 10),
(51, 2, 23),
(52, 2, 24),
(53, 1, 43),
(89, 1, 45);

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_program`
--

CREATE TABLE `system_program` (
  `id` int(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `system_program`
--

INSERT INTO `system_program` (`id`, `name`, `controller`) VALUES
(1, 'System Group Form', 'SystemGroupForm'),
(2, 'System Group List', 'SystemGroupList'),
(3, 'System Program Form', 'SystemProgramForm'),
(4, 'System Program List', 'SystemProgramList'),
(5, 'System User Form', 'UsuarioForm'),
(6, 'System User List', 'UsuarioList'),
(7, 'Common Page', 'CommonPage'),
(8, 'System PHP Info', 'SystemPHPInfoView'),
(9, 'System ChangeLog View', 'SystemChangeLogView'),
(10, 'Welcome View', 'WelcomeView'),
(11, 'System Sql Log', 'SystemSqlLogList'),
(12, 'Perfil View', 'PerfilView'),
(13, 'Perfil Form', 'PerfilForm'),
(14, 'System SQL Panel', 'SystemSQLPanel'),
(15, 'System Access Log', 'SystemAccessLogList'),
(35, 'Cultura Form', 'CulturaForm'),
(34, 'Experimento Form', 'ExperimentoForm'),
(32, 'Planta Form', 'PlantaForm'),
(33, 'Experimento Lista', 'ExperimentoList'),
(31, 'Planta Lista', 'PlantaList'),
(21, 'System Document Category List', 'SystemDocumentCategoryFormList'),
(22, 'System Document Form', 'SystemDocumentForm'),
(23, 'System Document Upload Form', 'SystemDocumentUploadForm'),
(24, 'System Document List', 'SystemDocumentList'),
(25, 'System Shared Document List', 'SystemSharedDocumentList'),
(26, 'System Unit Form', 'SystemUnitForm'),
(27, 'System Unit List', 'SystemUnitList'),
(28, 'System Access stats', 'SystemAccessLogStats'),
(29, 'System Preference form', 'SystemPreferenceForm'),
(30, 'System Support form', 'SystemSupportForm'),
(36, 'Medida Form', 'MedidaForm'),
(37, 'Planta Form', 'PlantaForm'),
(38, 'Fenologia  Form', 'FenologiaForm'),
(39, 'ParcelaForm', 'ParcelaForm'),
(40, 'Medida List', 'MedidaList'),
(41, 'Exporta View', 'ExportaView'),
(42, 'Visão Geral', 'VisaoGeralView'),
(43, 'Bloco Form', 'BlocoForm'),
(44, 'Local Form', 'LocalForm'),
(45, 'Local Form', 'LocalForm');

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_user_group`
--

CREATE TABLE `system_user_group` (
  `id` int(11) NOT NULL,
  `system_user_id` int(11) DEFAULT NULL,
  `system_group_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `system_user_group`
--

INSERT INTO `system_user_group` (`id`, `system_user_id`, `system_group_id`) VALUES
(4, 1, 2),
(7, 2, 2),
(3, 1, 1),
(5, 3, 2),
(6, 4, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `system_user_program`
--

CREATE TABLE `system_user_program` (
  `id` int(11) NOT NULL,
  `system_user_id` int(11) DEFAULT NULL,
  `system_program_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `system_user_program`
--

INSERT INTO `system_user_program` (`id`, `system_user_id`, `system_program_id`) VALUES
(31, 2, 7),
(28, 1, 32),
(27, 1, 30),
(26, 1, 29),
(25, 1, 28),
(24, 1, 27),
(23, 1, 26),
(22, 1, 25),
(21, 1, 24),
(20, 1, 23),
(19, 1, 22),
(18, 1, 21),
(17, 1, 15),
(16, 1, 14),
(15, 1, 13),
(14, 1, 12),
(13, 1, 11),
(12, 1, 9),
(11, 1, 8),
(10, 1, 7),
(9, 1, 6),
(8, 1, 5),
(7, 1, 4),
(6, 1, 3),
(5, 1, 10),
(4, 1, 1),
(3, 1, 2),
(2, 1, 31),
(29, 1, 33),
(30, 1, 34),
(32, 2, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo`
--

CREATE TABLE `tipo` (
  `tip_id` int(2) NOT NULL,
  `tip_nome` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipo`
--

INSERT INTO `tipo` (`tip_id`, `tip_nome`) VALUES
(1, 'DIC'),
(2, 'DBC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloco`
--
ALTER TABLE `bloco`
  ADD PRIMARY KEY (`blc_id`);

--
-- Indexes for table `cultura`
--
ALTER TABLE `cultura`
  ADD PRIMARY KEY (`clt_id`);

--
-- Indexes for table `experimentos`
--
ALTER TABLE `experimentos`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `fenologia`
--
ALTER TABLE `fenologia`
  ADD PRIMARY KEY (`fen_id`);

--
-- Indexes for table `local`
--
ALTER TABLE `local`
  ADD PRIMARY KEY (`lcl_id`);

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
-- Indexes for table `system_access_log`
--
ALTER TABLE `system_access_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_document`
--
ALTER TABLE `system_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_document_category`
--
ALTER TABLE `system_document_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_document_group`
--
ALTER TABLE `system_document_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_document_user`
--
ALTER TABLE `system_document_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_group`
--
ALTER TABLE `system_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_group_program`
--
ALTER TABLE `system_group_program`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_group_program_program_idx` (`system_program_id`),
  ADD KEY `system_group_program_group_idx` (`system_group_id`);

--
-- Indexes for table `system_program`
--
ALTER TABLE `system_program`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_user_group`
--
ALTER TABLE `system_user_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_user_group_group_idx` (`system_group_id`),
  ADD KEY `system_user_group_user_idx` (`system_user_id`);

--
-- Indexes for table `system_user_program`
--
ALTER TABLE `system_user_program`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_user_program_program_idx` (`system_program_id`),
  ADD KEY `system_user_program_user_idx` (`system_user_id`);

--
-- Indexes for table `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`tip_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bloco`
--
ALTER TABLE `bloco`
  MODIFY `blc_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `cultura`
--
ALTER TABLE `cultura`
  MODIFY `clt_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `experimentos`
--
ALTER TABLE `experimentos`
  MODIFY `exp_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fenologia`
--
ALTER TABLE `fenologia`
  MODIFY `fen_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `local`
--
ALTER TABLE `local`
  MODIFY `lcl_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `lgn_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `medidas`
--
ALTER TABLE `medidas`
  MODIFY `med_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `parcelas`
--
ALTER TABLE `parcelas`
  MODIFY `par_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `planta`
--
ALTER TABLE `planta`
  MODIFY `plt_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `system_group`
--
ALTER TABLE `system_group`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `system_program`
--
ALTER TABLE `system_program`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `tipo`
--
ALTER TABLE `tipo`
  MODIFY `tip_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
