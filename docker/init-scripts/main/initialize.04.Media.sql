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


-- Dumping database structure for excell_media
CREATE DATABASE IF NOT EXISTS `excell_media` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `excell_media`;

-- Dumping structure for table excell_media.image
CREATE TABLE IF NOT EXISTS `image` (
    `image_id` int(15) NOT NULL AUTO_INCREMENT,
    `parent_id` int(15) DEFAULT NULL COMMENT 'ParentId',
    `company_id` int(15) DEFAULT NULL COMMENT 'CompanyId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `entity_id` int(15) DEFAULT NULL COMMENT 'EntityId',
    `entity_name` varchar(45) NOT NULL COMMENT 'EntityName',
    `image_class` varchar(25) NOT NULL DEFAULT 'editor' COMMENT 'ImageClass',
    `title` varchar(150) NOT NULL COMMENT 'Title',
    `url` varchar(200) NOT NULL COMMENT 'Url',
    `thumb` varchar(200) NOT NULL COMMENT 'Thumb',
    `width` int(6) DEFAULT NULL COMMENT 'Width',
    `height` int(6) DEFAULT NULL COMMENT 'Height',
    `type` varchar(15) NOT NULL COMMENT 'Type',
    `created_on` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `created_by` int(15) NOT NULL COMMENT 'CreatedBy',
    `last_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `updated_by` int(15) NOT NULL COMMENT 'UpdatedBy',
    `sys_row_id` char(36) NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`image_id`),
    KEY `user_id` (`user_id`),
    KEY `image_id` (`image_id`),
    KEY `entity_id` (`entity_id`),
    KEY `entity_name` (`entity_name`),
    KEY `image_class` (`image_class`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ImageTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for trigger excell_media.tgr_image_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_image_sysrowid` BEFORE INSERT ON `image` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
