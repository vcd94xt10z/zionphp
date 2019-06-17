CREATE TABLE `zion_core_acl` (
  `uri` varchar(255) NOT NULL,
  `method` varchar(4) NOT NULL,
  `object_type` varchar(10) NOT NULL COMMENT 'perfil ou user',
  `object_id` varchar(32) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'SOL' COMMENT '(sol)icitado, (lib)erado, (neg)ado',
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `requested_by` varchar(32) DEFAULT NULL,
  `updated_by` varchar(32) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`uri`,`method`,`object_type`,`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zion_core_config` (
  `mandt` int(11) NOT NULL,
  `env` varchar(3) NOT NULL DEFAULT 'ALL' COMMENT 'DEV,QAS,PRD,ALL',
  `key` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` varchar(1024) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `sequence` int(11) DEFAULT 0,
  PRIMARY KEY (`mandt`,`env`,`key`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zion_core_module` (
  `moduleid` varchar(32) NOT NULL,
  `name` varchar(45) NOT NULL,
  `category` varchar(45) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`moduleid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zion_core_user` (
  `mandt` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `perfil` varchar(32) NOT NULL,
  `force_new_password` int(1) DEFAULT 0,
  `redefine_password_hash` varchar(32) DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(256) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `docf` varchar(45) DEFAULT NULL COMMENT 'Documento Federal (CPF,CNPJ)',
  `doce` varchar(45) DEFAULT NULL COMMENT 'Documento Estadual (RG, IE)',
  `docm` varchar(45) DEFAULT NULL COMMENT 'Documento Municipal (IM)',
  `validity_begin` datetime DEFAULT NULL,
  `validity_end` datetime DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'I' COMMENT 'A = Ativo\nI = Inativo\nB = Bloqueado',
  PRIMARY KEY (`mandt`,`userid`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `docf_UNIQUE` (`docf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
