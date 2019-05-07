CREATE TABLE IF NOT EXISTS `zion_core_config` (
  `mandt` int(11) NOT NULL,
  `env` varchar(3) NOT NULL DEFAULT 'ALL' COMMENT 'DEV,QAS,PRD,ALL',
  `category` varchar(32) NOT NULL,
  `group` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` varchar(1024) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`mandt`,`env`,`category`,`group`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `zion_core_user` (
  `mandt` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `force_new_password` int(1) DEFAULT 0,
  `redefine_password_hash` varchar(32) DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(256) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `docf` varchar(45) DEFAULT NULL COMMENT 'Documento Federal (CPF,CNPJ)',
  `doce` varchar(45) DEFAULT NULL COMMENT 'Documento Estadual (RG, IE)',
  `docm` varchar(45) DEFAULT NULL COMMENT 'Documento Municipal (IM)',
  `validity_begin` datetime DEFAULT NULL,
  `validity_end` datetime DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'I' COMMENT 'A = Ativo\nI = Inativo\nB = Bloqueado',
  PRIMARY KEY (`mandt`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
