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


-- Dumping database structure for excell_versioning
CREATE DATABASE IF NOT EXISTS `excell_versioning` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `excell_versioning`;

-- Dumping structure for table excell_versioning.card_page_versioning
CREATE TABLE IF NOT EXISTS `card_page_versioning` (
    `card_page_version_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardPageVersionId',
    `card_page_version_status` varchar(25) DEFAULT 'pending' COMMENT 'CardPageVersionStatus',
    `card_page_id` int(15) DEFAULT NULL COMMENT 'CardPageId',
    `card_id` int(15) DEFAULT NULL,
    `company_id` int(15) DEFAULT '0' COMMENT 'CompanyId',
    `division_id` int(15) DEFAULT '0' COMMENT 'DivisionId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `card_tab_type_id` int(5) DEFAULT NULL COMMENT 'CardTabTypeId',
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
    PRIMARY KEY (`card_page_version_id`),
    KEY `card_page_version_status` (`card_page_version_status`),
    KEY `card_page_id` (`card_page_id`),
    KEY `user_id` (`user_id`),
    KEY `company_id` (`company_id`),
    KEY `visibility` (`visibility`),
    KEY `fk_card_tab_division` (`division_id`),
    KEY `library_tab` (`library_tab`),
    KEY `fk_card_tab_type` (`card_tab_type_id`),
    KEY `card_id` (`card_id`),
    CONSTRAINT `fk_card_card_id` FOREIGN KEY (`card_id`) REFERENCES `excell_main`.`card` (`card_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_card_page` FOREIGN KEY (`card_page_id`) REFERENCES `excell_main`.`card_tab` (`card_tab_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_tab_company` FOREIGN KEY (`company_id`) REFERENCES `excell_main`.`company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_tab_division` FOREIGN KEY (`division_id`) REFERENCES `excell_main`.`division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_tab_type` FOREIGN KEY (`card_tab_type_id`) REFERENCES `excell_main`.`card_tab_type` (`card_tab_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_tab_user` FOREIGN KEY (`user_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardTabTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_versioning.card_versioning
CREATE TABLE IF NOT EXISTS `card_versioning` (
    `card_version_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardVersionId',
    `card_version_status` varchar(25) DEFAULT 'pending' COMMENT 'CardVersionStatus',
    `card_id` int(15) DEFAULT NULL COMMENT 'CardId',
    `owner_id` int(15) DEFAULT NULL COMMENT 'OwnerId',
    `card_user_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT '0' COMMENT 'DivisionId',
    `company_id` int(15) DEFAULT '0' COMMENT 'CompanyId',
    `card_type_id` int(5) DEFAULT NULL COMMENT 'CardTypeId',
    `card_name` varchar(255) DEFAULT NULL COMMENT 'CardName',
    `status` varchar(15) DEFAULT 'Active' COMMENT 'StatusId',
    `template_card` tinyint(1) DEFAULT '0' COMMENT 'TemplateCard',
    `order_line_id` int(15) DEFAULT NULL COMMENT 'OrderLineId',
    `product_id` int(15) DEFAULT NULL COMMENT 'ProductId',
    `template_id` int(15) DEFAULT '1' COMMENT 'TemplateId',
    `card_vanity_url` varchar(25) DEFAULT NULL COMMENT 'CardVanityUrl',
    `card_keyword` varchar(50) DEFAULT NULL COMMENT 'CardKeyword',
    `card_data` text COMMENT 'CardData',
    `card_num` int(15) NOT NULL COMMENT 'CardNumber',
    `redirect_to` int(15) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL COMMENT 'CreatedOn',
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    PRIMARY KEY (`card_version_id`),
    KEY `card_id` (`card_id`),
    KEY `card_num` (`card_num`),
    KEY `card_vanity_url` (`card_vanity_url`,`company_id`),
    KEY `user_id` (`owner_id`),
    KEY `division_id` (`division_id`),
    KEY `company_id` (`company_id`),
    KEY `status_id` (`status`),
    KEY `subscription_plan_id` (`product_id`),
    KEY `template_id` (`template_id`),
    KEY `template_card` (`template_card`),
    KEY `fk_card_type` (`card_type_id`),
    KEY `package_id` (`order_line_id`),
    KEY `card_keyword` (`card_keyword`),
    KEY `redirect_to` (`redirect_to`),
    KEY `card_user_id` (`card_user_id`),
    KEY `card_version_status` (`card_version_status`),
    KEY `created_on` (`created_on`),
    CONSTRAINT `FK_card_excell_crm.order_line` FOREIGN KEY (`order_line_id`) REFERENCES `excell_crm`.`order_line` (`order_line_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_card` FOREIGN KEY (`card_id`) REFERENCES `excell_main`.`card` (`card_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_company` FOREIGN KEY (`company_id`) REFERENCES `excell_main`.`company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_division` FOREIGN KEY (`division_id`) REFERENCES `excell_main`.`division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_owner` FOREIGN KEY (`owner_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_package` FOREIGN KEY (`product_id`) REFERENCES `excell_main`.`product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_redirectTo` FOREIGN KEY (`redirect_to`) REFERENCES `excell_main`.`company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_template` FOREIGN KEY (`template_id`) REFERENCES `excell_main`.`card_template` (`card_template_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_type` FOREIGN KEY (`card_type_id`) REFERENCES `excell_main`.`card_type` (`card_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_user` FOREIGN KEY (`card_user_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardTable for Excell 3.0';

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
