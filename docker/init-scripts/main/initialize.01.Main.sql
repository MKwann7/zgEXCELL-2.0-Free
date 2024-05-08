-- --------------------------------------------------------
-- Host:                         35.192.58.83
-- Server version:               5.7.34-google-log - (Google)
-- Server OS:                    Linux
-- Server OS:                    Linux
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

SET GLOBAL log_bin_trust_function_creators = 1;

-- Dumping database structure for excell_main
CREATE DATABASE IF NOT EXISTS `excell_main` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `excell_main`;

-- Dumping structure for table excell_main.app_instance
CREATE TABLE IF NOT EXISTS `app_instance` (
    `app_instance_id` int(15) NOT NULL AUTO_INCREMENT,
    `owner_id` int(15) DEFAULT NULL,
    `module_app_id` int(15) DEFAULT NULL,
    `order_line_id` int(15) DEFAULT NULL,
    `instance_uuid` char(36) DEFAULT NULL,
    `product_id` int(15) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`app_instance_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `insance_uuid` (`instance_uuid`) USING BTREE,
    KEY `last_updated` (`last_updated`),
    KEY `module_widget_id` (`module_app_id`) USING BTREE,
    KEY `product_id` (`product_id`),
    KEY `owner_id` (`owner_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.app_instance_rel
CREATE TABLE IF NOT EXISTS `app_instance_rel` (
    `app_instance_rel_id` int(11) NOT NULL AUTO_INCREMENT,
    `app_instance_id` int(11) DEFAULT NULL,
    `division_id` int(11) DEFAULT NULL,
    `company_id` int(11) DEFAULT NULL,
    `user_id` int(11) DEFAULT NULL,
    `module_app_widget_id` int(15) DEFAULT NULL,
    `card_id` int(15) DEFAULT NULL,
    `card_page_id` int(15) DEFAULT NULL,
    `card_page_rel_id` int(15) DEFAULT NULL,
    `page_box_id` int(15) DEFAULT NULL,
    `card_addon_id` int(11) DEFAULT NULL,
    `order_line_id` int(11) DEFAULT NULL,
    `status` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
    `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`app_instance_rel_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `app_instance_id` (`app_instance_id`),
    KEY `user_id` (`user_id`),
    KEY `module_app_widget_id` (`module_app_widget_id`),
    KEY `card_id` (`card_id`),
    KEY `card_page_id` (`card_page_id`),
    KEY `card_page_rel_id` (`card_page_rel_id`),
    KEY `page_box_id` (`page_box_id`),
    KEY `card_addon_id` (`card_addon_id`),
    KEY `order_line_id` (`order_line_id`),
    KEY `last_updated` (`last_updated`),
    KEY `division_id` (`division_id`),
    KEY `company_id` (`company_id`),
    KEY `status` (`status`),
    CONSTRAINT `FK_app_instance_rel_excell_crm.order_line` FOREIGN KEY (`order_line_id`) REFERENCES `excell_crm`.`order_line` (`order_line_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_appinstance_card_addon_id_card_addon` FOREIGN KEY (`card_addon_id`) REFERENCES `card_addon` (`card_addon_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_appinstance_card_id_card` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_appinstance_card_page_id_card_page` FOREIGN KEY (`card_page_id`) REFERENCES `card_tab` (`card_tab_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_appinstance_card_page_rel_id_card_page` FOREIGN KEY (`card_page_rel_id`) REFERENCES `card_tab_rel` (`card_tab_rel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_appinstance_id_appinstance` FOREIGN KEY (`app_instance_id`) REFERENCES `app_instance` (`app_instance_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_appinstance_user_id_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_appinstnace_company_id_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_setting
CREATE TABLE IF NOT EXISTS `app_instance_rel_setting` (
    `app_instance_rel_setting_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'AppInstanceRelSettingId',
    `app_instance_rel_id` int(15) NOT NULL COMMENT 'AppInstanceRelId',
    `label` varchar(35) NOT NULL COMMENT 'label',
    `value` varchar(1500) NOT NULL COMMENT 'value',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`app_instance_rel_setting_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `app_instance_rel_id` (`app_instance_rel_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardRelTable for Excell  3.0';

-- Dumping structure for table excell_main.campaign
CREATE TABLE IF NOT EXISTS `campaign` (
    `campaign_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CampaignId',
    `owner_id` int(15) NOT NULL COMMENT 'OwnerId',
    `division_id` int(15) NOT NULL COMMENT 'DivisionId',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `created_by` int(15) NOT NULL COMMENT 'CreatedBy',
    `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `modified_by` int(15) NOT NULL COMMENT 'ModifiedBy',
    `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `abbreviation` int(15) NOT NULL COMMENT 'Abbreviation',
    `name` varchar(75) NOT NULL COMMENT 'Name',
    `description` varchar(500) DEFAULT NULL COMMENT 'Description',
    `message` varchar(500) DEFAULT NULL COMMENT 'Message',
    `objective` varchar(500) DEFAULT NULL COMMENT 'Objective',
    `promotion_code_id` int(15) DEFAULT NULL COMMENT 'PromotionCodeId',
    `status` varchar(20) NOT NULL DEFAULT 'Active' COMMENT 'Status',
    `start` datetime DEFAULT NULL COMMENT 'Start',
    `end` datetime DEFAULT NULL COMMENT 'End',
    `type_id` int(15) DEFAULT NULL COMMENT 'TypeId',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`campaign_id`),
    UNIQUE KEY `abbreviation` (`abbreviation`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `owner_id` (`owner_id`),
    KEY `division_id` (`division_id`),
    KEY `company_id` (`company_id`),
    KEY `created_by` (`created_by`),
    KEY `modified_by` (`modified_by`),
    KEY `fkfk_campaign_status` (`status`),
    CONSTRAINT `fk_campaign_createdby` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_campaign_owner` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fkfk_campaign_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fkfk_campaign_division` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fkfk_campaign_modifiedby` FOREIGN KEY (`modified_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CampaignTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card
CREATE TABLE IF NOT EXISTS `card` (
    `card_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'SiteId',
    `owner_id` int(15) DEFAULT NULL COMMENT 'OwnerId',
    `card_user_id` int(15) DEFAULT NULL,
    `division_id` int(15) NOT NULL DEFAULT '0' COMMENT 'DivisionId',
    `company_id` int(15) NOT NULL DEFAULT '0' COMMENT 'CompanyId',
    `card_version_id` int(15) DEFAULT NULL,
    `card_type_id` int(5) DEFAULT NULL COMMENT 'SiteTypeId',
    `card_name` varchar(255) NOT NULL COMMENT 'SiteName',
    `status` varchar(25) NOT NULL DEFAULT 'Active' COMMENT 'StatusId',
    `template_card` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'TemplateCard',
    `order_line_id` int(15) DEFAULT NULL COMMENT 'OrderLineId',
    `product_id` int(15) DEFAULT NULL COMMENT 'ProductId',
    `template_id` int(15) DEFAULT '1' COMMENT 'TemplateId',
    `card_vanity_url` varchar(25) DEFAULT NULL COMMENT 'SiteVanityUrl',
    `phone_addon_id` int(15) DEFAULT NULL COMMENT 'SitePhoneNumber',
    `card_keyword` varchar(50) DEFAULT NULL COMMENT 'SiteKeyword',
    `card_data` text COMMENT 'SiteData',
    `card_num` int(15) NOT NULL COMMENT 'SiteNumber',
    `redirect_to` int(15) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL COMMENT 'CreatedOn',
    `created_by` int(15) NOT NULL COMMENT 'CreatedBy',
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `updated_by` int(15) NOT NULL COMMENT 'UpdatedBy',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_id`),
    UNIQUE KEY `card_num` (`card_num`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `card_vanity_url` (`card_vanity_url`,`company_id`),
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
    KEY `card_version_id` (`card_version_id`),
    CONSTRAINT `FK_card_excell_crm.order_line` FOREIGN KEY (`order_line_id`) REFERENCES `excell_crm`.`order_line` (`order_line_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_card_version` FOREIGN KEY (`card_version_id`) REFERENCES `excell_versioning`.`card_versioning` (`card_version_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_division` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_owner` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_package` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_template` FOREIGN KEY (`template_id`) REFERENCES `card_template` (`card_template_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_type` FOREIGN KEY (`card_type_id`) REFERENCES `card_type` (`card_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_user` FOREIGN KEY (`card_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card
CREATE TABLE IF NOT EXISTS `card_domain` (
    `card_domain_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardDomainId',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `card_id` int(15) NOT NULL COMMENT 'CardId',
    `domain_name` varchar(50) NOT NULL COMMENT 'DomainName',
    `ssl` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'SSL',
    `type` varchar(25) NOT NULL COMMENT 'Type',
    `created_on` datetime DEFAULT NULL COMMENT 'CreatedOn',
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_domain_id`),
    UNIQUE KEY `domain_name` (`domain_name`),
    CONSTRAINT `fl_card_domain_card` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`) ON DELETE CASCADE ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardDomainTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_addon
CREATE TABLE IF NOT EXISTS `card_addon` (
    `card_addon_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardAddonId',
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL,
    `card_id` int(15) DEFAULT NULL COMMENT 'CardId',
    `order_line_id` int(15) DEFAULT NULL COMMENT 'OrderLineId',
    `order_id` int(15) DEFAULT NULL COMMENT 'OrderId',
    `product_type_id` int(15) DEFAULT NULL COMMENT 'CardAddonType',
    `product_id` int(15) DEFAULT NULL,
    `module_id` int(15) DEFAULT NULL,
    `widget_id` int(15) DEFAULT NULL,
    `status` varchar(15) DEFAULT NULL COMMENT 'Status',
    `data` text DEFAULT NULL COMMENT 'Data',
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_addon_id`),
    KEY `card_id` (`card_id`),
    KEY `order_line_id` (`order_line_id`),
    KEY `order_id` (`order_id`),
    KEY `fk_card_addon_type` (`product_type_id`) USING BTREE,
    KEY `product_id` (`product_id`),
    KEY `widget_id` (`widget_id`),
    KEY `module_id` (`module_id`),
    KEY `user_id` (`user_id`),
    KEY `company_id` (`company_id`),
    CONSTRAINT `FK_card_addon_excell_crm.order_line` FOREIGN KEY (`order_line_id`) REFERENCES `excell_crm`.`order_line` (`order_line_id`) ON UPDATE NO ACTION,
    CONSTRAINT `FK_card_addon_excell_crm.orders` FOREIGN KEY (`order_id`) REFERENCES `excell_crm`.`orders` (`order_id`) ON UPDATE NO ACTION,
    CONSTRAINT `fl_card_addon_card` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `fl_card_addon_module` FOREIGN KEY (`module_id`) REFERENCES `excell_modules`.`modules` (`module_id`) ON UPDATE NO ACTION,
    CONSTRAINT `fl_card_addon_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON UPDATE NO ACTION,
    CONSTRAINT `fl_card_addon_product_type` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`product_type_id`) ON UPDATE NO ACTION,
    CONSTRAINT `fl_card_addon_widget` FOREIGN KEY (`widget_id`) REFERENCES `excell_modules`.`module_widgets` (`module_widget_id`) ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='CardAddonTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_addon_type
CREATE TABLE IF NOT EXISTS `card_addon_type` (
    `card_addon_type_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'card_addon_type_id',
    `title` varchar(50) NOT NULL COMMENT 'Title',
    `label` varchar(25) NOT NULL COMMENT 'Label',
    `description` varchar(500) NOT NULL COMMENT 'Description',
    `sys_row_id` char(36) NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_addon_type_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardAddonTypeTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_favorite
CREATE TABLE IF NOT EXISTS `card_favorite` (
    `card_favorite_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `card_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL,
    `favorite_source` int(2) DEFAULT NULL,
    `favorite_source_id` int(15) DEFAULT NULL,
    `favorite_source_type` int(5) DEFAULT NULL,
    `title` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `descrption` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `order` int(5) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL,
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`card_favorite_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `card_id` (`card_id`),
    KEY `user_id` (`user_id`),
    KEY `favorite_source_favorite_source_id` (`favorite_source`,`favorite_source_id`),
    KEY `last_updated` (`last_updated`),
    KEY `created_on` (`created_on`),
    KEY `order` (`order`),
    KEY `favorite_source_type` (`favorite_source_type`),
    CONSTRAINT `fk_cardfavorite_card` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cardfavorite_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cardfavorite_favoritesource` FOREIGN KEY (`favorite_source`) REFERENCES `card_favorite_source` (`card_favorite_source_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cardfavorite_favoritesourcetype` FOREIGN KEY (`favorite_source_type`) REFERENCES `connection_type` (`connection_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cardfavorite_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_favorite_source
CREATE TABLE IF NOT EXISTS `card_favorite_source` (
    `card_favorite_source_id` int(11) NOT NULL AUTO_INCREMENT,
    `source_label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `source_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`card_favorite_source_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_font
CREATE TABLE IF NOT EXISTS `card_font` (
    `card_font_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardFontId',
    `font_name` varchar(50) NOT NULL COMMENT 'FontName',
    `google_font_name` varchar(50) NOT NULL COMMENT 'GoogleFontName',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_font_id`),
    UNIQUE KEY `google_font_name` (`google_font_name`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_rel
CREATE TABLE IF NOT EXISTS `card_rel` (
    `card_rel_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardRelId',
    `card_id` int(15) DEFAULT NULL COMMENT 'CardId',
    `card_rel_group_id` int(15) DEFAULT NULL COMMENT 'CardGroupId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `status` varchar(15) DEFAULT 'Active' COMMENT 'Status',
    `card_rel_type_id` int(15) DEFAULT NULL COMMENT 'CardRelTypeId',
    `user_epp_id` int(4) DEFAULT NULL COMMENT 'MppId',
    `mpp_level` int(11) DEFAULT '0' COMMENT 'AppLevel',
    `created_on` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_rel_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `fk_card_rel_type` (`card_rel_type_id`),
    KEY `card_id` (`card_id`),
    KEY `user_id` (`user_id`),
    KEY `fk_card_rel_group` (`card_rel_group_id`),
    KEY `fk_card_rel_mpp` (`user_epp_id`),
    CONSTRAINT `fk_card_card` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_rel_group` FOREIGN KEY (`card_rel_group_id`) REFERENCES `card_rel_group` (`card_rel_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_rel_mpp` FOREIGN KEY (`user_epp_id`) REFERENCES `user_epp_class` (`user_epp_class_ide`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_rel_type` FOREIGN KEY (`card_rel_type_id`) REFERENCES `card_rel_type` (`card_rel_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_rel_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardRelTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_rel_group
CREATE TABLE IF NOT EXISTS `card_rel_group` (
    `card_rel_group_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardRelGroupId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `card_id` int(15) NOT NULL COMMENT 'CardId',
    `name` varchar(50) NOT NULL COMMENT 'Name',
    `description` varchar(250) NOT NULL COMMENT 'Description`',
    `status` varchar(25) NOT NULL COMMENT 'status',
    `card_rel_group_parent_id` int(15) DEFAULT NULL COMMENT 'CardRelGroupParentId`',
    `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedDate',
    `created_by` int(15) NOT NULL COMMENT 'CreatedBy',
    `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `updated_by` int(15) NOT NULL COMMENT 'UpdatedBy',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_rel_group_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `user_id` (`user_id`),
    KEY `card_id` (`card_id`),
    KEY `status` (`status`),
    KEY `fk_card_rel_group_parent` (`card_rel_group_parent_id`),
    KEY `fk_card_rel_group_updated_id` (`updated_by`),
    KEY `fk_card_rel_group_created_id` (`created_by`),
    CONSTRAINT `fk_card_rel_group_card` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_rel_group_created_id` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_rel_group_parent` FOREIGN KEY (`card_rel_group_parent_id`) REFERENCES `card_rel_group` (`card_rel_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_rel_group_updated_id` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_rel_group_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='C';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_rel_type
CREATE TABLE IF NOT EXISTS `card_rel_type` (
    `card_rel_type_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardRelTypeId',
    `name` varchar(25) NOT NULL COMMENT 'Name',
    `permissions` text NOT NULL COMMENT 'Permissions',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_rel_type_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardRelTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_setting
CREATE TABLE IF NOT EXISTS `card_setting` (
    `card_setting_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardSettingId',
    `card_id` int(15) NOT NULL COMMENT 'CardId',
    `tags` varchar(150) NOT NULL COMMENT 'tags',
    `label` varchar(50) NOT NULL COMMENT 'label',
    `value` varchar(1500) NULL COMMENT 'value',
    `options` varchar(1500) NULL COMMENT 'options',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_setting_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `card_id` (`card_id`),
    KEY `tags` (`card_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardRelTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_socialmedia
CREATE TABLE IF NOT EXISTS `card_socialmedia` (
    `card_socialmedia_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) NOT NULL DEFAULT '0',
    `division_id` int(15) NOT NULL DEFAULT '0',
    `user_id` int(15) DEFAULT NULL,
    `card_id` int(15) DEFAULT NULL,
    `connection_id` int(15) DEFAULT NULL,
    `action` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `display_order` int(5) DEFAULT NULL,
    `status` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL,
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`card_socialmedia_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `user_id` (`user_id`),
    KEY `card_id` (`card_id`),
    KEY `connection_id` (`connection_id`),
    KEY `action` (`action`),
    KEY `display_order` (`display_order`),
    KEY `status` (`status`),
    KEY `company_id` (`company_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_tab
CREATE TABLE IF NOT EXISTS `card_tab` (
    `card_tab_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardTab',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `division_id` int(15) NOT NULL COMMENT 'DivisionId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `card_page_version` int(15) DEFAULT NULL,
    `card_tab_type_id` int(5) DEFAULT NULL COMMENT 'CardTabTypeId',
    `title` varchar(100) NOT NULL COMMENT 'Title',
    `menu_title` varchar(20) NULL COMMENT 'MenuTitle',
    `url` varchar(150) NULL COMMENT 'Url',
    `content` mediumtext COMMENT 'Content',
    `order_number` int(3) NOT NULL COMMENT 'OrderNumber',
    `library_tab` tinyint(1) DEFAULT '0' COMMENT 'LibraryTab',
    `visibility` tinyint(1) DEFAULT '1' COMMENT 'Visibility',
    `permanent` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Permanent',
    `instance_count` int(5) DEFAULT '1' COMMENT 'InstanceCount',
    `card_tab_data` text COMMENT 'CardTabData',
    `created_on` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `created_by` int(15) NOT NULL COMMENT 'CreatedBy',
    `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `updated_by` int(15) NOT NULL COMMENT 'UpdatedBy',
    `old_card_id` int(15) DEFAULT NULL COMMENT 'OldCardId',
    `old_card_tab_id` int(15) DEFAULT NULL COMMENT 'OldCardTabId',
    `synced_state` int(2) DEFAULT NULL,
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_tab_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `user_id` (`user_id`),
    KEY `company_id` (`company_id`),
    KEY `url` (`url`),
    KEY `visibility` (`visibility`),
    KEY `fk_card_tab_division` (`division_id`),
    KEY `library_tab` (`library_tab`),
    KEY `fk_card_tab_created` (`created_by`),
    KEY `fk_card_tab_updated` (`updated_by`),
    KEY `fk_card_tab_type` (`card_tab_type_id`),
    KEY `card_page_version` (`card_page_version`),
    KEY `synced_state` (`synced_state`),
    CONSTRAINT `fk_card_cardPageVersion` FOREIGN KEY (`card_page_version`) REFERENCES `excell_versioning`.`card_page_versioning` (`card_page_version_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_tab_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_tab_created` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_tab_division` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_tab_type` FOREIGN KEY (`card_tab_type_id`) REFERENCES `card_tab_type` (`card_tab_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_tab_updated` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_tab_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardTabTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_tab_rel
CREATE TABLE IF NOT EXISTS `card_tab_rel` (
    `card_tab_rel_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardTabRelId',
    `card_tab_id` int(15) DEFAULT NULL COMMENT 'CardTabId',
    `card_id` int(15) DEFAULT NULL COMMENT 'CardId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `card_addon_id` int(15) DEFAULT NULL COMMENT 'CardAddonId',
    `order_line_id` int(15) DEFAULT NULL COMMENT 'OrderLineId',
    `rel_sort_order` int(5) DEFAULT NULL COMMENT 'RelSortOrder',
    `rel_visibility` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'RelVisibility',
    `card_tab_rel_title` varchar(100) DEFAULT NULL COMMENT 'CardTabRelTitle',
    `card_tab_rel_menu_title` varchar(20) DEFAULT NULL COMMENT 'CardTabRelTitle',
    `card_tab_rel_url` varchar(150) DEFAULT NULL COMMENT 'CardTabRelUrl',
    `card_tab_rel_data` text COMMENT 'CardTabRelData',
    `card_tab_rel_type` varchar(15) NOT NULL COMMENT 'CardTabRelType',
    `synced_state` int(2) NOT NULL DEFAULT '0',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_tab_rel_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `card_tab_id` (`card_tab_id`),
    KEY `card_id` (`card_id`),
    KEY `user_id` (`user_id`),
    KEY `order_line_id` (`order_line_id`),
    KEY `card_addon_id` (`card_addon_id`),
    KEY `synced_state` (`synced_state`),
    CONSTRAINT `fk_cardTabRel_cardAddon` FOREIGN KEY (`card_addon_id`) REFERENCES `card_addon` (`card_addon_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cardTabRel_orderLine` FOREIGN KEY (`order_line_id`) REFERENCES `excell_crm`.`order_line` (`order_line_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cardTabRel_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardTabRelTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_tab_type
CREATE TABLE IF NOT EXISTS `card_tab_type` (
    `card_tab_type_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardTabTypeId',
    `abbreviation` varchar(35) NOT NULL COMMENT 'Abbreviation',
    `name` varchar(75) NOT NULL COMMENT 'Name',
    `description` varchar(500) NOT NULL COMMENT 'Description',
    `sys_row_id` char(36) NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_tab_type_id`),
    UNIQUE KEY `abbreviation` (`abbreviation`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardTabTypeTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_tab_widget_property
CREATE TABLE IF NOT EXISTS `card_tab_widget_property` (
    `card_tab_widget_property_id` int(15) NOT NULL AUTO_INCREMENT,
    `card_tab_widget_id` int(15) DEFAULT NULL,
    `module_widget_type_id` int(15) DEFAULT NULL,
    `module_widget_source` varchar(25) DEFAULT NULL,
    `value` varchar(500) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`card_tab_widget_property_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `card_tab_widget_id` (`card_tab_widget_id`),
    KEY `module_widget_type_id_module_widget_source` (`module_widget_type_id`,`module_widget_source`),
    KEY `last_updated` (`last_updated`),
    KEY `created_at` (`created_on`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_template
CREATE TABLE IF NOT EXISTS `card_template` (
    `card_template_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL COMMENT 'CompanyId',
    `division_id` int(15) DEFAULT NULL COMMENT 'DivisionId',
    `name` varchar(50) NOT NULL COMMENT 'Name',
    `template_type` varchar(25) NOT NULL DEFAULT 'default' COMMENT 'TemplateType',
    `data` text COMMENT 'Data',
    `sys_row_id` char(36) NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_template_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `division_id` (`division_id`),
    CONSTRAINT `fk_card_template_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_card_template_division` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardTemplateTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_template
CREATE TABLE IF NOT EXISTS `card_template_company_rel` (
    `card_template_company_rel_id` int(15) NOT NULL AUTO_INCREMENT,
    `card_template_id` int(15) NOT NULL COMMENT 'CardTemplateId',
    `company_id` int(15) DEFAULT NULL COMMENT 'CompanyId',
    `sys_row_id` char(36) NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_template_company_rel_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `card_template_id` (`card_template_id`),
    KEY `company_id` (`company_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardTemplateCompanyRelTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_type
CREATE TABLE IF NOT EXISTS `card_type` (
    `card_type_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'CardTypeId',
    `name` varchar(25) NOT NULL COMMENT 'Name',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`card_type_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CardRelTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.card_user_credentials
CREATE TABLE IF NOT EXISTS `card_user_credentials` (
    `card_user_credential_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `card_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL,
    `status` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
    `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`card_user_credential_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `card_id` (`card_id`),
    KEY `user_id` (`user_id`),
    KEY `status` (`status`),
    KEY `company_id` (`company_id`),
    KEY `division_id` (`division_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.cart
CREATE TABLE IF NOT EXISTS `cart` (
    `cart_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL,
    `price` decimal(10,2) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`cart_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `user_id` (`user_id`),
    KEY `fk_cart_division_id` (`division_id`),
    CONSTRAINT `fk_cart_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cart_division_id` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cart_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.cart_line
CREATE TABLE IF NOT EXISTS `cart_line` (
    `cart_line_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `package_id` int(15) DEFAULT NULL,
    `product_id` int(15) DEFAULT NULL,
    `order_id` int(15) DEFAULT NULL,
    `order_line_id` int(15) DEFAULT NULL,
    `cart_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL,
    `price` decimal(10,2) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`cart_line_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `cart_id` (`cart_id`),
    KEY `company_id` (`company_id`),
    KEY `package_id` (`package_id`),
    KEY `product_id` (`product_id`),
    KEY `last_updated` (`last_updated`),
    KEY `created_on` (`created_on`),
    KEY `order_id` (`order_id`),
    KEY `order_line_id` (`order_line_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `FK_cart_line_excell_crm.order_line` FOREIGN KEY (`order_line_id`) REFERENCES `excell_crm`.`order_line` (`order_line_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_cart_line_excell_crm.orders` FOREIGN KEY (`order_id`) REFERENCES `excell_crm`.`orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cart_line_cart_id` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cart_line_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cart_line_package_id` FOREIGN KEY (`package_id`) REFERENCES `package` (`package_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cart_line_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_cart_line_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.company
CREATE TABLE IF NOT EXISTS `company` (
    `company_id` int(15) NOT NULL COMMENT 'CompanyID',
    `company_name` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'CompanyName',
    `platform_name` varchar(50) NOT NULL,
    `parent_id` int(15) DEFAULT '0',
    `owner_id` int(15) DEFAULT NULL,
    `default_sponsor_id` int(15) DEFAULT NULL,
    `status` varchar(15) DEFAULT NULL,
    `domain_portal` varchar(75) CHARACTER SET utf8 DEFAULT NULL,
    `domain_portal_ssl` tinyint(1) DEFAULT '0',
    `domain_portal_name` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
    `domain_public` varchar(75) CHARACTER SET utf8 DEFAULT NULL,
    `domain_public_ssl` tinyint(1) DEFAULT '0',
    `domain_public_name` varchar(35) CHARACTER SET utf8 DEFAULT NULL,
    `public_domain_404_redirect` varchar(75) DEFAULT NULL,
    `address_1` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Address1',
    `address_2` varchar(35) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Address2',
    `address_3` varchar(25) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Address3',
    `city` varchar(45) CHARACTER SET utf8 DEFAULT NULL COMMENT 'City',
    `state` varchar(25) CHARACTER SET utf8 DEFAULT NULL COMMENT 'State',
    `country` varchar(35) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Coutnry',
    `phone_number` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'PhoneNumber',
    `fein` int(9) DEFAULT NULL COMMENT 'FEINNumber',
    `legal_name` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT 'LegalName',
    `customer_support_email` varchar(150) DEFAULT NULL,
    `logo_url` varchar(150) CHARACTER SET utf8 DEFAULT NULL COMMENT 'LogoUrl',
    `commissions` tinyint(1) DEFAULT NULL COMMENT 'Commissions',
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) CHARACTER SET utf8 DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`company_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `domain_portal` (`domain_portal`),
    KEY `domain_public` (`domain_public`),
    KEY `parent_id` (`parent_id`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.company_department
CREATE TABLE IF NOT EXISTS `company_department` (
    `company_department_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `department_class_id` int(11) DEFAULT NULL,
    `department_type_id` int(11) DEFAULT NULL,
    `parent_department_id` int(15) DEFAULT NULL,
    `name` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `label` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `receives_promo_card` tinyint(1) DEFAULT '0',
    `promo_card_per_user` smallint(3) DEFAULT '1',
    `read_only` tinyint(1) DEFAULT '0',
    `can_receive_tickets` smallint(3) DEFAULT '1',
    `can_create_tickets` smallint(3) unsigned DEFAULT '1',
    `can_edit_tickets` tinyint(1) DEFAULT '1',
    `can_delete_tickets` tinyint(1) DEFAULT '1',
    `can_view_customers` tinyint(1) DEFAULT '0',
    `can_create_customers` tinyint(1) DEFAULT '0',
    `can_edit_customers` tinyint(1) unsigned DEFAULT '0',
    `can_delete_customers` tinyint(1) DEFAULT '0',
    `can_view_users` tinyint(1) DEFAULT '0',
    `can_create_users` tinyint(1) DEFAULT '0',
    `can_edit_users` tinyint(1) DEFAULT '0',
    `can_delete_users` tinyint(1) DEFAULT '0',
    `can_view_cards` tinyint(1) DEFAULT '0',
    `can_purchase_cards` tinyint(1) DEFAULT '0',
    `can_edit_cards` tinyint(1) DEFAULT '0',
    `can_delete_cards` tinyint(1) DEFAULT '0',
    `can_view_tool_owners` tinyint(1) DEFAULT '0',
    `can_create_tool_owners` tinyint(1) DEFAULT '0',
    `can_edit_tool_owners` tinyint(1) DEFAULT '0',
    `can_delete_tool_owners` tinyint(1) DEFAULT '0',
    `can_view_tools` tinyint(1) DEFAULT '0',
    `can_create_tools` tinyint(1) DEFAULT '0',
    `can_edit_tools` tinyint(1) DEFAULT '0',
    `can_delete_tools` tinyint(1) DEFAULT '0',
    `can_view_packages` tinyint(1) DEFAULT '0',
    `can_create_packages` tinyint(1) unsigned zerofill DEFAULT '0',
    `can_edit_packages` tinyint(1) DEFAULT '0',
    `can_delete_packages` tinyint(1) DEFAULT '0',
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`company_department_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `division_id` (`division_id`),
    KEY `parent_department_id` (`parent_department_id`),
    KEY `department_class` (`department_class_id`) USING BTREE,
    KEY `department_type` (`department_type_id`) USING BTREE,
    CONSTRAINT `fk_companydepartment_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_companydepartment_departmentclass` FOREIGN KEY (`department_class_id`) REFERENCES `company_department_class` (`department_class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_companydepartment_departmenttype` FOREIGN KEY (`department_type_id`) REFERENCES `company_department_type` (`department_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_companydepartment_parentdepartment` FOREIGN KEY (`parent_department_id`) REFERENCES `company_department` (`company_department_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping structure for table excell_main.company_department_class
CREATE TABLE IF NOT EXISTS `company_department_class` (
    `department_class_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `class_parent_id` int(15) DEFAULT NULL,
    `label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `description` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`department_class_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `class_parent_id` (`class_parent_id`),
    KEY `company_id` (`company_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.company_department_type
CREATE TABLE IF NOT EXISTS `company_department_type` (
    `department_type_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `type_parent_id` int(15) DEFAULT NULL,
    `label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `description` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`department_type_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `type_parent_id` (`type_parent_id`),
    KEY `company_id` (`company_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping structure for table excell_main.company_department_user_rel
CREATE TABLE IF NOT EXISTS `company_department_user_rel` (
    `department_user_rel_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `department_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`department_user_rel_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `user_id` (`user_id`),
    KEY `department_id` (`department_id`),
    KEY `last_updated` (`last_updated`),
    KEY `created_on` (`created_on`),
    CONSTRAINT `fk_companydepartmentuserrel_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_companydepartmentuserrel_department` FOREIGN KEY (`department_id`) REFERENCES `company_department` (`company_department_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_companydepartmentuserrel_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping structure for table excell_main.company_department_user_role
CREATE TABLE IF NOT EXISTS `company_department_user_role` (
    `department_user_role_id` int(10) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `name` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `abbreviation` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `sys_row_id` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`department_user_role_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `abbreviation_unique` (`abbreviation`),
    KEY `company_id` (`company_id`),
    KEY `abbreviation` (`abbreviation`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping structure for table excell_main.company_department_user_ticketqueue_role
CREATE TABLE IF NOT EXISTS `company_department_user_ticketqueue_role` (
    `user_ticketqueue_role_id` int(15) NOT NULL AUTO_INCREMENT,
    `user_id` int(15) DEFAULT NULL,
    `ticket_queue_id` int(15) DEFAULT NULL,
    `department_user_role` int(10) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL,
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`user_ticketqueue_role_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `created_on` (`created_on`),
    KEY `user_id` (`user_id`),
    KEY `ticket_queue_id` (`ticket_queue_id`),
    KEY `department_user_role` (`department_user_role`),
    CONSTRAINT `fk_userticketqueue_ticketqueu` FOREIGN KEY (`ticket_queue_id`) REFERENCES `excell_crm`.`ticket_queue` (`ticket_queue_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_userticketqueue_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_userticketqueue_userrole` FOREIGN KEY (`department_user_role`) REFERENCES `company_department_user_role` (`department_user_role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping structure for table excell_main.company_setting
CREATE TABLE IF NOT EXISTS `company_setting` (
    `company_setting_id` int(11) NOT NULL AUTO_INCREMENT,
    `company_id` int(11) DEFAULT NULL,
    `label` varchar(35) DEFAULT NULL,
    `value` varchar(7500) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`company_setting_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `fk_company_settings_company` (`company_id`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`),
    KEY `label` (`label`),
    CONSTRAINT `fk_company_settings_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.connection
CREATE TABLE IF NOT EXISTS `connection` (
    `connection_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ConnectionId',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `division_id` int(15) NOT NULL COMMENT 'DivisionId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `connection_type_id` int(15) NOT NULL COMMENT 'ConnectionTypeId',
    `connection_label` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `connection_value` varchar(150) CHARACTER SET utf8 NOT NULL COMMENT 'ConnectionValue',
    `is_primary` tinyint(1) NOT NULL COMMENT 'IsPrimary',
    `connection_class` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ConnectionClass',
    `sys_row_id` char(36) CHARACTER SET utf8 NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`connection_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `division_id` (`division_id`),
    KEY `user_id` (`user_id`),
    KEY `connection_type` (`connection_type_id`),
    KEY `connection_label` (`connection_label`),
    KEY `connection_value` (`connection_value`),
    CONSTRAINT `fk_connection_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_connection_division` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_connection_type` FOREIGN KEY (`connection_type_id`) REFERENCES `connection_type` (`connection_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_connection_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.connection_rel
CREATE TABLE IF NOT EXISTS `connection_rel` (
    `connection_rel_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ConnectionRelId',
    `connection_id` int(15) NOT NULL COMMENT 'ConnectionId',
    `card_id` int(15) DEFAULT NULL COMMENT 'CardId',
    `card_rel_group_id` int(15) DEFAULT NULL COMMENT 'CardRelGroupId',
    `status` varchar(15) NOT NULL DEFAULT 'Active' COMMENT 'Status',
    `action` varchar(15) NOT NULL DEFAULT 'link' COMMENT 'Action',
    `display_order` int(15) DEFAULT NULL COMMENT 'DisplayOrder',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`connection_rel_id`),
    KEY `connection_id` (`connection_id`),
    KEY `card_id` (`card_id`),
    CONSTRAINT `fk_connection_id` FOREIGN KEY (`connection_id`) REFERENCES `connection` (`connection_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_connection_rel_card` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='UserConnectionRelTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.connection_type
CREATE TABLE IF NOT EXISTS `connection_type` (
    `connection_type_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ConnectionTypeId',
    `abbreviation` varchar(25) NOT NULL COMMENT 'Abbreviation',
    `name` varchar(50) NOT NULL COMMENT 'Name',
    `action` varchar(15) NOT NULL COMMENT 'Action',
    `font_awesome` varchar(35) NOT NULL,
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`connection_type_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `name` (`abbreviation`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ConnectionTypeTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.contact
CREATE TABLE IF NOT EXISTS `contact` (
    `contact_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ContactId',
    `company_id` int(15) NOT NULL DEFAULT '0' COMMENT 'CompanyId',
    `division_id` int(15) NOT NULL DEFAULT '0' COMMENT 'DivisionId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `first_name` varchar(50) DEFAULT NULL COMMENT 'FirstName',
    `last_name` varchar(50) DEFAULT NULL COMMENT 'LastName',
    `phone` varchar(10) DEFAULT NULL COMMENT 'Phone',
    `email` varchar(150) DEFAULT NULL COMMENT 'Email',
    `birth_date` datetime DEFAULT NULL COMMENT 'BirthDate',
    `created_on` datetime DEFAULT NULL COMMENT 'CreatedOn',
    `last_updated` datetime DEFAULT NULL COMMENT 'LastUpdated',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`contact_id`),
    UNIQUE KEY `phone` (`phone`),
    KEY `user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ContactTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.contact_card_rel
CREATE TABLE IF NOT EXISTS `contact_card_rel` (
    `contact_card_rel_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ContactCardRelId',
    `contact_id` int(15) NOT NULL COMMENT 'ContactId',
    `card_id` int(15) NOT NULL COMMENT 'CardId',
    PRIMARY KEY (`contact_card_rel_id`),
    KEY `contact_id` (`contact_id`),
    KEY `card_id` (`card_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf32 COMMENT='ContactCardRelTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.contact_group
CREATE TABLE IF NOT EXISTS `contact_group` (
    `contact_group_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ContactGroupId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `title` varchar(75) NOT NULL COMMENT 'Title',
    `description` varchar(255) DEFAULT NULL COMMENT 'Description',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`contact_group_id`),
    KEY `user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ContactGroupTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.contact_user_rel
CREATE TABLE IF NOT EXISTS `contact_user_rel` (
    `contact_user_rel_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ContactUserRelId',
    `contact_id` int(15) DEFAULT NULL COMMENT 'ContactId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    PRIMARY KEY (`contact_user_rel_id`),
    KEY `contact_id` (`contact_id`),
    KEY `user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf32 COMMENT='ContactUserRelTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.contact_user_rel
CREATE TABLE IF NOT EXISTS `domain_ssl` (
    `domain_ssl_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'DomainSslId',
    `company_id` int(15) DEFAULT NULL COMMENT 'CompanyId',
    `card_domain_id` int(15) DEFAULT NULL COMMENT 'CardDomainId',
    `domain` varchar(255) DEFAULT NULL COMMENT 'DomainName',
    `key_value` text DEFAULT NULL COMMENT 'DomainKey',
    PRIMARY KEY (`domain_ssl_id`),
    KEY `domain` (`domain`),
    KEY `company_id` (`company_id`),
    KEY `card_domain_id` (`card_domain_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf32 COMMENT='DomainSslTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.division
CREATE TABLE IF NOT EXISTS `division` (
    `division_id` int(15) NOT NULL COMMENT 'DivisionID',
    `company_id` int(15) NOT NULL DEFAULT '0' COMMENT 'CompanyID',
    `division_parent_id` int(15) DEFAULT '0' COMMENT 'DivisionParentID',
    `division_name` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'DivisionName',
    `address_1` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'Address1',
    `address_2` varchar(35) CHARACTER SET utf8 NOT NULL COMMENT 'Address2',
    `address_3` varchar(25) CHARACTER SET utf8 NOT NULL COMMENT 'Address3',
    `city` varchar(45) CHARACTER SET utf8 NOT NULL COMMENT 'City',
    `state` varchar(25) CHARACTER SET utf8 DEFAULT NULL COMMENT 'State',
    `zip` int(10) DEFAULT NULL COMMENT 'Zip',
    `country` varchar(35) CHARACTER SET utf8 NOT NULL COMMENT 'Country',
    `phone_number` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT 'PhoneNumber',
    `fein` int(9) NOT NULL COMMENT 'FEINNumber',
    `legal_name` varchar(200) CHARACTER SET utf8 NOT NULL COMMENT 'LegalName',
    `logo_url` varchar(150) CHARACTER SET utf8 NOT NULL COMMENT 'LogoUrl',
    `sys_row_id` char(36) CHARACTER SET utf8 DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`division_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `division_parent_id` (`division_parent_id`),
    CONSTRAINT `fk_division_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_division_division_parent` FOREIGN KEY (`division_parent_id`) REFERENCES `division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.package
CREATE TABLE IF NOT EXISTS `package` (
    `package_id` int(15) NOT NULL AUTO_INCREMENT,
    `type` varchar(25) DEFAULT "default", -- "bundle" will include a parent_id value
    `source` varchar(25) DEFAULT "system", -- this also will include other apps that want to sell products e.g., "directory"
    `parent_id` int(15) DEFAULT NULL,
    `company_id` int(15) NOT NULL DEFAULT '0',
    `division_id` int(15) NOT NULL DEFAULT '0',
    `enduser_id` int(15) DEFAULT '1',
    `bundle_id` int(15) DEFAULT NULL,
    `name` varchar(75) DEFAULT NULL,
    `description` varchar(500) DEFAULT NULL,
    `content` text DEFAULT NULL,
    `currency` varchar(10) DEFAULT 'usd',
    `order` int(11) DEFAULT NULL,
    `max_quantity` int(5) DEFAULT NULL,
    `hide_line_items` tinyint(4) DEFAULT NULL,
    `image_url` varchar(150) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`package_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `type` (`type`),
    KEY `package_id_type` (`package_id`,`type`),
    KEY `division_id` (`division_id`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`),
    KEY `enduser_id` (`enduser_id`),
    CONSTRAINT `fk_package_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`),
    CONSTRAINT `fk_package_division_id` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`),
    CONSTRAINT `fk_package_enduser_id` FOREIGN KEY (`enduser_id`) REFERENCES `product_enduser` (`product_enduser_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping structure for table excell_main.package_class
CREATE TABLE IF NOT EXISTS `package_class` (
    `package_class_id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`package_class_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Dumping structure for table excell_main.package_class
CREATE TABLE IF NOT EXISTS `package_variation` (
    `package_variation_id` int(11) NOT NULL AUTO_INCREMENT,
    `package_id` int(11) NOT NULL,
    `name` varchar(50) DEFAULT NULL,
    `description` varchar(2000) DEFAULT NULL,
    `type` varchar(25) DEFAULT "billing",
    `promo_price` decimal(10,2) DEFAULT NULL,
    `regular_price` decimal(10,2) DEFAULT '0.00',
    `image` varchar(250) DEFAULT NULL,
    `order` int(5) DEFAULT 1,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`package_variation_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping structure for table excell_main.package_class_rel
CREATE TABLE IF NOT EXISTS `package_class_rel` (
    `package_class_rel_id` int(15) NOT NULL AUTO_INCREMENT,
    `package_id` int(15) DEFAULT '0',
    `package_class_id` int(15) DEFAULT '0',
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`package_class_rel_id`),
    KEY `package_id` (`package_id`),
    KEY `package_class_id` (`package_class_id`),
    CONSTRAINT `package_class_rel_package_class_id` FOREIGN KEY (`package_class_id`) REFERENCES `package_class` (`package_class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `package_class_rel_package_id` FOREIGN KEY (`package_id`) REFERENCES `package` (`package_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping structure for table excell_main.package_line
CREATE TABLE IF NOT EXISTS `package_line` (
    `package_line_id` int(15) NOT NULL AUTO_INCREMENT,
    `package_variation_id` int(15) DEFAULT NULL,
    `package_id` int(15) DEFAULT NULL,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `product_entity` varchar(35) DEFAULT '',
    `product_entity_id` int(15) DEFAULT NULL,
    `journey_id` int(15) DEFAULT NULL,
    `name` varchar(75) DEFAULT '',
    `description` varchar(500) DEFAULT '',
    `quantity` int(5) DEFAULT NULL,
    `cycle_type` int(3) DEFAULT NULL,
    `promo_price` decimal(10,2) DEFAULT '0.00',
    `promo_price_duration` int(5) DEFAULT NULL,
    `regular_price` decimal(10,2) DEFAULT '0.00',
    `regular_price_duration` int(5) DEFAULT NULL,
    `currency` varchar(10) DEFAULT 'usd',
    `product_price_override` decimal(10,2) DEFAULT NULL,
    `product_promo_price_override` decimal(10,2) DEFAULT NULL,
    `order` int(5) DEFAULT '0',
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`package_line_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `fk_package_id_package` (`package_id`),
    KEY `product_entity` (`product_entity`,`product_entity_id`),
    KEY `company_id` (`company_id`),
    KEY `journey_id` (`journey_id`),
    KEY `order` (`order`),
    KEY `created_on` (`created_on`),
    CONSTRAINT `fk_package_id_package` FOREIGN KEY (`package_id`) REFERENCES `package` (`package_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `fk_packageline_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_packageline_journey` FOREIGN KEY (`journey_id`) REFERENCES `excell_crm`.`journey` (`journey_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping structure for table excell_main.package_line_setting
CREATE TABLE IF NOT EXISTS `package_line_setting` (
    `package_line_setting_id` int(15) NOT NULL AUTO_INCREMENT,
    `package_line_id` int(15) DEFAULT NULL,
    `label` varchar(25) DEFAULT NULL,
    `value` varchar(2500) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(50) DEFAULT NULL,
    PRIMARY KEY (`package_line_setting_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `package_line_id` (`package_line_id`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`),
    KEY `label` (`label`),
    CONSTRAINT `fk_package_line_setting_pacakge_line` FOREIGN KEY (`package_line_id`) REFERENCES `package_line` (`package_line_id`) ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping structure for table excell_main.page
CREATE TABLE IF NOT EXISTS `page` (
    `page_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'PageId',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `page_parent_id` int(15) DEFAULT NULL COMMENT 'PageParentId',
    `division_id` int(15) NOT NULL COMMENT 'DivisionId',
    `unique_url` varchar(250) NOT NULL COMMENT 'UniqueUrl',
    `title` varchar(150) NOT NULL COMMENT 'Title',
    `excerpt` varchar(250) NOT NULL COMMENT 'Excerpt',
    `uri_request_list` varchar(500) NOT NULL COMMENT 'UriRequestList',
    `columns` int(1) NOT NULL DEFAULT '1' COMMENT 'Columns',
    `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `created_by` int(15) NOT NULL COMMENT 'CreatedBy',
    `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `updated_by` int(15) NOT NULL COMMENT 'UpdatedBy',
    `meta_title` varchar(60) NOT NULL COMMENT 'MetaTitle',
    `meta_description` varchar(300) NOT NULL COMMENT 'MetaDescription',
    `meta_keywords` varchar(250) NOT NULL COMMENT 'MetaKeywords',
    `menu_name` varchar(35) NOT NULL COMMENT 'MenuName',
    `menu_order` int(5) NOT NULL DEFAULT '0' COMMENT 'MenuOrder',
    `menu_visibility` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'MenuVisibility',
    `status` varchar(15) NOT NULL DEFAULT 'draft' COMMENT 'PageStatus',
    `locked_for_editing` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'LockedForEditing',
    `ddr_widget` varchar(25) DEFAULT NULL COMMENT 'DdrWidget',
    `type` varchar(10) NOT NULL DEFAULT 'page' COMMENT 'PageType',
    `page_data` mediumtext COMMENT 'PageData',
    PRIMARY KEY (`page_id`),
    UNIQUE KEY `unique_url` (`unique_url`),
    KEY `fk_page_created` (`created_by`),
    KEY `fk_page_updated` (`updated_by`),
    KEY `fk_page_company` (`company_id`),
    KEY `fk_page_division` (`division_id`),
    KEY `fk_page_parentpage` (`page_parent_id`),
    CONSTRAINT `fk_page_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_page_created` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_page_division` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_page_parentpage` FOREIGN KEY (`page_parent_id`) REFERENCES `page` (`page_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_page_updated` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='PageTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.page_block
CREATE TABLE IF NOT EXISTS `page_block` (
    `page_block_id` int(15) NOT NULL COMMENT 'PageBlockId',
    `page_id` int(15) NOT NULL COMMENT 'PageId',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `division_id` int(15) NOT NULL COMMENT 'DivisionId',
    `title` varchar(100) NOT NULL COMMENT 'Title',
    `description` varchar(250) NOT NULL COMMENT 'Description',
    `sort_order` int(5) NOT NULL DEFAULT '0' COMMENT 'SortOrder',
    `visibility` tinyint(1) DEFAULT '1' COMMENT 'Visibility',
    `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `created_by` int(15) NOT NULL COMMENT 'CreatedBy',
    `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `updated_by` int(15) NOT NULL COMMENT 'UpdatedBy',
    `block_data` mediumtext COMMENT 'BlockData',
    PRIMARY KEY (`page_block_id`),
    KEY `page_id` (`page_id`),
    KEY `fk_pageblock_created` (`created_by`),
    KEY `fk_pageblock_updated` (`updated_by`),
    KEY `fk_pageblock_company` (`company_id`),
    KEY `fk_pageblock_division` (`division_id`),
    CONSTRAINT `fk_pageblock_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_pageblock_created` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_pageblock_division` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_pageblock_page` FOREIGN KEY (`page_id`) REFERENCES `page` (`page_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_pageblock_updated` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='PageBlockTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.payment_type
CREATE TABLE IF NOT EXISTS `payment_type` (
    `payment_type_id` int(5) NOT NULL AUTO_INCREMENT,
    `type_name` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'description',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
    PRIMARY KEY (`payment_type_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.product
CREATE TABLE IF NOT EXISTS `product` (
    `product_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ProductId',
    `product_class_id` int(5) DEFAULT '1' COMMENT 'ProductClassId',
    `product_type_id` int(15) DEFAULT NULL COMMENT 'ProductTypeId',
    `product_enduser_id` int(5) DEFAULT '1',
    `title` varchar(50) DEFAULT NULL COMMENT 'Title',
    `abbreviation` varchar(75) DEFAULT NULL COMMENT 'Abbreviation',
    `display_name` varchar(35) DEFAULT NULL COMMENT 'DisplayName',
    `description` varchar(250) DEFAULT NULL COMMENT 'Description',
    `source_uuid` char(36) DEFAULT NULL,
    `min_package_value` decimal(10,2) DEFAULT NULL,
    `promo_value` decimal(6,2) DEFAULT NULL COMMENT 'PromoValue',
    `promo_cycle_duration` int(5) DEFAULT NULL COMMENT 'PromoCycleDuration',
    `value` decimal(6,2) DEFAULT NULL COMMENT 'Value',
    `value_duration` int(2) DEFAULT '0' COMMENT 'BillingCount',
    `cycle_type` int(15) DEFAULT NULL COMMENT 'AccrualCycle',
    `status` varchar(15) DEFAULT 'Active' COMMENT 'Status',
    `created_on` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`product_id`),
    UNIQUE KEY `abbreviation` (`abbreviation`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `package_type_id` (`product_type_id`) USING BTREE,
    KEY `fk_package_class` (`product_class_id`),
    KEY `status` (`status`),
    KEY `widget_uuid` (`source_uuid`) USING BTREE,
    KEY `fk_package_plan_cycle` (`cycle_type`) USING BTREE,
    KEY `end_user_id` (`product_enduser_id`) USING BTREE,
    CONSTRAINT `fk_package_class` FOREIGN KEY (`product_class_id`) REFERENCES `product_class` (`product_class_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_package_cycle` FOREIGN KEY (`cycle_type`) REFERENCES `product_cycle` (`product_cycle_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_package_enduser` FOREIGN KEY (`product_enduser_id`) REFERENCES `product_enduser` (`product_enduser_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_package_type` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`product_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ProductTable for Excell  3.0';

-- Dumping structure for table excell_main.product_class
CREATE TABLE IF NOT EXISTS `product_class` (
    `product_class_id` int(15) NOT NULL COMMENT 'ProductClassId',
    `name` varchar(100) NOT NULL COMMENT 'Name',
    `promo_code_prefix` varchar(10) NOT NULL COMMENT 'PromoCodePrefix',
    `class_type` varchar(25) NOT NULL COMMENT 'ClassType',
    `user_class_type_id` int(15) DEFAULT NULL COMMENT 'UserClassTypeId',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`product_class_id`),
    UNIQUE KEY `promo_code_prefix` (`promo_code_prefix`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ProductClassTable for Excell  3.0';

-- Dumping structure for table excell_main.product_cycle
CREATE TABLE IF NOT EXISTS `product_cycle` (
    `product_cycle_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ProductCycleId',
    `name` varchar(50) NOT NULL COMMENT 'Name',
    `description` varchar(250) DEFAULT NULL COMMENT 'Description',
    `seconds` int(9) NOT NULL COMMENT 'Seconds',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`product_cycle_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ProductCycleTable for Excell  3.0';

-- Dumping structure for table excell_main.product_enduser
CREATE TABLE IF NOT EXISTS `product_enduser` (
    `product_enduser_id` int(15) NOT NULL AUTO_INCREMENT,
    `enduser_label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`product_enduser_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `enduser_label` (`enduser_label`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping structure for table excell_main.product_type
CREATE TABLE IF NOT EXISTS `product_type` (
    `product_type_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ProductTypeId',
    `product_primary` tinyint(1) DEFAULT NULL COMMENT 'ProductPrimary',
    `abbreviation` varchar(15) NOT NULL COMMENT 'Abbreviation',
    `name` varchar(50) NOT NULL COMMENT 'Name',
    `description` varchar(250) DEFAULT NULL COMMENT 'Description',
    `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`product_type_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `package_type_parent_id` (`product_primary`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ProductTypeTable for Excell  3.0';

-- Dumping structure for table excell_main.promo_code
CREATE TABLE IF NOT EXISTS `promo_code` (
    `promo_code_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT '0',
    `entity_type` varchar(50) DEFAULT NULL,
    `entity_id` int(15) unsigned DEFAULT NULL,
    `promo_code` varchar(25) NOT NULL DEFAULT '',
    `title` varchar(50) DEFAULT NULL,
    `description` varchar(500) DEFAULT NULL,
    `promo_discount_value` decimal(10,2) DEFAULT NULL,
    `discount_value` decimal(10,2) DEFAULT NULL,
    `discount_type` varchar(5) DEFAULT NULL,
    `min_entity_value` decimal(10,2) DEFAULT NULL,
    `expiration_date` datetime DEFAULT NULL,
    `test_only` tinyint(4) DEFAULT '0',
    `expired` tinyint(4) DEFAULT '0',
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`promo_code_id`),
    UNIQUE KEY `company_id_promo_code` (`company_id`,`promo_code`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`),
    KEY `discount_value` (`discount_value`),
    KEY `discount_type` (`discount_type`),
    KEY `expired` (`expired`),
    KEY `promo_value` (`promo_discount_value`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping structure for table excell_main.scan
CREATE TABLE IF NOT EXISTS `scan` (
    `scan_id` int(15) NOT NULL COMMENT 'ScanId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `contact_id` int(15) DEFAULT NULL COMMENT 'ContactId',
    `owner_id` int(15) NOT NULL COMMENT 'OwnerId',
    `scan_group_id` int(15) DEFAULT NULL COMMENT 'ScanGroupId',
    `url` varchar(255) NOT NULL COMMENT 'Url',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`scan_id`),
    UNIQUE KEY `user_id` (`user_id`),
    UNIQUE KEY `contact_id` (`contact_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `scan_group_id` (`scan_group_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ScanTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.scan_group
CREATE TABLE IF NOT EXISTS `scan_group` (
    `scan_group_id` int(15) NOT NULL COMMENT 'ScanGroupId',
    `user_id` int(11) NOT NULL COMMENT 'UserId',
    `title` varchar(75) CHARACTER SET utf8 NOT NULL COMMENT 'Title',
    `description` int(255) DEFAULT NULL COMMENT 'Description',
    `sys_row_id` char(36) CHARACTER SET utf8 DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`scan_group_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='ScanGroupTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for procedure excell_main.UpdateCardTabs
DELIMITER //
CREATE PROCEDURE `UpdateCardTabs`(IN intSourceRel INT, IN strDestinationRels VARCHAR(255))
BEGIN

	SET @cardTab = (SELECT ctr1.card_tab_id FROM card_tab_rel ctr1 WHERE ctr1.card_tab_rel_id = intSourceRel LIMIT 1);

UPDATE
    card_tab
SET
    library_tab = 1
WHERE
        card_tab_id = @cardTab
    LIMIT 1;

UPDATE
    card_tab_rel
SET
    card_tab_rel_type = 'mirror'
WHERE
        card_tab_rel_id = intSourceRel
    LIMIT 1;

IF @cardTab > 0 THEN
		SET @sql = CONCAT('UPDATE 
			card_tab_rel 
		SET 
			card_tab_id = @cardTab, 
			card_tab_rel_type = \'mirror\' 
		WHERE 
			card_tab_rel_id IN (',strDestinationRels,');');
PREPARE stmt FROM @SQL;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

END IF;

END//
DELIMITER ;

-- Dumping structure for table excell_main.user
CREATE TABLE IF NOT EXISTS `user` (
    `user_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'UserId',
    `division_id` int(15) DEFAULT NULL COMMENT 'DivisionId',
    `company_id` int(15) DEFAULT '0' COMMENT 'CompanyId',
    `sponsor_id` int(15) DEFAULT NULL COMMENT 'SponsorId',
    `first_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'FirstName',
    `last_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'LastName',
    `name_prefx` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT 'NamePrefix',
    `middle_name` varchar(45) CHARACTER SET utf8 DEFAULT NULL COMMENT 'MiddleName',
    `name_sufx` varchar(15) CHARACTER SET utf8 DEFAULT NULL COMMENT 'NameSufix',
    `username` varchar(35) CHARACTER SET utf8 DEFAULT NULL COMMENT 'UserName',
    `password` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Password',
    `password_reset_token` char(36) CHARACTER SET utf8 DEFAULT NULL COMMENT 'PasswordResetToken',
    `pin` int(6) DEFAULT NULL COMMENT 'Pin',
    `user_email` int(15) DEFAULT NULL COMMENT 'UserEmail',
    `user_phone` int(15) DEFAULT NULL COMMENT 'UserPhone',
    `created_on` datetime DEFAULT NULL COMMENT 'CreatedOn',
    `created_by` int(15) DEFAULT NULL COMMENT 'CreatedBy',
    `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `updated_by` int(15) DEFAULT NULL COMMENT 'UpdatedBy',
    `status` varchar(15) CHARACTER SET utf8 DEFAULT 'Active' COMMENT 'Status',
    `preferred_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT 'PreferredName',
    `last_login` datetime DEFAULT NULL COMMENT 'LastLogin',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `user_email` (`user_email`),
    UNIQUE KEY `user_phone` (`user_phone`),
    KEY `sponsor_id` (`sponsor_id`),
    KEY `company_id` (`company_id`),
    KEY `division_id` (`division_id`),
    KEY `status_id` (`status`) USING BTREE,
    KEY `fk_user_created_by` (`created_by`),
    KEY `fk_user_updated_by` (`updated_by`),
    KEY `first_name` (`first_name`),
    KEY `last_name` (`last_name`),
    CONSTRAINT `fk_user_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_division` FOREIGN KEY (`division_id`) REFERENCES `division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_email` FOREIGN KEY (`user_email`) REFERENCES `connection` (`connection_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_phone` FOREIGN KEY (`user_phone`) REFERENCES `connection` (`connection_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_sponsor` FOREIGN KEY (`sponsor_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='UserTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.user_address
CREATE TABLE IF NOT EXISTS `user_address` (
    `address_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'AddressId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `display_name` varchar(35) DEFAULT NULL COMMENT 'DisplayName',
    `address_1` varchar(50) DEFAULT NULL COMMENT 'Address1',
    `address_2` varchar(35) DEFAULT NULL COMMENT 'Address2',
    `address_3` varchar(25) DEFAULT NULL COMMENT 'Address3',
    `city` varchar(50) DEFAULT NULL COMMENT 'City',
    `state` varchar(25) DEFAULT NULL COMMENT 'State',
    `zip` int(10) DEFAULT NULL COMMENT 'Zip',
    `country` varchar(35) DEFAULT NULL COMMENT 'Country',
    `phone_number` varchar(20) DEFAULT NULL COMMENT 'PhoneNumber',
    `fax_number` varchar(20) DEFAULT NULL COMMENT 'FaxNumber',
    `is_primary` tinyint(1) DEFAULT '0' COMMENT 'IsPrimary',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`address_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `fk_user_address_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='UserAddressTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.user_business
CREATE TABLE IF NOT EXISTS `user_business` (
    `business_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'BusinessId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `business_name` varchar(35) DEFAULT NULL COMMENT 'DisplayName',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`business_id`),
    KEY `fk_user_business_user_id` (`user_id`),
    CONSTRAINT `fk_user_business_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='UserBusinessTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.user_card_favorite
CREATE TABLE IF NOT EXISTS `user_card_favorite` (
    `user_card_favorite_id` int(15) NOT NULL AUTO_INCREMENT,
    `user_id` int(15) DEFAULT NULL,
    `card_id` int(15) DEFAULT NULL,
    `order` int(11) DEFAULT NULL,
    `title` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`user_card_favorite_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `user_id` (`user_id`),
    KEY `card_id` (`card_id`),
    KEY `order` (`order`),
    CONSTRAINT `fk_usercardfav_card` FOREIGN KEY (`card_id`) REFERENCES `card` (`card_id`),
    CONSTRAINT `fk_usercardfav_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.user_class
CREATE TABLE IF NOT EXISTS `user_class` (
    `user_class_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'UserClassId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `user_class_type_id` int(15) NOT NULL COMMENT 'UserClassTypeId',
    `sys_row_id` char(36) CHARACTER SET utf8 NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`user_class_id`),
    KEY `fk_user_class_type_id` (`user_class_type_id`),
    KEY `fk_user_class_user` (`user_id`),
    CONSTRAINT `fk_user_class_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping structure for table excell_main.user_class_can
CREATE TABLE IF NOT EXISTS `user_class_can` (
    `user_class_can_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_class_can_code` varchar(20) NOT NULL,
    `user_class_can_label` varchar(45) NOT NULL,
    `user_class_can_desc` varchar(200) NOT NULL,
    `created_by` int(11) NOT NULL DEFAULT '0',
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`user_class_can_id`),
    UNIQUE KEY `user_class_can_code_unique` (`user_class_can_code`),
    UNIQUE KEY `user_class_can_label_unique` (`user_class_can_label`),
    UNIQUE KEY `sys_row_id_unique` (`sys_row_id`),
    KEY `user_class_can_code_index` (`user_class_can_code`),
    KEY `user_class_can_creating_user_fk` (`created_by`),
    CONSTRAINT `user_class_can_creating_user_fk` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.user_class_product
CREATE TABLE IF NOT EXISTS `user_class_product` (
    `user_class_product_id` int(5) NOT NULL COMMENT 'UserClassProductId',
    `user_class_type_id` int(5) NOT NULL COMMENT 'UserClassTypeId',
    `product_id` int(15) NOT NULL COMMENT 'ProductId',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `fk_user_class_package_type_id` (`user_class_type_id`),
    KEY `fk_user_class_package_id` (`product_id`),
    CONSTRAINT `fk_user_class_package_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_user_class_package_type_id` FOREIGN KEY (`user_class_type_id`) REFERENCES `user_class_type` (`user_class_type_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='UserClassPackageTable for Excell  3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_main.user_class_type
CREATE TABLE IF NOT EXISTS `user_class_type` (
    `user_class_type_id` int(15) NOT NULL COMMENT 'UserClassTypeId',
    `name` varchar(35) NOT NULL COMMENT 'Name',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`user_class_type_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='UserClassTypeTable for Excell  3.0';

-- Dumping structure for table excell_main.user_epp_class
CREATE TABLE IF NOT EXISTS `user_epp_class` (
    `user_epp_class_ide` int(4) NOT NULL COMMENT 'UserEppClassId',
    `title` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Title',
    `value` int(4) NOT NULL COMMENT 'Value',
    `epp_order` int(3) NOT NULL COMMENT 'EppOrder',
    `epp_type` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'EppType',
    `sys_row_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`user_epp_class_ide`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table excell_main.user_setting
CREATE TABLE IF NOT EXISTS `user_setting` (
    `user_setting_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) DEFAULT NULL,
    `label` varchar(25) DEFAULT NULL,
    `value` varchar(350) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`user_setting_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `fk_user_settings_user` (`user_id`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`),
    KEY `label` (`label`),
    CONSTRAINT `fk_user_settings_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data:


-- Dumping structure for trigger excell_main.tgr_app_instance
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_app_instance` BEFORE INSERT ON `app_instance` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_app_instance_rel
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_app_instance_rel` BEFORE INSERT ON `app_instance_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_app_instance_rel_setting
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_app_instance_rel_setting` BEFORE INSERT ON `app_instance_rel_setting` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_campaign_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_campaign_sysrowid` BEFORE INSERT ON `campaign` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_rel
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_card_rel` BEFORE INSERT ON `card_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_rel_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_rel_sysrowid` BEFORE INSERT ON `card_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_rel_type_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_rel_type_sysrowid` BEFORE INSERT ON `card_rel_type` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_setting_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_setting_sysrowid` BEFORE INSERT ON `card_setting` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_sysrowid` BEFORE INSERT ON `card` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_domain_sysrowid` BEFORE INSERT ON `card_domain` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_tab_rel_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_tab_rel_sysrowid` BEFORE INSERT ON `card_tab_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_tab_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_tab_sysrowid` BEFORE INSERT ON `card_tab` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_tab_type_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_tab_type_sysrowid` BEFORE INSERT ON `card_tab_type` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_template_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_template_sysrowid` BEFORE INSERT ON `card_template` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_template_company_rel_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_template_company_rel_sysrowid` BEFORE INSERT ON `card_template_company_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_card_type_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_card_type_sysrowid` BEFORE INSERT ON `card_type` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_company_department
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_company_department` BEFORE INSERT ON `company_department` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_company_department_class
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_company_department_class` BEFORE INSERT ON `company_department_class` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_company_department_type
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_company_department_type` BEFORE INSERT ON `company_department_type` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_company_department_user_rel
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_company_department_user_rel` BEFORE INSERT ON `company_department_user_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_company_department_user_role
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_company_department_user_role` BEFORE INSERT ON `company_department_user_role` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_company_department_user_ticketqueue_role
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_company_department_user_ticketqueue_role` BEFORE INSERT ON `company_department_user_ticketqueue_role` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_company_setting
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_company_setting` BEFORE INSERT ON `company_setting` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_company_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_company_sysrowid` BEFORE INSERT ON `company` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_connection_rel_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_connection_rel_sysrowid` BEFORE INSERT ON `connection_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_division_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_division_sysrowid` BEFORE INSERT ON `division` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_main_card_fonts_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_main_card_fonts_sysrowid` BEFORE INSERT ON `card_font` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_package_class_rel
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_package_class_rel` BEFORE INSERT ON `package_class_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_package_cycle_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_package_cycle_sysrowid` BEFORE INSERT ON `product_cycle` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_package_variation
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_package_variation` BEFORE INSERT ON `package_variation` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_package_line
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_package_line` BEFORE INSERT ON `package_line` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_package_plan_class_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_package_plan_class_sysrowid` BEFORE INSERT ON `product_class` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_product
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_product` BEFORE INSERT ON `product` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_promo_code
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_promo_code` BEFORE INSERT ON `promo_code` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_user_address_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_user_address_sysrowid` BEFORE INSERT ON `user_address` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_user_business_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_user_business_sysrowid` BEFORE INSERT ON `user_business` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_user_class_package_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_user_class_package_sysrowid` BEFORE INSERT ON `user_class_product` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_user_class_type_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_user_class_type_sysrowid` BEFORE INSERT ON `user_class_type` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_user_connection_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_user_connection_sysrowid` BEFORE INSERT ON `connection` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_user_rel_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_user_rel_sysrowid` BEFORE INSERT ON `user_class` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_main.tgr_user_sysrowid
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `tgr_user_sysrowid` BEFORE INSERT ON `user` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
