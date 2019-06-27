INSERT IGNORE INTO `zion_mail_server` (`mandt`,`server`,`smtp_host`,`smtp_port`,`smtp_auth`,`smtp_secure`,`pop_host`,`pop_port`,`pop_secure`,`status`) 
VALUES 
(0,'gmail','smtp.gmail.com',465,1,'ssl','pop.gmail.com',995,'tls','A'),
(0,'office365','smtp.office365.com',587,1,'tls','pop.office365.com',995,'tls','A'),
(0,'yahoo','smtp.mail.yahoo.com',465,1,'ssl','pop.mail.yahoo.com',995,'tls','A'),
(0,'zoho','smtp.zoho.com',465,1,'ssl','pop.zoho.com',995,'tls','A');

INSERT IGNORE INTO `zion_core_module` 
(`moduleid`,`name`,`category`,`description`,`created`,`updated`) 
VALUES ('builder','Gerador de CRUD','Ferramentas','Gera um CRUD a partir de uma tabela no banco de dados','2019-06-26 13:07:37','2019-06-26 13:07:37'),
('core','Gerenciamento do Sistema','Sistema','Gerencia as principais funções do sistema','2019-06-26 13:08:09','2019-06-26 13:08:09'),
('diff','Diferenças entre Ambientes','Ferramentas','Exibe as diferenças entre dois ambientes (arquivos, tabelas etc)','2019-06-26 13:09:08','2019-06-26 13:09:08'),
('error','Gerenciamento de Erros','Ferramentas','Gerencia os erros que estão ocorrendo no sistema','2019-06-26 13:10:11','2019-06-26 13:10:11'),
('ide','IDE','Workbench','IDE integrada no navegador','2019-06-26 13:10:37','2019-06-26 13:10:37'),
('mail','Mail','Sistema','Gerencia as configurações de e-mail, usuários etc','2019-06-26 13:11:51','2019-06-26 13:11:51'),
('post','Post','Ferramentas','Gerenciador de páginas estáticas','2019-06-26 13:11:51','2019-06-26 13:11:51'),
('proj','Proj','Ferramentas','Gerenciador de projetos de desenvolvimento','2019-06-26 13:12:43','2019-06-26 13:12:43'),
('sql','IDE para banco de dados','Workbench','IDE para realizar suas operações com o banco de dados','2019-06-26 13:11:19','2019-06-26 13:11:19'),
('waf','WAF','Sistema','Firewall integrado','2019-06-26 13:13:17','2019-06-26 13:13:17');