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


-- Dumping database structure for excell_financial
CREATE DATABASE IF NOT EXISTS `excell_financial` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `excell_financial`;

-- Dumping structure for table excell_financial.ar_invoice
CREATE TABLE IF NOT EXISTS `ar_invoice` (
    `ar_invoice_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'ArInvoiceId',
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `gross_value` float DEFAULT NULL COMMENT 'GrossValue',
    `net_value` float DEFAULT NULL COMMENT 'NetValue',
    `tax` int(15) DEFAULT NULL COMMENT 'Tax',
    `payment_account_id` int(15) DEFAULT NULL,
    `payment_type_id` int(15) DEFAULT '1' COMMENT 'PaymentTypeId',
    `status` varchar(25) DEFAULT NULL COMMENT 'Status',
    `created_on` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'CreatedDate',
    `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'LastUpdated',
    `closed_date` datetime DEFAULT NULL COMMENT 'ClosedDate',
    `closed_by` int(15) DEFAULT NULL COMMENT 'ClosedBy',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`ar_invoice_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `user_id` (`user_id`),
    KEY `status` (`status`),
    KEY `fk_arinvoice_payment_type` (`payment_type_id`),
    KEY `company_id` (`company_id`),
    KEY `payment_account_id` (`payment_account_id`),
    KEY `gross_value` (`gross_value`),
    KEY `net_value` (`net_value`),
    KEY `created_date` (`created_on`) USING BTREE,
    CONSTRAINT `fk_arinvoice_payment_type` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_type` (`payment_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ArInvoiceTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_financial.mytable
CREATE TABLE IF NOT EXISTS `mytable` (
    `stripe_subscription_id` varchar(18) DEFAULT NULL,
    `company_id` int(11) NOT NULL,
    `divsion` int(11) NOT NULL,
    `email` varchar(35) NOT NULL,
    `status` varchar(9) NOT NULL,
    `customer_id` varchar(18) NOT NULL,
    `cycle` varchar(5) NOT NULL,
    `price` decimal(8,4) NOT NULL,
    `start_date` date NOT NULL,
    `notes` varchar(30) DEFAULT NULL,
    `user_id` int(11) DEFAULT NULL,
    `billing` varchar(30) DEFAULT NULL,
    `expiration_date` varchar(30) DEFAULT NULL,
    `created_on` date DEFAULT NULL,
    `subscription_item` varchar(30) DEFAULT NULL,
    `billing_date` date DEFAULT NULL,
    `quantity` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_financial.payment_account
CREATE TABLE IF NOT EXISTS `payment_account` (
    `payment_account_id` int(15) NOT NULL COMMENT 'PaymentAccountId',
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `payment_type` int(5) DEFAULT NULL COMMENT 'PaymentType',
    `method` varchar(35) DEFAULT NULL COMMENT 'Method',
    `token` varchar(255) DEFAULT NULL COMMENT 'Token',
    `type` varchar(15) DEFAULT NULL,
    `display_1` varchar(25) DEFAULT NULL COMMENT 'Display1',
    `display_2` varchar(25) DEFAULT NULL COMMENT 'Display2',
    `expiration_date` datetime DEFAULT NULL COMMENT 'ExpirationDate',
    `status` varchar(25) DEFAULT 'active',
    `created_on` datetime DEFAULT NULL,
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`payment_account_id`),
    KEY `fk_payment_account_payment_type` (`payment_type`),
    KEY `fk_payment_account_user_id` (`user_id`),
    CONSTRAINT `fk_payment_account_payment_type` FOREIGN KEY (`payment_type`) REFERENCES `payment_type` (`payment_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_payment_account_user_id` FOREIGN KEY (`user_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='PaymentAccountTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_financial.payment_type
CREATE TABLE IF NOT EXISTS `payment_type` (
    `payment_type_id` int(15) NOT NULL COMMENT 'PaymentTypeId',
    `name` varchar(35) NOT NULL COMMENT 'Name',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`payment_type_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='PaymentTypeTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_financial.transaction
CREATE TABLE IF NOT EXISTS `transaction` (
    `transaction_id` int(15) NOT NULL AUTO_INCREMENT COMMENT 'TransactionId',
    `company_id` int(15) DEFAULT NULL,
    `division_id` int(15) DEFAULT NULL,
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `ar_invoice_id` int(15) DEFAULT NULL COMMENT 'ArInvoiceId',
    `package_id` int(15) DEFAULT NULL COMMENT 'PackageId',
    `package_line_id` int(15) DEFAULT NULL,
    `product_entity` varchar(50) DEFAULT NULL,
    `product_entity_id` int(15) DEFAULT NULL,
    `order_id` int(15) DEFAULT NULL COMMENT 'OrderId',
    `order_line_id` int(15) DEFAULT NULL COMMENT 'OrderLineId',
    `gross_value` float DEFAULT NULL COMMENT 'GrossValue',
    `net_value` float DEFAULT NULL COMMENT 'NetValue',
    `tax` int(10) DEFAULT '0' COMMENT 'Tax',
    `transaction_type_id` int(5) DEFAULT NULL COMMENT 'TransactionTypeId',
    `created_on` datetime DEFAULT NULL COMMENT 'CreationDate',
    `last_updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`transaction_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    KEY `user_id` (`user_id`),
    KEY `ar_Invoice_ud` (`ar_invoice_id`),
    KEY `fk_transaction_order` (`order_id`),
    KEY `fk_transaction_order_line` (`order_line_id`),
    KEY `company_id` (`company_id`),
    KEY `transaction_type_id` (`transaction_type_id`),
    KEY `created_on` (`created_on`),
    KEY `last_updated` (`last_updated`),
    CONSTRAINT `FK_transaction_excell_crm.order_line` FOREIGN KEY (`order_line_id`) REFERENCES `excell_crm`.`order_line` (`order_line_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `FK_transaction_excell_crm.orders` FOREIGN KEY (`order_id`) REFERENCES `excell_crm`.`orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_transaction_arinvoice` FOREIGN KEY (`ar_invoice_id`) REFERENCES `ar_invoice` (`ar_invoice_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_transaction_user` FOREIGN KEY (`user_id`) REFERENCES `excell_main`.`user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='TransactionTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_financial.user_payment_property
CREATE TABLE IF NOT EXISTS `user_payment_property` (
    `user_payment_property_id` int(15) NOT NULL COMMENT 'PaymentRelId',
    `company_id` int(15) DEFAULT '0',
    `user_id` int(15) DEFAULT NULL COMMENT 'UserId',
    `type_id` int(5) DEFAULT NULL COMMENT 'PaymentType',
    `state` varchar(5) DEFAULT NULL,
    `value` varchar(255) NOT NULL COMMENT 'Value',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId',
    PRIMARY KEY (`user_payment_property_id`) USING BTREE,
    UNIQUE KEY `sys_row_id` (`sys_row_id`),
    UNIQUE KEY `type_id_state` (`type_id`,`state`,`user_id`,`company_id`) USING BTREE,
    KEY `value` (`value`),
    KEY `user_id` (`user_id`),
    KEY `type` (`type_id`) USING BTREE,
    KEY `company_id` (`company_id`),
    CONSTRAINT `fk_payment_property_type_id` FOREIGN KEY (`type_id`) REFERENCES `user_payment_property_type` (`user_payment_property_type_id`),
    CONSTRAINT `fk_payment_property_user_id` FOREIGN KEY (`user_id`) REFERENCES `excell_main`.`user` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='PaymentRelTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for table excell_financial.user_payment_property_type
CREATE TABLE IF NOT EXISTS `user_payment_property_type` (
    `user_payment_property_type_id` int(15) NOT NULL AUTO_INCREMENT,
    `name` varchar(50) DEFAULT NULL,
    `sys_row_id` char(36) DEFAULT NULL,
    PRIMARY KEY (`user_payment_property_type_id`),
    UNIQUE KEY `sys_row_id` (`sys_row_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Dumping structure for table excell_financial.user_payout
CREATE TABLE IF NOT EXISTS `user_payout` (
    `user_payout_id` int(15) NOT NULL COMMENT 'UserPayoutId',
    `value` decimal(15,0) NOT NULL COMMENT 'Value',
    `sys_row_id` char(36) DEFAULT NULL COMMENT 'SysRowId'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='UserPayoutTable for Excell 3.0';

-- Data exporting was unselected.

-- Dumping structure for trigger excell_financial.tgr_user_payment_property
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `tgr_user_payment_property` BEFORE INSERT ON `user_payment_property` FOR EACH ROW SET NEW.sys_row_id = UUID()//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
