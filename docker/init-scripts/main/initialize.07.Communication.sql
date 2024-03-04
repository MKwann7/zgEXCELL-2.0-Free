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


-- Dumping database structure for excell_communication
CREATE DATABASE IF NOT EXISTS `excell_communication` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `excell_communication`;

-- Dumping structure for table excell_communication.email
CREATE TABLE IF NOT EXISTS `email` (
    `email_id` int(15) NOT NULL COMMENT 'EmailId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `card_id` int(15) DEFAULT NULL COMMENT 'CardId',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `division_id` int(15) NOT NULL COMMENT 'DivisionId',
    `email_type_id` int(5) NOT NULL COMMENT 'EmailTypeId',
    `content_file_reference` char(36) NOT NULL COMMENT 'ContentFileReference',
    `created_on` datetime NOT NULL COMMENT 'CreatedOn',
    `created_by` int(15) NOT NULL COMMENT 'CreatedBy',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`email_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `user_id` (`user_id`),
    KEY `card_id` (`card_id`),
    KEY `created_on` (`created_on`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='EmailTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_communication.message
CREATE TABLE IF NOT EXISTS `message` (
    `message_id` int(15) NOT NULL COMMENT 'MessageId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `target_group_id` int(15) DEFAULT NULL COMMENT 'TargetGroupId',
    `target_user_id` int(15) NOT NULL COMMENT 'TargetUserId',
    `created_at` datetime NOT NULL COMMENT 'CreatedAt',
    `text` text NOT NULL COMMENT 'Text',
    `viewed_by` text NOT NULL COMMENT 'ViewedBy'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='MessagesTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_communication.text
CREATE TABLE IF NOT EXISTS `text` (
    `text_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'TextId',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `division_id` int(15) NOT NULL COMMENT 'DivisionId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `contact_ids` text NOT NULL COMMENT 'ContactIds',
    `message_text` varchar(512) NOT NULL COMMENT 'message_text',
    `created_at` datetime NOT NULL COMMENT 'CreatedAt',
    `last_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `resent_at` datetime NOT NULL COMMENT 'ResentAt',
    PRIMARY KEY (`text_id`),
    KEY `company_id` (`company_id`),
    KEY `division_id` (`division_id`),
    KEY `user_id` (`user_id`),
    KEY `last_updated` (`last_updated`),
    KEY `resent_at` (`resent_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COMMENT='TextMessageTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for trigger excell_communication.tgr_email_email_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_email_email_sysrowid` BEFORE INSERT ON `email` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
