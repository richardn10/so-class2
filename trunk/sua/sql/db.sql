CREATE TABLE IF NOT EXISTS `work` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correlation_id` int(11) NOT NULL,
  `filename` varchar(300) COLLATE utf8_bin NOT NULL,
  `filetype` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'image',
  `upload_pid` int(11) DEFAULT NULL,
  `upload_start` datetime DEFAULT NULL,
  `upload_end` datetime DEFAULT NULL,
  `errorflag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `correlation_id` (`correlation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=15 ;
