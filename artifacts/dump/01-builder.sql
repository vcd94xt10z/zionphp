CREATE TABLE IF NOT EXISTS `zion_builder_history` (
  `mandt` int(11) NOT NULL DEFAULT 0,
  `module` varchar(20) NOT NULL,
  `entity` varchar(20) NOT NULL,
  `table` varchar(20) NOT NULL,
  `destiny` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `update_count` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`mandt`,`module`,`entity`,`table`,`destiny`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Historico de Geração';
