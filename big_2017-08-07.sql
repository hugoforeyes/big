# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17)
# Database: big
# Generation Time: 2017-08-07 00:03:54 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table vf_article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_article`;

CREATE TABLE `vf_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `lang` char(2) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `preview` text NOT NULL,
  `content` mediumtext NOT NULL,
  `pic_thumb` varchar(255) DEFAULT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `hot` tinyint(1) NOT NULL DEFAULT '0',
  `prop` text,
  `meta` text,
  `ordering` int(11) unsigned NOT NULL DEFAULT '0',
  `created` int(4) unsigned NOT NULL DEFAULT '0',
  `modified` int(4) unsigned NOT NULL DEFAULT '0',
  `published` int(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vf_article` WRITE;
/*!40000 ALTER TABLE `vf_article` DISABLE KEYS */;

INSERT INTO `vf_article` (`id`, `cid`, `lang`, `title`, `alias`, `preview`, `content`, `pic_thumb`, `hits`, `hot`, `prop`, `meta`, `ordering`, `created`, `modified`, `published`)
VALUES
	(1,2,'','About','about','','<p>Founded in 2010, B.I.G INTERNATIONAL is a local sourcing company. We manage the global sourcing requirements of customers from all over the world, providing them the services as on demand. Our services are known for sourcing community products with strong suppliers network in Vietnam and South East Asia. We have been quite successful in outdoor and indoor products with various kinds of materials.</p>\r\n<p>B.I.G INTERNATIONAL currently serves DIY retailers Market in Europe, specific Germany, and third party services for North America Importers.</p>\r\n<p>Our Mission:</p>\r\n<p>Together with Buyers, we want to satisfy the end users around the world.</p>','2017/about1.jpg',281,0,NULL,NULL,0,1490681808,1501424320,1501424320),
	(2,2,'','Quality','quality','','<p><span class=\"content_type1_header\">B.I.G International</span> <span class=\"content_type1_header4\">is Quality!</span></p>\r\n<p>We are a dynamic product development company offering innovative solutions which commercially delight our customers and enable them to better differentiate from their competition. We are trusted product consultants and partners who are passionate about furniture and home.</p>\r\n<p> </p>','2017/about3.jpg',20,0,NULL,NULL,0,1490683198,1490935484,1490683185),
	(3,2,'','B.I.G International is Furniture!','about-big','','<p><span class=\"content_type1_header\">B.I.G International</span> <span class=\"content_type1_header4\">is Furniture!</span></p>\r\n<p>We are a dynamic product development company offering innovative solutions which commercially delight our customers and enable them to better differentiate from their competition. We are trusted product consultants and partners who are passionate about furniture and home.</p>\r\n<p> </p>','2017/about2.jpg',23,0,NULL,NULL,0,1490683271,1501424326,1501424326),
	(4,5,'','Contact','contact','','<p><span class=\"content_type5_header\">Vietnam Office<br />B.I.G International</span></p>\r\n<p>2/7 Nguyen Thanh Y, Da kao ward,<br />Dist. 1, Ho Chi Minh city, Vietnam<br />Phone: +84 945 507 788 – Fax: +84 8 73001215<br />Info@big-international.com<br />www.big-international.com</p>\r\n<p> </p>\r\n<p><span class=\"content_type5_header\">Australia Office</span></p>\r\n<p>270 Highett Rd, Highett VIC 3190, Australia</p>','2017/contact.jpg',151,0,NULL,NULL,0,1490687087,1490691628,1490687033),
	(5,3,'','Service','service','','<p><span class=\"content_type1_header\">Our Services</span></p>\r\n<p><span class=\"content_type1_subheader\">Sourcing agent service</span></p>\r\n<p><span class=\"content_type1_subheader\">Technical services</span></p>\r\n<ul>\r\n<li>Product construction review and advice</li>\r\n<li>Packaging solution</li>\r\n</ul>\r\n<p><span class=\"content_type1_subheader\">Third-party service</span></p>\r\n<ul>\r\n<li>Factory Audit/ assessment</li>\r\n<li>Inspection</li>\r\n</ul>','2017/service.jpg',273,0,NULL,NULL,0,1490689532,1491817816,1490688667),
	(6,6,'','Career','career','','<p>Career</p>\r\n<p>The only way to really appreciate the merits of a product, or a range of products is to see them and test how they fit your needs. </p>','2017/showroom.jpg',169,0,NULL,NULL,0,1490692268,1501989908,1501989908);

/*!40000 ALTER TABLE `vf_article` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vf_banner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_banner`;

CREATE TABLE `vf_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `prop` text,
  `count` smallint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vf_banner` WRITE;
/*!40000 ALTER TABLE `vf_banner` DISABLE KEYS */;

INSERT INTO `vf_banner` (`id`, `title`, `prop`, `count`)
VALUES
	(1,'Trang chủ',NULL,5);

/*!40000 ALTER TABLE `vf_banner` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vf_banners
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_banners`;

CREATE TABLE `vf_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `tip` varchar(255) NOT NULL DEFAULT '',
  `content` text,
  `note` varchar(255) NOT NULL DEFAULT '',
  `imageurl` varchar(255) NOT NULL DEFAULT '',
  `width` smallint(2) unsigned NOT NULL DEFAULT '0',
  `height` smallint(2) unsigned NOT NULL DEFAULT '0',
  `clickurl` varchar(255) NOT NULL DEFAULT '',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `impressions` int(11) DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vf_banners` WRITE;
/*!40000 ALTER TABLE `vf_banners` DISABLE KEYS */;

INSERT INTO `vf_banners` (`id`, `pid`, `title`, `tip`, `content`, `note`, `imageurl`, `width`, `height`, `clickurl`, `clicks`, `impressions`, `created`, `modified`, `ordering`, `published`)
VALUES
	(1,1,'1','',NULL,'','b/1.jpg',962,362,'',0,0,1490677089,1490929615,1,1490929612),
	(2,1,'2','',NULL,'','b/2.jpg',962,500,'',0,0,1490677102,1490677102,2,1490929745),
	(3,1,'3','',NULL,'','b/4.jpg',962,500,'',0,0,1490677113,1490677113,3,1490929746),
	(4,1,'4','',NULL,'','b/6.jpg',962,500,'',0,0,1490677120,1490677120,4,1490929747),
	(5,1,'5','',NULL,'','b/8.jpg',962,500,'',0,0,1490677126,1490677126,5,1490929748);

/*!40000 ALTER TABLE `vf_banners` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vf_blocks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_blocks`;

CREATE TABLE `vf_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lang` char(2) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `ctype` varchar(100) NOT NULL DEFAULT '',
  `pos` varchar(10) NOT NULL DEFAULT '',
  `page` varchar(255) NOT NULL DEFAULT '',
  `page2` tinyint(1) NOT NULL DEFAULT '0',
  `auth` tinyint(1) NOT NULL DEFAULT '0',
  `prop` text,
  `ordering` smallint(2) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vf_blocks` WRITE;
/*!40000 ALTER TABLE `vf_blocks` DISABLE KEYS */;

INSERT INTO `vf_blocks` (`id`, `sid`, `lang`, `title`, `ctype`, `pos`, `page`, `page2`, `auth`, `prop`, `ordering`, `enabled`)
VALUES
	(1,0,'','~Logo','code','HDR','',0,0,'htm=<div id=\"mainlogo\" class=\"logo-wp\"><a href=\"{URL_BASE}\"><img src=\"logo.png\" alt=\"\" height=\"83\" border=\"0\" /></a></div>',9,1),
	(2,0,'','~Main menu','menu','HDR','',0,0,'src=\nsel=1\nsub=0\nimg=\ncss=\ntpl=',11,1),
	(3,0,'','~Banner trang chủ','banner','P02',',1,',0,0,'src=1\nnum=10\ntyp=rnd\ntit=\nctn=\nimp=\ncli=\najx=0\ncss=\ntag=h3\ntpl=',8,1),
	(4,0,'','~Copyright','code','P08','',0,0,'htm=Copyright © 2017 B.I.G International. All rights reserved.',7,1),
	(5,0,'','~Home footer 1','html','P07',',1,',0,0,'htm=<div class=\"item-img\"><img src=\"home1.gif\" alt=\"\" border=\"0\" /></div>\\n<div class=\"item-content\">\\n<div class=\"item-title\" style=\"top: 33px;\">\\n<div>B.I.G International is Furniture!</div>\\n<br /><br /></div>\\n<div class=\"learnmore\"><a href=\"{URL_BASE}about/about-big.html\">Learn more ▶</a></div>\\n</div>\ncss=col-md-4 col-sm-6 col-xs-12 item\ntag=h3',4,1),
	(6,0,'','~Home footer 2','html','P07',',1,',0,0,'htm=<div class=\"item-seperate\"><img src=\"bottombar-div.gif\" alt=\"\" width=\"3\" height=\"104\" border=\"0\" /></div>\\n<div class=\"item-img\"><img src=\"home2.gif\" alt=\"\" border=\"0\" /></div>\\n<div class=\"item-content\">\\n<div class=\"item-title\" style=\"top: 33px;\">\\n<div>Quality</div>\\n</div>\\n<div class=\"learnmore\"><a href=\"{URL_BASE}about/quality.html\">Learn more ▶</a></div>\\n</div>\ncss=col-md-4 col-sm-6 col-xs-12 item next\ntag=h3',5,1),
	(7,0,'','~Home footer 3','html','P07',',1,',0,0,'htm=<div class=\"item-seperate visible-md visible-lg\"><img src=\"bottombar-div.gif\" alt=\"\" width=\"3\" height=\"104\" border=\"0\" /></div>\\n<div class=\"item-img\"><img src=\"home3.gif\" alt=\"\" border=\"0\" /></div>\\n<div class=\"item-content\">\\n<div class=\"item-title\" style=\"top: 33px;\">\\n<div>Products</div>\\n</div>\\n<div class=\"item-desc\">View some of the products that we have sourced....</div>\\n<div class=\"learnmore\"><a href=\"{URL_BASE}products/\">Learn more ▶</a></div>\\n</div>\ncss=col-md-4 col-sm-6 col-xs-12 item next last\ntag=h3',6,1),
	(8,0,'','~Menu product','menu','P01',',4,7,8,9,10,',0,0,'src=7|8|9|10\nsel=1\nsub=0\nimg=\ncss=\ntpl=blk_menu_product',3,1),
	(9,0,'','~Products intro text','html','P03',',4,',0,0,'htm=<p>These are just some of the products that we have sourced. If you have any questions or require further information, please do not hesitate to contact us at <a href=\"mailto:info@big-international.com\">info@big-international.com</a></p>\ncss=\ntag=h3',2,1),
	(10,0,'','~Products cat','menu','P04',',4,',0,0,'src=7|8|9|10\nsel=1\nsub=0\nimg=\ncss=\ntpl=blk_menu_cat',1,1),
	(11,0,'','~Social icon','html','HDR','',0,0,'htm=<p><a href=\"#\"><img src=\"facebook.png\" alt=\"\" /></a><a href=\"#\"><img src=\"instagram.png\" alt=\"\" /></a><a href=\"#\"><img src=\"twitter.png\" alt=\"\" /></a><a href=\"#\"><img src=\"pinterest.png\" alt=\"\" /></a></p>\ncss=#social social-wp\ntag=h3',10,1);

/*!40000 ALTER TABLE `vf_blocks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vf_contact
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_contact`;

CREATE TABLE `vf_contact` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `prop` text,
  `created` int(4) unsigned NOT NULL DEFAULT '0',
  `unread` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table vf_ctype
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_ctype`;

CREATE TABLE `vf_ctype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `func` tinyint(1) NOT NULL DEFAULT '0',
  `prop` text,
  `ctype` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vf_ctype` WRITE;
/*!40000 ALTER TABLE `vf_ctype` DISABLE KEYS */;

INSERT INTO `vf_ctype` (`id`, `name`, `func`, `prop`, `ctype`, `enabled`)
VALUES
	(1,'search',0,'src=pages\ntyp=get|post\ncss=string\ntpl=tpl',0,1),
	(2,'search',0,'typ=post|get\nrel=page\ncss=string\ntpl=tpl',1,1),
	(3,'sitemap',0,'src=pages\nnum=int',0,1),
	(4,'nav',0,'nav=0|1|2\nnah=bool\npat=bool\nvie=0|1|2\ncon=string\ncss=string',1,1),
	(5,'menu',0,'src=pages\nsel=bool\nsub=int\nimg=bool\ncss=string\ntpl=text\ntpl=tpl',1,1),
	(6,'html',0,'htm=html\ncss=string\ntag=h3|h4|h5|h6|h2|h1|div|p',1,1),
	(7,'alias',0,'url=string',0,1),
	(8,'null',0,'',0,1),
	(9,'code',0,'htm=htm',1,1),
	(10,'fileman',1,'',2,1),
	(11,'ping',1,'',2,1),
	(12,'staff',1,'change_pass=\"staff&t=password\"\nchange_lang=\"staff&t=lang\"',2,1),
	(13,'article',1,'typ=1|2|3\npic_thumb=bool\n~pic_thumb_sz=size\npre=bool\nod=published|created|modified|id|ordering\n~od2=DESC|ASC\ndat=|published|created|modified\ncat=int\nhot=int\npag=int\nnxt=int\n~prv=int\nseo=bool\ncss=string\next=text\ntpl=tpl',0,1),
	(14,'article',0,'typ=hot|new|top|rnd\nsrc=pages\nhot=int\nnum=int\nimg=bool\npre=bool\najx=bool\ncss=string\ntag=h3|h4|h5|h6|h2|h1|div|p\ntpl=tpl',1,1),
	(15,'contact',1,'eml=string\ncss=string\next=text\ntpl=tpl',0,1),
	(16,'banner',1,'src=record\nnum=int\ntyp=rnd|ord\ntit=bool\nctn=bool\nimp=bool\ncli=bool\najx=0|10|20|30|60|120|300\ncss=string\ntag=h3|h4|h5|h6|h2|h1|div|p\ntpl=tpl',1,1),
	(17,'banner',1,'',2,1),
	(18,'gallery',1,'typ=2|3\npic_thumb_sz=size\npic_full_sz=size\ntit=bool\nmti=bool\npre=bool\nctn=bool\nod=published|created|modified|id|ordering\n~od2=DESC|ASC\ndat=|published|created|modified\ncat=int\npag=int\nnxt=int\next=text\ncss=string\ntpl=tpl',0,1),
	(19,'gallery',0,'typ=hot|new|top|rnd\nsrc=pages\nthumb=bool\npre=bool\nnum=int\ncss=string\ntag=h3|h4|h5|h6|h2|h1|div|p\ntpl=tpl',1,1);

/*!40000 ALTER TABLE `vf_ctype` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vf_gallery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_gallery`;

CREATE TABLE `vf_gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `pic_thumb` varchar(255) NOT NULL DEFAULT '',
  `pic_full` text NOT NULL,
  `pic_full_tit` text NOT NULL,
  `preview` tinytext NOT NULL,
  `content` text NOT NULL,
  `hot` tinyint(1) NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `prop` text NOT NULL,
  `meta` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ordering` int(11) unsigned NOT NULL DEFAULT '0',
  `created` int(11) unsigned NOT NULL DEFAULT '0',
  `modified` int(11) unsigned NOT NULL DEFAULT '0',
  `published` int(11) unsigned NOT NULL DEFAULT '0',
  `pic1` varchar(255) DEFAULT '',
  `pic2` varchar(255) DEFAULT NULL,
  `pic3` varchar(255) DEFAULT NULL,
  `pic4` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vf_gallery` WRITE;
/*!40000 ALTER TABLE `vf_gallery` DISABLE KEYS */;

INSERT INTO `vf_gallery` (`id`, `cid`, `title`, `alias`, `pic_thumb`, `pic_full`, `pic_full_tit`, `preview`, `content`, `hot`, `hits`, `prop`, `meta`, `ordering`, `created`, `modified`, `published`, `pic1`, `pic2`, `pic3`, `pic4`)
VALUES
	(1,7,'Ghế dài 1','ghe-dai-1','2017/ghe-dai-1-s.png','2017/ghe-dai-1.png','','Ghế dài gỗ','',0,0,'','',0,1490778249,1490778278,1490778217,NULL,NULL,NULL,NULL),
	(2,7,'Ghế dài 2','ghe-dai-2','2017/ghe-dai-2-s.png','2017/ghe-dai-2.png','','Ghế dài có nệm','',0,0,'','',0,1490778311,1490778311,1490778283,NULL,NULL,NULL,NULL),
	(3,7,'Bàn 1','ban-1','2017/ban-1-s.png','2017/ban-1.png','','Bàn gỗ 1','',0,0,'','',0,1490778341,1490778341,1490778314,NULL,NULL,NULL,NULL),
	(4,7,'Daybed with integrated  table','daybed-with-integrated-table','2017/ghe-dai-nho.jpg','2017/ghe-dai-nho_1.jpg','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1490842755,1493798124,1490778217,NULL,NULL,NULL,NULL),
	(5,7,'Ghế dài vintage','ghe-dai-vintage','2017/ghe-dai.jpg','2017/ghe-dai_1.jpg','','Ghế dài vintage','',0,0,'','',0,1490843509,1490843509,1490843482,NULL,NULL,NULL,NULL),
	(6,7,'Sun Lounger','sun-lounger','2017/truong-ky.jpg','2017/truong-ky_1.jpg','','Description: Dimension: 64x160x78cm Flat wicker 7mm Steel frame, powder coating 180 grs polyester fabric, Seat cushion 3 cm','',0,0,'','',0,1490844215,1493798424,1490844128,NULL,NULL,NULL,NULL),
	(7,7,'Bàn 2','ban-2','2017/ban-2-s.png','2017/ban-2.png','','Bàn gỗ trắng','',0,0,'','',0,1490844882,1490844882,1490844856,NULL,NULL,NULL,NULL),
	(8,7,'Ghế 2','ghe-2','2017/ghe-2-s.png','2017/ghe-2.png','','Ghế gỗ dựa màu trắng','',0,0,'','',0,1490844941,1490844941,1490844899,NULL,NULL,NULL,NULL),
	(9,7,'oldable wooden 2 seater bench','oldable-wooden-2-seater-bench','2017/ghe-go.jpg','2017/ghe-go_1.jpg','','Product information: foldable wooden 2 seater bench\r\n Description: FSC 100% acacia item size: 127 x 52 x 81 cm,  oil finish,  Galvanized / Stainless steel hardwar','',0,0,'','',0,1490846860,1493798178,1490846841,NULL,NULL,NULL,NULL),
	(10,7,'Ghế mây dài','ghe-may-dai','2017/anh-dep-cho-dien-thoai-2_3.jpg','2017/anh-dep-cho-dien-thoai-2_1.jpg','','Ghế mây nằm','',0,0,'','',0,1490846991,1502016825,1490846940,'2017/screen_shot_2017-06-11_at_7.33.59_pm.png','','',''),
	(11,7,'Daybed with integrated  table','daybed-with-integrated-table-1','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993636,1501993636,1490778217,NULL,NULL,NULL,NULL),
	(12,7,'Daybed with integrated  table','daybed-with-integrated-table-1-1','2017/logo76.png','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993663,1501993663,1490778217,NULL,NULL,NULL,NULL),
	(13,7,'Daybed with integrated  table','daybed-with-integrated-table-1-2','2017/logo80.png','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993694,1501993694,1490778217,NULL,NULL,NULL,NULL),
	(14,7,'Daybed with integrated  table','daybed-with-integrated-table-1-3','2017/logo1.png','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993702,1501993702,1490778217,NULL,NULL,NULL,NULL),
	(15,7,'Daybed with integrated  table','daybed-with-integrated-table-1-4','2017/logo1_1.png','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993713,1501993713,1490778217,NULL,NULL,NULL,NULL),
	(16,7,'Daybed with integrated  table','daybed-with-integrated-table-1-5','2017/logo1_2.png','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993726,1501993726,1490778217,NULL,NULL,NULL,NULL),
	(17,7,'Daybed with integrated  table','daybed-with-integrated-table-1-5-1','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993790,1501993790,1490778217,NULL,NULL,NULL,NULL),
	(18,7,'Daybed with integrated  table','daybed-with-integrated-table-1-5-1-1','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993796,1501993796,1490778217,NULL,NULL,NULL,NULL),
	(19,7,'Daybed with integrated  table','daybed-with-integrated-table-1-5-1-1-1','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993800,1501993800,1490778217,NULL,NULL,NULL,NULL),
	(20,7,'Daybed with integrated  table','daybed-with-integrated-table-1-5-1-1-1-1','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993805,1501993805,1490778217,NULL,NULL,NULL,NULL),
	(21,7,'Daybed with integrated  table','daybed-with-integrated-table-1-6','2017/friday.png','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993809,1501994037,1490778217,NULL,NULL,NULL,NULL),
	(22,7,'Daybed with integrated  table','daybed-with-integrated-table-1-7','2017/friday_1.png','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993813,1501994049,1490778217,NULL,NULL,NULL,NULL),
	(23,7,'Daybed with integrated  table','daybed-with-integrated-table-1-8','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993816,1501993816,1490778217,NULL,NULL,NULL,NULL),
	(24,7,'Daybed with integrated  table','daybed-with-integrated-table-1-9','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993820,1501993820,1490778217,NULL,NULL,NULL,NULL),
	(25,7,'Daybed with integrated  table','daybed-with-integrated-table-1-10','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993824,1501993824,1490778217,NULL,NULL,NULL,NULL),
	(26,7,'Daybed with integrated  table','daybed-with-integrated-table-1-11','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993827,1501993827,1490778217,NULL,NULL,NULL,NULL),
	(27,7,'Daybed with integrated  table','daybed-with-integrated-table-1-12','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993830,1501993830,1490778217,NULL,NULL,NULL,NULL),
	(28,7,'Daybed with integrated  table','daybed-with-integrated-table-1-13','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993834,1501993834,1490778217,NULL,NULL,NULL,NULL),
	(29,7,'Daybed with integrated  table','daybed-with-integrated-table-1-14','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993838,1501993838,1490778217,NULL,NULL,NULL,NULL),
	(30,7,'Daybed with integrated  table','daybed-with-integrated-table-1-15','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993841,1501993841,1490778217,NULL,NULL,NULL,NULL),
	(31,7,'Daybed with integrated  table','daybed-with-integrated-table-1-16','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993843,1501993843,1490778217,NULL,NULL,NULL,NULL),
	(32,7,'Daybed with integrated  table','daybed-with-integrated-table-1-17','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993846,1501993846,1490778217,NULL,NULL,NULL,NULL),
	(33,7,'Daybed with integrated  table','daybed-with-integrated-table-1-18','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993850,1501993850,1490778217,NULL,NULL,NULL,NULL),
	(34,7,'Daybed with integrated  table','daybed-with-integrated-table-1-19','','','','Product information: Daybed with integrated  table \r\nDescription: Daybed: 202/180x65.5x87cm Galvanized hardware/Stainless Steel, Cushion 100% polyester 180gr/m2 thickness 7 cm ( seat+back ) Acacia FSC 100%','',0,0,'','',0,1501993853,1501993853,1490778217,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `vf_gallery` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vf_sitemap
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_sitemap`;

CREATE TABLE `vf_sitemap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `alias` varchar(100) NOT NULL DEFAULT '',
  `ctype` varchar(50) NOT NULL DEFAULT '',
  `pic_thumb` varchar(255) DEFAULT NULL,
  `auth` tinyint(1) NOT NULL DEFAULT '0',
  `prop` text,
  `tree` text,
  `meta` text,
  `count` smallint(3) unsigned NOT NULL DEFAULT '0',
  `ordering` smallint(2) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vf_sitemap` WRITE;
/*!40000 ALTER TABLE `vf_sitemap` DISABLE KEYS */;

INSERT INTO `vf_sitemap` (`id`, `sid`, `pid`, `title`, `alias`, `ctype`, `pic_thumb`, `auth`, `prop`, `tree`, `meta`, `count`, `ordering`, `enabled`)
VALUES
	(1,0,0,'Home','/','null','',0,NULL,'l=0\nf=\nc=\np=','t=\nk=\nd=',0,1,1),
	(2,0,0,'About us','about','article','',0,'typ=1\npic_thumb=1\npic_thumb_sz=685|362\npre=\nod=published\nod2=DESC\ndat=\ncat=0\nhot=0\npag=0\nnxt=0\nprv=0\nseo=\ncss=\next=\ntpl=article_bigpic','l=0\nf=\nc=\np=','t=\nk=\nd=',3,2,1),
	(3,0,0,'Service','service','article','',0,'typ=1\npic_thumb=1\npic_thumb_sz=685|362\npre=\nod=published\nod2=DESC\ndat=\ncat=0\nhot=0\npag=0\nnxt=0\nprv=0\nseo=\ncss=\next=\ntpl=article_bigpic','l=0\nf=\nc=\np=','t=\nk=\nd=',1,3,1),
	(4,0,0,'Products','products','null','',0,NULL,'l=0\nf=7,8,9,10\nc=7,8,9,10\np=','t=\nk=\nd=',0,4,1),
	(5,0,0,'Contact us','contact','article','',0,'typ=1\npic_thumb=1\npic_thumb_sz=685|362\npre=\nod=published\nod2=DESC\ndat=\ncat=0\nhot=0\npag=0\nnxt=0\nprv=0\nseo=\ncss=\next=\ntpl=article_contact','l=0\nf=\nc=\np=','t=\nk=\nd=',1,10,1),
	(7,0,4,'Out-Door','out-door','gallery','s/outdoor.jpg',0,'typ=2\npic_thumb_sz=70|70\npic_full_sz=1024|800\ntit=\nmti=\npre=1\nctn=\nod=published\nod2=DESC\ndat=\ncat=0\npag=0\nnxt=0\next=\ncss=\ntpl=','l=1\nf=\nc=\np=4','t=\nk=\nd=',10,5,1),
	(6,0,0,'Career','career','article','',0,'typ=1\npic_thumb=1\npic_thumb_sz=685|362\npre=\nod=published\nod2=DESC\ndat=\ncat=0\nhot=0\npag=0\nnxt=0\nprv=0\nseo=\ncss=\next=\ntpl=article_bigpic','l=0\nf=\nc=\np=','t=\nk=\nd=',1,9,0),
	(8,0,4,'In-Door','in-door','gallery','s/indoor.jpg',0,'typ=2\npic_thumb_sz=70|70\npic_full_sz=1024|800\ntit=\nmti=\npre=1\nctn=\nod=published\nod2=DESC\ndat=\ncat=0\npag=0\nnxt=0\next=\ncss=\ntpl=','l=1\nf=\nc=\np=4','t=\nk=\nd=',0,6,1),
	(9,0,4,'Bathroom','bathroom','gallery','s/bathroom.jpg',0,'typ=2\npic_thumb_sz=70|70\npic_full_sz=1024|800\ntit=\nmti=\npre=1\nctn=\nod=published\nod2=DESC\ndat=\ncat=0\npag=0\nnxt=0\next=\ncss=\ntpl=','l=1\nf=\nc=\np=4','t=\nk=\nd=',0,7,1),
	(10,0,4,'Decoration','decoration','gallery','s/decoration.jpg',0,'typ=2\npic_thumb_sz=70|70\npic_full_sz=1024|800\ntit=\nmti=\npre=1\nctn=\nod=published\nod2=DESC\ndat=\ncat=0\npag=0\nnxt=0\next=\ncss=\ntpl=','l=1\nf=\nc=\np=4','t=\nk=\nd=',0,8,1);

/*!40000 ALTER TABLE `vf_sitemap` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vf_staff
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_staff`;

CREATE TABLE `vf_staff` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lang` char(2) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL,
  `log_sid` varchar(32) DEFAULT NULL,
  `log_time` int(11) NOT NULL DEFAULT '0',
  `log_expire` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(15) DEFAULT NULL,
  `prop` text,
  `created` int(4) NOT NULL DEFAULT '0',
  `modified` int(4) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vf_staff` WRITE;
/*!40000 ALTER TABLE `vf_staff` DISABLE KEYS */;

INSERT INTO `vf_staff` (`id`, `username`, `password`, `level`, `lang`, `email`, `log_sid`, `log_time`, `log_expire`, `ip`, `prop`, `created`, `modified`, `enabled`)
VALUES
	(1,'vip','232059cb5361a9336ccf1b8c2ba7657a',2,'vn','','b65597dc24f6150c363322612e161a6e',1491883358,1491889478,'14.169.182.77',NULL,0,0,1),
	(2,'uytin','9e3669d19b675bd57058fd4664205d2a',2,'en','','fa985e4ae028ed7fbc3a62b019aa9b15',1490936916,1490940703,'14.169.193.16',NULL,0,0,1),
	(3,'trang','1e184ab537f0d6d6d94bbb5790b1fee0',1,'','','97460a7e9507588998c8daf60c65a0a9',1490846841,1490850460,'14.169.193.16',NULL,1490839905,1490839905,1),
	(4,'Bigadmin','a573de650eeda72921c38019d1faa1bc',1,'vn','','c6d901bac1b72fc83bb76cfbbdfe96ea',1502016804,1502021037,'127.0.0.1',NULL,1490849514,1490928986,1);

/*!40000 ALTER TABLE `vf_staff` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vf_staff_grp
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_staff_grp`;

CREATE TABLE `vf_staff_grp` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `prop` text,
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `vf_staff_grp` WRITE;
/*!40000 ALTER TABLE `vf_staff_grp` DISABLE KEYS */;

INSERT INTO `vf_staff_grp` (`id`, `title`, `prop`, `readonly`)
VALUES
	(1,'Administrator','access=1\nedit=1\ndelete=1\ncreate=1\npublish=1\nmove=1\nown=1\nmanage=1',1),
	(2,'Moderator','access=1\nedit=1\ndelete=0\ncreate=1\npublish=1\nmove=1\nown=0\nmanage=0',1),
	(3,'Publisher','access=1\nedit=1\ndelete=0\ncreate=1\npublish=1\nmove=0\nown=0\nmanage=0',1),
	(4,'Editor','access=1\nedit=1\ndelete=0\ncreate=1\npublish=0\nmove=0\nown=0\nmanage=0',1);

/*!40000 ALTER TABLE `vf_staff_grp` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vf_staff_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vf_staff_logs`;

CREATE TABLE `vf_staff_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff` int(11) NOT NULL DEFAULT '0',
  `page` varchar(50) NOT NULL DEFAULT '',
  `task` varchar(50) NOT NULL DEFAULT '',
  `prop` text,
  `created` int(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
