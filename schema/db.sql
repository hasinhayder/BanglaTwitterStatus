CREATE TABLE IF NOT EXISTS `posts` (
  `user_id` int(11) NOT NULL,
  `status` text NOT NULL,
  `short_url` varchar(200) default NULL,
  `created` int(11) NOT NULL,
  KEY `user_id` (`user_id`,`created`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `status` text NOT NULL,
  `short_url` varchar(200) default NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`,`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;