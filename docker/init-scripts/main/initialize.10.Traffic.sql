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


-- Dumping database structure for excell_traffic
CREATE DATABASE IF NOT EXISTS `excell_traffic` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `excell_traffic`;

-- Dumping structure for table excell_traffic.card_browsing_history
CREATE TABLE IF NOT EXISTS `card_browsing_history` (
    `card_browsing_history_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL,
    `card_id` int(15) DEFAULT NULL,
    `note` text COLLATE utf8mb4_unicode_ci,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`card_browsing_history_id`),
    KEY `last_updated` (`last_updated`),
    KEY `card_id` (`card_id`),
    KEY `user_id` (`user_id`),
    KEY `company_id` (`company_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_traffic.visitor_activity
CREATE TABLE IF NOT EXISTS `visitor_activity` (
    `visitor_activity_id` int(15) NOT NULL COMMENT 'VistiorActivityId',
    `visitor_activity_guid` varchar(36) NOT NULL COMMENT 'VistiorActivityGuid',
    `company_id` int(15) DEFAULT NULL COMMENT 'CompanyId',
    `division_id` int(15) DEFAULT NULL COMMENT 'DivisionId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `card_id` int(15) DEFAULT NULL COMMENT 'CardId',
    `activity_type` varchar(25) NOT NULL DEFAULT 'website_visitor' COMMENT 'ActivityType',
    `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `ip_address` varchar(25) NOT NULL COMMENT 'IpAddress',
    `address_city` varchar(35) DEFAULT NULL COMMENT 'AddressCity',
    `address_state` varchar(25) DEFAULT NULL COMMENT 'AddressState',
    `address_zip` int(15) DEFAULT NULL COMMENT 'AddressZip',
    `address_country` varchar(25) DEFAULT NULL COMMENT 'AddressCountry',
    `address_loc` varchar(50) DEFAULT NULL COMMENT 'AddressLoc',
    `visitor_data` text NOT NULL COMMENT 'VistorData',
    PRIMARY KEY (`visitor_activity_id`),
    KEY `fk_visitoractivity_company` (`company_id`),
    KEY `fk_visitoractivity_division` (`division_id`),
    KEY `fk_visitoractivity_user` (`user_id`),
    KEY `fk_visitoractivity_card` (`card_id`),
    CONSTRAINT `fk_visitoractivity_card` FOREIGN KEY (`card_id`) REFERENCES `excell_main`.`card` (`card_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_visitoractivity_company` FOREIGN KEY (`company_id`) REFERENCES `excell_main`.`company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_visitoractivity_division` FOREIGN KEY (`division_id`) REFERENCES `excell_main`.`division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_visitoractivity_user` FOREIGN KEY (`user_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_traffic.visitor_browser
CREATE TABLE IF NOT EXISTS `visitor_browser` (
    `visitor_browser_id` int(15) NOT NULL COMMENT 'VisitorBrowserId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `contact_id` int(15) DEFAULT NULL COMMENT 'ContactId',
    `browser_cookie` varchar(150) NOT NULL COMMENT 'BrowserCookie',
    `browser_ip` varchar(50) DEFAULT NULL COMMENT 'BrowserIP',
    `logged_in_at` datetime DEFAULT NULL COMMENT 'LoggedInAt',
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `created_on` datetime DEFAULT NULL COMMENT 'CreatedOn',
    `browser_type` varchar(25) DEFAULT NULL COMMENT 'BrowserType',
    `device_type` varchar(25) DEFAULT NULL COMMENT 'DeviceType',
    PRIMARY KEY (`visitor_browser_id`),
    UNIQUE KEY `browser_cookie` (`browser_cookie`),
    KEY `contact_id` (`contact_id`),
    KEY `user_id` (`user_id`),
    KEY `logged_in_at` (`logged_in_at`),
    KEY `last_updated` (`last_updated`),
    KEY `created_on` (`created_on`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='VisitorBrowserTable for Excell 3.0';

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
