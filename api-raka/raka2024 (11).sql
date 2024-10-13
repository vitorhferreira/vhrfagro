-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Out-2024 às 02:59
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `raka2024`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cpf` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medico` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` date NOT NULL,
  `telefone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hora` time NOT NULL,
  `local` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnostico` varchar(800) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `cpf`, `medico`, `data`, `telefone`, `hora`, `local`, `diagnostico`, `created_at`, `updated_at`) VALUES
(1, '09656221931', 'Dr Carlos', '2024-07-30', '44984473802', '10:30:00', 'Hospital Cemil', 'Consulta com medico cardiologista', '2024-06-26 00:45:20', '2024-06-26 00:45:20'),
(2, '96385274100', 'Dr Carlos', '2024-08-04', '4489552233', '15:00:00', 'Hospital Cemil', 'Consulta com medico neuro', '2024-06-26 01:05:04', '2024-06-26 01:05:04'),
(3, '09656221931', 'Dra Maria', '2024-08-22', '44984473802', '15:00:00', 'Hospital NSA', 'Consulta com medico Geral', '2024-06-26 01:08:31', '2024-06-26 01:09:32'),
(5, '74185296300', 'Dr Renan', '2024-08-22', '4488998899', '10:30:00', 'Hospital Cemil', 'Sem consulta ainda', '2024-06-28 01:54:55', '2024-06-28 01:54:55'),
(6, '12345678910', 'Dr Carlos', '2024-07-10', '44988889999', '10:30:00', 'Hospital Cemil', 'Sem consulta ainda', '2024-06-28 02:56:14', '2024-06-28 02:56:14');

-- --------------------------------------------------------

--
-- Estrutura da tabela `consumo_racao`
--

CREATE TABLE `consumo_racao` (
  `id` int(11) NOT NULL,
  `tipo_racao` varchar(100) NOT NULL,
  `quantidade_kg` decimal(10,2) NOT NULL,
  `valor_estimado` decimal(10,2) NOT NULL,
  `data_inicial` date NOT NULL,
  `data_final` date NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `consumo_racao`
--

INSERT INTO `consumo_racao` (`id`, `tipo_racao`, `quantidade_kg`, `valor_estimado`, `data_inicial`, `data_final`, `created_at`, `updated_at`) VALUES
(2, 'Sal', '100.00', '1000.00', '2024-09-01', '2024-10-30', '2024-10-05 20:06:44', '2024-10-05 20:06:44'),
(3, 'mineral', '250.00', '3000.00', '2024-09-01', '2024-10-10', '2024-10-05 20:26:50', '2024-10-05 20:37:50'),
(5, 'Sal', '20.00', '200.00', '2024-10-12', '2024-10-15', '2024-10-12 21:12:23', '2024-10-12 21:12:23');

-- --------------------------------------------------------

--
-- Estrutura da tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gastovets`
--

CREATE TABLE `gastovets` (
  `id` int(11) NOT NULL,
  `motivo_gasto` text NOT NULL,
  `qtd_cabecas` int(11) NOT NULL,
  `data_pagamento` date DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `lote` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pago` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `gastovets`
--

INSERT INTO `gastovets` (`id`, `motivo_gasto`, `qtd_cabecas`, `data_pagamento`, `valor`, `lote`, `created_at`, `updated_at`, `pago`) VALUES
(2, 'Compra de gado', 62, '2024-12-29', '120000.00', '003', '2024-09-29 15:05:15', '2024-10-13 02:01:00', 0),
(5, 'Pasto', 30, '2024-11-05', '1500.00', '004', '2024-10-05 22:45:20', '2024-10-05 22:45:20', 0),
(8, 'Serviço Veterinário', 15, '2024-10-01', '700.00', '002', '2024-10-05 22:14:43', '2024-10-13 02:00:52', 0),
(9, 'Produtos Veterinarios', 19, '2024-09-24', '300.00', '005', '2024-10-08 01:35:31', '2024-10-08 01:35:31', 0),
(10, 'Gasto Veterinario', 20, '2024-11-15', '100.00', '005', '2024-10-08 01:46:54', '2024-10-08 01:46:54', 0),
(11, 'Gasto Veterinario', 15, '2024-11-20', '150.00', '005', '2024-10-08 01:50:38', '2024-10-08 01:50:38', 0),
(12, 'Gasto Veterinario', 30, '2024-10-20', '30.00', '002', '2024-10-13 00:07:15', '2024-10-13 00:07:15', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lotes`
--

CREATE TABLE `lotes` (
  `id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `peso` decimal(10,2) NOT NULL,
  `valor_individual` decimal(10,2) NOT NULL,
  `idade_media` int(11) NOT NULL,
  `data_compra` date NOT NULL,
  `numero_lote` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `lotes`
--

INSERT INTO `lotes` (`id`, `quantidade`, `peso`, `valor_individual`, `idade_media`, `data_compra`, `numero_lote`, `created_at`, `updated_at`) VALUES
(2, 10, '140.00', '2500.00', 15, '2024-09-28', '002', '2024-09-29 01:30:02', '2024-10-13 03:54:28'),
(3, 60, '230.00', '2000.00', 18, '2024-09-29', '003', '2024-09-29 15:04:37', '2024-10-13 03:48:34'),
(4, 30, '200.00', '2300.00', 17, '2024-09-30', '004', '2024-09-29 15:07:46', '2024-09-29 15:07:46'),
(5, 20, '180.00', '1800.00', 15, '2024-09-25', '005', '2024-09-29 15:08:12', '2024-09-29 15:08:12'),
(7, 30, '150.00', '1500.00', 15, '2024-10-05', '897', '2024-10-06 16:21:19', '2024-10-06 16:21:19'),
(8, 40, '180.00', '2200.00', 14, '2024-10-08', '758', '2024-10-11 04:14:59', '2024-10-11 04:14:59'),
(9, 30, '180.00', '2100.00', 18, '2024-10-12', '006', '2024-10-12 23:50:32', '2024-10-12 23:50:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `medicos`
--

CREATE TABLE `medicos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idade` int(11) NOT NULL,
  `profissao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `medicos`
--

INSERT INTO `medicos` (`id`, `nome`, `cpf`, `idade`, `profissao`, `created_at`, `updated_at`) VALUES
(1, 'Dr Carlos', '78945612300', 30, 'Cardio', '2024-06-26 00:43:53', '2024-06-26 00:43:53'),
(2, 'Dra Maria', '74177896300', 40, 'Geral', '2024-06-26 01:07:43', '2024-06-26 01:07:43'),
(4, 'Dr Renan', '78945612300', 23, 'Cardio', '2024-06-28 01:54:03', '2024-06-28 01:54:03'),
(5, 'joaoo', '12345678910', 12, 'Cardio', '2024-06-28 02:53:19', '2024-06-28 02:53:40');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_06_17_230635_create_vacinas_table', 1),
(6, '2024_06_17_234556_create_medicos_table', 1),
(7, '2024_06_18_000001_create_pacientes_table', 1),
(8, '2024_06_18_003208_create_agendamentos_table', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cpf` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nascimento` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `pacientes`
--

INSERT INTO `pacientes` (`id`, `cpf`, `nome`, `senha`, `nascimento`, `created_at`, `updated_at`) VALUES
(1, '09656221931', 'vitor hugo ferreira', 'ferreira', '2001-05-24', '2024-06-26 00:43:26', '2024-06-26 00:43:26'),
(6, '12345678910', 'renann', '123', '2002-10-10', '2024-06-28 02:54:23', '2024-06-28 02:54:47'),
(7, '96385274100', 'chines', 'chines', '1998-02-01', '2024-06-28 03:03:54', '2024-06-28 03:03:54');

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('vitorferrras@gmail.com', 'p0Nbv1GusTKfNS9fmb8UuKdBBsWFlP5U3CsVXV31hJ75ECvLbxaBP9G3EqKS', '2024-10-12 22:29:06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `relatorio`
--

CREATE TABLE `relatorio` (
  `id` int(11) NOT NULL,
  `lote_id` int(11) NOT NULL,
  `valor_compra` decimal(10,2) NOT NULL,
  `peso_comprado` decimal(10,2) NOT NULL,
  `quantidade_comprada` int(11) NOT NULL,
  `valor_venda` decimal(10,2) NOT NULL,
  `peso_vendido` decimal(10,2) NOT NULL,
  `quantidade_vendida` int(11) NOT NULL,
  `total_gastos` decimal(10,2) NOT NULL,
  `total_vacinas` int(11) NOT NULL,
  `lucro` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `numero_lote` varchar(50) DEFAULT NULL,
  `id_venda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cpf` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `cpf`, `email`, `nome`, `senha`, `created_at`, `updated_at`) VALUES
(7, '09656221931', 'vitorferrras@gmail.com', 'vitor hugo ferreira', '$2y$10$5iE4dI1OVMyi.zup/Rt3KujcbDOY5k4Fi0StXrUACklOu.dSLFvs.', '2024-10-03 02:39:54', '2024-10-12 22:19:24'),
(10, '12345678900', 'renanflausino2000@gmail.com', 'Renan Flausino', '$2y$10$A0WnPktFPiBr7MmVrj26/OsPPF9KdYwaHrU1yEuJRGWjrIhrUfrm.', '2024-10-03 03:40:51', '2024-10-05 22:07:44'),
(11, '78945612300', 'geeegarcia@gmail.com', 'Geovana', '$2y$10$elW5fxKlc.olYapjTormn.hgQLE6MoKHeXJmzoo02CTeZDHmaRROW', '2024-10-05 22:08:34', '2024-10-05 22:08:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vacinas`
--

CREATE TABLE `vacinas` (
  `id` int(11) NOT NULL,
  `nome_vacina` varchar(255) NOT NULL,
  `data_aplicacao` date NOT NULL,
  `numero_lote` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `quantidade_cabecas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `vacinas`
--

INSERT INTO `vacinas` (`id`, `nome_vacina`, `data_aplicacao`, `numero_lote`, `created_at`, `updated_at`, `quantidade_cabecas`) VALUES
(4, 'Febre', '2024-09-16', '003', '2024-09-29 16:26:53', '2024-10-05 23:34:37', 50),
(7, 'malaria', '2024-10-15', '003', '2024-10-05 22:32:39', '2024-10-05 22:32:39', 15),
(9, 'malaria', '2024-09-09', '002', '2024-10-11 01:10:10', '2024-10-11 01:10:10', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `id` int(11) NOT NULL,
  `lote_id` int(11) NOT NULL,
  `peso_medio_venda` decimal(10,2) NOT NULL,
  `comprador` varchar(255) NOT NULL,
  `cpf_cnpj_comprador` varchar(18) NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `quantidade_vendida` int(11) NOT NULL,
  `prazo_pagamento` varchar(50) DEFAULT NULL,
  `data_compra` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `numero_lote` varchar(50) DEFAULT NULL,
  `recebido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Acionadores `vendas`
--
DELIMITER $$
CREATE TRIGGER `after_delete_vendas` AFTER DELETE ON `vendas` FOR EACH ROW BEGIN
    -- Deletar os registros do relatório associados ao id_venda da venda excluída
    DELETE FROM relatorio WHERE id_venda = OLD.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_vendas` AFTER INSERT ON `vendas` FOR EACH ROW BEGIN
    DECLARE valor_compra DECIMAL(10,2);
    DECLARE peso_comprado DECIMAL(10,2);
    DECLARE total_gastos DECIMAL(10,2);
    DECLARE total_gastos_registrados DECIMAL(10,2);
    DECLARE total_vacinas INT;
    DECLARE quantidade_total_lote INT;

    -- Obter o valor de compra e o peso comprado, ajustados pela quantidade vendida
    SELECT valor_individual * NEW.quantidade_vendida, 
           peso * NEW.quantidade_vendida
    INTO valor_compra, peso_comprado
    FROM lotes
    WHERE id = NEW.lote_id;

    -- Obter a quantidade total do lote
    SELECT quantidade INTO quantidade_total_lote
    FROM lotes
    WHERE id = NEW.lote_id;

    -- Obter o total de gastos já registrados no relatório
    SELECT IFNULL(SUM(total_gastos), 0) INTO total_gastos_registrados
    FROM relatorio
    WHERE lote_id = NEW.lote_id;

    -- Somar o total de gastos do lote, ajustados proporcionalmente pela quantidade vendida e subtraindo o que já está registrado
    SELECT (IFNULL(SUM(valor), 0) - total_gastos_registrados) / quantidade_total_lote * NEW.quantidade_vendida
    INTO total_gastos
    FROM gastovets
    WHERE lote = (SELECT numero_lote FROM lotes WHERE id = NEW.lote_id);

    -- Contar o total de vacinas aplicadas no lote
    SELECT COUNT(*)
    INTO total_vacinas
    FROM vacinas
    WHERE numero_lote = (SELECT numero_lote FROM lotes WHERE id = NEW.lote_id);

    -- Inserir ou atualizar o relatório com os novos valores, incluindo o id_venda
    INSERT INTO relatorio (lote_id, id_venda, valor_compra, peso_comprado, quantidade_comprada, valor_venda, peso_vendido, quantidade_vendida, total_gastos, total_vacinas, lucro, numero_lote)
    VALUES (
        NEW.lote_id,
        NEW.id,
        valor_compra,
        peso_comprado,
        NEW.quantidade_vendida,
        NEW.valor_unitario * NEW.quantidade_vendida,
        NEW.peso_medio_venda * NEW.quantidade_vendida,
        NEW.quantidade_vendida,
        total_gastos,
        total_vacinas,
        (NEW.valor_unitario * NEW.quantidade_vendida) - valor_compra - total_gastos,
        NEW.numero_lote
    )
    ON DUPLICATE KEY UPDATE
        valor_venda = valor_venda + (NEW.valor_unitario * NEW.quantidade_vendida),
        peso_vendido = peso_vendido + (NEW.peso_medio_venda * NEW.quantidade_vendida),
        quantidade_vendida = quantidade_vendida + NEW.quantidade_vendida,
        total_gastos = total_gastos + (total_gastos - total_gastos_registrados),
        lucro = (valor_venda) - valor_compra - total_gastos;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_vendas` AFTER UPDATE ON `vendas` FOR EACH ROW BEGIN
    DECLARE valor_compra DECIMAL(10,2);
    DECLARE peso_comprado DECIMAL(10,2);
    DECLARE total_gastos DECIMAL(10,2);
    DECLARE total_gastos_lote DECIMAL(10,2);
    DECLARE quantidade_total_lote INT;

    -- Obter o valor de compra e o peso comprado com base na nova quantidade vendida
    SELECT valor_individual * NEW.quantidade_vendida, 
           peso * NEW.quantidade_vendida
    INTO valor_compra, peso_comprado
    FROM lotes
    WHERE id = NEW.lote_id;

    -- Obter a quantidade total do lote
    SELECT quantidade INTO quantidade_total_lote
    FROM lotes
    WHERE id = NEW.lote_id;

    -- Obter o total de gastos do lote
    SELECT IFNULL(SUM(valor), 0) INTO total_gastos_lote
    FROM gastovets
    WHERE lote = (SELECT numero_lote FROM lotes WHERE id = NEW.lote_id);

    -- Calcular o total de gastos com base na nova quantidade vendida e quantidade total do lote
    SET total_gastos = (total_gastos_lote / (quantidade_total_lote + NEW.quantidade_vendida)) * NEW.quantidade_vendida;

    -- Atualizar o relatório com os novos valores
    UPDATE relatorio
    SET 
        valor_venda = (SELECT SUM(valor_unitario * quantidade_vendida) FROM vendas WHERE lote_id = NEW.lote_id),
        peso_vendido = (SELECT SUM(peso_medio_venda * quantidade_vendida) FROM vendas WHERE lote_id = NEW.lote_id),
        quantidade_vendida = (SELECT SUM(quantidade_vendida) FROM vendas WHERE lote_id = NEW.lote_id),
        quantidade_comprada = NEW.quantidade_vendida, -- Atualiza a quantidade comprada com a nova quantidade vendida
        valor_compra = valor_compra, -- Atualiza o valor de compra com base na nova quantidade vendida
        total_gastos = total_gastos, -- Atualiza o total de gastos proporcionalmente
        lucro = valor_venda - valor_compra - total_gastos,
        numero_lote = NEW.numero_lote
    WHERE lote_id = NEW.lote_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_vendas` BEFORE INSERT ON `vendas` FOR EACH ROW BEGIN
    -- Buscar o numero_lote na tabela `lotes` baseado no lote_id
    SET NEW.numero_lote = (SELECT numero_lote FROM lotes WHERE id = NEW.lote_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_vendas` BEFORE UPDATE ON `vendas` FOR EACH ROW BEGIN
    -- Atualizar o numero_lote baseado no lote_id
    SET NEW.numero_lote = (SELECT numero_lote FROM lotes WHERE id = NEW.lote_id);
END
$$
DELIMITER ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `consumo_racao`
--
ALTER TABLE `consumo_racao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices para tabela `gastovets`
--
ALTER TABLE `gastovets`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pacientes_cpf_unique` (`cpf`);

--
-- Índices para tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Índices para tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices para tabela `relatorio`
--
ALTER TABLE `relatorio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lote_relatorio` (`lote_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_cpf_unique` (`cpf`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Índices para tabela `vacinas`
--
ALTER TABLE `vacinas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_lote_id` (`lote_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `consumo_racao`
--
ALTER TABLE `consumo_racao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `gastovets`
--
ALTER TABLE `gastovets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `lotes`
--
ALTER TABLE `lotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `relatorio`
--
ALTER TABLE `relatorio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `vacinas`
--
ALTER TABLE `vacinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `relatorio`
--
ALTER TABLE `relatorio`
  ADD CONSTRAINT `fk_lote_relatorio` FOREIGN KEY (`lote_id`) REFERENCES `lotes` (`id`);

--
-- Limitadores para a tabela `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_lote_id` FOREIGN KEY (`lote_id`) REFERENCES `lotes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
