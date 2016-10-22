-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 19-Jan-2016 às 02:01
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sistema`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `Id_Area` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Area`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `areas`
--

INSERT INTO `areas` (`Id_Area`, `Nome`) VALUES
(0, 'Nenhuma'),
(1, 'Administração de Informática'),
(2, 'Análise e Desenvolvimento de Sistemas'),
(3, 'Banco de Dados'),
(4, 'Computação Gráfica'),
(5, 'Desenvolvimento de Modelos Computacionais'),
(6, 'Engenharia de Software'),
(7, 'Hardware'),
(8, 'Redes de Computadores'),
(9, 'Suporte a Infraestrutura de Informática'),
(10, 'Suporte ao Usuário Final no Uso de Software'),
(11, 'Organização, Sistemas e Métodos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios_termos_aditivos`
--

CREATE TABLE IF NOT EXISTS `comentarios_termos_aditivos` (
  `Id_Estagio` int(10) unsigned NOT NULL,
  `Id_TermoAditivo` int(10) unsigned NOT NULL,
  `Comentario` varchar(256) NOT NULL,
  KEY `comentarios_termos_aditivos_ibfk_1` (`Id_TermoAditivo`),
  KEY `comentarios_termos_aditivos_ibfk_2` (`Id_Estagio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario_estagio`
--

CREATE TABLE IF NOT EXISTS `comentario_estagio` (
  `Id_Estagio` int(10) unsigned NOT NULL,
  `Comentario_Empresa` varchar(256) NOT NULL,
  `Comentario_Supervisor` varchar(256) NOT NULL,
  `Comentario_Modalidade` varchar(256) NOT NULL,
  `Comentario_Area` varchar(256) NOT NULL,
  `Comentario_Data_Inicio` varchar(256) NOT NULL,
  `Comentario_Data_Fim` varchar(256) NOT NULL,
  `Comentario_Termo` varchar(256) NOT NULL,
  PRIMARY KEY (`Id_Estagio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `comentario_estagio`
--

INSERT INTO `comentario_estagio` (`Id_Estagio`, `Comentario_Empresa`, `Comentario_Supervisor`, `Comentario_Modalidade`, `Comentario_Area`, `Comentario_Data_Inicio`, `Comentario_Data_Fim`, `Comentario_Termo`) VALUES
(15, 'Empresa não afiliada!', 'Supervisor incorreto', 'Modalidade esta certa?', 'Area incorreta, champs', 'Data inicial wut?', 'Final, ctz? ok', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario_plano_de_atividades`
--

CREATE TABLE IF NOT EXISTS `comentario_plano_de_atividades` (
  `Comentario_Local` varchar(256) NOT NULL,
  `Comentario_Carga` varchar(256) NOT NULL,
  `Comentario_Horarios` varchar(256) NOT NULL,
  `Comentario_Descricao` varchar(256) NOT NULL,
  `Comentario_Data` varchar(256) NOT NULL,
  `Id_Plano_De_Atividades` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id_Plano_De_Atividades`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario_relatorio`
--

CREATE TABLE IF NOT EXISTS `comentario_relatorio` (
  `Id_Relatorio` int(10) unsigned NOT NULL,
  `Comentario_Tipo_Relatorio` varchar(256) NOT NULL,
  `Comentario_Data_Inicial` varchar(256) NOT NULL,
  `Comentario_Data_Final` varchar(256) NOT NULL,
  `Comentario_Atividades` varchar(256) NOT NULL,
  `Comentario_Comentario` varchar(256) NOT NULL,
  PRIMARY KEY (`Id_Relatorio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `comentario_relatorio`
--

INSERT INTO `comentario_relatorio` (`Id_Relatorio`, `Comentario_Tipo_Relatorio`, `Comentario_Data_Inicial`, `Comentario_Data_Final`, `Comentario_Atividades`, `Comentario_Comentario`) VALUES
(9, 'Tudo', 'Errado', 'Seu', 'Vagabundo', 'PQP'),
(10, '', '', '', '', 'LOL'),
(12, 'LOL', 'LOL', 'LOL', 'LOL', 'LOL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `conversas`
--

CREATE TABLE IF NOT EXISTS `conversas` (
  `User1` varchar(50) NOT NULL,
  `User2` varchar(50) NOT NULL,
  `ID` int(22) unsigned NOT NULL AUTO_INCREMENT,
  `TotalMensagens` int(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `conversas`
--

INSERT INTO `conversas` (`User1`, `User2`, `ID`, `TotalMensagens`) VALUES
('Victor Gaíva', 'lucas', 9, 2),
('Victor Gaíva', 'Ricardo', 10, 1),
('Victor Gaíva', 'lucas', 11, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

CREATE TABLE IF NOT EXISTS `cursos` (
  `Id_Curso` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Curso`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `cursos`
--

INSERT INTO `cursos` (`Id_Curso`, `nome`) VALUES
(1, 'Ciência da Computação'),
(2, 'Análise de Sistemas'),
(3, 'Técnico em Redes de Computadores'),
(4, 'Engenharia da Computação'),
(5, 'Engenharia de Software'),
(6, 'Técnico em Análise e Desenvolvimento de Sistemas'),
(7, 'Nenhum');

-- --------------------------------------------------------

--
-- Estrutura da tabela `declaracao_final`
--

CREATE TABLE IF NOT EXISTS `declaracao_final` (
  `Id_Declaracao` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Estagio` int(10) unsigned DEFAULT NULL,
  `Nome_Declaracao` varchar(50) NOT NULL,
  `Tamanho_Declaracao` int(11) NOT NULL,
  `Tipo_Declaracao` varchar(30) NOT NULL,
  `Arquivo_Declaracao` mediumblob NOT NULL,
  `Status_Declaracao` varchar(30) NOT NULL,
  `Comentario` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`Id_Declaracao`),
  KEY `Id_Estagio` (`Id_Estagio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `declaracao_final`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `Id_Empresa` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(100) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Telefone` varchar(14) DEFAULT NULL,
  `Ativa` tinyint(1) NOT NULL,
  `Ativa_Email` tinyint(1) NOT NULL,
  `Rua` varchar(50) NOT NULL,
  `Cep` varchar(9) NOT NULL,
  `Numero` int(11) NOT NULL,
  `Bairro` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Empresa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`Id_Empresa`, `Nome`, `Email`, `Telefone`, `Ativa`, `Ativa_Email`, `Rua`, `Cep`, `Numero`, `Bairro`) VALUES
(1, 'Bia representações', 'bia@rtes.com', '06736666969', 1, 1, '', '', 0, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estagio`
--

CREATE TABLE IF NOT EXISTS `estagio` (
  `Id_Estagio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Id_Aluno` int(11) unsigned DEFAULT NULL,
  `Id_Empresa` int(11) unsigned DEFAULT NULL,
  `Id_Supervisor` int(11) unsigned DEFAULT NULL,
  `Modalidade` tinyint(1) DEFAULT NULL,
  `Area` int(11) NOT NULL DEFAULT '0',
  `Data_Inicio` date DEFAULT NULL,
  `Data_Fim` date DEFAULT NULL,
  `Status` varchar(20) NOT NULL,
  `Erros` varchar(13) NOT NULL DEFAULT '0;0;0;0;0;0;0',
  PRIMARY KEY (`Id_Estagio`),
  KEY `Id_Aluno` (`Id_Aluno`),
  KEY `Id_Supervisor` (`Id_Supervisor`),
  KEY `Id_Empresa` (`Id_Empresa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Extraindo dados da tabela `estagio`
--

INSERT INTO `estagio` (`Id_Estagio`, `Id_Aluno`, `Id_Empresa`, `Id_Supervisor`, `Modalidade`, `Area`, `Data_Inicio`, `Data_Fim`, `Status`, `Erros`) VALUES
(7, 5, 1, 7, 1, 6, '2016-01-03', '2016-11-01', 'aprovado', '0;0;0;0;0;0;0'),
(8, 6, 1, 7, 1, 1, '2016-01-04', '2016-06-18', 'entrega', '0;0;0;0;0;0;0'),
(15, 6, 1, 8, 1, 6, '2016-01-04', '2016-08-05', 'presidente', '0;0;0;0;0;0;0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE IF NOT EXISTS `mensagens` (
  `ID_Conversa` int(255) unsigned NOT NULL,
  `Marca_De_Tempo` varchar(40) NOT NULL,
  `Conteudo` text NOT NULL,
  `nome_remetente` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_Conversa`,`Marca_De_Tempo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `mensagens`
--

INSERT INTO `mensagens` (`ID_Conversa`, `Marca_De_Tempo`, `Conteudo`, `nome_remetente`) VALUES
(1, '19/03/2015 15:49:14', 'DERP', 'Victor GaÃ­va'),
(9, '19/03/2015 15:48:08', 'Sou viado', 'Victor GaÃ­va'),
(9, '19/03/2015 15:48:58', 'Derp', 'Victor GaÃ­va'),
(10, '19/03/2015 15:51:20', '321', 'Victor GaÃ­va'),
(11, '25/03/2015 22:09:49', 'Olá', 'Victor Gaíva'),
(11, '25/03/2015 22:10:17', 'oi', 'Victor Gaíva');

-- --------------------------------------------------------

--
-- Estrutura da tabela `plano_de_atividades`
--

CREATE TABLE IF NOT EXISTS `plano_de_atividades` (
  `Id_Plano_De_Atividades` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Id_Estagio` int(10) unsigned NOT NULL,
  `Id_Aluno` int(10) unsigned NOT NULL,
  `Horario` varchar(73) NOT NULL,
  `Descricao` varchar(497) NOT NULL,
  `Local` varchar(50) NOT NULL,
  `Data` date NOT NULL,
  `Hora_Do_Envio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Carga_Horaria` varchar(10) DEFAULT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'alterar',
  `Erros` varchar(32) NOT NULL DEFAULT '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0',
  PRIMARY KEY (`Id_Plano_De_Atividades`),
  KEY `Id_Estagio` (`Id_Estagio`),
  KEY `Id_Aluno` (`Id_Aluno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Extraindo dados da tabela `plano_de_atividades`
--

INSERT INTO `plano_de_atividades` (`Id_Plano_De_Atividades`, `Id_Estagio`, `Id_Aluno`, `Horario`, `Descricao`, `Local`, `Data`, `Hora_Do_Envio`, `Carga_Horaria`, `Status`, `Erros`) VALUES
(16, 7, 5, '05:00;11:00;;;;;;;;;;', ' 10', '', '0000-00-00', '2016-01-18 14:10:05', '6:0', 'aprovado', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(17, 7, 5, '05:00;11:00;;;;;;;;;;', ' 10', '', '0000-00-00', '2016-01-08 17:41:23', '6:0', 'presidente', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0'),
(18, 8, 6, ';;11:00;17:00;;;;;;;;', 'Farei: ', 'Campo Grande - MS', '2016-01-04', '2016-01-10 22:39:37', '6:0', 'aprovado', '0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorio`
--

CREATE TABLE IF NOT EXISTS `relatorio` (
  `Id_Relatorio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Id_Aluno` int(10) unsigned NOT NULL,
  `Id_Estagio` int(10) unsigned NOT NULL,
  `Tipo` tinyint(1) DEFAULT NULL,
  `Data_Inicio` date NOT NULL,
  `Data_Fim` date NOT NULL,
  `Atividades` varchar(652) NOT NULL,
  `Comentario_Aluno` varchar(308) NOT NULL,
  `Avaliacao` varchar(10) NOT NULL DEFAULT '0000000000',
  `Observacao` varchar(389) NOT NULL,
  `Data` varchar(10) NOT NULL,
  `Hora_Do_Envio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Status` varchar(20) NOT NULL,
  `Erros` varchar(11) NOT NULL,
  PRIMARY KEY (`Id_Relatorio`),
  KEY `Id_Aluno` (`Id_Aluno`),
  KEY `Id_Estagio` (`Id_Estagio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `relatorio`
--

INSERT INTO `relatorio` (`Id_Relatorio`, `Id_Aluno`, `Id_Estagio`, `Tipo`, `Data_Inicio`, `Data_Fim`, `Atividades`, `Comentario_Aluno`, `Avaliacao`, `Observacao`, `Data`, `Hora_Do_Envio`, `Status`, `Erros`) VALUES
(7, 5, 4, 1, '0000-00-00', '0000-00-00', '11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111', '          111111111111111     123123213', '0000000000', 'a', '', '2016-01-18 14:16:26', 'entrega', ''),
(9, 5, 5, 0, '0000-00-00', '0000-00-00', '1111111111', '11111111', '0000000000', '', '', '2016-01-10 16:19:22', 'presidente', '1;1;1;1;1'),
(10, 5, 4, 1, '0000-00-00', '0000-00-00', '      ', '         ', '0000000000', 'adasdasdasd', '', '2015-11-30 03:00:00', 'presidente', ''),
(11, 5, 4, 1, '0000-00-00', '0000-00-00', '  ', '   ', '0123012321', 'Uma escada!', '', '2016-01-10 16:19:13', 'presidente', ''),
(12, 5, 7, 1, '2016-01-01', '2016-02-01', ' ehuehuehueheuh ', '  heuheuehuehuehh ', '1000000000', 'Aluno nota 10!', '', '2016-01-18 14:16:36', 'entrega', '0;0;0;0;0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `termos_aditivos`
--

CREATE TABLE IF NOT EXISTS `termos_aditivos` (
  `Id_TermoAditivo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Id_Estagio` int(10) unsigned DEFAULT NULL,
  `Nome_TermoAditivo` varchar(50) NOT NULL,
  `Tamanho_TermoAditivo` int(11) NOT NULL,
  `Tipo_TermoAditivo` varchar(30) NOT NULL,
  `Arquivo_TermoAditivo` mediumblob NOT NULL,
  `Status_TermoAditivo` varchar(30) NOT NULL,
  `Data_Prorrogacao` date DEFAULT NULL,
  PRIMARY KEY (`Id_TermoAditivo`),
  KEY `termos_Aditivos_ibfk_1` (`Id_Estagio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `termos_aditivos`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `termo_de_compromisso`
--

CREATE TABLE IF NOT EXISTS `termo_de_compromisso` (
  `Id_Termo` int(11) NOT NULL AUTO_INCREMENT,
  `Id_Estagio` int(10) unsigned DEFAULT NULL,
  `Nome_Termo` varchar(50) NOT NULL,
  `Tamanho_Termo` int(11) NOT NULL,
  `Tipo_Termo` varchar(30) NOT NULL,
  `Arquivo_Termo` mediumblob NOT NULL,
  `Status_Termo` varchar(30) NOT NULL,
  PRIMARY KEY (`Id_Termo`),
  KEY `Id_Estagio` (`Id_Estagio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `termo_de_compromisso`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `Id_Usuario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Ativa` tinyint(1) NOT NULL,
  `Ativa_Email` tinyint(1) NOT NULL,
  `Rga` varchar(12) NOT NULL,
  `Nome_Completo` varchar(50) NOT NULL,
  `Nome_De_Usuario` varchar(25) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Senha` varchar(50) NOT NULL,
  `Tipo` char(1) NOT NULL,
  `Hash_Email` varchar(32) NOT NULL,
  `Curso` tinyint(1) NOT NULL,
  `Telefone` varchar(14) NOT NULL,
  `Id_Curso` int(11) DEFAULT '0',
  PRIMARY KEY (`Id_Usuario`),
  UNIQUE KEY `username` (`Nome_De_Usuario`),
  UNIQUE KEY `email` (`Email`),
  KEY `Id_Curso` (`Id_Curso`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`Id_Usuario`, `Ativa`, `Ativa_Email`, `Rga`, `Nome_Completo`, `Nome_De_Usuario`, `Email`, `Senha`, `Tipo`, `Hash_Email`, `Curso`, `Telefone`, `Id_Curso`) VALUES
(5, 1, 1, '201319040365', 'Victor Gaíva', 'victor', 'victorgaiva2014@gmail.com', '$P$BlORTuaUpkY1Q/CyI3.Hz/.exs8lRD.', 'E', 'c4ca4238a0b923820dcc509a6f75849b', 1, '06792712109', 1),
(6, 1, 1, '201319040128', 'Lucas MarX', 'lucas', 'marquesnavarezi@gmail.com', '$P$BeS0ChvaPFoJIkJaYlq/L7MBDc1zZG/', 'E', 'a597e50502f5ff68e3e25b9114205d4a', 1, '06792712109', 1),
(7, 1, 1, '', 'Ricardo Brandão', 'ricardinho', '@niguem_tem', '$P$BeS0ChvaPFoJIkJaYlq/L7MBDc1zZG/', 'P', '', 0, '06792712109', 1),
(8, 1, 1, '', 'Batata da Silva', 'batata', 'batata@no.domain', '$P$BCKBfQXPoicrN9euULNmXqNT9V4JAk0', 'P', 'a597e50502f5ff68e3e25b9114205d4a', 0, '06792712109', 1),
(9, 1, 1, '', 'gabryel rigol da silva', 'gabryelrigol', 'gabryelrigol@gmail.com', '$P$BeS0ChvaPFoJIkJaYlq/L7MBDc1zZG/', 'V', '', 1, '06791052707', 1);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `comentarios_termos_aditivos`
--
ALTER TABLE `comentarios_termos_aditivos`
  ADD CONSTRAINT `comentarios_termos_aditivos_ibfk_1` FOREIGN KEY (`Id_TermoAditivo`) REFERENCES `termos_aditivos` (`Id_TermoAditivo`),
  ADD CONSTRAINT `comentarios_termos_aditivos_ibfk_2` FOREIGN KEY (`Id_Estagio`) REFERENCES `estagio` (`Id_Estagio`);

--
-- Limitadores para a tabela `comentario_estagio`
--
ALTER TABLE `comentario_estagio`
  ADD CONSTRAINT `comentario_estagio_ibfk_1` FOREIGN KEY (`Id_Estagio`) REFERENCES `estagio` (`Id_Estagio`);

--
-- Limitadores para a tabela `comentario_plano_de_atividades`
--
ALTER TABLE `comentario_plano_de_atividades`
  ADD CONSTRAINT `comentario_plano_de_atividades_ibfk_1` FOREIGN KEY (`Id_Plano_De_Atividades`) REFERENCES `plano_de_atividades` (`Id_Plano_De_Atividades`);

--
-- Limitadores para a tabela `comentario_relatorio`
--
ALTER TABLE `comentario_relatorio`
  ADD CONSTRAINT `comentario_relatorio_ibfk_1` FOREIGN KEY (`Id_Relatorio`) REFERENCES `relatorio` (`Id_Relatorio`);

--
-- Limitadores para a tabela `estagio`
--
ALTER TABLE `estagio`
  ADD CONSTRAINT `estagio_ibfk_1` FOREIGN KEY (`Id_Aluno`) REFERENCES `usuarios` (`Id_Usuario`),
  ADD CONSTRAINT `estagio_ibfk_2` FOREIGN KEY (`Id_Supervisor`) REFERENCES `usuarios` (`Id_Usuario`),
  ADD CONSTRAINT `estagio_ibfk_3` FOREIGN KEY (`Id_Empresa`) REFERENCES `empresa` (`Id_Empresa`);

--
-- Limitadores para a tabela `termos_aditivos`
--
ALTER TABLE `termos_aditivos`
  ADD CONSTRAINT `termos_Aditivos_ibfk_1` FOREIGN KEY (`Id_Estagio`) REFERENCES `estagio` (`Id_Estagio`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
