-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 22 2025 г., 21:13
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bakery`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`) VALUES
(1, 'Круассаны и слойки', 'Разнообразие выпечки из слоеного теста', 'https://i.pinimg.com/736x/63/28/b2/6328b2bd9b901be696b4e17c34e1b25e.jpg'),
(2, 'Маффины и капкейки', 'Сладкие кексы и пирожные', 'https://i.pinimg.com/736x/d6/79/05/d67905e2f754d6c8cd189fab7842b284.jpg'),
(3, 'Хлеб и багеты', 'Различные виды хлеба', 'https://i.pinimg.com/736x/8f/dd/cf/8fddcf3478b2fdae067eab9e74c9fe2a.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `featured` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `amount` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `short_description`, `image`, `price`, `stock`, `featured`, `created_at`, `updated_at`, `amount`) VALUES
(1, 1, 'Французский круассан', 'Нежный слоеный круассан, приготовленный по классическому рецепту.', 'Хрустящий и ароматный круассан', 'https://i.pinimg.com/736x/e5/eb/da/e5ebdaa4d515852bd56e89650fcc997e.jpg', 120.00, 100, 1, '2025-03-18 10:13:08', '2025-03-18 11:18:36', 2),
(2, 2, 'Шоколадный маффин', 'Вкусный маффин с кусочками шоколада.', 'Сочный шоколадный маффин', 'https://i.pinimg.com/736x/36/fd/76/36fd76e6b5a4783c2bcb9eab7dd28754.jpg', 80.00, 150, 1, '2025-03-18 10:13:08', '2025-03-18 11:18:36', 7),
(3, 3, 'Ржаной хлеб с семечками', 'Ароматный ржаной хлеб с семенами подсолнечника.', 'Полезный и вкусный ржаной хлеб', 'https://i.pinimg.com/736x/64/b5/a8/64b5a8471628a961fcfe5c95f8c8442a.jpg', 90.00, 80, 0, '2025-03-18 10:13:08', '2025-03-18 11:18:36', 8),
(4, 1, 'Слойка с яблоками', 'Сладкая слойка с начинкой из свежих яблок.', 'Нежная и сочная слойка', 'https://i.pinimg.com/736x/23/10/3c/23103c867aea77f7b5b30f0c5d54d41d.jpg', 100.00, 120, 0, '2025-03-18 10:13:08', '2025-03-18 11:18:36', 17),
(5, 2, 'Ванильный капкейк', 'Нежный капкейк с кремом из ванили.', 'Сладкий и воздушный капкейк', 'https://i.pinimg.com/736x/46/77/63/467763e65b0372ecfcd714601146eee3.jpg', 95.00, 110, 1, '2025-03-18 10:13:08', '2025-03-18 11:18:36', 1),
(6, 3, 'Багет', 'Хрустящий багет с золотистой корочкой.', 'Идеальный багет для бутербродов', 'https://i.pinimg.com/736x/e2/de/55/e2de55d18501040d639230833ef53ead.jpg', 75.00, 90, 0, '2025-03-18 10:13:08', '2025-03-22 19:38:21', 15),
(7, 1, 'Пирог с вишней', 'Сочный пирог с начинкой из свежей вишни.', 'Сладкий вишневый пирог', 'https://i.pinimg.com/736x/9a/34/78/9a3478d14d4912de672a7b9f4a6e2118.jpg', 250.00, 50, 1, '2025-03-18 10:13:08', '2025-03-22 19:41:40', 12),
(8, 2, 'Кекс с изюмом', 'Классический кекс с изюмом.', 'Пышный и вкусный кекс', 'https://i.pinimg.com/736x/36/85/f4/3685f414f84cc7dd4fe7fdca86ee3f91.jpg', 110.00, 70, 0, '2025-03-18 10:13:08', '2025-03-22 19:40:58', 13),
(9, 3, 'Чиабатта', 'Итальянский хлеб чиабатта с воздушной структурой.', 'Мягкий внутри, хрустящий снаружи', 'https://i.pinimg.com/736x/19/da/fa/19dafad9cff027929b8ed5395216444c.jpg', 85.00, 60, 0, '2025-03-18 10:13:09', '2025-03-22 19:40:11', 9),
(10, 1, 'Творожная ватрушка', 'Ватрушка с начинкой из творога', 'Нежная выпечка с творожным кремом', 'https://i.pinimg.com/736x/a3/d0/a1/a3d0a11b1abd9fe32bfdf210d098e5cc.jpg', 130.00, 80, 1, '2025-03-18 10:13:09', '2025-03-22 19:42:15', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `registration_date`, `last_login`, `is_active`) VALUES
(1, 'fuckedurmom', '$2y$10$Y02SZ3OPZOlgDxivlXhJbujehnUBOAPTVhJV0FnEGk8VrILGWv6qm', 'marinatimoshina234@gmail.com', 'Марина', 'Тимошина', '2025-03-19 06:49:52', NULL, 1),
(2, 'kfjnefjklrf', '$2y$10$GMORUgFigoYExZqG.zteLOLRNxaEJNsLZSkPZNoejdjtFJ.GKvERe', 'qwertyuio@sdfg.fgh', 'маришка', 'Иди нахуй', '2025-03-21 08:49:39', NULL, 1),
(4, 'маришка', '$2y$10$P.Doov2AWM8.PhbuW.KnJOIrDPeVLMkKgvo0dSdx2r.ku2gJr32Hq', 'marinat@gmail.com', 'Марина', 'Тимошина', '2025-03-21 13:46:52', NULL, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
