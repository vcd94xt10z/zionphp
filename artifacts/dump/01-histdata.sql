CREATE TABLE `zion_histdata_object` (
  `mandt` int(11) NOT NULL DEFAULT 0,
  `name` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `value_label` varchar(45) NOT NULL,
  `sequence` int(11) DEFAULT 0,
  PRIMARY KEY (`mandt`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `zion_histdata_value` (
  `mandt` int(11) NOT NULL DEFAULT 0,
  `name` varchar(45) NOT NULL,
  `date` datetime NOT NULL,
  `value` double(18,2) NOT NULL,
  PRIMARY KEY (`mandt`,`name`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Dados históricos';