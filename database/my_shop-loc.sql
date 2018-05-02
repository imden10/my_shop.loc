-- Adminer 4.2.5 MySQL dump

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
(2,	0,	1,	4,	0,	'kategoriya-1',	'1512205623.jpg',	1,	'2017-12-01 15:12:18',	'2017-12-12 13:51:46'),
(3,	0,	5,	6,	0,	'kategoriya-2',	'noimage.jpg',	1,	'2017-12-01 15:22:14',	'2017-12-12 13:51:46'),
(4,	0,	7,	8,	0,	'kategoriya-3',	'1512141870.JPG',	1,	'2017-12-01 15:24:31',	'2017-12-02 11:03:17'),
(7,	2,	2,	3,	1,	'podkategoriya-11',	'noimage.jpg',	1,	'2017-12-02 10:43:28',	'2017-12-02 10:43:28'),
(15,	0,	9,	12,	0,	'kategoriya-4',	'noimage.jpg',	1,	'2017-12-02 11:07:12',	'2017-12-12 12:45:15'),
(16,	15,	10,	11,	1,	'podkategoriya-41',	'noimage.jpg',	1,	'2017-12-02 11:08:30',	'2017-12-02 11:08:30');

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
(1,	2,	'ru',	'Категория 1',	'<p>Описание первой категории на Русском update</p>',	'Категория 1',	'',	'',	'2017-12-01 15:12:18',	'2017-12-02 09:21:10'),
(2,	3,	'ru',	'Категория 2',	'<p>Описание к категории2 на Русском</p>',	'Категория 2',	'',	'',	'2017-12-01 15:22:14',	'2017-12-01 15:22:14'),
(3,	4,	'ru',	'Категория 3',	'<p>Описание к категории 3 на Русском</p>',	'Категория 3',	'',	'',	'2017-12-01 15:24:31',	'2017-12-01 15:24:31'),
(4,	2,	'uk',	'Категория 1 на Укр',	'<p>Описание первой категории на Украинском</p>',	'Категория 1',	'',	'',	'2017-12-01 15:50:20',	'2017-12-01 15:50:20'),
(5,	7,	'ru',	'Подкатегория 1.1',	'<p>ывмывмым</p>',	'Подкатегория 1.1',	'',	'',	'2017-12-02 10:43:28',	'2017-12-02 10:43:28'),
(8,	15,	'ru',	'Категория 4',	'<p>Родительская категория 4 на русском</p>',	'Категория 4',	'',	'',	'2017-12-02 11:07:12',	'2017-12-02 11:07:12'),
(9,	16,	'ru',	'Подкатегория 4.1',	'<p>Подкатегория 4.1</p>',	'Подкатегория 4.1',	'',	'',	'2017-12-02 11:08:30',	'2017-12-02 11:08:30');

DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rgt` int(10) DEFAULT NULL,
  `depth` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `features` (`id`, `parent_id`, `lft`, `rgt`, `depth`, `created_at`, `updated_at`) VALUES
(1,	0,	NULL,	NULL,	NULL,	'2017-12-04 12:15:05',	'2017-12-04 12:15:05'),
(2,	0,	NULL,	NULL,	NULL,	'2017-12-04 12:35:59',	'2017-12-04 12:35:59'),
(3,	0,	NULL,	NULL,	NULL,	'2017-12-12 12:30:20',	'2017-12-12 12:30:20'),
(4,	3,	NULL,	NULL,	NULL,	'2017-12-12 13:53:56',	'2017-12-12 13:53:56'),
(34,	3,	1,	2,	0,	'2017-12-14 13:38:18',	'2017-12-14 13:38:18'),
(35,	NULL,	3,	4,	0,	'2017-12-14 13:41:25',	'2017-12-14 13:41:25'),
(36,	35,	5,	6,	0,	'2017-12-14 13:41:46',	'2017-12-14 13:41:46');

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
(1,	1,	'ru',	'Бренд',	'2017-12-04 12:15:05',	'2017-12-04 12:15:05'),
(2,	2,	'ru',	'Страна производитель',	'2017-12-04 12:35:59',	'2017-12-04 12:35:59'),
(3,	3,	'ru',	'Механизм',	'2017-12-12 12:30:20',	'2017-12-12 12:30:20'),
(4,	4,	'ru',	'Механические',	'2017-12-12 13:54:32',	'2017-12-12 13:54:32'),
(5,	4,	'uk',	'Механічні',	'2017-12-12 13:59:04',	'2017-12-12 13:59:04'),
(9,	34,	'ru',	'Кварцовые',	'2017-12-14 13:38:18',	'2017-12-14 13:38:18'),
(10,	35,	'ru',	'Цвет',	'2017-12-14 13:41:25',	'2017-12-14 13:41:25'),
(11,	36,	'ru',	'Красный',	'2017-12-14 13:41:46',	'2017-12-14 13:41:46');

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
('2017_12_02_133844_create_features_loc_table',	18);

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
(1,	0,	1,	4,	0,	'/',	'default.jpg',	'main',	1,	1,	'2017-11-22 10:02:32',	'2017-08-24 05:49:19'),
(2,	1,	2,	3,	1,	'produktsiya',	'default.jpg',	'main',	0,	1,	'2017-11-22 10:02:33',	'2017-08-24 05:49:19'),
(5,	0,	5,	8,	0,	'palvelut',	'default.jpg',	'main',	0,	1,	'2017-11-22 08:08:56',	'2017-08-24 05:36:33'),
(6,	5,	6,	7,	1,	'basket',	'default.jpg',	'main',	1,	1,	'2017-11-22 08:08:56',	'2017-08-24 05:18:07'),
(7,	0,	9,	10,	0,	'eta-stranitsa-na-polskom',	'1510739594.jpg',	'main',	0,	1,	'2017-11-15 13:33:14',	'2017-11-15 07:15:57'),
(8,	NULL,	11,	12,	0,	'dopolnitelnaya-stranitsa',	'default.jpg',	'other',	0,	1,	'2017-11-16 08:41:39',	'2017-11-16 08:41:39'),
(9,	0,	11,	12,	0,	'novaya-stranitsa-v-novom-stile-bez-kartinki',	'default.jpg',	'main',	0,	1,	'2017-11-28 17:20:53',	'2017-11-27 07:10:18'),
(10,	NULL,	15,	16,	0,	'novaya-dop-stranitsa-s-kartinkoj',	'1511766869.jpg',	'other',	0,	1,	'2017-11-27 07:59:54',	'2017-11-27 07:14:29');

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
(1,	1,	'ru',	'О компании',	'',	'<p><strong><span style=\"font-size: 18pt;\">Заголовок главной страницы</span></strong></p>\r\n<p></p>\r\n<p>Текст главной страницы</p>',	'О компании заголовок',	'ключи о компании',	'описание о компании'),
(2,	1,	'uk',	'Про компанию',	'',	'<p>Текст Українською мовою</p>',	'Про компанию заголовок',	'Про компанию ключі',	'опис Про компанию'),
(4,	2,	'ru',	'Продукция',	'',	'<p>Текст</p>',	'Продукция',	'ключи',	'Описание ру'),
(5,	2,	'uk',	'Продукция',	'',	'',	'Продукція заголовок',	'Про нас',	''),
(13,	5,	'ru',	'Услуги',	'',	'<p>Мы предоставляем такие-то услуги...</p>',	'Услуги заголовок',	'услуги ключи',	'Описание услуги'),
(14,	5,	'uk',	'Послуги',	'',	'<p>Ми надаємо такі послуги</p>',	'Послуги заголовок',	'ключі послуги',	'опис послуги'),
(16,	6,	'ru',	'Корзина',	NULL,	'',	'Корзина title',	'ключевые слова',	'Описание страницы корзины'),
(17,	6,	'uk',	'',	NULL,	'',	'Кошик title',	'',	'Опис кошика'),
(19,	7,	'ru',	'Тестовая страница (Изначально на Русском)',	NULL,	'<p>Описание страницы на Русском</p>',	'Тестовая страница (Изначально на Русском)',	'',	''),
(20,	7,	'uk',	'Тестовая Украина1',	NULL,	'<p>Описание страницы на Русском</p>',	'Тестовая Украина1',	'',	''),
(23,	5,	'fr',	'Palvelut',	NULL,	'<p>Tarjoamme t&auml;llaisia palveluita ...</p>',	'Palvelut',	'услуги ключи',	'Описание услуги'),
(24,	2,	'fr',	'tuotteet',	NULL,	'<p>Sivun kuvaustuotteet ranskaksi</p>',	'tuotteet',	'ключи',	'Описание ру'),
(25,	1,	'fr',	'Meistä',	NULL,	'<p><strong>P&auml;&auml;sivun otsikko</strong></p>\r\n<p>P&auml;&auml;sivuteksti</p>',	'Meistä',	'ключи о компании',	'описание о компании'),
(26,	8,	'ru',	'Дополнительная страница',	NULL,	'<p>Описание доп страницы</p>',	'Дополнительная страница',	'',	''),
(27,	9,	'ru',	'Новая страница в новом стиле без картинки',	NULL,	'<p>Описание новой страницы</p>',	'Новая страница в новом стиле без картинки',	'',	''),
(28,	10,	'ru',	'Новая доп страница с картинкой',	NULL,	'<p>Описание доп страницы с картинкой</p>',	'Новая доп страница с картинкой',	'',	''),
(29,	10,	'uk',	'Нова доп сторінка з картинкою',	NULL,	'<p>Опис доп сторінки з картинкою</p>',	'Новая доп страница с картинкой',	'',	''),
(30,	10,	'es',	'Nueva página con una imagen',	NULL,	'<p>Descripci&oacute;n de p&aacute;gina adicional con una imagen</p>',	'Новая доп страница с картинкой',	'',	'');

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
(1,	1,	'ru',	'Слоган на Русском',	'',	'И права1',	'2017-11-27 10:19:28',	'2017-11-27 11:51:13'),
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

-- 2017-12-14 13:55:01
