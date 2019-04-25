CREATE TABLE IF NOT EXISTS `monitor_notify_queue` (
  `objectid` varchar(32) NOT NULL,
  `notifyid` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `type` varchar(10) NOT NULL COMMENT 'email,sms,sound',
  `status` varchar(10) NOT NULL DEFAULT 'A' COMMENT 'A=Aguardando,P=Processando,C=Concluido,E=Erro,I=Ignorado',
  `sended` datetime DEFAULT NULL,
  PRIMARY KEY (`objectid`,`notifyid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `monitor_object` (
  `objectid` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `type` varchar(45) NOT NULL COMMENT 'http,ping',
  `url` varchar(500) NOT NULL,
  `interval` int(11) NOT NULL COMMENT 'Intervalo em segundo de cada verificação',
  `status` varchar(45) NOT NULL COMMENT 'on,off',
  `last_check` datetime DEFAULT NULL,
  `notify_by_email` tinyint(4) DEFAULT 0,
  `notify_by_sms` tinyint(4) DEFAULT 0,
  `notify_by_sound` tinyint(4) DEFAULT 0,
  `notify_email` varchar(256) DEFAULT NULL,
  `notify_phone` varchar(20) DEFAULT NULL,
  `notify_sound` varchar(500) DEFAULT NULL,
  `sound_enabled` tinyint(4) DEFAULT 1,
  `enabled` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`objectid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Objeto de monitoramento';
