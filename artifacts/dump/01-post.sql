CREATE TABLE `zion_post_category` (
  `mandt` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=Ativo,I=Inativo',
  PRIMARY KEY (`mandt`,`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zion_post_page` (
  `mandt` int(11) NOT NULL,
  `pageid` int(11) NOT NULL,
  `rewrite` varchar(300) NOT NULL,
  `title` varchar(45) NOT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `content_html` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(120) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(120) DEFAULT NULL,
  `meta_description` varchar(300) NOT NULL,
  `meta_keywords` varchar(120) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=Ativo,I=Inativo',
  PRIMARY KEY (`mandt`,`pageid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;