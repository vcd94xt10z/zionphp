INSERT INTO `zion_mail_server` (`mandt`,`server`,`smtp_host`,`smtp_port`,`smtp_auth`,`smtp_secure`,`pop_host`,`pop_port`,`pop_secure`,`status`) 
VALUES 
(0,'gmail','smtp.gmail.com',587,1,'ssl','pop.gmail.com',995,'tls','A'),
(0,'office365','smtp.office365.com',587,1,'tls','pop.office365.com',995,'tls','A'),
(0,'yahoo','smtp.mail.yahoo.com',465,1,'ssl','pop.mail.yahoo.com',995,'tls','A'),
(0,'zoho','smtp.zoho.com',465,1,'ssl','pop.zoho.com',995,'tls','A');