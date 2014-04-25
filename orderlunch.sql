-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 04 月 20 日 01:54
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `orderlunch`
--
CREATE DATABASE IF NOT EXISTS `orderlunch` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `orderlunch`;

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` varchar(8) CHARACTER SET utf8 NOT NULL,
  `password` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `admin`
--



-- --------------------------------------------------------

--
-- 表的结构 `debt`
--

CREATE TABLE IF NOT EXISTS `debt` (
  `userId` varchar(8) CHARACTER SET utf8 NOT NULL,
  `debter` varchar(8) CHARACTER SET utf8 NOT NULL,
  `debt` float NOT NULL DEFAULT '0',
  KEY `userId` (`userId`,`debter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `type` varchar(2) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `menu`
--



-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderId` int(8) NOT NULL AUTO_INCREMENT,
  `userId` varchar(8) CHARACTER SET utf8 NOT NULL,
  `lunchType` varchar(2) CHARACTER SET utf8 NOT NULL,
  `time` varchar(15) CHARACTER SET utf8 NOT NULL,
  `helper` varchar(8) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `isPaid` int(1) NOT NULL DEFAULT '0',
  `actuallyPaid` float NOT NULL,
  `returnMoney` float NOT NULL,
  PRIMARY KEY (`orderId`),
  KEY `userId` (`userId`,`helper`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(8) CHARACTER SET utf8 NOT NULL,
  `password` varchar(40) CHARACTER SET utf8 NOT NULL,
  `name` varchar(10) CHARACTER SET utf8 NOT NULL,
  `email` varchar(40) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `password`, `name`, `email`) VALUES
('09333023', '3b38eeb8ddd26202b12930318a96c291', 'é™†æ³³æ–½', 'wings@qq.com'),
('10360027', 'a1564ab801c9911a07930895642c849e', 'æŽå˜‰', '229998548@qq.com'),
('10382072', '6f6d2f2d4d5d81edff55fdb7ea087608', 'é»„é”¦æµ©', 'jinhao_sysu@qq.com'),
('10383077', '2a07d0b31ac94bca3cf9e7e06b5ecdcd', 'æ¢é”¦å¹³', 'lykginy@qq.com'),
('10386019', '32f6b8b7fa3fe361b76959f4a21b0ddd', 'åˆ˜ä¼Ÿä»»', 'liuweiren.sysu+ecnc@gmail.com'),
('10388009', '94ba464a0a50a61d8c5635892669e3dd', 'å†¯æ·‘è´¤', '619542287@qq.com'),
('11301059', 'd69794bb8cd3926643e0037d44bd7116', 'é»„å˜‰è£', '306553893@qq.com'),
('11301191', '0a6bcdcd03c178833d69f08db17c408c', 'æ¨è‰³èŠ³', '1831468069@qq.com'),
('11308019', 'b93a975c01c070b764481538a5c3df2e', 'èµ–æµ·ä¸½', '1012025237@qq.com'),
('11322082', 'fa6bdca8a939af8238735341ebdf8383', 'å´æ´›æž—', '395841718@qq.com'),
('11323066', '49ab5373833a67b8620476ca32263bcf', 'æž—æ™“æ¢¦', '578333654@qq.com'),
('11331008', 'ee669e1bd91e97c29a9b288d1ee41b74', 'æ›¹ç’Ÿæ¯…', '519386150@qq.com'),
('11331027', '74c984a1fad74b0020c3c11e3ff682c7', 'é™ˆæ¶¦æ³½', '443655977@qq.com'),
('11331173', '63ca72af8f7fa9f619536bee7477bacf', 'æŽæ˜Žå®½', 'limkuan@mail2.sysu.edu.cn'),
('11331254', 'f7abb00be2dce8421f74ea6b3f8ce6c1', 'åºžæ¶¤', '1985488263@qq.com'),
('11331400', 'd6cffc9d11242f0c88685ef49a2f962d', 'å¼ è€€é”‹', '812528938@qq.com'),
('11331423', 'cccbcc7460a6e2dc8537ce0e44531e7b', 'éƒ‘é‘«ä¼Ÿ', 'kuxinwei@163.com'),
('11332028', '8e83df18e189034c957d30587361d59a', 'é’Ÿæ’', '353904974@qq.com'),
('11346008', '2987d854447afa42704fbf2bc8652e77', 'é™ˆå‰‘å›', '240904843@qq.com'),
('11346059', '2afe17397e27e17d579cfc12f9056d0b', 'æž—åŸ¹åµ©', '289215852@qq.com'),
('11346085', '005440d494e19f3e56e3ed888291cef5', 'ä¸˜è£', '394935241@qq.com'),
('11346100', 'bedad9e27f0467fb5f94b54368a1b738', 'çŽ‹è‡»', '1173447912@qq.com'),
('11346118', '9472fbdb2fa13c2a723e8f62ae6bdf00', 'é—«é‘«', 'yx_sysu@163.com'),
('11348036', 'fc498291dee3f950be7ffd1fb43c3bb2', 'ä½•å®‡', 'heyu1025@gmail.com'),
('11348043', '2821d0060a41d758d605c34833ec8970', 'é»„å˜‰åª›', 'echojk@gmail.com'),
('11348160', '821e3b1cea7c1ce66dc9d64acf9ec542', 'éƒ‘æ¦†å¨œ', '1107094301@qq.com'),
('11364102', '0860b3ac667d0ff33468430425b5d72c', 'å´å€©é’°', '759276217@qq.com'),
('11365059', 'a8535249fc9749c5202ecc3bc957f472', 'æž—èŽ¹å€©', '125629795@qq.com'),
('12301085', 'c8c18dfbae19e4b1664a0620e4a6a6ab', 'å¢æ™“æ˜Ž', '11vickey77@163.com'),
('12305017', '9b1cc2b1a8bebcac951eba73fdad1754', 'èƒ¡æ°¸æ’', 'foreverhu@outlook.com'),
('12312033', '0f3af3f7cd74d0d774b844acf15420f6', 'åˆ˜çŽ‰åŽ', '597453398@qq.com'),
('12312038', 'c0ff6597011b468ec2d2b7162f8ae2cf', 'ç››è‰º', '1240127600@qq.com'),
('12323030', 'f0e3084d125b78bfbb79b002f3bf1657', 'æŽå……', '553734986@qq.com'),
('12330017', 'a5b23a25ec238b6b3d5ffec0791abd05', 'é™ˆè¾‰', '490552355@qq.com'),
('12330018', '2a58786d93957a0dd9f2945bb29a5a06', 'é™ˆçºªäº‘', 'c940113@qq.com'),
('12330022', 'f4c42a6814eace1b6b017d656e89db19', 'é™ˆåšç”Ÿ', '793494356@qq.com'),
('12330049', 'bc058fe3fa9a0cb84871ff3abd2fa37a', 'é™ˆé¢–èª', '609918436@qq.com'),
('12330054', '63cf4379159c19e3e34ac1d0cf5db14e', 'é™ˆè·ƒä¸œ', 'chenyvehtung@gmail.com'),
('12330057', 'a9dbb6382ea3b1e85c413adf309a059f', 'é™ˆç« æ ¹', '121579293@qq.com'),
('12330097', '64b1c511fec3a06d4f11a53c873ea57c', 'éƒ­æ²›æ˜Ž', '243540060@qq.com'),
('12330191', 'fbe5ae0bec1b729bcfb509267e7cf7b1', 'å»–ä¸½æ•', '820945130@qq.com'),
('12330214', '5363f6fa29d14e7ff299207a490d1293', 'åˆ˜ç¿”å®‡', 'liuxiangyu@live.com'),
('12330416', 'ba33184699f265aec3fd7d05b983aa27', 'éƒ‘é”¦æ³½', 'a1098035@163.com'),
('12330438', 'd1336aee0fbe12fbc0499ea3b39c893f', 'æœ±æŽè®¾', '2279038262@qq.com'),
('12344001', '0fc7a3534108de802dc908b432b8cbe9', 'é™ˆæµ©æ˜Ž', '568500809@qq.com'),
('12346058', '7a5195c02870f97a6ed7ccd44d91efce', 'å»–å…´æ·¦', '451638978@qq.com'),
('12346083', 'd55e490b27e74e18d1a318c3dab6d17d', 'æ²ˆé‡‘ç”°', '978925933@qq.com'),
('12346106', '38f5d3a4538e7e3a22e2f8057a20b60a', 'è°¢å¿—æ•', '397041522@qq.com'),
('12348009', 'e6fcdf7c96e10ea39638ba1fa4114bd3', 'é™ˆå† è¾¾', 'chenguand@qq.com'),
('12348014', '452ba284404daebc8bbf2862ff93dfc8', 'é™ˆä»•åš', '2293957953@qq.com'),
('12348030', '2f0474422204911e0fa584eebe5f0a70', 'å†¯çŽ‰ç¢', '825854166@qq.com'),
('12348044', '52badd95b36720b023a566f212fbf9fe', 'æ´ªèŠèˆª', '546466206@qq.com'),
('12348050', 'c893ea8450b9bff20b483f9bb008e952', 'é»„æ€¡ç¼', '779701992@qq.com'),
('12348052', '4c22b1e2aec40b0d9f6d71d0eb5700bf', 'é»„å¿—é›„', '429141380@qq.com'),
('12348086', 'df86708f6ddad5ae2d283a25b693bbfe', 'åˆ˜æŒ¯', '943294130@qq.com'),
('12348089', '2650e5f56a957c694ae3bf566342950a', 'å•å­ä»™', '602814703@qq.com'),
('12348102', 'bbfc1c0d3936331d14bd7b0b419b1fbc', 'æ½˜æµ·æ™º', '806968607@qq.com'),
('12348136', '1429255688ed035f8a92154cadc9dfa6', 'å¾æ™“æ¬£', '747393661@qq.com'),
('12348146', '680deeb6f6e0616182aff63fabe3d61c', 'å°¹æ£®å ‚', 'zsdx20@gmail.com'),
('12348148', '56d347c325311682623d17aa6f0b7773', 'æ›¾å®ç”Ÿ', '835015151@qq.com'),
('12348156', 'a98d6d08a3b70682f1d88749a6546b31', 'å¼ ç³èŒ¹', '893374336@qq.com'),
('12348157', '1ba02df42443487bcc160a10967dabd5', 'å¼ åŸ¹åœ³', '748598157@qq.com'),
('12348165', '611450ec6d87a74648ec6d48f577470c', 'å¼ æ™“è¾‰', '714558088@qq.com'),
('12348167', '0434e523b9eb5d653f9fb1b5b09dee12', 'å¼ æ­£', '1009901205@qq.com'),
('12349009', '99d88f769daad13062e98d95a4d45164', 'å…°å¤©ç¿”', '1195159810@qq.com'),
('12349010', '842ec31a3dd94593ef65efc58d07a9e9', 'æŽå¯ŒåŽ', '597787099@qq.com'),
('12356088', '5770f9baaae99225b48889e122a92f1c', 'æ¨æ±Ÿæ™–', '619843049@qq.com'),
('12365090', 'f1e03eb50ec1a5c4abac0fba418fc04b', 'çŽ‹æ¡‚é’', '1162804796@qq.com'),
('13306053', '151c223debf83f708886692867d932ec', 'é»„é–é›¯', '1072291144@qq.com'),
('13306095', '1ef2a7d8fd91416f73a1431314cea834', 'å»–è¶…ç‡•', '1020892056@qq.com'),
('13308019', '9bfd1b31e84ae8a50c2b5f95d3061a3f', 'æŽç¿æ˜Ž', '875661581@qq.com'),
('13308037', '2e386bb4168d51369b235b79c2430882', 'è°­æ¸…å…ƒ', '1135945738@qq.com'),
('13309041', 'ba2a3bdf732e0be1ef0361c7cc670c67', 'è°¢ä¿­é”‹', '849988514@qq.com'),
('13314114', 'e70f843f3bf0e78e97fff65bf00b9b1f', 'æŽå„’è‹‘', '814053477@qq.com'),
('13316032', '855a140ba4c119b5a4fac1165770685f', 'é™ˆç©', '739211733@qq.com'),
('13324057', '3086d89ce8f88bc47177bb7ec5fdbdaa', 'æž—ç‘žç¥º', 'davina_lin@126.com'),
('13331008', '1cf8589c2129186775ba915e9a4566c6', 'é™ˆå‹ƒéœ–', '610971194@qq.com'),
('13331097', 'e6efd6b01beaebfe894745ae9d2f78b6', 'é»„æ³½è½©', '394375106@qq.com'),
('13331201', 'ef741b31be94c41cf4aa323efd286370', 'è‹—ä½³æ¬£', '358920889@qq.com'),
('13331209', 'b4b712b4ab07757f08680fe9eebb2d9d', 'å½­é€¸ç¦', '626580692@qq.com'),
('13331293', 'c28fd537c48c719f880e51808ff31905', 'è°¢æŸåŸº', '604081343@qq.com'),
('13331342', '9cf98756739ff447b06aa34c0f3d6035', 'å¼ å¤©æ™´', 'lingmaoyao@qq.com'),
('13331349', 'ff9e4c7291c10f030bbc83d4d1120494', 'å¼ æŒ¯æ–‡', '826035498@qq.com'),
('13348020', '0469c8d988b868c4dead116be2719996', 'é™ˆæ˜ å®', '1099194438@qq.com'),
('13348065', '04a6384d552c20f94660b118fd3e1f1f', 'æŽå¿ å‘', '976502029@qq.com'),
('13349132', 'c0a63491be160e63ba6bd4d180bf8f70', 'è‚–æ³½é”‹', 'xiaozf3@mail2.sysu.edu.cn'),
('13358018', 'b2a3568218c0e15684e08e819dc1a304', 'èµµæ–¹æ˜±', '776397186@qq.com');

--
-- 限制导出的表
--

--
-- 限制表 `debt`
--
ALTER TABLE `debt`
  ADD CONSTRAINT `debt_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
