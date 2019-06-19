CREATE TABLE `zion_post_category` (
  `mandt` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `parentid` int(11) DEFAULT NULL,
  `name` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT '{"type": "select","list": "status"}',
  PRIMARY KEY (`mandt`,`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zion_post_page` (
  `mandt` int(11) NOT NULL,
  `pageid` int(11) NOT NULL,
  `rewrite` varchar(255) NOT NULL,
  `title` varchar(45) NOT NULL,
  `categoryid` int(11) DEFAULT NULL,
  `content_html` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(120) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(120) DEFAULT NULL,
  `meta_description` varchar(300) NOT NULL,
  `meta_keywords` varchar(120) NOT NULL,
  `http_status` int(5) DEFAULT 200,
  `cache_maxage` int(11) DEFAULT 3600,
  `cache_smaxage` int(11) DEFAULT 86400,
  `use_template` tinyint(4) DEFAULT 1,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT '{"type": "select","list": "status"}',
  PRIMARY KEY (`mandt`,`pageid`),
  UNIQUE KEY `rewrite_UNIQUE` (`rewrite`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
