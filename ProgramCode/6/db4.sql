-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 07 2023 г., 22:43
-- Версия сервера: 8.0.31
-- Версия PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db4`
--
CREATE DATABASE IF NOT EXISTS `db4` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `db4`;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_counter`
--

DROP TABLE IF EXISTS `tbl_counter`;
CREATE TABLE IF NOT EXISTS `tbl_counter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_counter` varchar(255) DEFAULT NULL,
  `units` varchar(255) DEFAULT NULL,
  `isActive` tinyint DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_indication`
--

DROP TABLE IF EXISTS `tbl_indication`;
CREATE TABLE IF NOT EXISTS `tbl_indication` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client` int DEFAULT NULL,
  `username` int DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `roleid` tinyint DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `client` (`client`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tbl_indication`
--

INSERT INTO `tbl_indication` (`id`, `client`, `username`, `address`, `mobile`, `roleid`, `created_at`, `updated_at`) VALUES
(1, 30, 1, 'Березовская', '644', 3, '2023-05-06 11:51:13', '2023-05-06 11:51:13'),
(29, 24, 2, 'гагарина', '321', 3, '2023-05-06 13:14:30', '2023-05-06 13:14:30'),
(32, 24, 0, 'Брест', '80123456789', 2, '2023-05-06 19:58:25', '2023-05-06 19:58:25'),
(49, 30, 1, 'kkk', '46464', 3, '2023-05-09 17:59:00', '2023-05-09 17:59:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_product`
--

DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE IF NOT EXISTS `tbl_product` (
  `Name` varchar(50) NOT NULL,
  `Prix` int NOT NULL,
  `Categorie` varchar(50) NOT NULL,
  `etat` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_roles`
--

DROP TABLE IF EXISTS `tbl_roles`;
CREATE TABLE IF NOT EXISTS `tbl_roles` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'role_id',
  `role` varchar(255) DEFAULT NULL COMMENT 'role_text',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Editor'),
(3, 'User');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `roleid` tinyint DEFAULT NULL,
  `isActive` tinyint DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `email`, `password`, `mobile`, `roleid`, `isActive`, `created_at`, `updated_at`) VALUES
(23, 'admin@admin1', 'admin@admin1', 'admin@admin1', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a', '54852852', 1, 0, '2020-12-19 14:35:56', '2020-12-19 14:35:56'),
(24, 'ahmed', 'benahmed', 'achme@gmail.com', '7f0c9d56d40c3cc1e23e0113d5377779a4de86ff', '54277528', 3, 0, '2020-12-19 15:13:39', '2020-12-19 15:13:39'),
(30, 'root@user1', 'root@user1', 'root@user1', 'eb794434fe45d8d36cb1bd1c2c578e38579d5dad', '6442254', 3, 0, '2023-04-15 19:37:38', '2023-04-15 19:37:38'),
(31, 'Editor', 'editor', 'Editor@editor', 'b9b85b9de7c2225d0bdccb65bfc75a9b75bcf66e', '123456789', 3, 0, '2023-05-04 15:37:42', '2023-05-04 15:37:42'),
(34, 'root@root1', 'root@root1', 'root@root1', '8f8cc717a4040b695b56d335d4febf300a5b2ad4', '123456789', 3, 0, '2023-05-10 10:52:24', '2023-05-10 10:52:24'),
(37, 'Виктор Викторович', 'Крощук', 'vitas20011@inbox.ru', '8ed2c5608218c228b6da35153f6c4275499f2afa', '+375333256425', 3, 0, '2023-06-01 12:10:03', '2023-06-01 12:10:03'),
(38, 'Дмитрий Геннадьевич', 'admin@admin1', 'ivanov@gmail.com', '00c612dd43867555ad897cb738246cc64f2967cb', '+375291234567', 3, 0, '2023-06-01 12:31:55', '2023-06-01 12:31:55'),
(39, 'Editor@editor1', 'Editor@editor1', 'Editor@editor1', 'f78a0ad132198a14e5c44bffc449076f8bcc98e8', 'Editor@editor1', 2, 0, '2023-06-06 16:48:11', '2023-06-06 16:48:11'),
(40, '123', 'admin@admin1', 'elml@inmdl.com', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a', '123456', 2, 0, '2023-06-06 16:53:33', '2023-06-06 16:53:33');

-- --------------------------------------------------------

--
-- Структура таблицы `оп_договор_на_пост`
--

DROP TABLE IF EXISTS `оп_договор_на_пост`;
CREATE TABLE IF NOT EXISTS `оп_договор_на_пост` (
  `Номер_договора` int NOT NULL AUTO_INCREMENT,
  `Дата_сост` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Код_адрес_обслуж` int DEFAULT NULL,
  `Код_реквизиты` int DEFAULT NULL,
  `Код_сотрудн` int DEFAULT NULL,
  PRIMARY KEY (`Номер_договора`),
  UNIQUE KEY `XPKОП_Договор_на_пост` (`Номер_договора`),
  KEY `XIF1ОП_Договор_на_пост` (`Код_адрес_обслуж`),
  KEY `XIF2ОП_Договор_на_пост` (`Код_реквизиты`),
  KEY `XIF3ОП_Договор_на_пост` (`Код_сотрудн`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `оп_договор_на_пост`
--

INSERT INTO `оп_договор_на_пост` (`Номер_договора`, `Дата_сост`, `Код_адрес_обслуж`, `Код_реквизиты`, `Код_сотрудн`) VALUES
(1, '2023-05-21 21:00:00', 1, 1, 1),
(3, '2023-05-26 17:36:09', 4, 2, 2),
(4, '2023-06-01 14:34:54', 2, 2, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `оп_извещение`
--

DROP TABLE IF EXISTS `оп_извещение`;
CREATE TABLE IF NOT EXISTS `оп_извещение` (
  `Код_извещения` int NOT NULL AUTO_INCREMENT,
  `Дата_сост` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Код_сотрудн` int DEFAULT NULL,
  `Код_реквизиты` int DEFAULT NULL,
  `Код_адрес_обслуж` int NOT NULL,
  PRIMARY KEY (`Код_извещения`),
  UNIQUE KEY `XPKОП_Извещение` (`Код_извещения`),
  KEY `XIF1ОП_Извещение` (`Код_сотрудн`),
  KEY `XIF3ОП_Извещение` (`Код_реквизиты`),
  KEY `Код_адрес_обслуж` (`Код_адрес_обслуж`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `оп_извещение`
--

INSERT INTO `оп_извещение` (`Код_извещения`, `Дата_сост`, `Код_сотрудн`, `Код_реквизиты`, `Код_адрес_обслуж`) VALUES
(1, '2023-05-21 21:00:00', 3, 1, 1),
(3, '2023-05-26 18:08:18', 2, 2, 2),
(4, '2023-05-30 13:46:51', 4, 2, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `сп_должности`
--

DROP TABLE IF EXISTS `сп_должности`;
CREATE TABLE IF NOT EXISTS `сп_должности` (
  `Код_должность` int NOT NULL AUTO_INCREMENT,
  `Наименование_должн` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`Код_должность`),
  UNIQUE KEY `XPKСП_Должности` (`Код_должность`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `сп_должности`
--

INSERT INTO `сп_должности` (`Код_должность`, `Наименование_должн`) VALUES
(1, 'Менеджер'),
(2, 'Контролер'),
(3, 'Бухгалтер'),
(4, 'Работник');

-- --------------------------------------------------------

--
-- Структура таблицы `сп_показания`
--

DROP TABLE IF EXISTS `сп_показания`;
CREATE TABLE IF NOT EXISTS `сп_показания` (
  `Код_показания` int NOT NULL AUTO_INCREMENT,
  `Код_адрес_обслуж` int DEFAULT NULL,
  `Код_услуги` int DEFAULT NULL,
  `Количество` int DEFAULT NULL,
  `Дата` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Итого_сумма` decimal(19,4) DEFAULT NULL,
  PRIMARY KEY (`Код_показания`),
  UNIQUE KEY `XPKСП_Показания` (`Код_показания`),
  KEY `XIF1СП_Показания` (`Код_адрес_обслуж`),
  KEY `XIF2СП_Показания` (`Код_услуги`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `сп_показания`
--

INSERT INTO `сп_показания` (`Код_показания`, `Код_адрес_обслуж`, `Код_услуги`, `Количество`, `Дата`, `Итого_сумма`) VALUES
(1, 1, 1, 100, '2023-05-21 21:00:00', '20.6200'),
(2, 1, 2, 100, '2023-05-24 21:00:00', '134.5600'),
(3, 1, 3, 100, '2023-05-21 21:00:00', '27.0500'),
(9, 3, 5, 1000, '2023-05-26 20:30:49', '1.0000'),
(10, 3, 4, 10, '2023-05-26 20:31:29', '11.3120'),
(12, 4, 5, 2000, '2023-05-27 12:04:30', '2.0000'),
(13, 1, 5, 10000, '2023-04-30 13:05:22', '10.0000'),
(14, 4, 1, 10, '2023-05-30 22:06:32', '20.6200'),
(15, 1, 5, 10000, '2023-06-06 16:40:04', '10.0000');

-- --------------------------------------------------------

--
-- Структура таблицы `сп_потребители`
--

DROP TABLE IF EXISTS `сп_потребители`;
CREATE TABLE IF NOT EXISTS `сп_потребители` (
  `Код_потреб` int NOT NULL AUTO_INCREMENT,
  `ФИО_потреб` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Лицевой_счет` int DEFAULT NULL,
  `id` int NOT NULL,
  PRIMARY KEY (`Код_потреб`),
  UNIQUE KEY `XPKСП_Потребители` (`Код_потреб`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `сп_потребители`
--

INSERT INTO `сп_потребители` (`Код_потреб`, `ФИО_потреб`, `Лицевой_счет`, `id`) VALUES
(1, 'Крощук Виктор Викторович', 1234, 37),
(2, 'Крощук Марк Викторович', 1111, 34),
(4, 'Ляшевич Тимофей Александрович', 5555, 31);

-- --------------------------------------------------------

--
-- Структура таблицы `сп_адреса_обслуживания`
--

DROP TABLE IF EXISTS `сп_адреса_обслуживания`;
CREATE TABLE IF NOT EXISTS `сп_адреса_обслуживания` (
  `Код_адрес_обслуж` int NOT NULL AUTO_INCREMENT,
  `Адрес_обслуж` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Код_потреб` int DEFAULT NULL,
  PRIMARY KEY (`Код_адрес_обслуж`),
  UNIQUE KEY `XPKСП_Адреса_обслуживания` (`Код_адрес_обслуж`),
  KEY `XIF1СП_Адреса_обслуживания` (`Код_потреб`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `сп_адреса_обслуживания`
--

INSERT INTO `сп_адреса_обслуживания` (`Код_адрес_обслуж`, `Адрес_обслуж`, `Код_потреб`) VALUES
(1, 'Брест ул.Березовская д.46', 1),
(2, 'Брест ул.Лирическая д.5', 1),
(3, 'Брест ул.Харитоновская д.28', 2),
(4, 'Брест ул.Киевская д.1', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `сп_единицы_хранения`
--

DROP TABLE IF EXISTS `сп_единицы_хранения`;
CREATE TABLE IF NOT EXISTS `сп_единицы_хранения` (
  `Код_ед_хран` int NOT NULL AUTO_INCREMENT,
  `Наименование_ед_хран` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Код_ед_хран`),
  UNIQUE KEY `XPKСП_единицы_хранения` (`Код_ед_хран`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `сп_единицы_хранения`
--

INSERT INTO `сп_единицы_хранения` (`Код_ед_хран`, `Наименование_ед_хран`) VALUES
(1, 'куб.м.'),
(2, ' кВт*ч'),
(3, 'Гкал');

-- --------------------------------------------------------

--
-- Структура таблицы `сп_реквизиты`
--

DROP TABLE IF EXISTS `сп_реквизиты`;
CREATE TABLE IF NOT EXISTS `сп_реквизиты` (
  `Код_реквизиты` int NOT NULL AUTO_INCREMENT,
  `Название_орган` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `УНП_орган` int DEFAULT NULL,
  `Адр_орган` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`Код_реквизиты`),
  UNIQUE KEY `XPKСП_Реквизиты` (`Код_реквизиты`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `сп_реквизиты`
--

INSERT INTO `сп_реквизиты` (`Код_реквизиты`, `Название_орган`, `УНП_орган`, `Адр_орган`) VALUES
(1, 'Брест ЖКХ-1', 123456789, 'Брест, Пионерская 5'),
(2, 'Брест ЖКХ-2', 123123123, 'Брест ул.Хацапетовская д.55');

-- --------------------------------------------------------

--
-- Структура таблицы `сп_сотрудники`
--

DROP TABLE IF EXISTS `сп_сотрудники`;
CREATE TABLE IF NOT EXISTS `сп_сотрудники` (
  `Код_сотрудн` int NOT NULL AUTO_INCREMENT,
  `ФИО` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Код_должность` int DEFAULT NULL,
  PRIMARY KEY (`Код_сотрудн`),
  UNIQUE KEY `XPKСП_Сотрудники` (`Код_сотрудн`),
  KEY `XIF1СП_Сотрудники` (`Код_должность`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `сп_сотрудники`
--

INSERT INTO `сп_сотрудники` (`Код_сотрудн`, `ФИО`, `Код_должность`) VALUES
(1, 'Иванов Иван Иванович', 1),
(2, 'Егоров Егор Егорович', 2),
(3, 'Викторов Виктор Викторович', 3),
(4, 'Курилюк Иоанн Семенович', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `сп_услуги`
--

DROP TABLE IF EXISTS `сп_услуги`;
CREATE TABLE IF NOT EXISTS `сп_услуги` (
  `Код_услуги` int NOT NULL AUTO_INCREMENT,
  `Наим_услуги` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Код_ед_хран` int DEFAULT NULL,
  `Тариф` decimal(19,4) DEFAULT NULL,
  PRIMARY KEY (`Код_услуги`),
  UNIQUE KEY `XPKСП_Услуги` (`Код_услуги`),
  KEY `XIF1СП_Услуги` (`Код_ед_хран`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `сп_услуги`
--

INSERT INTO `сп_услуги` (`Код_услуги`, `Наим_услуги`, `Код_ед_хран`, `Тариф`) VALUES
(1, 'Газоснабжение', 1, '0.2062'),
(2, 'Холодное водоснабжение', 1, '1.3456'),
(3, 'Электроснабжение', 2, '0.2705'),
(4, 'Канализация', 1, '1.1312'),
(5, 'Обогрев помещения', 3, '0.0010');

-- --------------------------------------------------------

--
-- Структура таблицы `таб_часть_договор_на_пост`
--

DROP TABLE IF EXISTS `таб_часть_договор_на_пост`;
CREATE TABLE IF NOT EXISTS `таб_часть_договор_на_пост` (
  `Код_таб_часть_дог_на_пост` int NOT NULL AUTO_INCREMENT,
  `Код_услуги` int DEFAULT NULL,
  `Номер_договора` int DEFAULT NULL,
  PRIMARY KEY (`Код_таб_часть_дог_на_пост`),
  UNIQUE KEY `XPKТаб_часть_договор_на_пост` (`Код_таб_часть_дог_на_пост`),
  KEY `XIF1Таб_часть_договор_на_пост` (`Код_услуги`),
  KEY `XIF2Таб_часть_договор_на_пост` (`Номер_договора`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `таб_часть_договор_на_пост`
--

INSERT INTO `таб_часть_договор_на_пост` (`Код_таб_часть_дог_на_пост`, `Код_услуги`, `Номер_договора`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `таб_часть_извещение`
--

DROP TABLE IF EXISTS `таб_часть_извещение`;
CREATE TABLE IF NOT EXISTS `таб_часть_извещение` (
  `Код_таб_часть_извещение` int NOT NULL AUTO_INCREMENT,
  `Код_показания` int DEFAULT NULL,
  `Код_извещения` int DEFAULT NULL,
  PRIMARY KEY (`Код_таб_часть_извещение`),
  UNIQUE KEY `XPKТаб_часть_извещение` (`Код_таб_часть_извещение`),
  KEY `XIF1Таб_часть_извещение` (`Код_показания`),
  KEY `XIF2Таб_часть_извещение` (`Код_извещения`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `таб_часть_извещение`
--

INSERT INTO `таб_часть_извещение` (`Код_таб_часть_извещение`, `Код_показания`, `Код_извещения`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 13, 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tbl_indication`
--
ALTER TABLE `tbl_indication`
  ADD CONSTRAINT `tbl_indication_ibfk_1` FOREIGN KEY (`client`) REFERENCES `tbl_users` (`id`);

--
-- Ограничения внешнего ключа таблицы `оп_договор_на_пост`
--
ALTER TABLE `оп_договор_на_пост`
  ADD CONSTRAINT `оп_договор_на_пост_ibfk_1` FOREIGN KEY (`Код_адрес_обслуж`) REFERENCES `сп_адреса_обслуживания` (`Код_адрес_обслуж`),
  ADD CONSTRAINT `оп_договор_на_пост_ibfk_2` FOREIGN KEY (`Код_реквизиты`) REFERENCES `сп_реквизиты` (`Код_реквизиты`),
  ADD CONSTRAINT `оп_договор_на_пост_ibfk_3` FOREIGN KEY (`Код_сотрудн`) REFERENCES `сп_сотрудники` (`Код_сотрудн`);

--
-- Ограничения внешнего ключа таблицы `оп_извещение`
--
ALTER TABLE `оп_извещение`
  ADD CONSTRAINT `оп_извещение_ibfk_1` FOREIGN KEY (`Код_сотрудн`) REFERENCES `сп_сотрудники` (`Код_сотрудн`),
  ADD CONSTRAINT `оп_извещение_ibfk_2` FOREIGN KEY (`Код_реквизиты`) REFERENCES `сп_реквизиты` (`Код_реквизиты`),
  ADD CONSTRAINT `оп_извещение_ibfk_3` FOREIGN KEY (`Код_адрес_обслуж`) REFERENCES `сп_адреса_обслуживания` (`Код_адрес_обслуж`);

--
-- Ограничения внешнего ключа таблицы `сп_показания`
--
ALTER TABLE `сп_показания`
  ADD CONSTRAINT `сп_показания_ibfk_1` FOREIGN KEY (`Код_адрес_обслуж`) REFERENCES `сп_адреса_обслуживания` (`Код_адрес_обслуж`),
  ADD CONSTRAINT `сп_показания_ibfk_2` FOREIGN KEY (`Код_услуги`) REFERENCES `сп_услуги` (`Код_услуги`);

--
-- Ограничения внешнего ключа таблицы `сп_потребители`
--
ALTER TABLE `сп_потребители`
  ADD CONSTRAINT `сп_потребители_ibfk_1` FOREIGN KEY (`id`) REFERENCES `tbl_users` (`id`);

--
-- Ограничения внешнего ключа таблицы `сп_адреса_обслуживания`
--
ALTER TABLE `сп_адреса_обслуживания`
  ADD CONSTRAINT `сп_адреса_обслуживания_ibfk_1` FOREIGN KEY (`Код_потреб`) REFERENCES `сп_потребители` (`Код_потреб`);

--
-- Ограничения внешнего ключа таблицы `сп_сотрудники`
--
ALTER TABLE `сп_сотрудники`
  ADD CONSTRAINT `сп_сотрудники_ibfk_1` FOREIGN KEY (`Код_должность`) REFERENCES `сп_должности` (`Код_должность`);

--
-- Ограничения внешнего ключа таблицы `сп_услуги`
--
ALTER TABLE `сп_услуги`
  ADD CONSTRAINT `сп_услуги_ibfk_1` FOREIGN KEY (`Код_ед_хран`) REFERENCES `сп_единицы_хранения` (`Код_ед_хран`);

--
-- Ограничения внешнего ключа таблицы `таб_часть_договор_на_пост`
--
ALTER TABLE `таб_часть_договор_на_пост`
  ADD CONSTRAINT `таб_часть_договор_на_пост_ibfk_1` FOREIGN KEY (`Код_услуги`) REFERENCES `сп_услуги` (`Код_услуги`),
  ADD CONSTRAINT `таб_часть_договор_на_пост_ibfk_2` FOREIGN KEY (`Номер_договора`) REFERENCES `оп_договор_на_пост` (`Номер_договора`);

--
-- Ограничения внешнего ключа таблицы `таб_часть_извещение`
--
ALTER TABLE `таб_часть_извещение`
  ADD CONSTRAINT `таб_часть_извещение_ibfk_1` FOREIGN KEY (`Код_показания`) REFERENCES `сп_показания` (`Код_показания`),
  ADD CONSTRAINT `таб_часть_извещение_ibfk_2` FOREIGN KEY (`Код_извещения`) REFERENCES `оп_извещение` (`Код_извещения`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
