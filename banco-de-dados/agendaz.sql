SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `agendaz`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_agenda`
--

CREATE TABLE `tb_agenda` (
  `id_agenda` int(11) NOT NULL,
  `descricao_agenda` varchar(2000) DEFAULT NULL,
  `cor_agenda` varchar(45) NOT NULL,
  `inicio_agenda` datetime NOT NULL,
  `fim_agenda` datetime NOT NULL,
  `id_unidade` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_paciente`
--

CREATE TABLE `tb_paciente` (
  `id_paciente` int(11) NOT NULL,
  `nome_paciente` varchar(100) NOT NULL,
  `cad_paciente` varchar(100) DEFAULT NULL,
  `ativo_paciente` tinyint(4) NOT NULL,
  `id_unidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_unidade`
--

CREATE TABLE `tb_unidade` (
  `id_unidade` int(11) NOT NULL,
  `nome_unidade` varchar(100) NOT NULL,
  `ativa_unidade` tinyint(4) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `login_usuario` varchar(100) NOT NULL,
  `senha_usuario` varchar(20) NOT NULL,
  `ativo_usuario` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`id_usuario`, `nome_usuario`, `login_usuario`, `senha_usuario`, `ativo_usuario`) VALUES
(1, 'User', 'user@user', '111', 1),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_agenda`
--
ALTER TABLE `tb_agenda`
  ADD PRIMARY KEY (`id_agenda`),
  ADD KEY `fk_tb_agenda_tb_unidade_idx` (`id_unidade`),
  ADD KEY `fk_tb_agenda_tb_paciente1_idx` (`id_paciente`);

--
-- Indexes for table `tb_paciente`
--
ALTER TABLE `tb_paciente`
  ADD PRIMARY KEY (`id_paciente`),
  ADD KEY `fk_tb_paciente_tb_unidade1_idx` (`id_unidade`);

--
-- Indexes for table `tb_unidade`
--
ALTER TABLE `tb_unidade`
  ADD PRIMARY KEY (`id_unidade`),
  ADD KEY `fk_tb_unidade_tb_usuario1_idx` (`id_usuario`);

--
-- Indexes for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_agenda`
--
ALTER TABLE `tb_agenda`
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tb_paciente`
--
ALTER TABLE `tb_paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_unidade`
--
ALTER TABLE `tb_unidade`
  MODIFY `id_unidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_agenda`
--
ALTER TABLE `tb_agenda`
  ADD CONSTRAINT `fk_tb_agenda_tb_paciente1` FOREIGN KEY (`id_paciente`) REFERENCES `tb_paciente` (`id_paciente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tb_agenda_tb_unidade` FOREIGN KEY (`id_unidade`) REFERENCES `tb_unidade` (`id_unidade`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_paciente`
--
ALTER TABLE `tb_paciente`
  ADD CONSTRAINT `fk_tb_paciente_tb_unidade1` FOREIGN KEY (`id_unidade`) REFERENCES `tb_unidade` (`id_unidade`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_unidade`
--
ALTER TABLE `tb_unidade`
  ADD CONSTRAINT `fk_tb_unidade_tb_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;