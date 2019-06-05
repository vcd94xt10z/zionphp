CREATE TABLE IF NOT EXISTS `proj_feature` (
  `mandt` int(11) NOT NULL,
  `projid` int(11) NOT NULL,
  `featid` int(11) NOT NULL,
  `sequence` int(11) NOT NULL DEFAULT 0,
  `name` varchar(120) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(120) DEFAULT NULL,
  `main_developer` varchar(120) DEFAULT NULL,
  `status` varchar(1) DEFAULT 'P' COMMENT 'E = Em execução, P = Parado, C = Concluído, X = Cancelado',
  `released_to_test` tinyint(4) DEFAULT 0,
  `complexity` varchar(1) DEFAULT 'B' COMMENT 'B=Baixa,M=Media,A=Alta',
  `version` int(11) DEFAULT 1 COMMENT 'Versão para controle de teste',
  `estimated_time` double(18,2) DEFAULT NULL COMMENT 'Tempo estimado em horas',
  `url` varchar(1024) DEFAULT NULL,
  `note` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`mandt`,`projid`,`featid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `proj_feature_time` (
  `mandt` int(11) NOT NULL,
  `projid` int(11) NOT NULL,
  `featid` int(11) NOT NULL,
  `begin` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  PRIMARY KEY (`mandt`,`projid`,`featid`,`begin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `proj_project` (
  `mandt` int(11) NOT NULL,
  `projid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(45) NOT NULL,
  PRIMARY KEY (`mandt`,`projid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Projetos';

CREATE TABLE IF NOT EXISTS `proj_test` (
  `mandt` int(11) NOT NULL,
  `projid` int(11) NOT NULL,
  `featid` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `testid` int(11) NOT NULL,
  `test_at` datetime NOT NULL,
  `test_by` varchar(120) NOT NULL,
  `result` varchar(1) NOT NULL COMMENT 'A=Aprovado,R=Reprovado',
  `device` varchar(45) DEFAULT NULL COMMENT 'D=Desktop,M=Mobile,T=Tablet,V=TV',
  `browser` varchar(45) DEFAULT NULL COMMENT 'Chrome,Firefox,IE,Edge',
  `note` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`mandt`,`projid`,`featid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
