DROP TABLE IF EXISTS `submissions`;

CREATE TABLE `submissions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` tinytext,
  `email` tinytext,
  `items` mediumblob,
  `subtotal` tinytext,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` tinytext,
  `thumbnail` tinytext,
  `price` tinytext,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;