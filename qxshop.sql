-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-02-08 10:49:43
-- 服务器版本： 8.0.12
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `qxshop`
--

-- --------------------------------------------------------

--
-- 表的结构 `qx_addproduct`
--

CREATE TABLE `qx_addproduct` (
  `jid` int(20) NOT NULL COMMENT '进货编号',
  `supplierMark` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '供应商编号',
  `productMark` varchar(13) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '商品编号',
  `productNum` int(10) NOT NULL COMMENT '商品数量',
  `totalMoney` decimal(10,1) NOT NULL COMMENT '总价',
  `satime` int(20) NOT NULL DEFAULT '0' COMMENT '进货时间',
  `sltime` int(20) NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '进货状态'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `qx_addproduct`
--

INSERT INTO `qx_addproduct` (`jid`, `supplierMark`, `productMark`, `productNum`, `totalMoney`, `satime`, `sltime`, `status`) VALUES
(2, '202102059948', '1', 10, '230.0', 1612596581, 0, 1),
(3, '202102059948', '2', 10, '100.0', 1612596581, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `qx_admin`
--

CREATE TABLE `qx_admin` (
  `id` smallint(10) UNSIGNED NOT NULL COMMENT '管理ID',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '管理名称',
  `pw` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '管理密码',
  `atime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
  `ltime` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `type` int(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '管理员类型'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `qx_admin`
--

INSERT INTO `qx_admin` (`id`, `name`, `pw`, `atime`, `ltime`, `type`) VALUES
(7, 'admin', 'd23cf937aa50836cd6ab2f83a5a932b1', 1612333125, 1612683170, 1),
(3, '测试账号001', 'd23cf937aa50836cd6ab2f83a5a932b1', 1611473479, 1611633127, 0),
(4, '测试账号002', 'd23cf937aa50836cd6ab2f83a5a932b1', 1611473491, 1611473491, 1);

-- --------------------------------------------------------

--
-- 表的结构 `qx_category`
--

CREATE TABLE `qx_category` (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT '分类编号',
  `pid` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父级编号',
  `catname` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '分类名称',
  `ord` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `qx_category`
--

INSERT INTO `qx_category` (`id`, `pid`, `catname`, `ord`) VALUES
(2, 0, '外墙乳胶漆', 2),
(1, 0, '内墙乳胶漆', 1),
(3, 0, '木器漆', 3),
(4, 0, '金属漆', 4),
(5, 0, '基材/工具', 5),
(6, 0, '艺术漆', 6),
(7, 0, '底漆', 7),
(8, 0, '防水产品', 8),
(9, 0, '花纹漆', 9);

-- --------------------------------------------------------

--
-- 表的结构 `qx_client`
--

CREATE TABLE `qx_client` (
  `clientName` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '客户姓名',
  `clientType` int(1) NOT NULL DEFAULT '0' COMMENT '客户类型',
  `clientPhone` char(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '联系方式',
  `clientProvince` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '省',
  `clientCity` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '市',
  `clientBlock` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '区',
  `clientDetailAddress` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '详细地址',
  `atime` int(20) NOT NULL DEFAULT '0' COMMENT '客户添加时间',
  `ltime` int(20) NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `cid` int(5) NOT NULL COMMENT '客户ID'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `qx_client`
--

INSERT INTO `qx_client` (`clientName`, `clientType`, `clientPhone`, `clientProvince`, `clientCity`, `clientBlock`, `clientDetailAddress`, `atime`, `ltime`, `cid`) VALUES
('沈大', 0, '78946513213', '海南省', '海口市', '秀英区', '市政府旁', 1612498097, 0, 4);

-- --------------------------------------------------------

--
-- 表的结构 `qx_product`
--

CREATE TABLE `qx_product` (
  `productName` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '商品名称',
  `saleMoney` decimal(10,1) NOT NULL COMMENT '销售价格',
  `costMoney` decimal(10,1) NOT NULL COMMENT '产品进价',
  `productMark` int(20) NOT NULL COMMENT '商品编号',
  `volume` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '商品体积',
  `weight` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '商品规格',
  `atime` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '发布时间',
  `ltime` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `inventoryNum` int(3) NOT NULL DEFAULT '0' COMMENT '商品库存',
  `saleNum` int(5) NOT NULL DEFAULT '0' COMMENT '商品销售',
  `cid` smallint(5) NOT NULL COMMENT '商品分类'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `qx_product`
--

INSERT INTO `qx_product` (`productName`, `saleMoney`, `costMoney`, `productMark`, `volume`, `weight`, `atime`, `ltime`, `inventoryNum`, `saleNum`, `cid`) VALUES
('测试油漆', '45.0', '23.0', 1, '20', 'kg/包', '1612595425', '0', 10, 10, 1),
('测试防水', '30.0', '10.0', 2, '50', 'KG/桶', '1612595517', '0', 10, 10, 8);

-- --------------------------------------------------------

--
-- 表的结构 `qx_supplier`
--

CREATE TABLE `qx_supplier` (
  `supplierName` varchar(25) COLLATE utf8_unicode_ci NOT NULL COMMENT '供应商名',
  `province` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '省份',
  `city` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '市（县）',
  `block` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '区',
  `detailAddress` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '详细地址',
  `contactName` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人姓名',
  `contactPhone` varchar(11) COLLATE utf8_unicode_ci NOT NULL COMMENT '联系人电话',
  `supplierMark` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '供应商编号'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `qx_supplier`
--

INSERT INTO `qx_supplier` (`supplierName`, `province`, `city`, `block`, `detailAddress`, `contactName`, `contactPhone`, `supplierMark`) VALUES
('银河帝国涂料第一批发市场', '海南省', '海口市', '秀英区', '向上看300米', '沈大', '11111111111', '202102059948');

-- --------------------------------------------------------

--
-- 表的结构 `qx_transaction`
--

CREATE TABLE `qx_transaction` (
  `atime` int(20) NOT NULL DEFAULT '0' COMMENT '交易添加时间',
  `ltime` int(20) NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `totalMoney` decimal(10,1) NOT NULL COMMENT '交易总额',
  `payWay` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '支付方式',
  `payee` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '收款人',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '交易状态',
  `tid` int(10) UNSIGNED NOT NULL COMMENT '交易ID',
  `cid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客户ID',
  `productMark` int(20) UNSIGNED NOT NULL COMMENT '商品ID',
  `oid` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '订单ID',
  `TransactionNum` int(5) NOT NULL COMMENT '交易数量'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `qx_transaction`
--

INSERT INTO `qx_transaction` (`atime`, `ltime`, `totalMoney`, `payWay`, `payee`, `status`, `tid`, `cid`, `productMark`, `oid`, `TransactionNum`) VALUES
(1612599109, 0, '450.0', '支付宝', '李四', 1, 22, 4, 1, '2021020608', 10),
(1612599109, 0, '300.0', '支付宝', '李四', 1, 23, 4, 2, '2021020650', 10);

--
-- 转储表的索引
--

--
-- 表的索引 `qx_addproduct`
--
ALTER TABLE `qx_addproduct`
  ADD PRIMARY KEY (`jid`),
  ADD KEY `supplierMark` (`supplierMark`),
  ADD KEY `pid` (`productMark`);

--
-- 表的索引 `qx_admin`
--
ALTER TABLE `qx_admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `qx_category`
--
ALTER TABLE `qx_category`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `qx_client`
--
ALTER TABLE `qx_client`
  ADD PRIMARY KEY (`cid`);

--
-- 表的索引 `qx_product`
--
ALTER TABLE `qx_product`
  ADD PRIMARY KEY (`productMark`),
  ADD KEY `cid` (`cid`) USING BTREE;

--
-- 表的索引 `qx_supplier`
--
ALTER TABLE `qx_supplier`
  ADD PRIMARY KEY (`supplierMark`);

--
-- 表的索引 `qx_transaction`
--
ALTER TABLE `qx_transaction`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `cid` (`cid`) USING BTREE,
  ADD KEY `pid` (`productMark`) USING BTREE,
  ADD KEY `oid` (`oid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `qx_addproduct`
--
ALTER TABLE `qx_addproduct`
  MODIFY `jid` int(20) NOT NULL AUTO_INCREMENT COMMENT '进货编号', AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `qx_admin`
--
ALTER TABLE `qx_admin`
  MODIFY `id` smallint(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '管理ID', AUTO_INCREMENT=8;

--
-- 使用表AUTO_INCREMENT `qx_category`
--
ALTER TABLE `qx_category`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类编号', AUTO_INCREMENT=20;

--
-- 使用表AUTO_INCREMENT `qx_client`
--
ALTER TABLE `qx_client`
  MODIFY `cid` int(5) NOT NULL AUTO_INCREMENT COMMENT '客户ID', AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `qx_product`
--
ALTER TABLE `qx_product`
  MODIFY `productMark` int(20) NOT NULL AUTO_INCREMENT COMMENT '商品编号', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `qx_transaction`
--
ALTER TABLE `qx_transaction`
  MODIFY `tid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '交易ID', AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
