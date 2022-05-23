-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 23 2022 г., 20:31
-- Версия сервера: 8.0.24
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `users_list`
--

-- --------------------------------------------------------

--
-- Структура таблицы `phone`
--

CREATE TABLE `phone` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `phone` text COLLATE utf8_bin NOT NULL,
  `number` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `phone`
--

INSERT INTO `phone` (`id`, `user_id`, `phone`, `number`) VALUES
(1, 1, '56498', 1),
(2, 1, '5896635', 2),
(3, 2, '7875441', 2),
(4, 2, '71747', 3),
(5, 1, '78575', 3),
(6, 4, '45274', 1),
(7, 4, '785676', 3),
(8, 5, '456456', 2),
(9, 6, '786786', 3),
(10, 7, '454524367', 2),
(11, 11, '785678', 3),
(12, 10, '87585', 3),
(13, 7, '159', 1),
(14, 8, '159634', 1),
(15, 8, '89635', 2),
(16, 8, '456', 3),
(17, 9, '75645', 2),
(18, 13, '8963', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `del` tinyint NOT NULL DEFAULT '0',
  `first_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `company_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `position` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `del`, `first_name`, `last_name`, `email`, `company_name`, `position`) VALUES
(1, 0, 'Вадим', 'Ломиворотов', 'lomvad1406@mail.ru', 'НГУЭУ', 'PHP-Junior'),
(2, 0, 'Яков', 'Маллаев', 'mallaev@mail.ru', 'НГУЭУ', 'Стажёр PHP'),
(3, 0, 'sgsdfgsd', 'sdfgsdfg', 'sdfgsdfg', '', ''),
(4, 0, 'Вася', 'Пупкин', 'lomsdfsdf@xcvsc', 'ыфувапаывп', 'ывапаывп'),
(5, 0, 'Олег', 'ываываыв', 'врпаопваро', 'вапроапо', ''),
(6, 0, 'Вадим', 'Ломиворотов', 'олдполрлдпрл', '', ''),
(7, 0, 'Яков', 'авпвап', 'апровао', 'апрлопро', ''),
(8, 0, 'Олег', 'Орлов', 'oleg@mail.ru', 'Ястреб', 'Сотрудник склада'),
(9, 0, 'Вася', 'да', 'sdfgsaefg@mail.ru', 'Орёл', ''),
(10, 0, 'Евгений', 'олджолджпдп', 'полчвапывап', 'пывапывап', ''),
(11, 0, 'нщшжлгщзшлжорл', 'олджолджпдп', 'полчвапывап', 'пывапывап', ''),
(12, 0, 'ывапыв', 'ывапывап', 'ывап', 'апыв', ''),
(13, 0, 'Юля', 'Где', 'ываывавыапр', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `phone`
--
ALTER TABLE `phone`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `phone`
--
ALTER TABLE `phone`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
