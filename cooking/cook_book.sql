-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 07 2023 г., 04:43
-- Версия сервера: 10.3.16-MariaDB
-- Версия PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cook_book`
--

-- --------------------------------------------------------

--
-- Структура таблицы `compositions`
--

CREATE TABLE `compositions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `ingredient_id` bigint(20) UNSIGNED NOT NULL,
  `counts` char(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `compositions`
--

INSERT INTO `compositions` (`id`, `recipe_id`, `ingredient_id`, `counts`) VALUES
(1, 2, 6, '100'),
(2, 2, 1, '250'),
(3, 2, 3, '50'),
(4, 2, 2, '10'),
(5, 1, 4, '200'),
(6, 1, 1, '300'),
(7, 1, 2, '15'),
(8, 3, 1, '250'),
(9, 3, 2, '15'),
(10, 3, 3, '120'),
(11, 3, 4, '0.3');

-- --------------------------------------------------------

--
-- Структура таблицы `cooks`
--

CREATE TABLE `cooks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surname` char(100) COLLATE utf8_bin NOT NULL,
  `name` char(50) COLLATE utf8_bin DEFAULT NULL,
  `login` char(50) COLLATE utf8_bin DEFAULT NULL,
  `password` char(100) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `cooks`
--

INSERT INTO `cooks` (`id`, `surname`, `name`, `login`, `password`) VALUES
(1, 'Птенчик', 'Виолетт', 'qwerty', '$2y$10$TGuYSvNVoBDKyHvyMPpc9.TAhnET2zGVvYCixzmqBbeNh.kxFxro.'),
(2, 'Пупкин', 'Василь', 'pupa', '$2y$10$EeH9GS.QLqWnvfvBgARQZ.9KNiOuendJ1nzyzzqmYndPL7/rb4fmO'),
(3, 'Зайкина', 'Надежда', ' заяц', '$2y$10$31mBLQBxWF3Lwd9daySuy.7cGeBWhe2v/BEAw9.WaThs6fb5LAXS2'),
(4, 'Брусничкина', 'Люся', 'brus', '$2y$10$l6384Lu2XgOYk08Sg4ZCLOxo7sNT8xf/NU5WoXTKY8EAWlxdUzzte'),
(5, 'Ivanova', 'Irina', 'ir', '$2y$10$qBUTzpn3DO1Y9.6nsEHKzez2jmB1JNIgwruAgwpKy0fGOagHzBaPi');

-- --------------------------------------------------------

--
-- Структура таблицы `ingredients`
--

CREATE TABLE `ingredients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` char(100) COLLATE utf8_bin NOT NULL,
  `unit` char(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `unit`) VALUES
(1, 'мука', 'г.'),
(2, 'соль', 'г.'),
(3, 'сахар', 'г.'),
(4, 'молоко', 'л.'),
(5, 'яйцо', 'шт.'),
(6, 'повидло', 'г.');

-- --------------------------------------------------------

--
-- Структура таблицы `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` char(255) COLLATE utf8_bin NOT NULL,
  `cook_id` bigint(20) UNSIGNED NOT NULL,
  `steps` text COLLATE utf8_bin NOT NULL,
  `picture` char(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `cook_id`, `steps`, `picture`) VALUES
(1, 'Блины \"Сытные\"', 3, 'Делаем с душой', '\'images/bliny.jpeg\''),
(2, 'Пирожки \"Огонёк\"', 1, 'Следить, чтобы не сгорели.', '\'images/pirozhki.jpeg\''),
(3, 'Просто вкусные блины', 1, 'Как сердце подскажет. ', '\'images/блинЛучший.jpg\'');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `compositions`
--
ALTER TABLE `compositions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingredient_id` (`ingredient_id`),
  ADD KEY `recipe_id` (`recipe_id`);

--
-- Индексы таблицы `cooks`
--
ALTER TABLE `cooks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cooks_id` (`cook_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `compositions`
--
ALTER TABLE `compositions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `cooks`
--
ALTER TABLE `cooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `compositions`
--
ALTER TABLE `compositions`
  ADD CONSTRAINT `compositions_ibfk_1` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`),
  ADD CONSTRAINT `compositions_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`);

--
-- Ограничения внешнего ключа таблицы `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`cook_id`) REFERENCES `cooks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
