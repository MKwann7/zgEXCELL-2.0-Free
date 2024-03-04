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


-- Dumping database structure for excell_archive
CREATE DATABASE IF NOT EXISTS `excell_archive` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `excell_archive`;

-- Dumping structure for table excell_archive.card_tab_archive
CREATE TABLE IF NOT EXISTS `card_tab_archive` (
    `card_tab_archive_id` int(15) NOT NULL COMMENT 'CardTabArchiveId',
    `archive_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ArchiveDate',
    `card_tab_id` int(15) NOT NULL COMMENT 'CardTabId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `division_id` int(15) DEFAULT NULL COMMENT 'DivisionId',
    `company_id` int(15) DEFAULT NULL COMMENT 'CompanyId',
    `card_tab_type_id` int(5) NOT NULL COMMENT 'CardTabTypeId',
    `title` varchar(100) NOT NULL COMMENT 'Title',
    `content` mediumtext COMMENT 'Content',
    `order_number` int(3) NOT NULL COMMENT 'OrderNumber',
    `url` text COMMENT 'Url',
    `library_tab` tinyint(1) DEFAULT '0' COMMENT 'LibraryTab',
    `visibility` tinyint(1) DEFAULT '1' COMMENT 'Visibility',
    `permanent` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Permanent',
    `instance_count` int(5) DEFAULT '1' COMMENT 'InstanceCount',
    `card_tab_data` text COMMENT 'CardTabData',
    `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `created_by` int(15) DEFAULT NULL COMMENT 'CreatedBy',
    `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `updated_by` int(15) DEFAULT NULL COMMENT 'UpdatedBy',
    `old_card_id` int(15) DEFAULT NULL COMMENT 'OldCardId',
    `old_card_tab_id` int(15) DEFAULT NULL COMMENT 'OldCardTabId',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_tab_archive_id`),
    KEY `card_tab_id` (`card_tab_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardTabTable for Excell 3.0';

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
