/*
Navicat MySQL Data Transfer

Source Server         : 知达WIN
Source Server Version : 50520
Source Host           : 121.40.86.231:3306
Source Database       : db_cameraclub

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2015-04-21 23:41:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tbl_activities`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_activities`;
CREATE TABLE `tbl_activities` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) DEFAULT NULL,
  `end_utc` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_activities
-- ----------------------------
INSERT INTO `tbl_activities` VALUES ('6', '测试', '1439545600', '2015-04-19');

-- ----------------------------
-- Table structure for `tbl_comment`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_comment`;
CREATE TABLE `tbl_comment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `photo_id` bigint(20) DEFAULT NULL,
  `sender_id` char(64) DEFAULT NULL,
  `content` char(200) DEFAULT NULL,
  `utc` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_comment_reply`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_comment_reply`;
CREATE TABLE `tbl_comment_reply` (
  `comment_id` bigint(20) NOT NULL,
  `content` char(200) DEFAULT NULL,
  `utc` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_comment_reply
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_follow`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_follow`;
CREATE TABLE `tbl_follow` (
  `id_a` char(64) NOT NULL,
  `id_b` char(64) NOT NULL,
  PRIMARY KEY (`id_a`,`id_b`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_follow
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_label`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_label`;
CREATE TABLE `tbl_label` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `photo_id` bigint(20) NOT NULL,
  `anchor_x` int(11) DEFAULT NULL,
  `anchor_y` int(11) DEFAULT NULL,
  `content` char(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_label
-- ----------------------------
INSERT INTO `tbl_label` VALUES ('47', '70', '175', '374', '弹出框');
INSERT INTO `tbl_label` VALUES ('48', '71', '244', '151', '头盔');
INSERT INTO `tbl_label` VALUES ('49', '71', '244', '151', '头盔');
INSERT INTO `tbl_label` VALUES ('50', '71', '131', '154', '塑料袋');
INSERT INTO `tbl_label` VALUES ('51', '76', '24', '74', '车灯');
INSERT INTO `tbl_label` VALUES ('52', '76', '24', '74', '车灯');
INSERT INTO `tbl_label` VALUES ('53', '76', '121', '100', '油箱');
INSERT INTO `tbl_label` VALUES ('54', '76', '24', '74', '车灯');
INSERT INTO `tbl_label` VALUES ('55', '76', '121', '100', '油箱');
INSERT INTO `tbl_label` VALUES ('56', '76', '283', '174', '轮胎');

-- ----------------------------
-- Table structure for `tbl_msg`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_msg`;
CREATE TABLE `tbl_msg` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sender_id` char(64) DEFAULT NULL,
  `reciver_id` char(64) DEFAULT NULL,
  `content` char(200) DEFAULT NULL,
  `utc` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_msg
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_photo`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_photo`;
CREATE TABLE `tbl_photo` (
  `photo_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` char(64) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `title` char(40) DEFAULT NULL,
  `desc` char(200) DEFAULT NULL,
  `utc` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_photo
-- ----------------------------
INSERT INTO `tbl_photo` VALUES ('68', 'o7E5at7-yDvpe52MAdIGeDhYYb_Y', '6', '', '', '1429628525', '2015-04-21');
INSERT INTO `tbl_photo` VALUES ('69', 'o7E5atyFXHVwp7MXW7a51GOL5huU', '6', '好yuuuh', '何厚铧', '1429628541', '2015-04-21');
INSERT INTO `tbl_photo` VALUES ('70', 'o7E5at7-yDvpe52MAdIGeDhYYb_Y', '6', '头像', '有错啊', '1429628621', '2015-04-21');
INSERT INTO `tbl_photo` VALUES ('71', 'o7E5at7-yDvpe52MAdIGeDhYYb_Y', '6', '办公桌', '厉害', '1429628963', '2015-04-21');
INSERT INTO `tbl_photo` VALUES ('72', 'o7E5at1w3baiS12vcDRZvZPEA5yk', '6', '郁郁', '好何厚铧', '1429629133', '2015-04-21');
INSERT INTO `tbl_photo` VALUES ('73', 'o7E5atyFXHVwp7MXW7a51GOL5huU', '6', 'uiiii', '看看扣款', '1429629374', '2015-04-21');
INSERT INTO `tbl_photo` VALUES ('74', 'o7E5at1w3baiS12vcDRZvZPEA5yk', '6', '不会后悔', '胡拒绝', '1429629461', '2015-04-21');
INSERT INTO `tbl_photo` VALUES ('75', 'o7E5atyFXHVwp7MXW7a51GOL5huU', '6', '让人的', '点点滴滴', '1429629590', '2015-04-21');
INSERT INTO `tbl_photo` VALUES ('76', 'o7E5at7-yDvpe52MAdIGeDhYYb_Y', '6', 'ybr', '雅马哈', '1429630687', '2015-04-21');

-- ----------------------------
-- Table structure for `tbl_praise`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_praise`;
CREATE TABLE `tbl_praise` (
  `photo_id` bigint(20) NOT NULL,
  `praiser_id` char(64) NOT NULL,
  `utc` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`photo_id`,`praiser_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_praise
-- ----------------------------
INSERT INTO `tbl_praise` VALUES ('75', 'o7E5at7-yDvpe52MAdIGeDhYYb_Y', '1429630795', '2015-04-21');
INSERT INTO `tbl_praise` VALUES ('76', 'o7E5at7-yDvpe52MAdIGeDhYYb_Y', '1429630792', '2015-04-21');

-- ----------------------------
-- Table structure for `tbl_type`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_type`;
CREATE TABLE `tbl_type` (
  `id` int(11) NOT NULL,
  `name` char(20) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_type
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` char(64) NOT NULL COMMENT '账号ID',
  `level` int(11) DEFAULT '1' COMMENT '用户级别',
  `nickname` char(64) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `adress` char(100) DEFAULT NULL,
  `intro` char(200) DEFAULT '' COMMENT '个性签名',
  `phone` char(15) DEFAULT '',
  `pic_url` text,
  `regist_utc` int(11) DEFAULT '0',
  `regist_data` date DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('o7E5at1w3baiS12vcDRZvZPEA5yk', '1', 'Jing', '0', '成都', '', '', 'no', '1429629108', '2015-04-21');
INSERT INTO `tbl_user` VALUES ('o7E5at7-yDvpe52MAdIGeDhYYb_Y', '1', 'Jing', '0', 'Chengdu', '你好我也好', '', 'http://wx.qlogo.cn/mmopen/Aqtvh6YDJ6SIOTWmmymxV0DqJ3w348Mgqbq22o4yYk5umU1ZDWiaaC0y0zwWUdBfpj2Msh5Rx2CmiaMD50SibbKH9jL7ItjC8fQ/0', '1429626209', '2015-04-21');
INSERT INTO `tbl_user` VALUES ('o7E5atyFXHVwp7MXW7a51GOL5huU', '1', '逐鹿', '0', 'Hangzhou', '', '', 'http://wx.qlogo.cn/mmopen/lPfTxuh1YrlzBAx7GhM7icSAdj39hcjINuqSTOtSfIiaGS5iabYicaPXaOj2QRibltymiaHOreuTLjEsRrpS6jSfDzYQstZiaJBmvUA/0', '1429627953', '2015-04-21');

-- ----------------------------
-- Table structure for `tbl_visit`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_visit`;
CREATE TABLE `tbl_visit` (
  `photo_id` bigint(20) NOT NULL,
  `visitor_id` char(64) NOT NULL,
  `utc` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`photo_id`,`visitor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_visit
-- ----------------------------

-- ----------------------------
-- Procedure structure for `add_activities`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_activities`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `add_activities`(name VARCHAR(100),end_utc INT)
BEGIN
	#Routine body goes here...
	INSERT INTO tbl_activities(`name`, end_utc, date)
	VALUES(`name`, end_utc, curdate());
	#查询出自增值
	SELECT @@IDENTITY AS 'identity';
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `add_comment`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_comment`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `add_comment`(photo INT, sender VARCHAR(64), content VARCHAR(200))
BEGIN

	#添加评论
	INSERT INTO tbl_comment(photo_id, sender_id, content, utc, date)
	VALUES(photo, sender, content, unix_timestamp(), curdate());

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `add_comment_reply`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_comment_reply`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `add_comment_reply`(comment INT,reply VARCHAR(200))
BEGIN

	#添加评论回复
	INSERT INTO tbl_comment_reply(comment_id, content, utc, date)
	VALUES(`comment`, reply, unix_timestamp(), curdate());

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `add_follow`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_follow`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_follow`(a VARCHAR(64), b VARCHAR(64))
BEGIN
	#Routine body goes here...
	INSERT INTO tbl_follow(id_a, id_b) VALUES(a,b);
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `add_msg`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_msg`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `add_msg`(sender VARCHAR(64), reciver VARCHAR(64), content VARCHAR(1000))
BEGIN
	#发送私信
	INSERT INTO tbl_msg(sender_id, reciver_id, content, utc, date)
	VALUES(sender, reciver, content, unix_timestamp(), curdate());
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `add_photo`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_photo`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `add_photo`(author VARCHAR(64), type INT, title VARCHAR(100), `desc` VARCHAR(1000))
BEGIN
	#新增图片
	INSERT INTO tbl_photo(author_id, type, title, `desc`, utc, date)
	VALUES(author, type, title, `desc`, unix_timestamp(), curdate());
	#查询出自增值
	SELECT @@IDENTITY AS 'identity';
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `add_praise`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_praise`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `add_praise`(photo INT, praiser VARCHAR(64))
BEGIN
	#点赞
	INSERT INTO tbl_praise(photo_id, praiser_id, utc, date)
	VALUES(photo, praiser, unix_timestamp(), curdate());

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `add_user`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_user`(id VARCHAR(64),nickname VARCHAR(64), headimgurl VARCHAR(1000),sex INT, adress VARCHAR(100))
BEGIN
	
	DECLARE count INT;
  #检查用户是否存在
	SELECT COUNT(*) INTO count FROM tbl_user WHERE tbl_user.id = id;
	#插入用户 2,'jing','nonono',0,'cde'
	IF count = 0 THEN
		INSERT INTO tbl_user(id, nickname, pic_url, sex, adress, regist_utc, regist_data) VALUES(id, nickname, headimgurl, sex, adress, unix_timestamp(), curdate());
	END IF;

	CALL get_user(id);
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `add_visit`
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_visit`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `add_visit`(visitor VARCHAR(64), photo INT)
BEGIN
	#Routine body goes here...
	REPLACE INTO tbl_visit VALUES(photo, visitor, unix_timestamp(), curdate());
	
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `check_user`
-- ----------------------------
DROP PROCEDURE IF EXISTS `check_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `check_user`(id VARCHAR(64))
BEGIN
	
	SELECT id FROM tbl_user WHERE id=id;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_comment_list`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_comment_list`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_comment_list`(photo INT)
BEGIN
		
	SELECT A.sender_id,B.nickname,A.content,A.id
		,(SELECT content FROM tbl_comment_reply WHERE comment_id = A.id) AS reply
	FROM tbl_comment AS A LEFT JOIN tbl_user AS B ON A.sender_id = B.id
	WHERE A.photo_id = photo;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_img_list`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_img_list`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_img_list`(page INT)
BEGIN

	DECLARE page_size INT DEFAULT 10;
	DECLARE start_index INT;
	SET start_index=page * page_size;
	
	SELECT photo_id,author_id,utc
		,(SELECT COUNT(*) FROM tbl_praise WHERE photo_id = TBL.photo_id) AS praise_amount
		,(SELECT COUNT(*) FROM tbl_comment WHERE photo_id = TBL.photo_id) AS comment_amount
		,(SELECT COUNT(*) FROM tbl_visit WHERE photo_id = TBL.photo_id) AS visit_amount
	FROM tbl_photo AS TBL ORDER BY utc DESC LIMIT start_index, page_size;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_img_list_by_search`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_img_list_by_search`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_img_list_by_search`(search VARCHAR(100), page INT)
BEGIN

	DECLARE page_size INT DEFAULT 10;
	DECLARE start_index INT;
	SET start_index=page * page_size;
	#参数实例：['%s%']
	#获得图片列表
	SELECT photo_id,author_id
		,(SELECT COUNT(*) FROM tbl_praise WHERE photo_id = TBL.photo_id) AS praise_amount
		,(SELECT COUNT(*) FROM tbl_comment WHERE photo_id = TBL.photo_id) AS comment_amount
		,(SELECT COUNT(*) FROM tbl_visit WHERE photo_id = TBL.photo_id) AS visit_amount
	FROM tbl_photo AS TBL
	WHERE TBL.title LIKE search 
  ORDER BY utc DESC
	LIMIT start_index, page_size;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_img_list_by_type`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_img_list_by_type`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_img_list_by_type`(type INT,page INT)
BEGIN

	DECLARE page_size INT DEFAULT 10;
	DECLARE start_index INT;
	SET start_index=page * page_size;

	#获得图片列表
	SELECT photo_id,author_id
		,(SELECT COUNT(*) FROM tbl_praise WHERE photo_id = TBL.photo_id) AS praise_amount
		,(SELECT COUNT(*) FROM tbl_comment WHERE photo_id = TBL.photo_id) AS comment_amount
		,(SELECT COUNT(*) FROM tbl_visit WHERE photo_id = TBL.photo_id) AS visit_amount
	FROM tbl_photo AS TBL
	WHERE TBL.type = type 
	ORDER BY utc DESC
	LIMIT start_index, page_size;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_img_list_by_user`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_img_list_by_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_img_list_by_user`(user_id VARCHAR(64), page INT)
BEGIN

	DECLARE page_size INT DEFAULT 10;
	DECLARE start_index INT;
	SET start_index=page * page_size;

	#获得图片列表
	SELECT photo_id,author_id
		,(SELECT COUNT(*) FROM tbl_praise WHERE photo_id = TBL.photo_id) AS praise_amount
		,(SELECT COUNT(*) FROM tbl_comment WHERE photo_id = TBL.photo_id) AS comment_amount
		,(SELECT COUNT(*) FROM tbl_visit WHERE photo_id = TBL.photo_id) AS visit_amount
	FROM tbl_photo AS TBL
	WHERE TBL.author_id = user_id 
	ORDER BY utc DESC
	LIMIT start_index, page_size;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_msg_list`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_msg_list`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_msg_list`(id VARCHAR(64))
BEGIN
	#Routine body goes here...

	CREATE TEMPORARY TABLE IF NOT EXISTS tmp_tbl_res
	(  
		`id` char(64),
		`level` int(11),
		`nickname` char(64),
		`sex` int(11),
		`adress` char(100) DEFAULT NULL,
		`pic_url` text,
		`fans` int(11),
		`follow` int(11),
		`content` char(200),
		`utc` int(11)	
	);  
  TRUNCATE TABLE tmp_tbl_res;  -- 使用前先清空临时表。  

	#INSERT INTO tmp_tbl_res VALUES('1',1,'hello',0,'a','a',2,3,'asdf',0);

	INSERT INTO tmp_tbl_res(id,`level`,nickname,sex,adress,pic_url)
	SELECT id,`level`,nickname,sex,adress,pic_url FROM tbl_user WHERE tbl_user.id IN (
(SELECT sender_id FROM tbl_msg WHERE reciver_id = id)
);

UPDATE tmp_tbl_res INNER JOIN tbl_msg ON tmp_tbl_res.id=tbl_msg.sender_id
SET tmp_tbl_res.content=tbl_msg.content;


	SELECT * FROM tmp_tbl_res;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_photo_details`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_photo_details`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_photo_details`(photo INT)
BEGIN
	#定义点赞数
	DECLARE praise_amount INT;
  #定义评论数
	DECLARE comment_amount INT;
	#定义访问数
	DECLARE visit_amount INT;

	DECLARE author_name CHAR(100);
	DECLARE pic_url VARCHAR(10000);
  SELECT COUNT(*) INTO praise_amount FROM tbl_praise WHERE photo_id = photo;
	SELECT COUNT(*) INTO comment_amount FROM tbl_comment WHERE photo_id = photo;
	SELECT COUNT(*) INTO visit_amount FROM tbl_visit WHERE photo_id = photo;
	SELECT tbl_user.nickname,tbl_user.pic_url INTO author_name, pic_url FROM tbl_user WHERE tbl_user.id IN (SELECT author_id FROM tbl_photo WHERE photo_id = photo);

	#获得图片列表
	SELECT *,author_name,pic_url,praise_amount,comment_amount,visit_amount FROM tbl_photo WHERE photo_id = photo;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_receive_msg_list`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_receive_msg_list`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_receive_msg_list`(id VARCHAR(64))
BEGIN

	SELECT A.sender_id,B.nickname,B.`level`,B.adress,A.content,A.utc
		,(SELECT COUNT(*) FROM tbl_follow WHERE id_b = B.id) AS fans
		,(SELECT COUNT(*) FROM tbl_follow WHERE id_a = B.id) AS follow
	FROM tbl_msg AS A LEFT JOIN tbl_user AS B ON A.sender_id = B.id
	WHERE A.reciver_id = id;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_sent_msg_list`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_sent_msg_list`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_sent_msg_list`(id VARCHAR(64))
BEGIN
	#获得发出的消息列表
	SELECT A.reciver_id,B.nickname, A.content,A.utc
	FROM tbl_msg AS A LEFT JOIN tbl_user AS B ON A.sender_id = B.id
	WHERE A.sender_id = id;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_user`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user`(id VARCHAR(64))
BEGIN
	#定义一个粉丝数的变量
	DECLARE fans INT;
  #定义关注数
	DECLARE follow INT;
  SELECT COUNT(*) INTO fans FROM tbl_follow WHERE id_b = id;
	SELECT COUNT(*) INTO follow FROM tbl_follow WHERE id_a = id;
	SELECT *,fans,follow FROM tbl_user WHERE tbl_user.id = id;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `get_visit_list`
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_visit_list`;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `get_visit_list`(photo INT)
BEGIN
	
	SELECT A.visitor_id,B.pic_url		
	FROM tbl_visit AS A LEFT JOIN tbl_user AS B ON A.visitor_id = B.id
	WHERE A.photo_id = photo ORDER BY utc DESC LIMIT 0, 5;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `test_add_user`
-- ----------------------------
DROP PROCEDURE IF EXISTS `test_add_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `test_add_user`()
BEGIN

#CALL add_user('4','jing','nonono',0,'cde');

	declare i int; 
  SET i = 1;
	WHILE i<100 DO
		CALL add_user(i,'jing','nonono',0,'cde');
		SET i=i+1;
	END WHILE;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `update_head_img`
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_head_img`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_head_img`(id VARCHAR(64), url VARCHAR(1000))
BEGIN
	#更新头像地址 
	UPDATE tbl_user SET tbl_user.pic_url = url WHERE tbl_user.id = id;
END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `update_info`
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_info`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_info`(id VARCHAR(64), nickname VARCHAR(100), sex INT, adress VARCHAR(100), intro VARCHAR(400), phone VARCHAR(20))
BEGIN
	#id VARCHAR(64), nickname VARCHAR(100), sex INT, adress VARCHAR(100), intro VARCHAR(400), phone VARCHAR(20)
	UPDATE tbl_user SET
tbl_user.nickname = nickname,
tbl_user.sex = sex,
tbl_user.adress = adress,
tbl_user.intro = intro,
tbl_user.phone = phone
WHERE tbl_user.id = id;
END
;;
DELIMITER ;
