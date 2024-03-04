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


-- Dumping database structure for excell_modules
CREATE DATABASE IF NOT EXISTS `excell_modules` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `excell_modules`;

-- Dumping structure for table excell_modules.authorizations
CREATE TABLE IF NOT EXISTS `authorizations` (
    `authorization_id` int(11) NOT NULL AUTO_INCREMENT,
    `authorization_uuid` char(36) DEFAULT NULL,
    `company_id` int(15) DEFAULT NULL,
    `type` varchar(15) DEFAULT NULL,
    `record_uuid` char(36) DEFAULT NULL,
    `parent_uuid` char(36) DEFAULT NULL,
    `name` varchar(75) DEFAULT NULL,
    `description` varchar(500) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`authorization_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `record_uuid` (`record_uuid`),
    UNIQUE KEY `authoriation_uuid` (`authorization_uuid`) USING BTREE,
    KEY `company_id` (`company_id`),
    KEY `last_updated` (`last_updated`),
    KEY `type` (`type`),
    KEY `record_uuid_key` (`record_uuid`),
    KEY `authoriation_uuid_key` (`authorization_uuid`) USING BTREE,
    KEY `created_at` (`created_on`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_modules.modules
CREATE TABLE IF NOT EXISTS `modules` (
    `module_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `name` varchar(75) DEFAULT NULL,
    `module_uuid` char(36) DEFAULT NULL,
    `author` varchar(50) DEFAULT NULL,
    `version` varchar(15) DEFAULT NULL,
    `category` varchar(25) DEFAULT NULL,
    `tags` text,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`module_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `uuid_version` (`version`,`module_uuid`) USING BTREE,
    KEY `company_id` (`company_id`),
    KEY `last_updated` (`last_updated`),
    KEY `created_at` (`created_on`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_modules.module_apps
CREATE TABLE IF NOT EXISTS `module_apps` (
    `module_app_id` int(15) NOT NULL AUTO_INCREMENT,
    `module_id` int(15) DEFAULT NULL,
    `company_id` int(15) DEFAULT NULL,
    `app_uuid` char(36) DEFAULT NULL,
    `name` varchar(75) DEFAULT NULL,
    `author` varchar(50) DEFAULT NULL,
    `domain` varchar(150) DEFAULT NULL,
    `version` varchar(15) DEFAULT NULL,
    `logo` varchar(150) DEFAULT NULL,
    `ui_type` varchar(50) DEFAULT NULL,
    `category` varchar(50) DEFAULT NULL,
    `tags` text,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`module_app_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `widget_uuid_version` (`app_uuid`,`version`) USING BTREE,
    KEY `module_id` (`module_id`),
    KEY `company_id` (`company_id`),
    KEY `created_at` (`created_on`) USING BTREE,
    KEY `widget_uuid_key` (`app_uuid`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_modules.module_app_events
CREATE TABLE IF NOT EXISTS `module_app_events` (
    `module_app_event_id` int(11) NOT NULL AUTO_INCREMENT,
    `module_app_id` int(11) DEFAULT NULL,
    `label` varchar(35) DEFAULT NULL,
    `name` varchar(50) DEFAULT NULL,
    `description` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`module_app_event_id`),
    UNIQUE KEY `label` (`label`),
    KEY `module_app_id` (`module_app_id`),
    CONSTRAINT `fk_moduleappevent_moduleapp` FOREIGN KEY (`module_app_id`) REFERENCES `module_apps` (`module_app_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_modules.module_app_widgets
CREATE TABLE IF NOT EXISTS `module_app_widgets` (
    `module_app_widget_id` int(15) NOT NULL AUTO_INCREMENT,
    `module_app_id` int(15) DEFAULT NULL,
    `widget_api_version` int(5) DEFAULT NULL,
    `widget_class` int(5) DEFAULT NULL,
    `name` varchar(75) DEFAULT NULL,
    `endpoint` varchar(75) DEFAULT NULL,
    `version` varchar(15) DEFAULT NULL,
    `variables` varchar(250) DEFAULT NULL,
    `data` text,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`module_app_widget_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `name_version` (`endpoint`,`version`,`module_app_id`) USING BTREE,
    KEY `version` (`version`),
    KEY `last_updated` (`last_updated`),
    KEY `created_at` (`created_on`) USING BTREE,
    KEY `module_widget_id` (`module_app_id`) USING BTREE,
    KEY `component_api_version` (`widget_api_version`) USING BTREE,
    KEY `widget_class` (`widget_class`),
    CONSTRAINT `fk_widget_class_app_widget_class` FOREIGN KEY (`widget_class`) REFERENCES `module_app_widget_class` (`module_app_widget_class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_modules.module_app_widget_class
CREATE TABLE IF NOT EXISTS `module_app_widget_class` (
    `module_app_widget_class_id` int(11) NOT NULL AUTO_INCREMENT,
    `tag` varchar(50) DEFAULT NULL,
    `label` varchar(50) DEFAULT NULL,
    `description` varchar(255) DEFAULT NULL,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`module_app_widget_class_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `label` (`label`),
    KEY `tag` (`tag`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_modules.module_app_widget_events
CREATE TABLE IF NOT EXISTS `module_app_widget_events` (
    `module_apps_widget_event_id` int(11) NOT NULL AUTO_INCREMENT,
    `module_app_event_id` int(11) DEFAULT NULL,
    `module_app_id` int(11) DEFAULT NULL,
    `module_app_widget_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`module_apps_widget_event_id`),
    KEY `module_app_event_id` (`module_app_event_id`),
    KEY `module_app_id` (`module_app_id`),
    KEY `module_app_widget_id` (`module_app_widget_id`),
    CONSTRAINT `fk_moduleappwidgetevent_mdouleapp` FOREIGN KEY (`module_app_id`) REFERENCES `module_apps` (`module_app_id`),
    CONSTRAINT `fk_moduleappwidgetevent_moduleappevent` FOREIGN KEY (`module_app_event_id`) REFERENCES `module_app_events` (`module_app_event_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
