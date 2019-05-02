CREATE TABLE IF NOT EXISTS `zion_error_log` (
  `errorid` varchar(32) NOT NULL,
  `type` varchar(20) NOT NULL COMMENT 'apache,php,mysql',
  `created` datetime NOT NULL,
  `duration` int(5) NOT NULL,
  `http_ipaddr` varchar(45) NOT NULL,
  `http_method` varchar(10) NOT NULL,
  `http_uri` varchar(500) NOT NULL,
  `level` varchar(10) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `stack` text DEFAULT NULL,
  `input` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `line` int(5) DEFAULT NULL,
  PRIMARY KEY (`errorid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;