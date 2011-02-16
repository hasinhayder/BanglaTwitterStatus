CREATE TABLE IF NOT EXISTS `posts` (
  `user_id` int(11) NOT NULL,
  `status` text NOT NULL,
  `short_url` varchar(200) default NULL,
  `created` int(11) NOT NULL,
  KEY `user_id` (`user_id`,`created`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(120) NOT NULL,
  `token` varchar(200) NOT NULL,
  `secret` varchar(200) NOT NULL,
  `screen_name` varchar(200) NOT NULL,
  `screen_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `screen_id` (`screen_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;