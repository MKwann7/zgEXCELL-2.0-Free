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


-- Dumping database structure for excell_activity
CREATE DATABASE IF NOT EXISTS `excell_activity` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `excell_activity`;

-- Dumping structure for table excell_activity.log_admin
CREATE TABLE IF NOT EXISTS `log_admin` (
    `log_admin_id` int(15) NOT NULL COMMENT 'LogAdminId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `entity` varchar(25) NOT NULL COMMENT 'Entity',
    `entity_id` int(15) NOT NULL COMMENT 'EntityId',
    `action` varchar(25) NOT NULL COMMENT 'Action',
    `value_old` varchar(1000) NOT NULL COMMENT 'ValueOld',
    `value_new` varchar(1000) NOT NULL COMMENT 'ValueNew',
    `reverted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Reverted',
    `created_on` datetime DEFAULT NULL COMMENT 'CreatedOn',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`log_admin_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf32 COMMENT='ActivityAdminLogTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_activity.log_user
CREATE TABLE IF NOT EXISTS `log_user` (
    `log_user_id` int(20) NOT NULL COMMENT 'LogUserId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `action` varchar(15) DEFAULT NULL COMMENT 'Action',
    `note` varchar(250) NOT NULL COMMENT 'Note',
    `entity_name` varchar(25) DEFAULT NULL COMMENT 'EntityName',
    `entity_id` int(15) DEFAULT NULL COMMENT 'EntityId',
    `created_on` datetime DEFAULT NULL COMMENT 'CreatedOn',
    `created_by` int(15) DEFAULT NULL COMMENT 'CreatedBy',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`log_user_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='UserLogTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for trigger excell_activity.tgr_log_admin_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_log_admin_sysrowid` BEFORE INSERT ON `log_admin` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_activity.tgr_user_log_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_user_log_sysrowid` BEFORE INSERT ON `log_user` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
