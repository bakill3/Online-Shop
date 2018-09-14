-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12-Jun-2018 às 22:21
-- Versão do servidor: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id2178076_dblifepage`
--
CREATE DATABASE IF NOT EXISTS `id2178076_dblifepage` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `id2178076_dblifepage`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `carrinho_id` int(11) NOT NULL,
  `nome_do_produto` varchar(20) NOT NULL,
  `preco_do_produto` float NOT NULL,
  `quantidade` int(6) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `categoria_id` int(11) NOT NULL,
  `categoria` varchar(20) NOT NULL DEFAULT 'todos',
  `feat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`categoria_id`, `categoria`, `feat`) VALUES
(1, 'Hardware', 0),
(2, 'Ratos', 0),
(3, 'Televisões', 1),
(4, 'Acessórios', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id_paypal` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `username` varchar(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `tn` varchar(30) NOT NULL,
  `status` varchar(20) NOT NULL,
  `morada` varchar(50) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `price_descontado` decimal(12,2) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `descricao` char(255) NOT NULL,
  `stock` int(50) NOT NULL,
  `detalhes` text NOT NULL,
  `avg_rating` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `p_name`, `image`, `price`, `price_descontado`, `categoria_id`, `descricao`, `stock`, `detalhes`, `avg_rating`) VALUES
(1, 'USB', 'usb.jpg', '5.00', '0.00', 4, 'Um bom produto 4 - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non nisi eu ipsum posuere pulvinar. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis fringilla, lacus a blandit porta, arcu met', 488, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Excelente <br>Ano em que foi fabricado: 2013', '4.0'),
(2, 'Rato Razer', '2.jpg', '80.00', '0.00', 2, 'Um bom produto 3 - Nulla sed interdum lectus. Pellentesque et ante et orci tempor sollicitudin in scelerisque nisi. Etiam aliquam, tortor ac vulputate ultricies, lacus quam lobortis sapien, sed viverra libero lacus eu ipsum. Nunc blandit erat ut nisl inte', 20, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Excelente <br>Ano em que foi fabricado: 2013', '5.0'),
(3, 'Disco Externo', 'disco.jpg', '20.00', '0.00', 1, 'Um bom produto 2 - Fusce ullamcorper in mauris quis efficitur. Morbi pellentesque purus eu justo imperdiet, et semper arcu interdum. Nullam ac mauris at leo tempus congue. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus m', 391, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Excelente <br>Ano em que foi fabricado: 2012', '3.0'),
(4, 'Televisao HD', 'tv.jpg', '500.00', '0.00', 3, 'Um bom produto 1 - Nam dignissim urna et condimentum ullamcorper. Nulla facilisi. Morbi vitae odio eget nisi ullamcorper faucibus at id nulla. Vestibulum dapibus nunc nec dignissim faucibus. Morbi quis mattis orci, eget sagittis arcu. Vestibulum sit amet', 9, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Boa <br>Ano em que foi fabricado: 2012', '1.0'),
(5, 'Laptop MSI', '6.png', '849.49', '0.00', 1, 'Um grande computador! - Pellentesque tempus porttitor mauris non porttitor. Quisque mattis sem vitae nibh auctor iaculis. Duis maximus non felis in imperdiet. Phasellus id justo metus. Etiam rutrum ut justo eu eleifend. Phasellus tincidunt vitae ipsum vel', 4, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Excelente <br>Ano em que foi fabricado: 2013', '0.0'),
(6, 'Plasma 1', '20.jpg', '900.00', '0.00', 3, 'Um bom plasma 1 - Suspendisse potenti. Nunc ac ex enim. Phasellus pulvinar turpis urna, sodales scelerisque justo viverra eget. Cras luctus hendrerit neque, id condimentum lectus. Phasellus quis aliquam sem, non consectetur nibh. Aliquam at mi at felis di', 12, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Muito Boa <br>Ano em que foi fabricado: 2013', '0.0'),
(7, 'Plasma 2', '21.jpg', '500.00', '0.00', 3, 'Um bom plasma 2', 15, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Razoável <br>Ano em que foi fabricado: 2012', '0.0'),
(8, 'Plasma 3', '22.jpg', '550.00', '0.00', 3, 'Um bom plasma 3', 13, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Razoável <br>Ano em que foi fabricado: 2005', '0.0'),
(9, 'Plasma 4', '23.jpg', '400.00', '0.00', 3, 'Um bom plasma 4', 5, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Muito Boa <br>Ano em que foi fabricado: 2013', '0.0'),
(10, 'Plasma 5', '24.jpg', '700.00', '0.00', 3, 'Uma televisão fenomenal', 133, 'Ecrã - Dimensão Diagonal <br />\r\n40 \'<br />\r\nEcrã - Tecnologia <br />\r\nLED<br />\r\nEcrã - Resolução Nativa <br />\r\n4K Ultra HD 3840 x 2160<br />\r\nContraste <br />\r\nMega Contraste<br />\r\nMelhoramento de Imagem <br />\r\nHDR | Auto Motion Plus<br />\r\nProcessamento de Cor <br />\r\nPurColor<br />\r\nSmart TV <br />\r\nSim<br />\r\nLigações USB <br />\r\n2x<br />\r\nLigações HDMI <br />\r\n3x', '0.0'),
(11, 'Plasma 6', '25.jpg', '999.00', '0.00', 3, 'Um bom plasma 6', 25, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Má <br>Ano em que foi fabricado: 2015', '0.0'),
(12, 'Plasma 7', '26.jpg', '4000.00', '0.00', 3, 'Um bom plasma 7', 50, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Boa <br>Ano em que foi fabricado: 2015', '0.0'),
(13, 'Plasma 8', '27.jpg', '1100.00', '0.00', 3, 'Um bom plasma 8', 22, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Excelente <br>Ano em que foi fabricado: 2005', '0.0'),
(14, 'Rato 1', '28.jpg', '40.00', '0.00', 2, 'Um bom rato 1', 15, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Muito Boa <br>Ano em que foi fabricado: 2005', '0.0'),
(15, 'Rato 2', '29.jpg', '60.00', '0.00', 2, 'Um bom rato 2', 13, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Muito Boa <br>Ano em que foi fabricado: 2013', '0.0'),
(16, 'Rato 3', '30.jpg', '70.00', '0.00', 2, 'Um bom rato 3', 23, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Muito Boa <br>Ano em que foi fabricado: 2010', '0.0'),
(17, 'Rato 4', '31.jpg', '74.26', '0.00', 2, 'Um bom rato 4', 11, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Excelente <br>Ano em que foi fabricado: 2010', '0.0'),
(18, 'Rato 5', '32.jpg', '80.00', '0.00', 2, 'Um bom rato 5', 17, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Má <br>Ano em que foi fabricado: 2010', '0.0'),
(19, 'Rato 6', '33.jpg', '85.00', '0.00', 2, 'Um bom rato 6', 14, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Má <br>Ano em que foi fabricado: 2013', '0.0'),
(20, 'Computador 1', '34.jpg', '620.00', '0.00', 1, 'Um bom computador 1', 55, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Razoável <br>Ano em que foi fabricado: 2012', '0.0'),
(21, 'Computador 2', '35.jpg', '730.00', '0.00', 1, 'Um bom computador 2', 99, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Muito Boa <br>Ano em que foi fabricado: 2005', '0.0'),
(22, 'Computador 3', '36.jpg', '475.00', '0.00', 1, 'Um bom computador 3', 92, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Muito Boa <br>Ano em que foi fabricado: 2013', '0.0'),
(23, 'Computador 4', '37.jpg', '1000.00', '0.00', 1, 'Um bom computador 4', 13, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Boa <br>Ano em que foi fabricado: 2010', '0.0'),
(24, 'Computador 5', '38.jpg', '850.00', '0.00', 1, 'Um bom computador 5', 24, 'Dados aleatórios feitos em Python:<br>Qualidade do produto: Excelente <br>Ano em que foi fabricado: 2012', '5.0'),
(26, 'USB Tipo C', '41FVZlkikEL._SL500_AC_SS350_.jpg', '2.50', '0.00', 4, 'Um bom acessório - Sed ut felis vel orci iaculis fermentum ut vitae ligula. Sed nec orci eu lectus sagittis accumsan. Donec a lacus quis leo consequat dictum vitae laoreet lacus. Sed tristique urna sed felis vestibulum, non iaculis ligula interdum. Aenean', 45, '<br />\r\n\nDetalhes do produto<br />\r\n\n100% brand new e de alta qualidade conectores: USB 3.1 <br />\r\n\nTipo C Macho para Fêmea Micro Conector USB 3.1 Tipo C Masculino para Micro USB 2.0 Pinos Adaptador de cabo de Dados Feminino o cabo Adaptador pode converter o cabo Micro USB 2.0 para Novo dispositivo do tipo C. conector do tipo C é o novo design para USB 3.1 Projeto reversível para o Tipo de conector C', '0.0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `products_rating`
--

CREATE TABLE `products_rating` (
  `rate_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `products_rating`
--

INSERT INTO `products_rating` (`rate_id`, `rate`, `comentario`, `user_id`, `product_id`) VALUES
(2, 5, 'Bom Produto estas estrelas vão contar para a Média de estrelas', 13, 1),
(3, 2, 'Estas estrelas vão mesmo contar para a Média de estrelas\r\n', 13, 1),
(5, 3, '3 estrelas nada mais', 12, 3),
(6, 1, '1 estrela nada mais', 12, 4),
(7, 5, 'Ganda pc 1234567', 12, 24),
(11, 5, 'bom produto', 12, 1),
(12, 5, 'Grande rato sim senhor', 12, 2),
(13, 5, 'THE THING GOES SRKRAAAAAAAAAAAA PA PA PA PA', 12, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `promocoes`
--

CREATE TABLE `promocoes` (
  `id_promocao` int(5) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `promocao` varchar(30) NOT NULL,
  `ativado` int(2) NOT NULL,
  `destaque` int(11) NOT NULL,
  `desconto` double NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `roles` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`role_id`, `roles`) VALUES
(1, 'Cliente'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `idade` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) NOT NULL DEFAULT 'assets/img/avatar.jpg',
  `morada` varchar(50) NOT NULL,
  `activate` int(2) NOT NULL DEFAULT '0',
  `recup` int(11) NOT NULL,
  `token` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `nome`, `idade`, `username`, `password`, `foto_perfil`, `morada`, `activate`, `recup`, `token`) VALUES
(12, 2, 'deostulti2@gmail.com', 'Gabriel', 18, 'gab800', '$2y$10$bEnvYP9nOObxCpYdacG2j.G46yT4TmfnZA71DBlcb/v0DDJEKQzka', 'imagens/perfil/gab800/bootstrap-stack.png', 'Edificio Atlântis, lote 3D', 1, 0, 2209),
(13, 1, 'gabriel@gmail.com', 'Gabriel', 18, 'bakill3', '$2y$10$qOUqanwonHOAEcP0bwfrdualOkpOIKB8AgReMvhwZO.2GHdlYZkoC', 'imagens/perfil/bakill3/647670462_preview_tumblr_oehrejZCVH1rpwm80o1_250.jpg', 'Edificio Atlântis, lote 3', 1, 0, 1345);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`carrinho_id`),
  ADD KEY `carrinho_product_id` (`product_id`),
  ADD KEY `carrinho_user_id` (`user_id`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders_user_id` (`user_id`),
  ADD KEY `orders_product_id` (`product_id`),
  ADD KEY `morada_order` (`morada`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_category_id` (`categoria_id`);

--
-- Indexes for table `products_rating`
--
ALTER TABLE `products_rating`
  ADD PRIMARY KEY (`rate_id`),
  ADD KEY `product_rating_user_id` (`user_id`),
  ADD KEY `product_rating_product_id` (`product_id`);

--
-- Indexes for table `promocoes`
--
ALTER TABLE `promocoes`
  ADD PRIMARY KEY (`id_promocao`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `id_produto_prod` (`id_produto`) USING BTREE;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_role` (`role_id`),
  ADD KEY `morada` (`morada`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `carrinho_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products_rating`
--
ALTER TABLE `products_rating`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `promocoes`
--
ALTER TABLE `promocoes`
  MODIFY `id_promocao` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `carrinho_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `morada_usr` FOREIGN KEY (`morada`) REFERENCES `users` (`morada`),
  ADD CONSTRAINT `orders_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `orders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_category_id` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`categoria_id`);

--
-- Limitadores para a tabela `products_rating`
--
ALTER TABLE `products_rating`
  ADD CONSTRAINT `product_rating_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_rating_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `promocoes`
--
ALTER TABLE `promocoes`
  ADD CONSTRAINT `promocoes_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `promocoes_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`categoria_id`);

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
