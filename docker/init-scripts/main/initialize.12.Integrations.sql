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


-- Dumping database structure for excell_integrations
CREATE DATABASE IF NOT EXISTS `excell_integrations` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `excell_integrations`;

-- Dumping structure for table excell_integrations.integrations_orderline
CREATE TABLE IF NOT EXISTS `integrations_orderline` (
    `integrations_orderline_id` int(15) NOT NULL AUTO_INCREMENT,
    `integration_type` int(3) DEFAULT '0',
    `external_id` varchar(50) DEFAULT NULL,
    `orderline_id` int(15) DEFAULT '0',
    `synced` tinyint(2) DEFAULT '0',
    `created_on` datetime DEFAULT NULL,
    `last_synced` datetime DEFAULT NULL,
    `state` char(6) DEFAULT NULL,
    PRIMARY KEY (`integrations_orderline_id`),
    UNIQUE KEY `integration_type_external_id_orderline_id` (`integration_type`,`external_id`,`orderline_id`),
    KEY `orderline_id` (`orderline_id`),
    KEY `integration_type` (`integration_type`),
    KEY `synced` (`synced`),
    KEY `last_synced` (`last_synced`),
    KEY `external_id` (`external_id`),
    KEY `state` (`state`),
    CONSTRAINT `fk_integrationsOrderline_integrationsType` FOREIGN KEY (`integration_type`) REFERENCES `integration_type` (`integration_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_integrationsOrderline_orderlineId` FOREIGN KEY (`orderline_id`) REFERENCES `excell_crm`.`order_line` (`order_line_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_integrations.integrations_ticket
CREATE TABLE IF NOT EXISTS `integrations_ticket` (
    `integrations_ticket_id` int(15) NOT NULL AUTO_INCREMENT,
    `integration_type` int(3) DEFAULT '0',
    `external_id` varchar(50) DEFAULT NULL,
    `ticket_id` int(15) DEFAULT '0',
    `synced` tinyint(2) DEFAULT '0',
    `created_on` datetime DEFAULT NULL,
    `last_synced` datetime DEFAULT NULL,
    `state` char(6) DEFAULT NULL,
    PRIMARY KEY (`integrations_ticket_id`),
    UNIQUE KEY `integration_type_external_id_ticket_id` (`integration_type`,`external_id`,`ticket_id`),
    KEY `ticket_id` (`ticket_id`),
    KEY `integration_type` (`integration_type`),
    KEY `synced` (`synced`),
    KEY `last_synced` (`last_synced`),
    KEY `external_id` (`external_id`),
    KEY `state` (`state`),
    CONSTRAINT `fk_integrationsTicket_integrationsType` FOREIGN KEY (`integration_type`) REFERENCES `integration_type` (`integration_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_integrationsTicket_ticketId` FOREIGN KEY (`ticket_id`) REFERENCES `excell_crm`.`ticket` (`ticket_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_integrations.integrations_user
CREATE TABLE IF NOT EXISTS `integrations_user` (
    `integrations_user_id` int(15) NOT NULL AUTO_INCREMENT,
    `integration_type` int(3) DEFAULT '0',
    `external_id` varchar(50) DEFAULT NULL,
    `user_id` int(15) DEFAULT '0',
    `synced` tinyint(2) DEFAULT '0',
    `created_on` datetime DEFAULT NULL,
    `last_synced` datetime DEFAULT NULL,
    `state` char(6) DEFAULT NULL,
    PRIMARY KEY (`integrations_user_id`),
    UNIQUE KEY `integration_type_external_id_user_id` (`integration_type`,`external_id`,`user_id`),
    KEY `user_id` (`user_id`),
    KEY `integration_type` (`integration_type`),
    KEY `synced` (`synced`),
    KEY `last_synced` (`last_synced`),
    KEY `external_id` (`external_id`),
    KEY `state` (`state`),
    CONSTRAINT `fk_integrationsUser_integrationsType` FOREIGN KEY (`integration_type`) REFERENCES `integration_type` (`integration_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_integrationsUser_userId` FOREIGN KEY (`user_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_integrations.integration_type
CREATE TABLE IF NOT EXISTS `integration_type` (
    `integration_type_id` int(11) NOT NULL AUTO_INCREMENT,
    `label` varchar(25) DEFAULT NULL,
    `name` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`integration_type_id`),
    KEY `label` (`label`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
