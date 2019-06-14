CREATE TABLE IF NOT EXISTS `zion_mail_quota` (
  `mandt` int(11) NOT NULL DEFAULT 0,
  `user` varchar(120) NOT NULL,
  `server` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `hour` int(11) NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`mandt`,`user`,`server`,`date`,`hour`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Controle de cotas';

CREATE TABLE IF NOT EXISTS `zion_mail_send_log` (
  `mandt` int(11) NOT NULL,
  `logid` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `server` varchar(45) NOT NULL,
  `user` varchar(45) NOT NULL,
  `from` varchar(300) DEFAULT NULL,
  `to` varchar(1024) DEFAULT NULL,
  `subject` varchar(45) DEFAULT NULL,
  `content_type` varchar(45) DEFAULT NULL,
  `content_body_size` int(11) DEFAULT NULL,
  `attachment_count` int(11) DEFAULT NULL,
  `result` varchar(1) NOT NULL COMMENT 'S=Sucesso,E=Erro',
  `result_message` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`mandt`,`logid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `zion_mail_server` (
  `mandt` int(11) NOT NULL DEFAULT 0,
  `server` varchar(45) NOT NULL,
  `smtp_host` varchar(120) DEFAULT NULL,
  `smtp_port` int(5) DEFAULT NULL,
  `smtp_auth` tinyint(4) DEFAULT NULL,
  `smtp_secure` varchar(45) DEFAULT NULL,
  `pop_host` varchar(120) DEFAULT NULL,
  `pop_port` int(5) DEFAULT NULL,
  `pop_secure` varchar(45) DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=Ativo,I=Inativo',
  PRIMARY KEY (`mandt`,`server`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Configuração do servidor de e-mail';

CREATE TABLE IF NOT EXISTS `zion_mail_user` (
  `mandt` int(11) NOT NULL DEFAULT 0,
  `user` varchar(120) NOT NULL,
  `password` varchar(45) NOT NULL,
  `server` varchar(45) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'A' COMMENT 'A=Ativo,I=Inativo',
  `hourly_quota` int(11) NOT NULL DEFAULT 0 COMMENT 'Quota por hora de envio de e-mails',
  `daily_quota` int(11) NOT NULL DEFAULT 0 COMMENT 'Quota por dia de envio de e-mails',
  `sent_success` int(11) NOT NULL DEFAULT 0,
  `sent_error` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`mandt`,`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Usuários de e-mail';