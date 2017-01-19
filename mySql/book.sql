-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016-12-17 09:24:20
-- 服务器版本: 5.1.73
-- PHP 版本: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `book`
--

-- --------------------------------------------------------

--
-- 表的结构 `facility`
--

CREATE TABLE IF NOT EXISTS `facility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(4) NOT NULL DEFAULT '0',
  `reg_time` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `fac_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `fac_index` int(5) NOT NULL,
  `intro` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `f_actived` int(3) NOT NULL DEFAULT '0',
  `f_address` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_num` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `facility`
--

INSERT INTO `facility` (`id`, `username`, `type`, `reg_time`, `fac_name`, `token`, `fac_index`, `intro`, `f_actived`, `f_address`, `data_num`) VALUES
(21, 'ABC', 0, '2016-09-12 21:37:42', 'ä¸€é¢—èµ›è‰‡', '65da1b2b98b92e881aa91d99194d9a27', 2, 'wewewerwerwer', 0, NULL, 0),
(24, 'ABC', 5, '2016-10-20 23:48:19', 'è®¾å¤‡1', '8ac01f8c0b879ac80ef920fd29c34b25', 3, 'é¡ºè¾¾SDF', 0, NULL, 0),
(18, 'ABC', 0, '2016-09-11 22:45:44', 'é˜¿è¨å¾·', '6395670a95f8c5b5b7f4b7e738627122', 1, 'èŒƒå›´å‘çš„æ–¹æ³•å•Šå‘å‘', 0, NULL, 0),
(25, 'æµ‹è¯•', 7, '2016-10-21 12:09:19', 'ç”µè§†æœº', 'e789cddd56a4e004d156e68268a43c5c', 1, 'æµ‹è¯•ç”¨è®¾å¤‡', 0, NULL, 0),
(26, 'æµ‹è¯•', 0, '2016-10-27 00:04:07', 'èƒœå¤šè´Ÿå°‘', '54d79a02d327afd09ec98235d6da98fa', 2, 'åœ°æ–¹', 0, NULL, 0),
(27, 'æµ‹è¯•', 15, '2016-10-28 20:44:10', 'ç©ºè°ƒ', '1caf61ce0af631023e380e110264a55d', 3, '', 0, NULL, 0),
(32, 'æµ‹è¯•', 9, '2016-12-16 16:14:29', 'å°ç¯', 'bf1fec4beba0cebd2c40f3d38d188747', 4, 'å¯ä»¥æŽ§åˆ¶äº®ç­ç¨‹åº¦çš„ç¯', 0, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `fac_data`
--

CREATE TABLE IF NOT EXISTS `fac_data` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `fac_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `token` int(60) NOT NULL,
  `data1` longtext COLLATE utf8_unicode_ci NOT NULL,
  `data2` longtext COLLATE utf8_unicode_ci NOT NULL,
  `reg_time` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `fac_data`
--

INSERT INTO `fac_data` (`id`, `fac_name`, `token`, `data1`, `data2`, `reg_time`) VALUES
(1, 'é˜¿æ–¯é¡¿', 2, '', '', '2016-09-12 21:36:08');

-- --------------------------------------------------------

--
-- 表的结构 `fac_photo`
--

CREATE TABLE IF NOT EXISTS `fac_photo` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `fac_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `reg_time` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `fac_photo`
--

INSERT INTO `fac_photo` (`id`, `fac_name`, `token`, `address`, `reg_time`) VALUES
(1, 'ä¸€é¢—èµ›è‰‡', '65da1b2b98b92e881aa91d99194d9a27', '', '2016-09-12 21:37:42');

-- --------------------------------------------------------

--
-- 表的结构 `fac_switch`
--

CREATE TABLE IF NOT EXISTS `fac_switch` (
  `fac_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(3) NOT NULL DEFAULT '0',
  `clock` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `reg_time` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `fac_switch`
--

INSERT INTO `fac_switch` (`fac_name`, `token`, `state`, `clock`, `id`, `reg_time`) VALUES
('é˜¿è¨å¾·', '6395670a95f8c5b5b7f4b7e738627122', 1, '2016-10-29 01:00:02', 2, '2016-09-11 22:45:44');

-- --------------------------------------------------------

--
-- 表的结构 `pro_data`
--

CREATE TABLE IF NOT EXISTS `pro_data` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `type` int(3) NOT NULL DEFAULT '0',
  `token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `data` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pro_index` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `pro_data`
--

INSERT INTO `pro_data` (`id`, `type`, `token`, `name`, `data`, `pro_index`) VALUES
(4, 0, 'e789cddd56a4e004d156e68268a43c5c', 'ç”µè§†æœºç”µåŽ‹', '0.0', 1),
(5, 0, 'e789cddd56a4e004d156e68268a43c5c', 'ç”µè§†æœºç”µæµ', '0.0', 2),
(6, 0, 'e789cddd56a4e004d156e68268a43c5c', 'ç”µè§†æœºç”¨ç”µé¢‘çŽ‡', '5000.0', 2),
(7, 0, 'e789cddd56a4e004d156e68268a43c5c', 'ç”µè§†æœºåŠŸçŽ‡', '0.0', 3),
(9, 1, 'bf1fec4beba0cebd2c40f3d38d188747', 'å¤šæ±', '5', 1),
(10, 1, '1caf61ce0af631023e380e110264a55d', 'è¯·é—®', '0', 1),
(11, 0, '1caf61ce0af631023e380e110264a55d', 'å„¿ç«¥', '0', 2);

-- --------------------------------------------------------

--
-- 表的结构 `pro_photo`
--

CREATE TABLE IF NOT EXISTS `pro_photo` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `pro_index` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `pro_photo`
--

INSERT INTO `pro_photo` (`id`, `token`, `name`, `address`, `pro_index`) VALUES
(5, '1caf61ce0af631023e380e110264a55d', '008', '', 1),
(4, 'e789cddd56a4e004d156e68268a43c5c', 'å›¾ç‰‡åž‹', './upload/æµ‹è¯•/_photo4.jpg', 1),
(3, '8ac01f8c0b879ac80ef920fd29c34b25', 'å›¾ç‰‡2', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `pro_switch`
--

CREATE TABLE IF NOT EXISTS `pro_switch` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(3) NOT NULL DEFAULT '0',
  `pro_index` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `pro_switch`
--

INSERT INTO `pro_switch` (`id`, `token`, `name`, `state`, `pro_index`) VALUES
(9, 'e789cddd56a4e004d156e68268a43c5c', 'ç”µè§†å¼€å…³', 0, 1),
(10, '1caf61ce0af631023e380e110264a55d', '007', 1, 1),
(8, '8ac01f8c0b879ac80ef920fd29c34b25', 'å¼€å…³1', 1, 1),
(14, 'bf1fec4beba0cebd2c40f3d38d188747', 'æ€»å¼€å…³', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sex` int(3) NOT NULL,
  `mail` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inter` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reg_time` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actived` int(3) NOT NULL DEFAULT '0',
  `token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `token_exptime` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `last_log_time` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`username`, `password`, `sex`, `mail`, `tel`, `web`, `birthday`, `inter`, `intro`, `reg_time`, `photo`, `id`, `actived`, `token`, `token_exptime`, `last_log_time`) VALUES
('admin', 'e10adc3949ba59abbe56e057f20f883e', 0, '6543@qq.com', '', '', '', 'fish', '', '2016-08-21 20:50:54', './upload/admin/admin.png', 1, 0, '', '', '2016-10-24 15:58:09'),
('æµ‹è¯•ç‹—', '1edf693ba07139f06803f3896e587ed3', 1, '1141200219@ncepu.edu.cn', '', '', '', '', '', '2016-09-16 17:14:48', NULL, 17, 1, '4da9a3d89da1f19257747f52d4b7e2a1', '1474103791', '2016-09-16 19:03:42'),
('æµ‹è¯•', 'e10adc3949ba59abbe56e057f20f883e', 0, '1365209680@qq.com', '123-456-7890', '', '1996-1-1', 'ä¸ªäººçˆ±å¥½', 'æµ‹è¯•ç³»ç»Ÿè´¦å·ã€‚', '2016-10-21 11:07:23', './upload/æµ‹è¯•/æµ‹è¯•.png', 25, 1, 'ff405586c22a1ac2bf5d5bf6f7750efa', '1477108269', '2016-12-17 01:11:37'),
('æ²‰é“ƒ', 'c93a2769943da790b7c0467c352aadbd', 0, '596733486@qq.com', '', '', '', '', '', '2016-09-30 21:46:01', NULL, 18, 1, '', '', '2016-09-30 21:46:51'),
('hack', 'e10adc3949ba59abbe56e057f20f883e', 1, '1461051584@qq.com', '15210230372', '', '', '', '', '2016-10-05 14:10:06', NULL, 19, 1, 'ef5fa9ecba31d9c69e5f56b981834b4d', '1475734233', '2016-11-02 17:32:56'),
('zlytob', '9cc02fabad711bbf8623f65ee0457d2e', 0, '2242718013@qq.com', '', '', '', '', '', '2016-10-21 00:11:41', NULL, 24, 0, '019209e0f6a37109127e6816937eb1d6', '1477066596', '2016-10-21 00:23:35'),
('æˆ‘çš„å¤©å‘', 'e10adc3949ba59abbe56e057f20f883e', 0, '1668659995@qq.com', '', '', '', '', '', '2016-10-07 12:09:08', './upload/æˆ‘çš„å¤©å‘/æˆ‘çš„å¤©å‘.jpg', 22, 1, 'd29f36204cd92d4b2454f999167082c8', '1475899791', '2016-10-07 18:12:20'),
('123', 'e10adc3949ba59abbe56e057f20f883e', 1, '18965460098@163.com', '', '', '', '', '', '2016-10-28 23:52:32', NULL, 26, 0, '5d03252a2b2e2bc4fb2562d1953af010', '1477756506', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
