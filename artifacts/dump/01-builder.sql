CREATE TABLE `zion_builder_history` (
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

CREATE TABLE `zion_builder_text` (
  `mandt` int(11) NOT NULL DEFAULT 0,
  `lang` varchar(5) NOT NULL DEFAULT 'pt-BR',
  `moduleid` varchar(45) NOT NULL,
  `entityid` varchar(45) NOT NULL,
  `field` varchar(45) NOT NULL,
  `text` varchar(120) NOT NULL,
  PRIMARY KEY (`mandt`,`lang`,`moduleid`,`entityid`,`field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;