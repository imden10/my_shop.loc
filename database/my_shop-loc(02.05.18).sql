-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `slug` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'noimage.jpg',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `categories` (`id`, `parent_id`, `lft`, `rgt`, `depth`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2,	0,	1,	12,	0,	'zhenschinam',	'1512205623.jpg',	1,	'2017-12-01 15:12:18',	'2018-04-19 18:12:44'),
(7,	2,	2,	3,	1,	'platya',	'noimage.jpg',	1,	'2017-12-02 10:43:28',	'2018-04-18 16:58:02'),
(21,	0,	13,	22,	0,	'muzhchinam',	'noimage.jpg',	1,	'2017-12-18 11:39:04',	'2018-04-19 18:12:44'),
(22,	2,	4,	5,	1,	'kardigany',	'noimage.jpg',	1,	'2018-01-18 19:30:45',	'2018-04-18 16:58:19'),
(23,	0,	23,	26,	0,	'detyam',	'noimage.jpg',	1,	'2018-04-17 19:02:45',	'2018-04-19 18:12:44'),
(24,	2,	6,	7,	1,	'bryuki',	'noimage.jpg',	1,	'2018-04-17 19:08:03',	'2018-04-18 16:58:39'),
(25,	2,	8,	11,	1,	'nizhnee-bele',	'noimage.jpg',	1,	'2018-04-17 19:08:45',	'2018-04-19 18:14:57'),
(26,	21,	14,	15,	1,	'futbolki',	'noimage.jpg',	1,	'2018-04-17 19:09:38',	'2018-04-19 18:12:44'),
(27,	21,	16,	17,	1,	'rubashki',	'noimage.jpg',	1,	'2018-04-17 19:10:14',	'2018-04-19 18:12:44'),
(28,	21,	18,	19,	1,	'dzhampery',	'noimage.jpg',	1,	'2018-04-17 19:10:37',	'2018-04-19 18:12:44'),
(29,	21,	20,	21,	1,	'bryuki-m',	'noimage.jpg',	1,	'2018-04-17 19:12:19',	'2018-04-19 18:12:44'),
(30,	23,	24,	25,	1,	'futbolki-d',	'noimage.jpg',	1,	'2018-04-17 19:13:13',	'2018-04-19 18:12:44'),
(31,	25,	9,	10,	2,	'bodi',	'noimage.jpg',	1,	'2018-04-19 18:12:44',	'2018-04-19 18:14:57');

DROP TABLE IF EXISTS `categories_features`;
CREATE TABLE `categories_features` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `feature_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `feature_id` (`feature_id`),
  CONSTRAINT `categories_features_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_features_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `categories_loc`;
CREATE TABLE `categories_loc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) unsigned NOT NULL,
  `lang` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keys` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `categories_loc_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `categories_loc` (`id`, `cat_id`, `lang`, `name`, `description`, `meta_title`, `meta_description`, `meta_keys`, `created_at`, `updated_at`) VALUES
(1,	2,	'ru',	'Женщинам',	'<p>Описание первой категории на Русском update</p>',	'Женщинам',	'',	'',	'2017-12-01 15:12:18',	'2018-04-18 16:57:38'),
(4,	2,	'uk',	'Категория 1 на Укр',	'<p>Описание первой категории на Украинском</p>',	'Категория 1',	'',	'',	'2017-12-01 15:50:20',	'2017-12-01 15:50:20'),
(5,	7,	'ru',	'Платья',	'<p>ывмывмым</p>',	'Платья',	'',	'',	'2017-12-02 10:43:28',	'2018-04-18 16:58:02'),
(14,	21,	'ru',	'Мужчинам',	'<p>фафыафыв</p>',	'Мужчинам',	'',	'',	'2017-12-18 11:39:04',	'2018-04-18 16:59:50'),
(15,	22,	'ru',	'Кардиганы',	'<p>Описание</p>',	'Кардиганы',	'',	'',	'2018-01-18 19:30:46',	'2018-04-18 16:58:19'),
(16,	23,	'ru',	'Детям',	'<p>Детям</p>',	'Детям',	'',	'',	'2018-04-17 19:02:45',	'2018-04-18 17:01:31'),
(17,	24,	'ru',	'Брюки',	'<p>Брюки</p>',	'Брюки',	'',	'',	'2018-04-17 19:08:03',	'2018-04-18 16:58:39'),
(18,	25,	'ru',	'Нижнее белье',	'<p>Нижнее белье</p>',	'Нижнее белье',	'',	'',	'2018-04-17 19:08:45',	'2018-04-18 16:59:27'),
(19,	26,	'ru',	'Футболки',	'<p>Футболки</p>',	'Футболки',	'',	'',	'2018-04-17 19:09:39',	'2018-04-18 17:00:16'),
(20,	27,	'ru',	'Рубашки',	'<p>Рубашки</p>',	'Рубашки',	'',	'',	'2018-04-17 19:10:14',	'2018-04-18 17:00:33'),
(21,	28,	'ru',	'Джамперы',	'<p>Джамперы</p>',	'Джамперы',	'',	'',	'2018-04-17 19:10:37',	'2018-04-18 17:00:59'),
(22,	29,	'ru',	'Брюки',	'<p>Брюки</p>',	'Брюки',	'',	'',	'2018-04-17 19:12:19',	'2018-04-18 17:01:14'),
(23,	30,	'ru',	'Футболки',	'<p>Футболки</p>',	'Футболки',	'',	'',	'2018-04-17 19:13:13',	'2018-04-18 17:01:54'),
(24,	31,	'ru',	'Боди',	'<p>Боди</p>',	'Боди',	'',	'',	'2018-04-19 18:12:45',	'2018-04-19 18:12:45');

DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `features` (`id`, `parent_id`, `lft`, `rgt`, `depth`, `created_at`, `updated_at`) VALUES
(69,	102,	3,	4,	0,	'2018-04-23 19:53:41',	'2018-04-23 19:30:16'),
(72,	103,	9,	10,	0,	'2018-04-24 16:02:29',	'2018-04-23 19:30:16'),
(73,	102,	11,	12,	0,	'2018-04-24 16:00:26',	'2018-04-23 19:30:16'),
(74,	102,	13,	14,	0,	'2018-04-24 16:01:04',	'2018-04-23 19:30:16'),
(75,	102,	15,	16,	0,	'2018-04-24 16:01:25',	'2018-04-23 19:30:16'),
(76,	102,	17,	18,	0,	'2018-04-24 16:01:25',	'2018-04-23 19:30:16'),
(77,	103,	19,	20,	0,	'2018-04-24 16:02:29',	'2018-04-23 19:30:16'),
(78,	103,	21,	22,	0,	'2018-04-24 16:02:29',	'2018-04-23 19:30:16'),
(79,	103,	23,	24,	0,	'2018-04-24 16:02:29',	'2018-04-23 19:30:16'),
(80,	103,	25,	26,	0,	'2018-04-24 16:02:29',	'2018-04-23 19:30:16'),
(82,	104,	27,	28,	0,	'2018-04-24 16:03:39',	'2018-04-23 19:30:16'),
(83,	104,	29,	30,	0,	'2018-04-24 16:03:39',	'2018-04-23 19:30:16'),
(84,	104,	31,	32,	0,	'2018-04-24 16:03:39',	'2018-04-23 19:30:16'),
(85,	104,	33,	34,	0,	'2018-04-24 16:03:39',	'2018-04-23 19:30:16'),
(86,	104,	35,	36,	0,	'2018-04-24 16:03:39',	'2018-04-23 19:30:16'),
(88,	105,	37,	38,	0,	'2018-04-24 16:04:33',	'2018-04-23 19:30:16'),
(89,	105,	39,	40,	0,	'2018-04-24 16:04:33',	'2018-04-23 19:30:16'),
(90,	105,	41,	42,	0,	'2018-04-24 16:04:33',	'2018-04-23 19:30:16'),
(92,	105,	43,	44,	0,	'2018-04-24 16:04:33',	'2018-04-23 19:30:16'),
(93,	105,	45,	46,	0,	'2018-04-24 16:04:33',	'2018-04-23 19:30:16'),
(95,	106,	47,	48,	0,	'2018-04-24 16:05:47',	'2018-04-23 19:30:16'),
(96,	106,	49,	50,	0,	'2018-04-24 16:05:47',	'2018-04-23 19:30:16'),
(97,	106,	51,	52,	0,	'2018-04-24 16:05:47',	'2018-04-23 19:30:16'),
(98,	106,	53,	54,	0,	'2018-04-24 16:05:47',	'2018-04-23 19:30:16'),
(99,	106,	55,	56,	0,	'2018-04-24 16:05:47',	'2018-04-23 19:30:16'),
(100,	106,	57,	58,	0,	'2018-04-24 16:05:47',	'2018-04-23 19:30:16'),
(101,	106,	59,	60,	0,	'2018-04-24 16:05:47',	'2018-04-23 19:30:16'),
(102,	0,	61,	62,	0,	'2018-04-23 19:53:06',	'2018-04-23 19:53:06'),
(103,	0,	63,	64,	0,	'2018-04-24 16:02:00',	'2018-04-24 16:02:00'),
(104,	0,	65,	66,	0,	'2018-04-24 16:03:03',	'2018-04-24 16:03:03'),
(105,	0,	67,	68,	0,	'2018-04-24 16:03:57',	'2018-04-24 16:03:57'),
(106,	0,	69,	70,	0,	'2018-04-24 16:05:21',	'2018-04-24 16:05:21');

DROP TABLE IF EXISTS `features_loc`;
CREATE TABLE `features_loc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` int(10) unsigned NOT NULL,
  `lang` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `feature_id` (`feature_id`),
  CONSTRAINT `features_loc_ibfk_1` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `features_loc` (`id`, `feature_id`, `lang`, `name`, `created_at`, `updated_at`) VALUES
(29,	69,	'ru',	'Армани',	'2017-12-18 11:27:23',	'2017-12-18 11:27:23'),
(32,	72,	'ru',	'Красный',	'2017-12-18 11:28:24',	'2017-12-18 11:28:24'),
(33,	72,	'uk',	'Чевоний',	'2017-12-18 11:28:51',	'2017-12-18 11:28:51'),
(37,	73,	'ru',	'LoveRepublik',	'2018-04-18 16:41:34',	'2018-04-18 16:41:34'),
(38,	74,	'ru',	'MANGO',	'2018-04-18 16:41:58',	'2018-04-18 16:41:58'),
(39,	75,	'ru',	'RIVER ISLAND',	'2018-04-18 16:42:16',	'2018-04-18 16:42:16'),
(40,	76,	'ru',	'TOP SHOP',	'2018-04-18 16:42:37',	'2018-04-18 16:42:37'),
(41,	77,	'ru',	'Желтый',	'2018-04-18 16:42:54',	'2018-04-18 16:42:54'),
(42,	78,	'ru',	'Зеленый',	'2018-04-18 16:43:11',	'2018-04-18 16:43:11'),
(43,	79,	'ru',	'Черный',	'2018-04-18 16:43:23',	'2018-04-18 16:43:23'),
(44,	80,	'ru',	'Белый',	'2018-04-18 16:43:35',	'2018-04-18 16:43:35'),
(46,	82,	'ru',	'48',	'2018-04-18 16:46:12',	'2018-04-18 16:46:12'),
(47,	83,	'ru',	'50',	'2018-04-18 16:46:23',	'2018-04-18 16:46:23'),
(48,	84,	'ru',	'52',	'2018-04-18 16:46:34',	'2018-04-18 16:46:34'),
(49,	85,	'ru',	'54',	'2018-04-18 16:46:56',	'2018-04-18 16:46:56'),
(50,	86,	'ru',	'56',	'2018-04-18 16:47:07',	'2018-04-18 16:47:07'),
(52,	88,	'ru',	'Всесезонная модель',	'2018-04-18 16:49:45',	'2018-04-18 16:49:45'),
(53,	89,	'ru',	'Зимний',	'2018-04-18 16:50:20',	'2018-04-18 16:50:20'),
(54,	90,	'ru',	'Летний',	'2018-04-18 16:50:39',	'2018-04-18 16:50:39'),
(56,	92,	'ru',	'Осенне-весенний',	'2018-04-18 16:51:05',	'2018-04-18 16:51:05'),
(57,	93,	'ru',	'Осенне-зимний',	'2018-04-18 16:51:44',	'2018-04-18 16:51:44'),
(59,	95,	'ru',	'Вечеринка',	'2018-04-18 16:53:20',	'2018-04-18 16:53:20'),
(60,	96,	'ru',	'Выпускной',	'2018-04-18 16:53:41',	'2018-04-18 16:53:41'),
(61,	97,	'ru',	'Клуб',	'2018-04-18 16:53:58',	'2018-04-18 16:53:58'),
(62,	98,	'ru',	'Новый год',	'2018-04-18 16:54:19',	'2018-04-18 16:54:19'),
(63,	99,	'ru',	'Праздничные',	'2018-04-18 16:54:37',	'2018-04-18 16:54:37'),
(64,	100,	'ru',	'Свадьба',	'2018-04-18 16:54:56',	'2018-04-18 16:54:56'),
(65,	101,	'ru',	'Свидание',	'2018-04-18 16:55:12',	'2018-04-18 16:55:12'),
(66,	102,	'ru',	'Бренд',	'2018-04-23 19:53:06',	'2018-04-23 19:53:06'),
(67,	103,	'ru',	'Цвет',	'2018-04-24 16:02:00',	'2018-04-24 16:02:00'),
(68,	104,	'ru',	'Размер',	'2018-04-24 16:03:03',	'2018-04-24 16:03:03'),
(69,	105,	'ru',	'Сезон',	'2018-04-24 16:03:57',	'2018-04-24 16:03:57'),
(70,	106,	'ru',	'Событие',	'2018-04-24 16:05:21',	'2018-04-24 16:05:21');

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_reserved_at_index` (`queue`,`reserved`,`reserved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `jobs_logs`;
CREATE TABLE `jobs_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connectionName` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `job` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `jobs_logs` (`id`, `connectionName`, `job`, `data`, `created_at`, `updated_at`) VALUES
(1,	'database',	'Object',	'Array',	'2018-02-07 19:50:42',	'2018-02-07 19:50:42'),
(2,	'database',	'Object',	'Array',	'2018-02-07 20:09:50',	'2018-02-07 20:09:50'),
(3,	'database',	'Object',	'Array',	'2018-02-07 20:09:53',	'2018-02-07 20:09:53');

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `default` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `languages` (`id`, `name`, `lang`, `status`, `default`, `created_at`, `updated_at`) VALUES
(1,	'Русский',	'ru',	1,	1,	'2017-11-15 11:00:06',	'2017-11-15 11:00:06'),
(2,	'Украинский',	'uk',	1,	0,	'2017-11-15 11:00:31',	'2017-11-27 12:07:10'),
(10,	'Германский',	'de',	1,	0,	'2017-11-15 15:40:50',	'2017-11-27 12:00:23'),
(11,	'Французкий',	'fr',	1,	0,	'2017-11-15 15:41:37',	'2017-11-15 15:41:37'),
(12,	'Испанский',	'es',	1,	0,	'2017-11-16 08:50:30',	'2017-11-16 08:50:30');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2016_03_23_111228_create_slider_works_table',	1),
('2017_04_13_110356_create_news_table',	1),
('2017_04_13_122625_create_baners_table',	1),
('2017_04_14_122109_create_sliders_table',	1),
('2017_04_18_104541_create_services_table',	1),
('2017_04_24_135812_create_products_table',	1),
('2017_04_24_150328_create_features_table',	1),
('2017_04_24_150441_create_feature_variants_table',	1),
('2017_04_25_140556_create_product_features_table',	2),
('2017_04_25_140557_create_product_features_table',	3),
('2017_08_29_182755_create_infoblocks_table',	4),
('2017_10_03_102810_create_user_infos_table',	5),
('2017_10_05_115828_create_news_table',	6),
('2017_10_09_114129_create_albums_table',	7),
('2017_10_09_114145_create_galleries_table',	7),
('2017_10_10_145741_create_ads_table',	8),
('2017_10_10_185155_create_callbacks_table',	9),
('2017_10_11_103111_create_company_cats_table',	10),
('2017_10_11_215808_create_banners_table',	11),
('2017_10_12_124636_create_company_requests_table',	11),
('2017_11_15_125536_create_languages_table',	12),
('2017_11_27_121332_create_settings_locs_table',	13),
('2017_11_27_163639_entrust_setup_tables',	14),
('2017_12_01_152049_create_categories_table',	15),
('2017_12_01_152113_create_categories-loc_table',	16),
('2017_12_01_153105_create_categories_loc_table',	17),
('2017_12_02_133758_create_features_table',	18),
('2017_12_02_133844_create_features_loc_table',	18),
('2017_12_18_114245_create_categories_features_table',	19),
('2017_12_18_154108_create_products_table',	20),
('2017_12_18_154128_create_products_loc_table',	20),
('2017_12_18_182247_create_products_categories_table',	21),
('2017_12_20_110059_create_products_attributes_table',	22),
('2017_08_11_150522_create_products_images_table',	23),
('2017_08_14_161054_create_products_features_table',	23),
('2018_02_07_200117_create_jobs_table',	24),
('2018_02_07_214517_create_jobs_logs_table',	25);

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rgt` int(10) DEFAULT NULL,
  `depth` int(10) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `type` enum('main','other','help') COLLATE utf8_unicode_ci NOT NULL,
  `constant` int(10) NOT NULL DEFAULT '0',
  `active` int(10) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `dv_pages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `pages` (`id`, `parent_id`, `lft`, `rgt`, `depth`, `slug`, `image`, `type`, `constant`, `active`, `created_at`, `updated_at`) VALUES
(1,	0,	1,	2,	0,	'/',	'default.jpg',	'main',	1,	1,	'2018-04-17 18:55:03',	'2017-08-24 05:49:19'),
(2,	0,	3,	4,	0,	'catalog',	'default.jpg',	'main',	0,	1,	'2018-04-17 18:58:28',	'2017-08-24 05:49:19'),
(5,	0,	5,	6,	0,	'aktsii',	'default.jpg',	'main',	0,	1,	'2018-04-17 18:59:20',	'2017-08-24 05:36:33'),
(6,	0,	1,	2,	0,	'basket',	'default.jpg',	'other',	1,	1,	'2018-04-17 18:56:49',	'2017-08-24 05:18:07'),
(8,	0,	3,	4,	0,	'dopolnitelnaya-stranitsa',	'default.jpg',	'other',	0,	1,	'2018-04-17 18:56:49',	'2017-11-16 08:41:39'),
(10,	0,	5,	6,	0,	'novaya-dop-stranitsa-s-kartinkoj',	'1511766869.jpg',	'other',	0,	1,	'2018-04-17 18:56:47',	'2017-11-27 07:14:29'),
(11,	NULL,	7,	8,	0,	'dostavka-i-oplata',	'default.jpg',	'main',	0,	1,	'2018-04-17 19:00:22',	'0000-00-00 00:00:00'),
(12,	NULL,	9,	10,	0,	'kontakty',	'default.jpg',	'main',	0,	1,	'2018-04-17 19:00:48',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `page_loc`;
CREATE TABLE `page_loc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(10) unsigned NOT NULL,
  `lang` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_desc` text COLLATE utf8_unicode_ci,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dv_page_localizations_page_id_foreign` (`page_id`),
  CONSTRAINT `dv_page_localizations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `page_loc` (`id`, `page_id`, `lang`, `name`, `short_desc`, `desc`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
(1,	1,	'ru',	'Главная',	'',	'<p><strong><span style=\"font-size: 18pt;\">Заголовок главной страницы</span></strong></p>\r\n<p></p>\r\n<p>Текст главной страницы</p>',	'Главная',	'',	''),
(2,	1,	'uk',	'Про компанию',	'',	'<p>Текст Українською мовою</p>',	'Про компанию заголовок',	'Про компанию ключі',	'опис Про компанию'),
(4,	2,	'ru',	'Каталог',	'',	'<p>Текст</p>',	'Каталог',	'ключи',	'Описание ру'),
(5,	2,	'uk',	'Продукция',	'',	'',	'Продукція заголовок',	'Про нас',	''),
(13,	5,	'ru',	'Акции',	'',	'<p>Акции</p>',	'Акции',	'',	''),
(14,	5,	'uk',	'Послуги',	'',	'<p>Ми надаємо такі послуги</p>',	'Послуги заголовок',	'ключі послуги',	'опис послуги'),
(16,	6,	'ru',	'Корзина',	NULL,	'',	'Корзина title',	'ключевые слова',	'Описание страницы корзины'),
(17,	6,	'uk',	'',	NULL,	'',	'Кошик title',	'',	'Опис кошика'),
(23,	5,	'fr',	'Palvelut',	NULL,	'<p>Tarjoamme t&auml;llaisia palveluita ...</p>',	'Palvelut',	'услуги ключи',	'Описание услуги'),
(24,	2,	'fr',	'tuotteet',	NULL,	'<p>Sivun kuvaustuotteet ranskaksi</p>',	'tuotteet',	'ключи',	'Описание ру'),
(25,	1,	'fr',	'Meistä',	NULL,	'<p><strong>P&auml;&auml;sivun otsikko</strong></p>\r\n<p>P&auml;&auml;sivuteksti</p>',	'Meistä',	'ключи о компании',	'описание о компании'),
(26,	8,	'ru',	'Дополнительная страница',	NULL,	'<p>Описание доп страницы</p>',	'Дополнительная страница',	'',	''),
(28,	10,	'ru',	'Новая доп страница с картинкой',	NULL,	'<p>Описание доп страницы с картинкой</p>',	'Новая доп страница с картинкой',	'',	''),
(29,	10,	'uk',	'Нова доп сторінка з картинкою',	NULL,	'<p>Опис доп сторінки з картинкою</p>',	'Новая доп страница с картинкой',	'',	''),
(30,	10,	'es',	'Nueva página con una imagen',	NULL,	'<p>Descripci&oacute;n de p&aacute;gina adicional con una imagen</p>',	'Новая доп страница с картинкой',	'',	''),
(31,	11,	'ru',	'Доставка и оплата',	NULL,	'<p>Описание</p>',	'Доставка и оплата',	'',	''),
(32,	12,	'ru',	'Контакты',	NULL,	'<p>Контакты</p>',	'Контакты',	'',	'');

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1,	'navigate_dashboard',	'Панель состояния ',	'Доступ к панели состояния',	'2017-11-27 15:02:37',	'2017-11-27 15:02:37'),
(2,	'navigate_catalog',	'Каталог',	'Доступ к каталогу',	'2017-11-28 09:52:28',	'2017-11-28 09:52:28'),
(3,	'navigate_design',	'Дизайн',	'Доступ к дизайну',	'2017-11-28 09:52:28',	'2017-11-28 09:52:28'),
(4,	'navigate_additions',	'Дополнения',	'Доступ к дополнениям',	'2017-11-28 09:52:28',	'2017-11-28 09:52:28'),
(5,	'navigate_orders',	'Заказы',	'Доступ к заказам',	'2017-11-28 09:52:28',	'2017-11-28 09:52:28'),
(6,	'navigate_feedback',	'Обратная связь',	'Доступ к обратной связи',	'2017-11-28 09:52:28',	'2017-11-28 09:52:28'),
(7,	'navigate_users',	'Пользователи',	'Доступ к пользователям',	'2017-11-28 09:52:28',	'2017-11-28 09:52:28'),
(8,	'navigate_settings',	'Настройки',	'Доступ к настройкам',	'2017-11-28 09:52:28',	'2017-11-28 09:52:28');

DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `permission_role` (`permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1,	1,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(1,	7,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(1,	8,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(2,	1,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(2,	7,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(2,	8,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(3,	1,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(4,	1,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(5,	1,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(5,	8,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(6,	1,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(6,	8,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(7,	1,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(8,	1,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `vendor_code` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `pricesite` decimal(8,2) NOT NULL,
  `count` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `dropshipping` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `products` (`id`, `slug`, `vendor_code`, `price`, `pricesite`, `count`, `status`, `dropshipping`, `created_at`, `updated_at`) VALUES
(2,	'losiny-610332',	'61033/2',	304.00,	584.00,	20,	1,	'',	'2018-01-09 18:41:03',	'2018-04-21 09:35:26'),
(3,	'kardigan-impreza-rm263',	'RM263',	430.00,	530.00,	1,	1,	'',	'2018-01-10 18:45:15',	'2018-04-19 17:47:13'),
(4,	'kardigan-folk-rm333',	'RM333',	518.00,	618.00,	1,	1,	'',	'2018-01-12 19:23:07',	'2018-04-19 17:39:54'),
(12,	'plate-l886512',	'L8865/12',	350.00,	450.00,	1,	1,	'',	'2018-01-15 19:55:35',	'2018-04-19 17:29:00'),
(13,	'suknya-n57801',	'n57801',	385.00,	585.00,	1,	1,	'',	'2018-01-15 19:56:07',	'2018-04-18 17:14:22'),
(14,	'bryuki-ejpril-rm1073',	'RM107/3',	445.00,	585.00,	1,	1,	'',	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(15,	'bodi-le1361',	'LE136/1',	700.00,	860.00,	1,	1,	'',	'2018-04-19 18:18:51',	'2018-04-19 18:23:00'),
(16,	'bodi-le11320',	'LE113/20',	700.00,	1214.00,	1,	1,	'',	'2018-04-20 17:14:24',	'2018-04-20 17:19:43'),
(17,	'futbolka-lb8448',	'LB844/8',	430.00,	530.00,	1,	1,	'',	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(18,	'futbolka-lb8101',	'LB810/1',	300.00,	431.00,	1,	1,	'',	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(19,	'rubashka-lb830',	'LB830',	300.00,	479.00,	1,	1,	'',	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(20,	'rubashka-lb8298',	'LB829/8',	300.00,	479.00,	1,	1,	'',	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(21,	'dzhemper-lc3248',	'LC324/8',	700.00,	854.00,	1,	1,	'wewewe1',	'2018-04-20 18:32:32',	'2018-04-20 18:39:28'),
(22,	'dzhemper-lc3258',	'LC325/8',	800.00,	974.00,	1,	1,	'',	'2018-04-20 18:45:56',	'2018-04-20 18:45:56');

DROP TABLE IF EXISTS `products_attributes`;
CREATE TABLE `products_attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `lang` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `products_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `products_attributes` (`id`, `product_id`, `lang`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1504,	2,	'uk',	'1ук',	'1ук',	'2018-01-14 20:37:47',	'2018-01-14 20:37:47'),
(1515,	4,	'de',	'германия',	'германия',	'2018-01-14 21:06:28',	'2018-01-14 21:06:28'),
(1525,	4,	'ru',	'Длина рукава от горловины во всех размерах',	'52 см',	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(1526,	4,	'ru',	'Длина изделия по спинке во всех размерах',	'74 см',	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(1527,	4,	'ru',	'Рост модели',	'164 см',	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(1528,	4,	'ru',	'Материал',	'трикотаж «ангора»  (40% шерсть, 40% вискоза, 20% полиэстер)',	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(1529,	3,	'ru',	'Длина изделия для всех размеров',	'94 см',	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(1530,	3,	'ru',	'Рост модели',	'164 см',	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(1531,	3,	'ru',	'Материал',	'французский трикотаж. (вискоза 50%, полиэстр 40%, шерсть 10%)',	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(1542,	14,	'ru',	'Длина изделия по шаговому шву для всех размеров',	'61,5 см.',	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(1543,	14,	'ru',	'Рост модели на фото',	'168 см.',	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(1544,	14,	'ru',	'Материал',	'костюмная ткань',	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(1549,	16,	'ru',	'Материал',	'Кружево, сетка',	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(1550,	2,	'ru',	'Растяжимость',	'средняя',	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(1551,	2,	'ru',	'Состав',	'50% вискоза, 50% полиэстер',	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(1552,	2,	'ru',	'Материал',	'Стрейч-джинс',	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(1553,	2,	'ru',	'по внутреннему',	'75 см.',	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(1554,	2,	'ru',	'длина по внешнему шву',	'91 см.',	'2018-04-21 09:35:26',	'2018-04-21 09:35:26');

DROP TABLE IF EXISTS `products_categories`;
CREATE TABLE `products_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_categories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `products_categories` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(68,	13,	2,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(69,	13,	7,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(70,	12,	2,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(71,	12,	7,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(74,	4,	2,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(75,	4,	22,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(76,	3,	2,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(77,	3,	22,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(82,	14,	2,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(83,	14,	24,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(85,	15,	25,	'2018-04-19 18:23:00',	'2018-04-19 18:23:00'),
(86,	15,	31,	'2018-04-19 18:23:00',	'2018-04-19 18:23:00'),
(99,	16,	2,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(100,	16,	25,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(101,	16,	31,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(102,	17,	21,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(103,	17,	26,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(104,	18,	21,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(105,	18,	26,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(106,	19,	21,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(107,	19,	27,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(108,	20,	21,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(109,	20,	27,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(112,	21,	21,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(113,	21,	28,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(114,	22,	21,	'2018-04-20 18:45:56',	'2018-04-20 18:45:56'),
(115,	22,	28,	'2018-04-20 18:45:56',	'2018-04-20 18:45:56'),
(116,	2,	2,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(117,	2,	24,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26');

DROP TABLE IF EXISTS `products_features`;
CREATE TABLE `products_features` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `feature_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `feature_id` (`feature_id`),
  CONSTRAINT `products_features_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_features_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `products_features` (`id`, `product_id`, `feature_id`, `created_at`, `updated_at`) VALUES
(70,	13,	69,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(71,	13,	79,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(72,	13,	82,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(73,	13,	83,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(74,	13,	84,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(75,	13,	90,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(76,	13,	95,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(77,	12,	73,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(78,	12,	80,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(79,	12,	82,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(80,	12,	83,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(81,	12,	85,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(82,	12,	90,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(83,	12,	95,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(84,	12,	97,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(94,	4,	69,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(95,	4,	79,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(96,	4,	80,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(97,	4,	84,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(98,	4,	85,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(99,	4,	86,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(100,	4,	92,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(101,	4,	95,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(102,	4,	97,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(103,	3,	74,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(104,	3,	79,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(105,	3,	82,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(106,	3,	83,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(107,	3,	84,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(108,	3,	85,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(109,	3,	86,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(110,	3,	90,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(111,	3,	92,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(112,	3,	93,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(113,	3,	95,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(114,	3,	97,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(131,	14,	75,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(132,	14,	80,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(133,	14,	82,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(134,	14,	83,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(135,	14,	90,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(136,	14,	92,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(137,	14,	95,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(138,	14,	97,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(141,	15,	73,	'2018-04-19 18:23:00',	'2018-04-19 18:23:00'),
(142,	15,	79,	'2018-04-19 18:23:00',	'2018-04-19 18:23:00'),
(171,	16,	74,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(172,	16,	80,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(173,	16,	82,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(174,	16,	83,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(175,	16,	84,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(176,	16,	90,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(177,	16,	100,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(178,	17,	73,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(179,	17,	79,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(180,	17,	82,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(181,	17,	83,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(182,	17,	84,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(183,	17,	90,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(184,	17,	97,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(185,	18,	74,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(186,	18,	79,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(187,	18,	82,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(188,	18,	83,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(189,	18,	84,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(190,	18,	90,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(191,	18,	95,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(192,	18,	97,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(193,	19,	69,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(194,	19,	80,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(195,	19,	82,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(196,	19,	83,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(197,	19,	84,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(198,	19,	90,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(199,	19,	92,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(200,	19,	95,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(201,	19,	96,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(202,	19,	97,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(203,	20,	69,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(204,	20,	79,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(205,	20,	82,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(206,	20,	83,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(207,	20,	84,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(208,	20,	85,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(209,	20,	86,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(210,	20,	90,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(211,	20,	92,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(212,	20,	95,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(213,	20,	97,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(222,	21,	69,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(223,	21,	79,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(224,	21,	82,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(225,	21,	83,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(226,	21,	84,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(227,	21,	88,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(228,	21,	95,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(229,	21,	97,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(230,	22,	69,	'2018-04-20 18:45:56',	'2018-04-20 18:45:56'),
(231,	22,	79,	'2018-04-20 18:45:56',	'2018-04-20 18:45:56'),
(232,	22,	82,	'2018-04-20 18:45:56',	'2018-04-20 18:45:56'),
(233,	22,	83,	'2018-04-20 18:45:56',	'2018-04-20 18:45:56'),
(234,	22,	84,	'2018-04-20 18:45:56',	'2018-04-20 18:45:56'),
(235,	22,	88,	'2018-04-20 18:45:56',	'2018-04-20 18:45:56'),
(236,	22,	95,	'2018-04-20 18:45:56',	'2018-04-20 18:45:56'),
(237,	2,	76,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(238,	2,	79,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(239,	2,	82,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(240,	2,	83,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(241,	2,	90,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(242,	2,	92,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(243,	2,	95,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(244,	2,	97,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26');

DROP TABLE IF EXISTS `products_images`;
CREATE TABLE `products_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `image` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `main` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `products_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `products_images` (`id`, `product_id`, `image`, `alt`, `main`, `created_at`, `updated_at`) VALUES
(104,	13,	'ee5494dd424411e8815bbcee7be24996_71b3177616c94f998eef2ff28c2f70f6.jpg',	'',	1,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(105,	13,	'dress5.jpg',	'',	0,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(106,	13,	'dress4.jpg',	'',	0,	'2018-04-18 17:14:23',	'2018-04-18 17:14:23'),
(107,	12,	'111.jpg',	'',	1,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(108,	12,	'112.jpg',	'',	0,	'2018-04-19 17:29:00',	'2018-04-19 17:29:00'),
(112,	4,	'kardigan1.jpg',	'тюлпаны',	1,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(113,	4,	'kardigan2.jpg',	'Пенгвины',	0,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(114,	4,	'kardigan3.jpg',	'',	0,	'2018-04-19 17:39:54',	'2018-04-19 17:39:54'),
(115,	3,	'kardigan4.jpg',	'',	1,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(116,	3,	'kardigan5.jpg',	'',	0,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(117,	3,	'kardigan6.jpg',	'',	0,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(118,	3,	'kardigan7.jpg',	'',	0,	'2018-04-19 17:47:13',	'2018-04-19 17:47:13'),
(125,	14,	'bryuki4.jpg',	'',	1,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(126,	14,	'bryuki5.jpg',	'',	0,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(127,	14,	'bryuki6.jpg',	'',	0,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(128,	14,	'bryuki7.jpg',	'',	0,	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(131,	15,	'bodi1.jpg',	'',	1,	'2018-04-19 18:23:00',	'2018-04-19 18:23:00'),
(132,	15,	'bodi2.jpg',	'',	0,	'2018-04-19 18:23:00',	'2018-04-19 18:23:00'),
(147,	16,	'bodi3.jpg',	'',	1,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(148,	16,	'bodi4.jpg',	'',	0,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(149,	16,	'bodi5.jpg',	'',	0,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(150,	16,	'bodi4.jpg',	'',	0,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(151,	16,	'bodi5.jpg',	'',	0,	'2018-04-20 17:19:43',	'2018-04-20 17:19:43'),
(152,	17,	'futbolka1.jpg',	'',	1,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(153,	17,	'futbolka2.jpg',	'',	0,	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(154,	18,	'futbolka3.jpg',	'',	1,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(155,	18,	'futbolka4.jpg',	'',	0,	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(156,	19,	'rubashka1.jpg',	'',	1,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(157,	19,	'rubashka2.jpg',	'',	0,	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(158,	20,	'rubashka3.jpg',	'',	1,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(159,	20,	'rubashka4.jpg',	'',	0,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(160,	20,	'futbolka5.jpg',	'',	0,	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(163,	21,	'djamper1.jpg',	'',	1,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(164,	21,	'djamper2.jpg',	'',	0,	'2018-04-20 18:39:28',	'2018-04-20 18:39:28'),
(165,	22,	'djamper3.jpg',	'',	1,	'2018-04-20 18:45:56',	'2018-04-20 18:45:56'),
(166,	2,	'bryuki1.jpg',	'',	1,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(167,	2,	'bryuki2.jpg',	'',	0,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26'),
(168,	2,	'bryuki3.jpg',	'',	0,	'2018-04-21 09:35:26',	'2018-04-21 09:35:26');

DROP TABLE IF EXISTS `products_loc`;
CREATE TABLE `products_loc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `lang` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_title` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keys` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `products_loc_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `products_loc` (`id`, `product_id`, `lang`, `name`, `description`, `meta_title`, `meta_description`, `meta_keys`, `created_at`, `updated_at`) VALUES
(2,	2,	'ru',	'Лосины 61033/2',	'<p>Стильные джегинсы с оригинальной наклейкой в виде цветов и разрезами на коленях. Пояс на резинке, без застежек.</p>',	'Лосины 61033/2',	'meta desc ru',	'1',	'2018-01-09 18:41:03',	'2018-04-21 09:35:26'),
(3,	3,	'ru',	'Кардиган \"Импреза\" RM263',	'<p>Удлиненный классический кардиган полуприлегающего силуэта. Воротник &laquo;шаль&raquo;, на двух пуговицах, сзади шлица.</p>',	'Кардиган \"Импреза\" RM263',	'meta desc ru',	'meta keys ru',	'2018-01-10 18:45:15',	'2018-04-19 17:47:13'),
(4,	2,	'uk',	'Сукня',	'<p>Описание укр</p>',	'Платье',	'',	'',	'2018-01-09 18:41:03',	'2018-01-14 20:37:47'),
(5,	3,	'uk',	'Продукт 2',	'',	'Продукт 2',	'',	'',	'2018-01-12 19:08:23',	'2018-01-12 19:08:23'),
(6,	4,	'ru',	'Кардиган \"Фолк\" RM333',	'<p>Классический повседневный кардиган для тех, кто хочет скрыть полноту в талии и руках, благодаря особому крою рукава, который также называется &laquo;летучая мышь&raquo;, и выигрышной расцветке, которая зрительно вытягивает фигуру. Спинка состоит из двух частей, нижняя часть разделена пополам, где в шве расположен стильный разрез &laquo;ласточка&raquo;. Удобная длина до линии бедра, цельнокроеный рукав,&nbsp; -&nbsp; в данном кардигане вы будете чувствовать себя комфортно и современно, а также сможете создавать с его помощью разнообразные образы, ведь он подойдет как под брюки с блузой, так и со строгим элегантным платьем этот кардиган выгодно завершит удачный тандем.</p>',	'Кардиган \"Фолк\" RM333',	'',	'',	'2018-01-12 19:23:07',	'2018-04-19 17:39:54'),
(7,	4,	'de',	'Товар 3 рус германия',	'<p>Описание товара 3 на&nbsp;германия</p>',	'Товар 3 рус германия',	'германия',	'германия',	'2018-01-14 21:06:28',	'2018-01-14 21:06:28'),
(15,	12,	'ru',	'Платье L8865/12',	'<p>Легкое бирюзовое платье с воланом. Платье без рукавов из воздушной ткани отлично подходит для жаркой погоды и не сковывает движений.</p>',	'Платье L8865/12',	'',	'',	'2018-01-15 19:55:35',	'2018-04-19 17:29:00'),
(16,	13,	'ru',	'Сукня N578/01',	'<p>Однотонна сукня вільного крою. Виріб виконаний з віскози. Має V-подібний виріз, широкі рукава, які прикрашає вставка з фатином. Підійде під будь-який тип фігури. Даний наряд універсальний і комфортний в носці.</p>',	'Сукня N578/01',	'',	'',	'2018-01-15 19:56:07',	'2018-04-18 17:14:23'),
(17,	14,	'ru',	'Брюки \"Эйприл\" RM107/3',	'<p>Специально к весеннему сезону мы создали стильные укороченные брюки длиной 7/8. Брюки выполнены из костюмной ткани, снизу манжеты, верхняя часть слегка свободного кроя, что придает данной модели легкости, с кокеткой, которая застегивается на две пуговицы. По бокам карманы.</p>',	'Брюки \"Эйприл\" RM107/3',	'',	'',	'2018-04-19 18:09:10',	'2018-04-19 18:09:10'),
(18,	15,	'ru',	'Боди LE136/1',	'<p>Нижнее белье Anabel Arto (материалы и фурнитура - Франция)<br />Состав: кружево: 87% полиамид, 13% спандекс, кружевное полотно: 84% полиамид, 16% спандекс<br />Соблазнительное боди из нежного черного кружева. Эффектный выбор для идеального пикантного образа. Боди открытое, передняя часть подчеркивает изгибы талии и бедер.</p>',	'Боди LE136/1',	'',	'',	'2018-04-19 18:18:51',	'2018-04-19 18:23:00'),
(19,	16,	'ru',	'Боди LE113/20',	'<p>Нижнее белье Anabel Arto (материалы и фурнитура - Франция)<br />Состав :нейлон 90%, спандекс 10%<br />Изысканное кружевное боди цвета шампанского. Идеальный выбор для незабываемого вечера или особого случая. Бюстгальтер-балконет великолепно поддерживает грудь и придает ей красивую округлую форму. Формованная поролоновая чашкой дополняется цельным полупрозрачным поясом с вертикальными рельефами, которые стройныт фигуру. Спинка кружевная, с вырезом.</p>',	'Боди LE113/20',	'',	'',	'2018-04-20 17:14:24',	'2018-04-20 17:19:43'),
(20,	17,	'ru',	'Футболка LB844/8',	'<p>Темно-синяя мужская футболка с принтом. Классический удобный крой. Натуральный хлопковый материал.</p>',	'Футболка LB844/8',	'',	'',	'2018-04-20 17:26:46',	'2018-04-20 17:26:46'),
(21,	18,	'ru',	'Футболка LB810/1',	'<p>Стильная мужская футболка черного цвета. Футболка с коротким рукавом, прямая, имеет круглый вырез горловины. Отлично сидит на любой фигуре. Нейтральный серый рисунок на ткани и броская надпись удачно декорируют модель.</p>',	'Футболка LB810/1',	'',	'',	'2018-04-20 17:34:05',	'2018-04-20 17:34:05'),
(22,	19,	'ru',	'Рубашка LB830',	'<p>Легкая прямая мужская рубашка мятного цвета. Холодный ледяной оттенок шикарно смотрится с любым низом, а также как часть делового образа с костюмом. Рукава длинные, на груди имеется накладной карман.</p>',	'Рубашка LB830',	'',	'',	'2018-04-20 17:41:13',	'2018-04-20 17:41:13'),
(23,	20,	'ru',	'Рубашка LB829/8',	'<p>Темно-синяя мужская рубашка с принтом. Рубашка с коротким рукавом, внизу отвороты. Имеет застежку на пуговицы по центру переда. Воротник классический, стояче-отложной. Низ округлый, плавной линией.</p>',	'Рубашка LB829/8',	'',	'',	'2018-04-20 17:46:16',	'2018-04-20 17:46:16'),
(24,	21,	'ru',	'Джемпер LC324/8',	'<p>Стильный мужской джемпер прямого кроя с круглым вырезом горловины. Джемпер выполнен из натурального материала. декорирован фактурными узорами.</p>',	'Джемпер LC324/8',	'',	'',	'2018-04-20 18:32:32',	'2018-04-20 18:39:28'),
(25,	22,	'ru',	'Джемпер LC325/8',	'<p>Тёплый мужской джемпер прямого кроя с геометрическим узором. Воротник дополнен застёжкой на \"молнию\". Отличный вариант для работы и на каждый день.</p>',	'Джемпер LC325/8',	'',	'',	'2018-04-20 18:45:56',	'2018-04-20 18:45:56');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1,	'Admin',	'Администрантор',	'80 level',	'2017-11-27 14:58:51',	'2017-11-28 12:14:19'),
(7,	'user',	'Пользователь',	'Не может ни че го',	'2017-11-27 15:59:59',	'2017-11-28 12:30:02'),
(8,	'manager',	'Менеджер',	'Может управлять сайтом, кроме настроек',	'2017-11-28 07:25:29',	'2017-11-28 12:16:18');

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `role_user` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(30,	1,	'2017-11-28 12:49:42',	'2017-11-28 12:49:42'),
(34,	7,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(35,	7,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `speed_slider` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '5000',
  `map` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `settings` (`id`, `logo`, `logo2`, `email`, `phone`, `speed_slider`, `map`) VALUES
(1,	'1511782155.jpg',	'1511782047.jpg',	'style.pack@gmail.com',	'+38 (050) 059-71-10',	'4000',	'');

DROP TABLE IF EXISTS `settings_loc`;
CREATE TABLE `settings_loc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting_id` int(11) NOT NULL,
  `lang` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `slogan` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `copy` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `settings_loc` (`id`, `setting_id`, `lang`, `slogan`, `address`, `copy`, `created_at`, `updated_at`) VALUES
(1,	1,	'ru',	'Слоган на Русском',	'',	'И права1',	'2017-11-27 10:19:28',	'2018-04-20 17:54:48'),
(2,	1,	'uk',	'Слоган ук',	'адрес Ук',	'Права Ук',	'2017-11-27 10:34:02',	'2017-11-27 10:34:02'),
(3,	1,	'de',	'Der Slogan auf Deutsch',	'',	'rechts',	'2017-11-27 11:50:05',	'2017-11-27 11:50:05');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'noimage.jpg',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `email`, `name`, `photo`, `password`, `permissions`, `remember_token`, `activated`, `created_at`, `updated_at`) VALUES
(30,	'dvacom_manager@dev.a',	'dvacom admin',	'1512062942.jpg',	'$2y$10$/NRfXNseJ1cskNPmMm4HpeopQxDh.nc1aME3d9nGSpJnmzoYtx4K6',	'admin',	'ohIAxtAZKbI6ifM8rF3vrWePRPRuoleNucuKR3qVihSBYPnWQmFhTmIhf4IJ',	1,	'2017-12-01 12:40:04',	'2017-12-01 12:41:27'),
(31,	'imden10@gmail.com',	'Denis',	'noimage.jpg',	'$2y$10$/NRfXNseJ1cskNPmMm4HpeopQxDh.nc1aME3d9nGSpJnmzoYtx4K6',	'user',	'08AZGWXrac4WPCKg9gBHfFmw4Rh6MUSu4rpjU4AgbMT0qAHzfgadmXc6A6r9',	1,	'2017-12-01 12:40:04',	'2017-12-01 12:40:04'),
(34,	'imden10@yandex.ru',	'Денис',	'noimage.jpg',	'$2y$10$q1kIG.VRR5wHu1VMFSBTSeuhIn55wxd4GTxHaatTc9Ab2VyBg/VQ.',	'admin',	NULL,	1,	'2017-12-01 12:40:04',	'2017-12-01 12:40:04'),
(35,	'dvacom_manager@dev.asd',	'Тестовый',	'noimage.jpg',	'$2y$10$tpSDsAwgjlWJhJS1zXB4F.OYWdLCdJ.Jyo8Ba3bFcVWT/Q0IRSjym',	'admin',	NULL,	1,	'2017-12-01 12:41:52',	'2017-12-01 12:41:59');

-- 2018-05-02 18:00:21
