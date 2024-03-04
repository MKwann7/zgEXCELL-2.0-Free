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


-- Dumping database structure for excell_crm
CREATE DATABASE IF NOT EXISTS `excell_crm` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `excell_crm`;

-- Dumping structure for table excell_crm.journey
CREATE TABLE IF NOT EXISTS `journey` (
    `journey_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `parent_id` int(15) DEFAULT NULL,
    `follows_id` int(15) DEFAULT NULL,
    `delay_days` int(5) DEFAULT NULL,
    `journey_type_id` int(2) DEFAULT NULL,
    `ticket_queue_id` int(15) DEFAULT NULL,
    `label` varchar(75) DEFAULT NULL,
    `name` varchar(75) DEFAULT NULL,
    `description` varchar(750) DEFAULT NULL,
    `expected_duration` int(15) DEFAULT NULL,
    `hierarchical_progression` tinyint(1) DEFAULT NULL,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`journey_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `journey_type_id` (`journey_type_id`),
    KEY `company_id` (`company_id`),
    KEY `parent_id` (`parent_id`),
    KEY `ticket_queue_id` (`ticket_queue_id`),
    KEY `follows_id` (`follows_id`),
    CONSTRAINT `fk_journey_company` FOREIGN KEY (`company_id`) REFERENCES `excell_main`.`company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_journey_journeyparent` FOREIGN KEY (`parent_id`) REFERENCES `journey` (`journey_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_journey_journeytype` FOREIGN KEY (`journey_type_id`) REFERENCES `journey_type` (`journey_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_journey_ticketfollows` FOREIGN KEY (`follows_id`) REFERENCES `journey` (`journey_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_journey_ticketqueue` FOREIGN KEY (`ticket_queue_id`) REFERENCES `ticket_queue` (`ticket_queue_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.journey_action
CREATE TABLE IF NOT EXISTS `journey_action` (
    `journey_action_id` int(15) NOT NULL AUTO_INCREMENT,
    `journey_id` int(15) DEFAULT NULL,
    `action_type_id` int(5) DEFAULT NULL,
    `order` int(5) DEFAULT NULL,
    `delay_seconds` int(15) DEFAULT NULL,
    `sender_type_id` int(5) DEFAULT NULL,
    `recipient_type_id` int(5) DEFAULT NULL,
    `content` int(5) DEFAULT NULL,
    `set_ticket_status` tinyint(1) DEFAULT NULL,
    `set_ticket_status_type` smallint(2) DEFAULT NULL,
    `set_orderline_status` tinyint(1) DEFAULT NULL,
    `set_orderline_status_type` smallint(2) DEFAULT NULL,
    `set_entity_status` tinyint(1) DEFAULT NULL,
    `set_entity_status_type` smallint(2) DEFAULT NULL,
    PRIMARY KEY (`journey_action_id`) USING BTREE,
    KEY `journey_id` (`journey_id`),
    KEY `delay_seconds` (`delay_seconds`),
    KEY `order` (`order`),
    KEY `action_type_id` (`action_type_id`),
    CONSTRAINT `fk_journeyaction_journey` FOREIGN KEY (`journey_id`) REFERENCES `journey` (`journey_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.journey_checklist
CREATE TABLE IF NOT EXISTS `journey_checklist` (
    `journey_checklist_id` int(15) NOT NULL AUTO_INCREMENT,
    `journey_id` int(15) DEFAULT NULL,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `checklist_type_id` int(5) DEFAULT NULL,
    PRIMARY KEY (`journey_checklist_id`),
    KEY `company_id` (`company_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.journey_type
CREATE TABLE IF NOT EXISTS `journey_type` (
    `journey_type_id` int(5) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `label` varchar(35) DEFAULT NULL,
    PRIMARY KEY (`journey_type_id`),
    KEY `fk_journeytype_company` (`company_id`),
    CONSTRAINT `fk_journeytype_company` FOREIGN KEY (`company_id`) REFERENCES `excell_main`.`company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.note
CREATE TABLE IF NOT EXISTS `note` (
    `note_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `entity_id` int(15) DEFAULT NULL,
    `entity_name` varchar(15) DEFAULT NULL,
    `note_owner_id` int(15) DEFAULT NULL,
    `ticket_id` int(15) DEFAULT NULL,
    `summary` varchar(75) DEFAULT NULL,
    `description` varchar(500) DEFAULT NULL,
    `visibility` varchar(25) DEFAULT NULL,
    `type` varchar(25) DEFAULT NULL,
    `sync_id` varchar(50) DEFAULT NULL,
    `synced` tinyint(4) DEFAULT '0',
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`note_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`),
    KEY `entity_id_entity_name` (`entity_id`,`entity_name`),
    KEY `type` (`type`),
    KEY `ticket_id` (`ticket_id`),
    KEY `company_id` (`company_id`),
    KEY `division_id` (`division_id`),
    KEY `visibility` (`visibility`),
    KEY `sync_id` (`sync_id`),
    KEY `synced` (`synced`),
    KEY `note_owner_id` (`note_owner_id`),
    CONSTRAINT `fk_notes_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`ticket_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.opportunity
CREATE TABLE IF NOT EXISTS `opportunity` (
    `opportunity_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'OpportunityId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `owner_id` int(15) NOT NULL COMMENT 'OwnerId',
    `division_id` int(15) NOT NULL COMMENT 'DivisionId',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `campaign_id` int(15) DEFAULT NULL COMMENT 'CampaignId',
    `creator_id` int(15) NOT NULL COMMENT 'CreatorId',
    `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedOn',
    `modified_by` int(15) DEFAULT NULL COMMENT 'ModifiedBy',
    `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `name` varchar(150) NOT NULL COMMENT 'Name',
    `description` varchar(500) DEFAULT NULL COMMENT 'Description',
    `actual_value` decimal(6,2) DEFAULT NULL COMMENT 'ActualValue',
    `actual_closed_date` datetime DEFAULT NULL COMMENT 'ActualClosedDate',
    `discount_amount` double(6,2) DEFAULT NULL COMMENT 'DiscountAmount',
    `estimated_value` decimal(6,2) DEFAULT NULL COMMENT 'EstimatedValue',
    `estimated_close_date` datetime DEFAULT NULL COMMENT 'EstimatedCloseDate',
    `budget_amount` decimal(6,2) DEFAULT NULL COMMENT 'BudgetAmount',
    `confirm_interest` tinyint(1) DEFAULT '0' COMMENT 'ConfirmInterest',
    `close_probability` int(2) DEFAULT NULL COMMENT 'CloseProbability',
    `need` int(1) DEFAULT NULL COMMENT 'Need',
    `present_proposal` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'PresentProposal',
    `present_final_proposal` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'PresentFinalProposal',
    `priority_code` int(3) DEFAULT NULL COMMENT 'PriorityCode',
    `stage` varchar(15) NOT NULL COMMENT 'Stage',
    `state_code` int(3) NOT NULL COMMENT 'StateCode',
    `status` varchar(25) NOT NULL DEFAULT 'Active' COMMENT 'Status',
    `version_number` int(3) NOT NULL DEFAULT '1' COMMENT 'VersionNumber',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`opportunity_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `user_id` (`user_id`),
    KEY `owner_id` (`owner_id`),
    KEY `creator_id` (`creator_id`),
    KEY `modified_by` (`modified_by`),
    KEY `company_id` (`company_id`),
    KEY `division_id` (`division_id`),
    KEY `actual_value` (`actual_value`),
    KEY `actual_closed_date` (`actual_closed_date`),
    KEY `stage_id` (`stage`),
    KEY `status_id` (`status`),
    KEY `state_code` (`state_code`),
    CONSTRAINT `FK_opportunity_excell_main.company` FOREIGN KEY (`company_id`) REFERENCES `excell_main`.`company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_opportunity_excell_main.division` FOREIGN KEY (`division_id`) REFERENCES `excell_main`.`division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_opportunity_excell_main.user` FOREIGN KEY (`user_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_opportunity_excell_main.user_2` FOREIGN KEY (`owner_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_opportunity_excell_main.user_3` FOREIGN KEY (`modified_by`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_opportunity_excell_main.user_4` FOREIGN KEY (`creator_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='OpportunityTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.opportunity_line
CREATE TABLE IF NOT EXISTS `opportunity_line` (
    `opportunity_line_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'OpportunityLineId',
    `opportunity_id` int(15) NOT NULL COMMENT 'OpportunityId',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `division_id` int(15) NOT NULL COMMENT 'DvisionId',
    `user_id` int(15) NOT NULL COMMENT 'UserId',
    `owner_id` int(15) NOT NULL COMMENT 'OwnerId',
    `product_plan_id` int(15) NOT NULL COMMENT 'ProductPlanId',
    `name` varchar(50) NOT NULL COMMENT 'Name',
    `description` varchar(500) DEFAULT NULL COMMENT 'Description',
    `price_per_unit` decimal(6,2) NOT NULL COMMENT 'PricePerUnit',
    `quantity` int(5) NOT NULL DEFAULT '1' COMMENT 'Quantity',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`opportunity_line_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `opportunity_id` (`opportunity_id`),
    KEY `company_id` (`company_id`),
    KEY `division_id` (`division_id`),
    KEY `package_plan_id` (`product_plan_id`),
    KEY `owner_id` (`owner_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `FK_opportunity_line_excell_main.company` FOREIGN KEY (`company_id`) REFERENCES `excell_main`.`company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_opportunity_line_excell_main.division` FOREIGN KEY (`division_id`) REFERENCES `excell_main`.`division` (`division_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_opportunity_line_excell_main.product` FOREIGN KEY (`product_plan_id`) REFERENCES `excell_main`.`product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_opportunity_line_excell_main.user` FOREIGN KEY (`user_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_opportunity_line_excell_main.user_2` FOREIGN KEY (`user_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_opportunity_line_opp` FOREIGN KEY (`opportunity_id`) REFERENCES `opportunity` (`opportunity_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='OpportunityLineTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.opportunity_stage
CREATE TABLE IF NOT EXISTS `opportunity_stage` (
    `opportunity_stage_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'OpportunityStageId',
    `opportunity_id` int(15) NOT NULL COMMENT 'OpportunityId',
    `division_id` int(15) NOT NULL COMMENT 'DivisionId',
    `company_id` int(15) NOT NULL COMMENT 'CompanyId',
    `title` varchar(50) NOT NULL COMMENT 'Title',
    `description` varchar(500) NOT NULL COMMENT 'Description',
    `display_order` int(2) NOT NULL COMMENT 'DisplayOrder',
    `sys_row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`opportunity_stage_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `opportunity_id` (`opportunity_id`),
    KEY `division_id` (`division_id`),
    KEY `company_id` (`company_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='OpportunityStageTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.orders
CREATE TABLE IF NOT EXISTS `orders` (
    `order_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'OrderId',
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `total_price` decimal(10,2) DEFAULT NULL COMMENT 'TotalPrice',
    `opportunity_id` int(15) DEFAULT NULL COMMENT 'OpportunityId',
    `quote_id` int(15) DEFAULT NULL COMMENT 'QuoteId',
    `title` varchar(255) DEFAULT NULL COMMENT 'Title',
    `status` varchar(25) DEFAULT NULL COMMENT 'Status',
    `created_on` datetime DEFAULT NULL COMMENT 'CreatedDate',
    `created_by` int(15) DEFAULT NULL COMMENT 'CreatedBy',
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `updated_by` int(15) DEFAULT NULL COMMENT 'UpdatedBy',
    `closed_date` datetime DEFAULT NULL COMMENT 'ClosedDate',
    `closed_by` int(15) DEFAULT NULL COMMENT 'ClosedBy',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`order_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `user_id` (`user_id`),
    KEY `opportunity_id` (`opportunity_id`),
    KEY `quote_id` (`quote_id`),
    KEY `fk_card_rel_group_created` (`created_by`),
    KEY `fk_card_rel_group_updated` (`updated_by`),
    KEY `company_id` (`company_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='OrderTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.order_line
CREATE TABLE IF NOT EXISTS `order_line` (
    `order_line_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'OrderLineId',
    `order_id` int(15) DEFAULT NULL COMMENT 'OrderId',
    `company_id` int(15) DEFAULT NULL COMMENT 'CompanyId',
    `product_id` int(15) DEFAULT NULL COMMENT 'ProductId',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `promo_price` decimal(10,2) DEFAULT NULL,
    `promo_fee` decimal(10,2) DEFAULT NULL,
    `promo_duration` int(2) DEFAULT NULL,
    `price` decimal(10,2) DEFAULT NULL COMMENT 'Price',
    `price_fee` decimal(10,2) DEFAULT NULL,
    `price_duration` int(2) DEFAULT '1',
    `cycle_type` int(2) DEFAULT '1',
    `payment_account_id` int(15) DEFAULT NULL COMMENT 'PaymentAccountId',
    `opportunity_line_id` int(15) DEFAULT NULL COMMENT 'OpportunityLineId',
    `quote_line_id` int(15) DEFAULT NULL COMMENT 'QuoteLineId',
    `package_bundle_id` int(15) DEFAULT NULL COMMENT 'BundleId',
    `title` varchar(255) DEFAULT NULL COMMENT 'Title',
    `status` varchar(25) DEFAULT NULL COMMENT 'status',
    `billing_date` datetime DEFAULT NULL COMMENT 'BillingDate',
    `last_billed` datetime DEFAULT NULL COMMENT 'LastBilled',
    `next_bill_date` datetime DEFAULT NULL,
    `created_on` datetime DEFAULT NULL COMMENT 'CreatedDate',
    `created_by` int(15) DEFAULT NULL COMMENT 'CreatedBy',
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `updated_by` int(15) DEFAULT NULL COMMENT 'UpdatedBy',
    `closed_date` datetime DEFAULT NULL COMMENT 'ClosedDate',
    `closed_by` int(15) DEFAULT NULL COMMENT 'ClosedBy',
    `data` text COMMENT 'JsonData',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`order_line_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `package_plan_id` (`product_id`),
    KEY `user_id` (`user_id`),
    KEY `fk_order_line_closed` (`closed_by`),
    KEY `fk_order_line_created` (`created_by`),
    KEY `fk_order_line_updated` (`updated_by`),
    KEY `fk_order_line_order` (`order_id`),
    KEY `fk_order_line_payment_account` (`payment_account_id`),
    KEY `company_id` (`company_id`),
    KEY `last_billed` (`last_billed`),
    KEY `billing_date` (`billing_date`),
    KEY `price_duration` (`price_duration`),
    KEY `promo_duration` (`promo_duration`),
    KEY `price` (`price`),
    KEY `promo_price` (`promo_price`),
    KEY `next_bill_date` (`next_bill_date`),
    CONSTRAINT `FK_order_line_excell_main.product` FOREIGN KEY (`product_id`) REFERENCES `excell_main`.`product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_order_line_excell_main.user` FOREIGN KEY (`closed_by`) REFERENCES `excell_main`.`user` (`user_id`),
    CONSTRAINT `FK_order_line_excell_main.user_2` FOREIGN KEY (`created_by`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='OrderLineTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.project
CREATE TABLE IF NOT EXISTS `project` (
    `project_id` int(15) NOT NULL AUTO_INCREMENT,
    `parent_project_id` int(15) DEFAULT NULL,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `creator_id` int(15) DEFAULT NULL,
    `owner_id` int(15) DEFAULT NULL,
    `type` varchar(25) DEFAULT NULL,
    `title` varchar(50) DEFAULT NULL,
    `description` varchar(250) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`project_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `owner_id` (`owner_id`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`),
    KEY `type` (`type`),
    KEY `parent_project_id` (`parent_project_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.ticket
CREATE TABLE IF NOT EXISTS `ticket` (
    `ticket_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `parent_ticket_id` int(15) DEFAULT NULL,
    `journey_id` int(15) DEFAULT NULL,
    `follows_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL,
    `assignee_id` int(15) DEFAULT NULL,
    `summary` varchar(75) DEFAULT NULL,
    `description` varchar(500) DEFAULT NULL,
    `status` varchar(25) DEFAULT NULL,
    `entity_id` int(15) DEFAULT NULL,
    `entity_name` varchar(15) DEFAULT NULL,
    `ticket_queue_id` int(11) DEFAULT NULL,
    `type` varchar(25) DEFAULT NULL,
    `ticket_opened` datetime DEFAULT NULL,
    `expected_completion` datetime DEFAULT NULL,
    `ticket_closed` datetime DEFAULT NULL,
    `duration` int(11) DEFAULT NULL,
    `delayed` tinyint(4) DEFAULT NULL,
    `delayed_duration` int(11) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`ticket_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`),
    KEY `entity_id_entity_name` (`entity_id`,`entity_name`),
    KEY `type` (`type`),
    KEY `journey_id` (`journey_id`),
    KEY `ticket_queue_id` (`ticket_queue_id`),
    KEY `company_id` (`company_id`),
    KEY `ticket_opened` (`ticket_opened`),
    KEY `ticket_closed` (`ticket_closed`),
    KEY `duration` (`duration`),
    KEY `parent_ticket_id` (`parent_ticket_id`),
    KEY `status` (`status`),
    KEY `ticket_expecated_completion` (`expected_completion`) USING BTREE,
    KEY `fk_ticket_user` (`user_id`),
    KEY `owner_id` (`assignee_id`) USING BTREE,
    KEY `delayed` (`delayed`),
    KEY `delayed_duration` (`delayed_duration`),
    KEY `follows_id` (`follows_id`),
    CONSTRAINT `fk_ticket_assignee` FOREIGN KEY (`assignee_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_ticket_company` FOREIGN KEY (`company_id`) REFERENCES `excell_main`.`company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_ticket_followsticket` FOREIGN KEY (`follows_id`) REFERENCES `ticket` (`ticket_id`),
    CONSTRAINT `fk_ticket_journey` FOREIGN KEY (`journey_id`) REFERENCES `journey` (`journey_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_ticket_parentticket` FOREIGN KEY (`parent_ticket_id`) REFERENCES `ticket` (`ticket_id`),
    CONSTRAINT `fk_ticket_ticketqueue` FOREIGN KEY (`ticket_queue_id`) REFERENCES `ticket_queue` (`ticket_queue_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_ticket_user` FOREIGN KEY (`user_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.ticket_queue
CREATE TABLE IF NOT EXISTS `ticket_queue` (
    `ticket_queue_id` int(15) NOT NULL AUTO_INCREMENT,
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `company_department_id` int(15) DEFAULT NULL,
    `queue_type_id` int(5) DEFAULT NULL,
    `label` varchar(50) DEFAULT NULL,
    `name` varchar(50) DEFAULT NULL,
    `description` varchar(250) DEFAULT NULL,
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`ticket_queue_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `company_id` (`company_id`),
    KEY `company_department_id` (`company_department_id`),
    KEY `label` (`label`),
    KEY `queue_type_id` (`queue_type_id`),
    CONSTRAINT `fk_ticketqueue_company` FOREIGN KEY (`company_id`) REFERENCES `excell_main`.`company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_ticketqueue_companydepartment` FOREIGN KEY (`company_department_id`) REFERENCES `excell_main`.`company_department` (`company_department_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_ticketqueue_queuetype` FOREIGN KEY (`queue_type_id`) REFERENCES `ticket_queue_type` (`ticket_queue_type_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_crm.ticket_queue_type
CREATE TABLE IF NOT EXISTS `ticket_queue_type` (
    `ticket_queue_type_id` int(11) NOT NULL AUTO_INCREMENT,
    `label` varchar(50) DEFAULT NULL,
    `description` varchar(250) DEFAULT NULL,
    `action` varchar(250) DEFAULT NULL,
    PRIMARY KEY (`ticket_queue_type_id`),
    UNIQUE KEY `action` (`action`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for trigger excell_crm.tgr_journey
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_journey` BEFORE INSERT ON `journey` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger excell_crm.tgr_ticket
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_ticket` BEFORE INSERT ON `ticket` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
