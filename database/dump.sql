-- Версия сервера: 5.0.95
-- Версия PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Структура таблицы `list`
--

DROP TABLE IF EXISTS `list`;
CREATE TABLE IF NOT EXISTS `list` (
  `ip` int(10) unsigned NOT NULL,
  `added_id` text NOT NULL,
  `last_commit` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `queue` int(11) NOT NULL default '1',
  UNIQUE KEY `ip_queue_index_unique` (`ip`,`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Структура таблицы `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(32) NOT NULL,
  `ip_array` text NOT NULL,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  `queue` int(11) NOT NULL default '1',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL auto_increment,
  `key` varchar(32) NOT NULL,
  `userip` int(10) unsigned NOT NULL,
  `comments` text NOT NULL,
  `enable` tinyint(2) NOT NULL default '0',
  `queue` int(11) NOT NULL,
  PRIMARY KEY  (`userid`),
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

