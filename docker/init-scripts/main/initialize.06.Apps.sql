-- --------------------------------------------------------
-- Host:                         35.192.58.83
-- Server version:               5.7.34-google-log - (Google)
-- Server OS:                    Linux
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for excell_apps
CREATE DATABASE IF NOT EXISTS `excell_apps` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `excell_apps`;

-- Dumping structure for table excell_apps.ezcard_media_directory
CREATE TABLE IF NOT EXISTS `media_directory` (
    `media_directory_id` int(15) NOT NULL AUTO_INCREMENT,
    `instance_uuid` char(36) DEFAULT NULL,
    `template_id` int(15) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`media_directory_id`),
    UNIQUE KEY `instance_uuid` (`instance_uuid`),
    KEY `last_updated` (`last_updated`),
    KEY `instance_uuid_key` (`instance_uuid`),
    KEY `created_at` (`created_on`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_media_directory_column
CREATE TABLE IF NOT EXISTS `media_directory_field` (
    `media_directory_field_id` int(15) NOT NULL AUTO_INCREMENT,
    `template_id` int(15) DEFAULT NULL,
    `label` varchar(25) DEFAULT NULL,
    `name` varchar(25) DEFAULT NULL,
    `order` int(5) DEFAULT NULL,
    `sortable` tinyint(4) NOT NULL DEFAULT '0',
    `type` varchar(35) DEFAULT NULL,
    `length` smallint(6) DEFAULT NULL,
    `visible` tinyint(1) NOT NULL DEFAULT '0',
    `created_at` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`media_directory_field_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `last_updated` (`last_updated`),
    KEY `created_at` (`created_at`),
    KEY `order` (`order`),
    KEY `ezcard_media_directory_id` (`template_id`) USING BTREE,
    KEY `sortable` (`sortable`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_media_directory_default
CREATE TABLE IF NOT EXISTS `media_directory_default` (
    `media_directory_default_id` int(15) NOT NULL AUTO_INCREMENT,
    `directory_id` int(15) DEFAULT NULL,
    `template_id` int(15) DEFAULT NULL,
    `label` varchar(25) DEFAULT NULL,
    `value` varchar(500) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`media_directory_default_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `template_id` (`template_id`),
    KEY `directory_id` (`directory_id`),
    KEY `label` (`label`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_media_directory_record_value
CREATE TABLE IF NOT EXISTS `media_directory_record_value` (
    `media_directory_record_value_id` int(15) NOT NULL AUTO_INCREMENT,
    `media_directory_record_id` int(15) DEFAULT NULL,
    `media_directory_id` int(15) DEFAULT NULL,
    `media_directory_column_id` int(15) DEFAULT NULL,
    `type` varchar(15) DEFAULT NULL,
    `value` text,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`media_directory_record_value_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `last_updated` (`last_updated`),
    KEY `type` (`type`),
    KEY `ezcard_media_directory_record_column_id` (`media_directory_column_id`) USING BTREE,
    KEY `created_at` (`created_on`) USING BTREE,
    KEY `ezcard_media_directory_record_id` (`media_directory_id`) USING BTREE,
    KEY `ezcard_media_directory_id` (`media_directory_record_id`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_media_directory_template
CREATE TABLE IF NOT EXISTS `media_directory_template` (
    `media_directory_template_id` int(15) NOT NULL AUTO_INCREMENT,
    `template_name` varchar(50) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`media_directory_template_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_member_directory
CREATE TABLE IF NOT EXISTS `directory` (
    `directory_id` int(15) NOT NULL AUTO_INCREMENT,
    `parent_id` int(15) DEFAULT NULL,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(5) DEFAULT NULL,
    `site_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL,
    `type_id` int(5) DEFAULT NULL,
    `template_id` int(5) DEFAULT NULL,
    `title` varchar(50) DEFAULT NULL,
    `directory_data` text DEFAULT NULL,
    `starts_on` datetime DEFAULT NULL,
    `ends_on` datetime DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `instance_uuid` char(36) DEFAULT NULL,
    PRIMARY KEY (`directory_id`),
    UNIQUE KEY `instance_uuid` (`instance_uuid`),
    KEY `last_updated` (`last_updated`),
    KEY `instance_uuid_key` (`instance_uuid`),
    KEY `site_id_key` (`site_id`),
    KEY `created_at` (`created_on`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping structure for table excell_main.card_setting
CREATE TABLE IF NOT EXISTS `directory_setting` (
    `directory_setting_id` int(15) NOT NULL COMMENT 'DirectorySettingId',
    `directory_id` int(15) NOT NULL COMMENT 'DirectoryId',
    `label` varchar(35) NOT NULL COMMENT 'label',
    `value` varchar(1500) NOT NULL COMMENT 'value',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`directory_setting_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `directory_id` (`directory_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='DirectorySettingTable for Excell  3.0';

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_directory_setting_sysrowid` BEFORE INSERT ON `directory_setting` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_member_directory
CREATE TABLE IF NOT EXISTS `directory_type` (
    `directory_type_id` int(15) NOT NULL AUTO_INCREMENT,
    `title` varchar(50) DEFAULT NULL,
    `label` varchar(25) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`directory_type_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `last_updated` (`last_updated`),
    KEY `sys_row_id_key` (`sys_row_id`),
    KEY `created_at` (`created_on`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_directory_type_sysrowid` BEFORE INSERT ON `directory_type` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for table excell_apps.ezcard_member_directory
CREATE TABLE IF NOT EXISTS `directory_package` (
    `directory_package_id` int(15) NOT NULL AUTO_INCREMENT,
    `directory_id` int(15) DEFAULT NULL,
    `package_id` int(15) DEFAULT NULL,
    `permanent_public_viewing` int(2) DEFAULT NULL,
    `membership` int(2) DEFAULT NULL,
    `events_discount` int(2) DEFAULT NULL,
    `events_discount_value` decimal(5,2) DEFAULT NULL,
    `events_free` int(2) DEFAULT NULL,
    `status` varchar(15) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`directory_package_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `last_updated` (`last_updated`),
    KEY `directory_id_key` (`directory_id`),
    KEY `package_id_key` (`package_id`),
    KEY `sys_row_id_key` (`sys_row_id`),
    KEY `created_at` (`created_on`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_directory_package_sysrowid` BEFORE INSERT ON `directory_package` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;


-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_member_directory_column
CREATE TABLE IF NOT EXISTS `directory_member_field` (
    `directory_member_field_id` int(15) NOT NULL AUTO_INCREMENT,
    `directory_template_id` int(15) DEFAULT NULL,
    `label` varchar(25) DEFAULT NULL,
    `name` varchar(25) DEFAULT NULL,
    `order` int(5) DEFAULT NULL,
    `sortable` tinyint(4) NOT NULL DEFAULT '0',
    `type` varchar(35) DEFAULT NULL,
    `length` smallint(6) DEFAULT NULL,
    `visible` tinyint(1) NOT NULL DEFAULT '0',
    `created_at` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`directory_member_field_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `last_updated` (`last_updated`),
    KEY `created_at` (`created_at`),
    KEY `order` (`order`),
    KEY `directory_template_id` (`directory_template_id`) USING BTREE,
    KEY `sortable` (`sortable`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_directory_member_field_sysrowid` BEFORE INSERT ON `directory_member_field` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_member_directory_default
CREATE TABLE IF NOT EXISTS `directory_default` (
    `directory_default_id` int(15) NOT NULL AUTO_INCREMENT,
    `directory_id` int(15) DEFAULT NULL,
    `directory_template_id` int(15) DEFAULT NULL,
    `label` varchar(25) DEFAULT NULL,
    `value` varchar(1000) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`directory_default_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `directory_template_id` (`directory_template_id`),
    KEY `directory_id` (`directory_id`),
    KEY `label` (`label`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_directory_default_sysrowid` BEFORE INSERT ON `directory_default` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_member_directory_record
CREATE TABLE IF NOT EXISTS `directory_member_rel` (
    `directory_member_rel_id` int(15) NOT NULL AUTO_INCREMENT,
    `directory_id` int(15) DEFAULT NULL,
    `status` varchar(50) DEFAULT NULL,
    `user_id` char(36) DEFAULT NULL,
    `persona_id` int(15) DEFAULT '0',
    `created_on` datetime DEFAULT NULL,
    `last_updated` datetime DEFAULT NULL,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`directory_member_rel_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `directory_id_user_id` (`directory_id`,`user_id`),
    KEY `directory_id` (`directory_id`),
    KEY `status` (`status`),
    CONSTRAINT `fk_ezcard_memdir_record_to_dir` FOREIGN KEY (`directory_id`) REFERENCES `directory` (`directory_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_directory_member_rel_sysrowid` BEFORE INSERT ON `directory_member_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_member_directory_template
CREATE TABLE IF NOT EXISTS `directory_template` (
    `directory_template_id` int(15) NOT NULL AUTO_INCREMENT,
    `template_name` varchar(50) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`directory_template_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_directory_template_sysrowid` BEFORE INSERT ON `directory_template` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.ezcard_talk_to_me
CREATE TABLE IF NOT EXISTS `talk_to_me` (
    `talk_to_me_id` int(15) NOT NULL AUTO_INCREMENT,
    `template_id` int(15) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `instance_uuid` char(36) DEFAULT NULL,
    PRIMARY KEY (`talk_to_me_id`),
    UNIQUE KEY `instance_uuid` (`instance_uuid`),
    KEY `instance_uuid_key` (`instance_uuid`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- //////////////////////////////////////////////////////////// MARKET PLACE

-- Dumping structure for table excell_apps.marketplace
CREATE TABLE IF NOT EXISTS `marketplace` (
    `marketplace_id` int(15) NOT NULL AUTO_INCREMENT,
    `instance_uuid` char(36) DEFAULT NULL,
    `template_id` int(15) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`marketplace_id`),
    UNIQUE KEY `instance_uuid` (`instance_uuid`),
    KEY `last_updated` (`last_updated`),
    KEY `instance_uuid_key` (`instance_uuid`),
    KEY `created_at` (`created_on`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.marketplace_column
CREATE TABLE IF NOT EXISTS `marketplace_field` (
    `marketplace_field_id` int(15) NOT NULL AUTO_INCREMENT,
    `template_id` int(15) DEFAULT NULL,
    `label` varchar(25) DEFAULT NULL,
    `name` varchar(25) DEFAULT NULL,
    `order` int(5) DEFAULT NULL,
    `sortable` tinyint(4) NOT NULL DEFAULT '0',
    `type` varchar(35) DEFAULT NULL,
    `length` smallint(6) DEFAULT NULL,
    `visible` tinyint(1) NOT NULL DEFAULT '0',
    `created_at` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`marketplace_field_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `last_updated` (`last_updated`),
    KEY `created_at` (`created_at`),
    KEY `order` (`order`),
    KEY `marketplace_field_id` (`template_id`) USING BTREE,
    KEY `sortable` (`sortable`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_marketplace_field_sysrowid` BEFORE INSERT ON `marketplace_field` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.marketplace_default
CREATE TABLE IF NOT EXISTS `marketplace_default` (
    `marketplace_default_id` int(15) NOT NULL AUTO_INCREMENT,
    `marketplace_id` int(15) DEFAULT NULL,
    `template_id` int(15) DEFAULT NULL,
    `label` varchar(25) DEFAULT NULL,
    `value` varchar(1000) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`marketplace_default_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `template_id` (`template_id`),
    KEY `marketplace_id` (`marketplace_id`),
    KEY `label` (`label`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_marketplace_default_sysrowid` BEFORE INSERT ON `marketplace_default` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.marketplace_package
CREATE TABLE IF NOT EXISTS `marketplace_package` (
    `marketplace_package_id` int(15) NOT NULL AUTO_INCREMENT,
    `marketplace_id` int(15) DEFAULT NULL,
    `status` varchar(50) DEFAULT NULL,
    `package_id` int(15) DEFAULT NULL,
    `order` int(11) DEFAULT NULL,
    `name` varchar(75) DEFAULT NULL,
    `description` varchar(5000) DEFAULT NULL,
    `promo_price` decimal(10,2) DEFAULT NULL,
    `regular_price` decimal(10,2) DEFAULT '0.00',
    `currency` varchar(10) DEFAULT 'usd',
    `package_image_url` varchar(250) DEFAULT NULL,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`marketplace_package_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `marketplace_id` (`marketplace_id`),
    KEY `promo_price` (`promo_price`),
    KEY `regular_price` (`regular_price`),
    KEY `order` (`order`),
    KEY `name` (`name`),
    KEY `status` (`status`),
    KEY `package_id` (`package_id`),
    CONSTRAINT `fk_marketplace_package_to_mp` FOREIGN KEY (`marketplace_id`) REFERENCES `marketplace` (`marketplace_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_marketplace_package_sysrowid` BEFORE INSERT ON `marketplace_package` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.marketplace_package_value
CREATE TABLE IF NOT EXISTS `marketplace_package_value` (
    `marketplace_package_value_id` int(15) NOT NULL AUTO_INCREMENT,
    `marketplace_package_id` int(15) DEFAULT NULL,
    `marketplace_id` int(15) DEFAULT NULL,
    `marketplace_column_id` int(15) DEFAULT NULL,
    `type` varchar(15) DEFAULT NULL,
    `value` text,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`marketplace_package_value_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `last_updated` (`last_updated`),
    KEY `type` (`type`),
    KEY `marketplace_package_column_id` (`marketplace_column_id`) USING BTREE,
    KEY `created_at` (`created_on`) USING BTREE,
    KEY `marketplace_id` (`marketplace_id`) USING BTREE,
    KEY `marketplace_package_id` (`marketplace_package_id`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_marketplace_package_value_sysrowid` BEFORE INSERT ON `marketplace_package_value` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Data exporting was unselected.

-- Dumping structure for table excell_apps.marketplace_template
CREATE TABLE IF NOT EXISTS `marketplace_template` (
    `marketplace_template_id` int(15) NOT NULL AUTO_INCREMENT,
    `template_name` varchar(50) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`marketplace_template_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_marketplace_template_sysrowid` BEFORE INSERT ON `marketplace_template` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
