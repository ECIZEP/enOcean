-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-04-02 09:50:51
-- 服务器版本： 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `enocean`
--

-- --------------------------------------------------------

--
-- 表的结构 `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(20) NOT NULL COMMENT '密码',
  `nickname` varchar(30) NOT NULL COMMENT '昵称',
  `personal` varchar(100) NOT NULL COMMENT '个性签名',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `phoneNumber` varchar(20) DEFAULT NULL COMMENT '电话号码',
  `email` varchar(30) NOT NULL COMMENT '邮箱',
  `registerDate` datetime DEFAULT NULL COMMENT '注册时间',
  `photoUrl` varchar(100) NOT NULL DEFAULT '../images/default.png' COMMENT '头像地址',
  `lastLoginDate` datetime DEFAULT NULL COMMENT '上次登录时间',
  `activated` int(11) NOT NULL DEFAULT '0' COMMENT '邮箱激活标志项',
  `quickCon` varchar(30) NOT NULL COMMENT '控制台快捷控制',
  `token` varchar(60) NOT NULL COMMENT '注册激活码',
  `token_exptime` varchar(30) NOT NULL COMMENT '注册有效时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户信息存储表';

--
-- 转存表中的数据 `account`
--

INSERT INTO `account` (`username`, `password`, `nickname`, `personal`, `address`, `phoneNumber`, `email`, `registerDate`, `photoUrl`, `lastLoginDate`, `activated`, `quickCon`, `token`, `token_exptime`) VALUES
('jueqi199', '123456', 'ECIZEP', '三十年众生马牛', '', '15650797979', 'sunriseteam@sina.com', '2017-01-21 05:19:01', '../images/default.png', '2017-02-18 13:52:43', 1, '6 12 8 14 A0001', '691bd73272cb06ad4351d6f9a0071d6b', '1485242624'),
('root', '', '', '', '', NULL, '', NULL, '../images/default.png', NULL, 0, '', '', '');

--
-- 触发器 `account`
--
DELIMITER //
CREATE TRIGGER `updateAccount` AFTER UPDATE ON `account`
 FOR EACH ROW begin
declare content varchar(100);
declare noticeLevel int default 2;
if old.email != new.email then
set content = CONCAT('将绑定邮箱修改为：',new.email);
elseif old.phoneNumber != new.phoneNumber then
set content = CONCAT('将绑定手机号修改为：',new.phoneNumber);
elseif old.password != new.password then
set content = CONCAT('修改了账户密码');
else
set content = '更新了个人资料';
set noticeLevel = 1;
end if;
insert into logbook values(NOW(),new.username,content,noticeLevel);
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `controller`
--

CREATE TABLE IF NOT EXISTS `controller` (
  `controllerId` varchar(20) NOT NULL DEFAULT '',
  `deviceId` int(11) NOT NULL DEFAULT '0' COMMENT '所属设备id',
  `controName` varchar(20) DEFAULT '未定义' COMMENT '控制器名称',
  `data` int(11) DEFAULT '0' COMMENT '控制器状态或者数值',
  `typeId` int(11) NOT NULL DEFAULT '1' COMMENT '控制器类型',
  `minValue` int(11) DEFAULT NULL COMMENT '控制器最小值',
  `maxValue_` int(11) DEFAULT NULL COMMENT '控制器最大值',
  `modeNames` varchar(100) DEFAULT NULL COMMENT '模式开关选项'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='控制器表';

--
-- 转存表中的数据 `controller`
--

INSERT INTO `controller` (`controllerId`, `deviceId`, `controName`, `data`, `typeId`, `minValue`, `maxValue_`, `modeNames`) VALUES
('12', 4, '电视机开关', 1, 1, 0, 1, ''),
('14', 1, '温度监控', 10, 4, 10, 30, ''),
('15', 2, '电源开关', 0, 1, 0, 1, ''),
('3', 1, '电源开关', 1, 1, 0, 1, ''),
('5', 1, '温度控制', 17, 3, 10, 30, ''),
('6', 1, '屏幕开关', 0, 1, 0, 1, ''),
('8', 1, '空调模式', 2, 2, 0, 3, '制冷模式 暖气模式 睡眠模式'),
('9', 1, '电压监控', 213, 4, 180, 240, ''),
('A0001', 2, '制冷温度', -6, 3, -15, 10, '');

--
-- 触发器 `controller`
--
DELIMITER //
CREATE TRIGGER `deleteController` AFTER DELETE ON `controller`
 FOR EACH ROW begin
declare content varchar(100);
declare username varchar(20);
declare devicename varchar(30);
select devices.owner,devices.devicename into username,devicename from devices where devices.deviceID = old.deviceId;
set content = CONCAT('删除设备',devicename,'的控制器：',old.controname);
insert into logbook values(NOW(),username,content,1);
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `insertController` AFTER INSERT ON `controller`
 FOR EACH ROW begin
declare content varchar(100);
declare username varchar(20);
declare devicename varchar(30);
select devices.owner,devices.devicename into username,devicename from devices where devices.deviceID = new.deviceId;
set content = CONCAT('设备',devicename,'添加控制器：',new.controname);
insert into logbook values(NOW(),username,content,1);
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `updateControllerName` AFTER UPDATE ON `controller`
 FOR EACH ROW begin
declare username varchar(20);
declare devicename varchar(30);
declare content varchar(100);
if new.controname != old.controname then
select devices.owner,devices.devicename into username,devicename from devices where devices.deviceID = new.deviceId;
set content = CONCAT('修改设备',devicename,'的控制器名称：',old.controname,'改名为',new.controname);
insert into logbook values(NOW(),username,content,0);
end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
`deviceId` int(11) NOT NULL,
  `owner` varchar(20) NOT NULL DEFAULT 'root' COMMENT '设备归属人',
  `devicename` varchar(30) NOT NULL COMMENT '设备名称',
  `connectState` int(11) NOT NULL DEFAULT '0' COMMENT '设备连接状态',
  `remark` varchar(100) NOT NULL COMMENT '备注'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='设备表';

--
-- 转存表中的数据 `devices`
--

INSERT INTO `devices` (`deviceId`, `owner`, `devicename`, `connectState`, `remark`) VALUES
(0, 'root', 'WGCX001', 0, ''),
(1, 'jueqi199', '空调', 1, '卧室'),
(2, 'jueqi199', '冰箱', 0, '客厅的美的'),
(4, 'jueqi199', '电视机', 0, '客厅的乐视'),
(6, 'jueqi199', '水电费', 0, '水电费');

--
-- 触发器 `devices`
--
DELIMITER //
CREATE TRIGGER `deleteDevice` AFTER DELETE ON `devices`
 FOR EACH ROW begin
declare contenta varchar(100);
set contenta =CONCAT( '删除设备：',old.devicename);
insert into logbook values(NOW(),old.owner,contenta,2);
#delete from controller where deviceId = old.deviceId;
end
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `insertDevice` AFTER INSERT ON `devices`
 FOR EACH ROW begin
declare content varchar(100);
set content =CONCAT( '添加新设备：',new.devicename);
insert into logbook values(NOW(),new.owner,content,1);
END
//
DELIMITER ;
DELIMITER //
CREATE TRIGGER `updateDevice` AFTER UPDATE ON `devices`
 FOR EACH ROW begin
declare content varchar(100);
set content =CONCAT( '更新设备资料：',new.devicename);
insert into logbook values(NOW(),new.owner,content,0);
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `logbook`
--

CREATE TABLE IF NOT EXISTS `logbook` (
  `logDate` datetime NOT NULL COMMENT '操作发生时间',
  `username` varchar(20) NOT NULL COMMENT '操作发起用户',
  `content` varchar(100) NOT NULL COMMENT '操作内容',
  `noticeLevel` int(11) NOT NULL DEFAULT '0' COMMENT '日志等级'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作记录表';

--
-- 转存表中的数据 `logbook`
--

INSERT INTO `logbook` (`logDate`, `username`, `content`, `noticeLevel`) VALUES
('2017-01-21 20:07:07', 'jueqi199', '添加新设备：空调', 1),
('2017-01-21 22:37:44', 'jueqi199', '删除设备：空调', 2),
('2017-01-21 22:39:58', 'jueqi199', '添加新设备：空调', 1),
('2017-01-21 22:47:31', 'jueqi199', '删除设备：空调', 2),
('2017-01-21 22:53:12', 'jueqi199', '添加新设备：空调', 1),
('2017-01-21 23:18:53', 'jueqi199', '修改设备空调的控制器名称：电源开关1改名为电源开关2', 0),
('2017-01-21 23:43:43', 'jueqi199', '将绑定手机号修改为：43223512534', 2),
('2017-01-21 23:44:00', 'jueqi199', '将绑定邮箱修改为：8394354318@qq.com', 2),
('2017-01-21 23:44:11', 'jueqi199', '将绑定邮箱修改为：839435418@qq.com', 2),
('2017-01-21 23:44:50', 'jueqi199', '将绑定手机号修改为：15650797978', 2),
('2017-01-22 00:12:14', 'jueqi199', '修改设备空调的控制器名称：电源开关2改名为电源开关', 0),
('2017-01-22 00:12:50', 'jueqi199', '删除设备空调的控制器：模式选择', 1),
('2017-01-22 10:00:18', 'jueqi199', '设备空调添加控制器：温度控制', 1),
('2017-01-22 10:52:26', 'jueqi199', '更新设备:空调资料', 0),
('2017-01-22 16:51:58', 'jueqi199', '将绑定手机号修改为：15650797979', 2),
('2017-01-23 15:27:09', 'jueqi199', '将绑定邮箱修改为：839435418@qq.com', 2),
('2017-01-23 15:28:03', 'jueqi199', '将绑定邮箱修改为：sunriseteam@sina.com', 2),
('2017-01-23 22:38:20', 'root', '添加新设备：', 1),
('2017-01-23 22:39:01', 'root', '更新设备资料：WGCX1', 0),
('2017-01-23 23:10:49', 'root', '添加新设备：WGCX2', 1),
('2017-01-23 23:47:12', 'root', '更新设备资料：WGCS1', 0),
('2017-01-24 11:21:33', 'jueqi199', '修改设备空调的控制器名称：电源开关改名为电源开关', 0),
('2017-01-24 11:21:36', 'jueqi199', '修改设备空调的控制器名称：电源开关改名为电源开关', 0),
('2017-01-24 12:53:07', 'jueqi199', '更新设备资料：空调', 0),
('2017-01-24 13:05:30', 'jueqi199', '更新设备资料：冰箱', 0),
('2017-01-24 15:56:00', 'jueqi199', '将绑定手机号修改为：15650797978', 2),
('2017-01-24 17:05:31', 'jueqi199', '修改设备空调的控制器名称：电源开关改名为电源开关', 0),
('2017-01-24 19:37:51', 'jueqi199', '设备空调添加控制器：屏幕开关', 1),
('2017-01-24 19:38:47', 'jueqi199', '设备冰箱添加控制器：电源开关', 1),
('2017-01-24 19:40:05', 'jueqi199', '设备空调添加控制器：空调模式', 1),
('2017-01-24 19:40:46', 'jueqi199', '设备空调添加控制器：电压监控', 1),
('2017-01-24 19:41:54', 'jueqi199', '设备冰箱添加控制器：制冷温度', 1),
('2017-01-24 23:37:36', 'jueqi199', '修改设备空调的控制器名称：电源开关改名为电源开关', 0),
('2017-01-25 20:12:29', 'jueqi199', '更新设备资料：冰箱', 0),
('2017-01-25 20:14:35', 'jueqi199', '更新设备资料：冰箱大大', 0),
('2017-01-25 21:03:15', 'root', '添加新设备：WGCX001', 1),
('2017-01-25 21:03:57', 'jueqi199', '更新设备资料：冰箱', 0),
('2017-01-26 11:24:09', 'jueqi199', '删除设备冰箱的控制器：电源开关', 1),
('2017-01-26 11:42:49', 'jueqi199', '设备电视机添加控制器：电视机开关', 1),
('2017-01-26 15:04:03', 'jueqi199', '修改设备空调的控制器名称：温度控制改名为温度控制', 0),
('2017-01-26 23:05:32', 'jueqi199', '设备空调添加控制器：温度监控', 1),
('2017-01-27 10:09:25', 'jueqi199', '删除设备空调的控制器：温度监控', 1),
('2017-01-27 10:12:30', 'jueqi199', '设备空调添加控制器：温度监控', 1),
('2017-01-27 12:19:32', 'jueqi199', '更新了个人资料', 1),
('2017-01-27 15:43:52', 'jueqi199', '设备冰箱添加控制器：电源开关', 1),
('2017-01-27 16:35:11', 'jueqi199', '更新了个人资料', 1),
('2017-01-27 16:42:28', 'jueqi199', '更新设备资料：冰箱', 0),
('2017-01-27 17:18:26', 'jueqi199', '更新了个人资料', 1),
('2017-01-27 17:32:06', 'root', '添加新设备：WGCX001', 1),
('2017-02-18 20:52:43', 'jueqi199', '更新了个人资料', 1),
('2017-03-03 20:25:48', 'jueqi199', '将绑定手机号修改为：15650797979', 2),
('2017-03-31 16:50:55', 'root', '更新设备资料：WGCX001', 0),
('2017-04-02 14:01:40', 'root', '设备WGCX001添加控制器： ', 1),
('2017-04-02 14:02:25', 'root', '修改设备WGCX001的控制器名称： 改名为未定义', 0),
('2017-04-02 14:38:10', 'root', '设备WGCX001添加控制器：未定义', 1),
('2017-04-02 14:39:40', 'root', '删除设备WGCX001的控制器：未定义', 1),
('2017-04-02 15:48:03', 'jueqi199', '修改了账户密码', 2);

-- --------------------------------------------------------

--
-- 表的结构 `type`
--

CREATE TABLE IF NOT EXISTS `type` (
`typeId` int(11) NOT NULL COMMENT '控制器类型',
  `typeName` varchar(30) NOT NULL COMMENT '类型名称'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='控制器类型表';

--
-- 转存表中的数据 `type`
--

INSERT INTO `type` (`typeId`, `typeName`) VALUES
(1, '开关'),
(2, '下拉选择'),
(3, '滑块控制'),
(4, '数值监控');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
 ADD PRIMARY KEY (`username`);

--
-- Indexes for table `controller`
--
ALTER TABLE `controller`
 ADD PRIMARY KEY (`controllerId`), ADD KEY `typeId` (`typeId`), ADD KEY `controller_ibfk_1` (`deviceId`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
 ADD PRIMARY KEY (`deviceId`), ADD KEY `owner` (`owner`);

--
-- Indexes for table `logbook`
--
ALTER TABLE `logbook`
 ADD PRIMARY KEY (`logDate`,`username`), ADD KEY `logbook_ibfk_1` (`username`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
 ADD PRIMARY KEY (`typeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
MODIFY `deviceId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
MODIFY `typeId` int(11) NOT NULL AUTO_INCREMENT COMMENT '控制器类型',AUTO_INCREMENT=5;
--
-- 限制导出的表
--

--
-- 限制表 `controller`
--
ALTER TABLE `controller`
ADD CONSTRAINT `controller_ibfk_1` FOREIGN KEY (`deviceId`) REFERENCES `devices` (`deviceId`) ON DELETE CASCADE,
ADD CONSTRAINT `controller_ibfk_2` FOREIGN KEY (`typeId`) REFERENCES `type` (`typeId`);

--
-- 限制表 `devices`
--
ALTER TABLE `devices`
ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `account` (`username`);

--
-- 限制表 `logbook`
--
ALTER TABLE `logbook`
ADD CONSTRAINT `logbook_ibfk_1` FOREIGN KEY (`username`) REFERENCES `account` (`username`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
