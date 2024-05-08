SET FOREIGN_KEY_CHECKS=0;

-- Main Database Data Load:
USE `excell_main`;

INSERT INTO card_addon_type (card_addon_type_id,title,label,description,sys_row_id) VALUES
(1,'Keyword','keyword','A keyword for the ezcard system.','ea82f21b-5060-491c-ab2f-f25aa3fc7e9a');

INSERT INTO card_favorite_source (source_label,source_name) VALUES
('user','Users'),
('card','Cards'),
('module','Module/Tools'),
('website','Website URL'),
('social-media','Social Media');

INSERT INTO card_font (card_font_id,font_name,google_font_name,sys_row_id) VALUES
(1,'Alegreya Sans SC','Alegreya+Sans+SC','e5953869-e3b2-4747-aeb2-06b8e934e151'),
(2,'Cabin','Cabin','75cb1c69-0f29-460f-994f-bd018a8e95ea'),
(3,'PT Sans','PT+Sans','3c5f83d9-71fd-4c89-a5cf-c0ce1e79a27b'),
(4,'Philosopher','Philosopher','1d86f0ac-74a1-4511-bd42-5b14581e7b1e'),
(5,'Quicksand','Quicksand','975beb69-aead-4a64-b674-f4d31fffceed'),
(6,'Josefin Sans','Josefin+Sans','281b5ec2-59c4-42d9-9704-0b34cbee5712'),
(7,'Open Sans','Open+Sans','a1712f66-9400-4dbf-9f95-52f5ca673632'),
(8,'Oswald','Oswald','04627796-d126-4ca3-9a22-2fbedca58719'),
(9,'Open Sans Condensed','Open+Sans+Condensed:300','a8307813-2874-4cda-a48b-8e3c7d6b98be'),
(10,'Montserrat','Montserrat','2e9de4ca-2c44-423b-947e-f92b9f132a43');
INSERT INTO card_font (card_font_id,font_name,google_font_name,sys_row_id) VALUES
(11,'Maven Pro','Maven+Pro','e1522052-741b-496a-b2e6-aa7fa36b1485'),
(12,'Marmelad','Marmelad','b87acb25-7ef0-4cc8-95d0-448a75b8b1e6'),
(13,'Aclonica','Aclonica','00bd03d9-5a6f-4124-b8ef-ef36b17cc5c5'),
(14,'Allerta Stencil','Allerta+Stencil','4b54da06-9317-48c9-aef0-64e18ef04648');

INSERT INTO card_rel_type (card_rel_type_id,name,permissions,sys_row_id) VALUES
(1,'Card Owner','','122bd8d2-c82c-11e8-95ec-6ef620543eb9'),
(2,'Card Admin','','2968e987-c82c-11e8-95ec-6ef620543eb9'),
(3,'Card Editor','','9b29f147-c82c-11e8-95ec-6ef620543eb9'),
(4,'Card Page Editor','','db21aade-1134-11e9-9461-52de8773d5f0'),
(5,'Card Connections Editor','','e65ef70e-1134-11e9-af40-6ef620543eb9'),
(6,'Card Franchise Editor','','d4706338-1136-11e9-af40-6ef620543eb9'),
(7,'Card Group Editor','','f47e2a48-1136-11e9-af40-6ef620543eb9'),
(8,'Sales Rep','','9b054c83-1137-11e9-9461-52de8773d5f0'),
(9,'Affiliate','','a11eec40-1137-11e9-9461-52de8773d5f0');

INSERT INTO card_tab_type (card_tab_type_id,abbreviation,name,description,sys_row_id) VALUES
(1,'HTML','HTML Text Editor','The Default Tab Type in EZcard','cf7c309a-57e9-11ea-b088-42010a522005'),
(2,'TEMPLATEFILE','Template File','The displays content rendered from a template tab file.','cf7c3595-57e9-11ea-b088-42010a522005'),
(3,'COGNITO','Cognito Form','This renders a tab with a cognotio form.','cf7c3792-57e9-11ea-b088-42010a522005'),
(4,'WIDGET','Single Widget','This renders the card page with a single widget.','fe2910b6-e265-11ea-b088-42010a522005');

INSERT INTO card_template (card_template_id,company_id,division_id,name,template_type,`data`,sys_row_id) VALUES
(1,0,0,'Excell Theme','site','{"connections":{"count":"NA=="}}','9a2b1749-3474-11e9-9461-52de8773d5f0'),
(2,2,0,'EZ Card Original','site','{"connections":{"count":"NA=="}}','4dd5597f-3f7e-11eb-9e97-42010a52200a'),
(3,2,0,'Premium EZ Digital','site','{"connections":{"count":"NA=="}}','cee79531-8781-11eb-969d-42010a52200b'),
(4,1,0,'Standard MaxSite','site','{"header": {"title": "SGVhZGVy","type": "dGhlbWU=","elements": [{"title": "SGVhZGVyIEhlaWdodA==","label": "aGVhZGVyLWJhbm5lcg==","type": "Y3Nz","data": {"label": "aGVpZ2h0","default": "MTc1","responsive": {"tablet": "MTUw","mobile": "MTI1"}}}]},"main-logo": {"type": "bG9nbw==","elements": [{"title": "TG9nbyBIZWlnaHQ=","label": "bG9nby1oZWlnaHQ=","type": "Y3Nz","data": {"label": "aGVpZ2h0","default": "MTI1","responsive": {"tablet": "MTAw","mobile": "NzU="}}},{"title": "TG9nbyBVcmw=","label": "bG9nby11cmw=","type": "aW1hZ2U=","data": {"label": "dXJs","default": "L3dlYnNpdGUvaW1hZ2VzL21heHItbWljcm9zaXRlLWxvZ28ucG5n","responsive": {"tablet": null,"mobile": null}}},{"title": "VG9wIE9mZnNldA==","label": "dG9wLW9mZnNldA==","type": "Y3Nz","data": {"label": "dG9w","default": "Mg==","responsive": {"tablet": "Mg==","mobile": "Mg=="}}},{"title": "TGVmdCBPZmZzZXQ=","label": "bGVmdC1vZmZzZXQ=","type": "Y3Nz","data": {"label": "bGVmdA==","default": "MjA=","responsive": {"tablet": "MjU=","mobile": "MjA="}}}]}}','cee79531-8781-11eb-969d-42010a52200b'),
(5,1,0,'Premium MaxSite','site','{"connections":{"count":"NA=="}}','cee79531-8781-11eb-969d-42010a52200b'),
(6,1,0,'Basic Persona','persona','{"connections":{"count":"NA=="}}','cee79531-8781-11eb-969d-42010a52200b'),
(7,1,0,'Premium Persona','persona','{"connections":{"count":"NA=="}}','cee79531-8781-11eb-969d-42010a52200b');

INSERT INTO card_template_company_rel (card_template_company_rel_id,card_template_id,company_id,sys_row_id) VALUES
(1,1,0,'9a2b1749-3474-11e9-9461-52de8773d5f0'),
(2,4,1,'4dd5597f-3f7e-11eb-9e97-42010a52200a'),
(3,5,1,'cee79531-8781-11eb-969d-42010a52200b'),
(4,6,1,'cee79531-8781-11eb-969d-42010a52200b'),
(5,2,2,'cee79531-8781-11eb-969d-42010a52200b'),
(6,3,2,'cee79531-8781-11eb-969d-42010a52200b'),
(7,7,1,'cee79531-8781-11eb-969d-42010a52200b');

INSERT INTO card_type (card_type_id,name,sys_row_id) VALUES (1,'Default','e507f2ff-c82d-11e8-95ec-6ef620543eb9');
INSERT INTO card_type (card_type_id,name,sys_row_id) VALUES (2,'Persona','8df7701a-302f-40fd-9e3f-d959eedc4fa9');
INSERT INTO card_type (card_type_id,name,sys_row_id) VALUES (3,'Group','fae8fa20-e601-42f6-b3e6-a97dec39eaaa');

INSERT INTO `company` (company_id,company_name,platform_name,parent_id,owner_id,default_sponsor_id,status,domain_portal,domain_portal_ssl,domain_portal_name,domain_public,domain_public_ssl,domain_public_name,public_domain_404_redirect,address_1,address_2,address_3,city,state,country,phone_number,fein,legal_name,customer_support_email,logo_url,commissions,created_on,last_updated,sys_row_id) VALUES
(0,'ZakGraphix Excell','zgEXCELL',NULL,1000,1000,'active','app.zgexcell.docker',0,'zgEXCELL.com','app.zgexcell.docker',0,'zgEXCELL.com',NULL,'','','','','IL','USA','',62208,'ZakGraphix, LLC',NULL,'',1,'2016-05-12 15:43:24','2023-10-22 03:04:05','8ce0f91a-643e-11ee-8c6c-0242ac010007'),
(1,'Max Tech Inspire, LLC','MaxCard',NULL,1001,1000,'active','admin.maxr.docker',0,'MaxR','maxr.docker',0,'Max Card','http://admin.maxr.docker/account','524 N Locust St','','','Greenville','IL','USA','(618) 335-9468',853213941,'Max Community, LLC','greg@maxcommunity.us','',1,'2016-05-12 15:43:24','2023-10-22 02:56:55','8ceeb694-643e-11ee-8c6c-0242ac010007'),
(2,'EZ Digital World Corp, LLC','EZcard',0,1001,1001,'active','dev.ezcard.docker',0,'EZcard','dev.ezcard.docker',0,'EZcard.com',NULL,'P.O. Box 1',NULL,NULL,'Greenville','IL','USA','(618) 267-2730',54321,'EZ Card, LLC',NULL,NULL,NULL,'2021-05-02 15:49:25','2023-10-22 02:56:27','8cfb4ea5-643e-11ee-8c6c-0242ac010007'),
(3,'Shapeshiftworld, LLC','Elevate Marketplace',0,90820,90820,'active','admin.elevate.docker',0,'Elevate','elevate.docker',0,'Elevate','https://admin.elevate.bi/account','4848 E Cactus Road','Suite 505-575',NULL,'Scotosdale','AZ','USA','(949) 300-1117',12345,'Shapeshift World, LLC','support@shapeshiftworld.com',NULL,1,'2020-09-09 21:39:18','2020-11-11 23:53:25','8d0956e7-643e-11ee-8c6c-0242ac010007'),
(4,'AK BRANDING','AK Enterprizes',0,71732,71732,'active','admin.akenterprizes.docker',0,'AK Enterprizes','akenterprizes.docker',0,'AK Enterprizes','https://admin.akenterprizes.com/account','240 S Sunnyside Ave','#1441',NULL,'Sequim','WA','USA','425-890-7271',602533903,'AK BRANDING','aprilkaufmann@akbranding.com',NULL,1,'2020-12-07 12:02:09','2023-10-06 11:57:46','8d1832e3-643e-11ee-8c6c-0242ac010007');

INSERT INTO `company_department` (`company_department_id`, `company_id`, `division_id`, `department_class_id`, `department_type_id`, `parent_department_id`, `name`, `label`, `description`, `receives_promo_card`, `promo_card_per_user`, `read_only`, `can_receive_tickets`, `can_create_tickets`, `can_edit_tickets`, `can_delete_tickets`, `can_view_customers`, `can_create_customers`, `can_edit_customers`, `can_delete_customers`, `can_view_users`, `can_create_users`, `can_edit_users`, `can_delete_users`, `can_view_cards`, `can_purchase_cards`, `can_edit_cards`, `can_delete_cards`, `can_view_tool_owners`, `can_create_tool_owners`, `can_edit_tool_owners`, `can_delete_tool_owners`, `can_view_tools`, `can_create_tools`, `can_edit_tools`, `can_delete_tools`, `can_view_packages`, `can_create_packages`, `can_edit_packages`, `can_delete_packages`, `sys_row_id`) VALUES (1000, 0, NULL, NULL, 1, NULL, 'EZ Digital Customer Service', 'Customer Service', NULL, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'edb87fe0-2545-4dc4-912b-cdef69f98835');
INSERT INTO `company_department` (`company_department_id`, `company_id`, `division_id`, `department_class_id`, `department_type_id`, `parent_department_id`, `name`, `label`, `description`, `receives_promo_card`, `promo_card_per_user`, `read_only`, `can_receive_tickets`, `can_create_tickets`, `can_edit_tickets`, `can_delete_tickets`, `can_view_customers`, `can_create_customers`, `can_edit_customers`, `can_delete_customers`, `can_view_users`, `can_create_users`, `can_edit_users`, `can_delete_users`, `can_view_cards`, `can_purchase_cards`, `can_edit_cards`, `can_delete_cards`, `can_view_tool_owners`, `can_create_tool_owners`, `can_edit_tool_owners`, `can_delete_tool_owners`, `can_view_tools`, `can_create_tools`, `can_edit_tools`, `can_delete_tools`, `can_view_packages`, `can_create_packages`, `can_edit_packages`, `can_delete_packages`, `sys_row_id`) VALUES (1001, 0, NULL, NULL, 1, NULL, 'EZ Digital Operations', 'Operations', NULL, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '153fa6fa-9d6d-4330-953d-d4bcb82183c2');
INSERT INTO `company_department` (`company_department_id`, `company_id`, `division_id`, `department_class_id`, `department_type_id`, `parent_department_id`, `name`, `label`, `description`, `receives_promo_card`, `promo_card_per_user`, `read_only`, `can_receive_tickets`, `can_create_tickets`, `can_edit_tickets`, `can_delete_tickets`, `can_view_customers`, `can_create_customers`, `can_edit_customers`, `can_delete_customers`, `can_view_users`, `can_create_users`, `can_edit_users`, `can_delete_users`, `can_view_cards`, `can_purchase_cards`, `can_edit_cards`, `can_delete_cards`, `can_view_tool_owners`, `can_create_tool_owners`, `can_edit_tool_owners`, `can_delete_tool_owners`, `can_view_tools`, `can_create_tools`, `can_edit_tools`, `can_delete_tools`, `can_view_packages`, `can_create_packages`, `can_edit_packages`, `can_delete_packages`, `sys_row_id`) VALUES (1002, 0, NULL, NULL, 1, NULL, 'EZ Digital Finance', 'Finance', NULL, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '96e38353-2dbd-43eb-b7c0-6f0f0937d510');
INSERT INTO `company_department` (`company_department_id`, `company_id`, `division_id`, `department_class_id`, `department_type_id`, `parent_department_id`, `name`, `label`, `description`, `receives_promo_card`, `promo_card_per_user`, `read_only`, `can_receive_tickets`, `can_create_tickets`, `can_edit_tickets`, `can_delete_tickets`, `can_view_customers`, `can_create_customers`, `can_edit_customers`, `can_delete_customers`, `can_view_users`, `can_create_users`, `can_edit_users`, `can_delete_users`, `can_view_cards`, `can_purchase_cards`, `can_edit_cards`, `can_delete_cards`, `can_view_tool_owners`, `can_create_tool_owners`, `can_edit_tool_owners`, `can_delete_tool_owners`, `can_view_tools`, `can_create_tools`, `can_edit_tools`, `can_delete_tools`, `can_view_packages`, `can_create_packages`, `can_edit_packages`, `can_delete_packages`, `sys_row_id`) VALUES (1003, 0, NULL, NULL, 1, NULL, 'EZ Digital Information Technologies', 'Information Technologies', NULL, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'e489e58e-94d2-4397-8d36-19b0b73d0190');
INSERT INTO `company_department` (`company_department_id`, `company_id`, `division_id`, `department_class_id`, `department_type_id`, `parent_department_id`, `name`, `label`, `description`, `receives_promo_card`, `promo_card_per_user`, `read_only`, `can_receive_tickets`, `can_create_tickets`, `can_edit_tickets`, `can_delete_tickets`, `can_view_customers`, `can_create_customers`, `can_edit_customers`, `can_delete_customers`, `can_view_users`, `can_create_users`, `can_edit_users`, `can_delete_users`, `can_view_cards`, `can_purchase_cards`, `can_edit_cards`, `can_delete_cards`, `can_view_tool_owners`, `can_create_tool_owners`, `can_edit_tool_owners`, `can_delete_tool_owners`, `can_view_tools`, `can_create_tools`, `can_edit_tools`, `can_delete_tools`, `can_view_packages`, `can_create_packages`, `can_edit_packages`, `can_delete_packages`, `sys_row_id`) VALUES (1004, 0, NULL, NULL, 1, NULL, 'EZ Digital Executive', 'Executive', NULL, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'a346a1e5-2a2d-44a2-be5e-c0413e55226c');
INSERT INTO `company_department` (`company_department_id`, `company_id`, `division_id`, `department_class_id`, `department_type_id`, `parent_department_id`, `name`, `label`, `description`, `receives_promo_card`, `promo_card_per_user`, `read_only`, `can_receive_tickets`, `can_create_tickets`, `can_edit_tickets`, `can_delete_tickets`, `can_view_customers`, `can_create_customers`, `can_edit_customers`, `can_delete_customers`, `can_view_users`, `can_create_users`, `can_edit_users`, `can_delete_users`, `can_view_cards`, `can_purchase_cards`, `can_edit_cards`, `can_delete_cards`, `can_view_tool_owners`, `can_create_tool_owners`, `can_edit_tool_owners`, `can_delete_tool_owners`, `can_view_tools`, `can_create_tools`, `can_edit_tools`, `can_delete_tools`, `can_view_packages`, `can_create_packages`, `can_edit_packages`, `can_delete_packages`, `sys_row_id`) VALUES (1005, 1, NULL, NULL, 1, NULL, 'MaxCard Customer Service', 'Customer Service', NULL, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'f95d0976-8c6a-11eb-969d-42010a52200b');
INSERT INTO `company_department` (`company_department_id`, `company_id`, `division_id`, `department_class_id`, `department_type_id`, `parent_department_id`, `name`, `label`, `description`, `receives_promo_card`, `promo_card_per_user`, `read_only`, `can_receive_tickets`, `can_create_tickets`, `can_edit_tickets`, `can_delete_tickets`, `can_view_customers`, `can_create_customers`, `can_edit_customers`, `can_delete_customers`, `can_view_users`, `can_create_users`, `can_edit_users`, `can_delete_users`, `can_view_cards`, `can_purchase_cards`, `can_edit_cards`, `can_delete_cards`, `can_view_tool_owners`, `can_create_tool_owners`, `can_edit_tool_owners`, `can_delete_tool_owners`, `can_view_tools`, `can_create_tools`, `can_edit_tools`, `can_delete_tools`, `can_view_packages`, `can_create_packages`, `can_edit_packages`, `can_delete_packages`, `sys_row_id`) VALUES (1006, 1, NULL, NULL, 1, NULL, 'MaxCard Operations', 'Operations', NULL, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'f96ae293-8c6a-11eb-969d-42010a52200b');
INSERT INTO `company_department` (`company_department_id`, `company_id`, `division_id`, `department_class_id`, `department_type_id`, `parent_department_id`, `name`, `label`, `description`, `receives_promo_card`, `promo_card_per_user`, `read_only`, `can_receive_tickets`, `can_create_tickets`, `can_edit_tickets`, `can_delete_tickets`, `can_view_customers`, `can_create_customers`, `can_edit_customers`, `can_delete_customers`, `can_view_users`, `can_create_users`, `can_edit_users`, `can_delete_users`, `can_view_cards`, `can_purchase_cards`, `can_edit_cards`, `can_delete_cards`, `can_view_tool_owners`, `can_create_tool_owners`, `can_edit_tool_owners`, `can_delete_tool_owners`, `can_view_tools`, `can_create_tools`, `can_edit_tools`, `can_delete_tools`, `can_view_packages`, `can_create_packages`, `can_edit_packages`, `can_delete_packages`, `sys_row_id`) VALUES (1007, 1, NULL, NULL, 1, NULL, 'MaxCard Finance', 'Finance', NULL, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'f9793514-8c6a-11eb-969d-42010a52200b');
INSERT INTO `company_department` (`company_department_id`, `company_id`, `division_id`, `department_class_id`, `department_type_id`, `parent_department_id`, `name`, `label`, `description`, `receives_promo_card`, `promo_card_per_user`, `read_only`, `can_receive_tickets`, `can_create_tickets`, `can_edit_tickets`, `can_delete_tickets`, `can_view_customers`, `can_create_customers`, `can_edit_customers`, `can_delete_customers`, `can_view_users`, `can_create_users`, `can_edit_users`, `can_delete_users`, `can_view_cards`, `can_purchase_cards`, `can_edit_cards`, `can_delete_cards`, `can_view_tool_owners`, `can_create_tool_owners`, `can_edit_tool_owners`, `can_delete_tool_owners`, `can_view_tools`, `can_create_tools`, `can_edit_tools`, `can_delete_tools`, `can_view_packages`, `can_create_packages`, `can_edit_packages`, `can_delete_packages`, `sys_row_id`) VALUES (1009, 1, NULL, NULL, 1, NULL, 'MaxCard Executive', 'Executive', NULL, 0, 1, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'f9945a93-8c6a-11eb-969d-42010a52200b');

INSERT INTO `company_department_type` (`department_type_id`, `company_id`, `division_id`, `type_parent_id`, `label`, `description`, `sys_row_id`) VALUES (1, NULL, NULL, NULL, 'department', 'A standard department with a manager and teams', '33fc9a92-8c6b-11eb-969d-42010a52200b');
INSERT INTO `company_department_type` (`department_type_id`, `company_id`, `division_id`, `type_parent_id`, `label`, `description`, `sys_row_id`) VALUES (2, NULL, NULL, NULL, 'team', 'A team inside a department', '42a34ccd-8c6b-11eb-969d-42010a52200b');

INSERT INTO `company_department_user_rel` (`department_user_rel_id`, `company_id`, `division_id`, `department_id`, `user_id`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1001, 0, 0, 1003, 1000, '2021-03-24 01:09:15', '2021-03-24 06:09:20', 'be5cd857-552f-48c0-8b90-34a0abb7f419');
INSERT INTO `company_department_user_rel` (`department_user_rel_id`, `company_id`, `division_id`, `department_id`, `user_id`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1002, 1, 0, 1009, 1001, '2021-03-24 01:11:23', '2021-03-24 07:10:44', 'a2e30e75-fa21-4ea7-b9c5-df63178c77ff');
INSERT INTO `company_department_user_rel` (`department_user_rel_id`, `company_id`, `division_id`, `department_id`, `user_id`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1003, 0, 0, 1003, 1002, '2021-03-24 02:11:05', '2021-03-24 07:11:10', '181ce5b3-8c70-11eb-969d-42010a52200b');
INSERT INTO `company_department_user_rel` (`department_user_rel_id`, `company_id`, `division_id`, `department_id`, `user_id`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1004, 1, 0, 1006, 91101, '2021-03-25 15:54:08', '2021-03-25 15:54:09', '3e202a3e-8dac-11eb-969d-42010a52200b');
INSERT INTO `company_department_user_rel` (`department_user_rel_id`, `company_id`, `division_id`, `department_id`, `user_id`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1005, 1, 0, 1006, 91050, '2021-03-25 15:54:08', '2021-03-25 15:54:09', '9c4a8626-8dac-11eb-969d-42010a52200b');
INSERT INTO `company_department_user_rel` (`department_user_rel_id`, `company_id`, `division_id`, `department_id`, `user_id`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1006, 1, 0, 1005, 1001, '2021-03-24 01:11:23', '2021-03-24 07:10:44', 'c5461f6b-8dac-11eb-969d-42010a52200b');
INSERT INTO `company_department_user_rel` (`department_user_rel_id`, `company_id`, `division_id`, `department_id`, `user_id`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1007, 1, 0, 1006, 1001, '2021-03-24 01:11:23', '2021-03-24 07:10:44', 'c969a740-8dac-11eb-969d-42010a52200b');
INSERT INTO `company_department_user_rel` (`department_user_rel_id`, `company_id`, `division_id`, `department_id`, `user_id`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1008, 1, 0, 1007, 1001, '2021-03-24 01:11:23', '2021-03-24 07:10:44', 'ccb1af65-8dac-11eb-969d-42010a52200b');

INSERT INTO `company_department_user_role` (`department_user_role_id`, `company_id`, `division_id`, `label`, `name`, `abbreviation`, `description`, `sys_row_id`) VALUES (1, NULL, NULL, 'Team Member', 'Team Member', 'gen_teammem', NULL, '25f0f016-3d90-4beb-b3fe-3d83f5ddcf90');
INSERT INTO `company_department_user_role` (`department_user_role_id`, `company_id`, `division_id`, `label`, `name`, `abbreviation`, `description`, `sys_row_id`) VALUES (2, NULL, NULL, 'Manager', 'Manager', 'gen_manager', NULL, '2453354f-8d3e-11eb-969d-42010a52200b');
INSERT INTO `company_department_user_role` (`department_user_role_id`, `company_id`, `division_id`, `label`, `name`, `abbreviation`, `description`, `sys_row_id`) VALUES (3, NULL, NULL, 'Viewer', 'Viewer', 'gen_viewer', NULL, 'b278f57e-8dac-11eb-969d-42010a52200b');

INSERT INTO `company_department_user_ticketqueue_role` (`user_ticketqueue_role_id`, `user_id`, `ticket_queue_id`, `department_user_role`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1, 1000, 1003, 2, '2021-03-25 15:06:49', '2021-03-25 15:06:49', '8c06d4cf-8da5-11eb-969d-42010a52200b');

INSERT INTO company_setting (company_setting_id, company_id, label, value, created_on, last_updated, sys_row_id) VALUES
(8, 0, 'application_type', 'default', '2020-09-15 12:49:19', '2021-11-01 22:16:03', '2d517438-763f-40a5-af2d-1d5f4f873ec9'),
(9, 0, 'portal_theme', '1', '2020-09-15 12:49:19', '2021-11-01 22:16:03', '2d517438-763f-40a5-af2d-1d5f4f873ec9'),
(12, 0, 'website_theme', '1', '2020-09-15 12:57:41', '2021-04-13 17:06:39', '3496bc17-72d8-421b-9175-b5ec7b1ac59b'),
(21, 0, 'portal_logo_light', '/website/logos/ez-card-logo-initials-green.svg', '2020-09-23 05:26:54', '2020-12-16 09:50:50', '21e76d85-4407-4de4-896c-3c71f0310f91'),
(23, 0, 'website_logo_css', 'width: 125px; top: 8px;', '2020-10-14 21:52:39', '2020-10-20 13:44:17', '36f79545-d0d8-407e-93f9-ab9521de0f46'),
(25, 0, 'website_logo_link', 'https://www.ezcard.com', '2020-10-14 21:53:27', '2020-10-20 13:44:23', '28a5e56d-aa23-4abe-b61b-9463f049f49b'),
(27, 0, 'website_logo', '/website/logos/ez-card-logo-green.svg', '2020-10-22 23:10:00', '2020-10-23 04:10:12', '92d64ec7-f1cd-4ee1-9d87-f0f8c83f8af7'),
(28, 0, 'default_site_template_1', '1', '2020-11-06 16:54:20', '2021-02-20 08:07:47', 'eee52cd2-1eb5-44df-8671-9c9b6ce4e654'),
(29, 0, 'stripe_account_type', 'customer', '2021-04-22 12:21:42', '2021-04-22 17:21:43', '33a91b19-a38f-11eb-969d-42010a52200b'),
(35, 1, 'application_type', 'maxtech', '2020-09-15 12:49:19', '2021-11-01 22:16:03', '2d517438-763f-40a5-af2d-1d5f4f873ec9'),
(36, 1, 'portal_theme', '3', '2020-12-16 02:57:24', '2020-12-18 02:28:18', '9f3a3d15-4938-11eb-9e97-42010a52200a'),
(37, 1, 'website_theme', '3', '2020-12-16 02:57:45', '2021-01-02 21:20:12', '9f46971b-4938-11eb-9e97-42010a52200a'),
(38, 1, 'application_menu', '[{"title": "LAUNCHPAD","name": "launch-pad","icon": "fa fa-rocket desktop-30px","items": [{"title": "Notices","icon": "fas fa-info-circle desktop-20px","url": "/account/notices"}, {"title": "Quick Start","icon": "fas fa-play desktop-20px","url": "/account/quick-start"}, {"title": "Success Journey","icon": "fas fa-trophy desktop-20px","url": "/account/success-journey"}]}, {"title": "ACCOUNT","name": "account","icon": "fas fa-user-circle desktop-30px","items": [{"title": "Profile","icon": "fas fa-user desktop-20px","url": "/account/profile"}, {"title": "Personas","icon": "fas fa-users desktop-20px","url": "/account/my-personas"}, {"title": "Free Resources","icon": "fa fa-book desktop-20px","url": "/account/free-resources"}, {"title": "Billing","icon": "fa fa-credit-card desktop-20px","url": "/account/billing"}, {"title": "Upgrade","icon": "fa fa-money-bill desktop-20px","url": "/account/upgrade"}, {"title": "Support/Help","icon": "fas fa-headphones desktop-20px","url": "/account/support"}]}, {"title": "MAX TOOLS","name": "max-tools","icon": "fa fa-wrench desktop-30px","items": [{"title": "My Sites","icon": "fa fa-globe desktop-20px","url": "/account/my-sites"}, {"title": "My Groups","icon": "fa fa-id-card desktop-20px","url": "/account/my-groups"}, {"title": "Max Pro CRM","icon": "fa fa-users desktop-20px","url": "/account/max-pro-crm"}, {"title": "Max Follow Up","icon": "fa fa-handshake desktop-20px","url": "/account/max-follow-up"}, {"title": "Marketplace","icon": "fa fa-shopping-basket desktop-20px","url": "/account/marketplace"}]}, {"title": "MY BUSINESS","name": "my-business","icon": "fa fa-building desktop-30px","items": [{"title": "To-Do","icon": "fa fa-check desktop-20px","url": "/account/to-do"}, {"title": "Calendar","icon": "fa fa-calendar-alt desktop-20px","url": "/account/calendar"}, {"title": "Journal","icon": "fa fa-address-book desktop-20px","url": "/account/max-groups"}, {"title": "Planning","icon": "fa fa-handshake desktop-20px","url": "/account/max-follow-up"}, {"title": "Key Objectives","icon": "fa fa-bullseye desktop-20px","url": "/account/marketplace"}, {"title": "Passwords","icon": "fa fa-user-secret desktop-20px","url": "/account/marketplace"}]}, {"title": "PEOPLE","name": "people","icon": "fa fa-users desktop-30px","items": [{"title": "Contacts","icon": "fa fa-id-card desktop-20px","url": "/account/contacts"}, {"title": "Conversations","icon": "fa fa-comments desktop-20px","url": "/account/conversations"}, {"title": "Social Media","icon": "fa fa-share-alt desktop-20px","url": "/account/social-media"}, {"title": "Prospects","icon": "fa fa-search desktop-20px","url": "/account/prospects"}, {"title": "Follow-Up","icon": "fa fa-bullhorn desktop-20px","url": "/account/follow-up"}]}, {"title": "WORKSHOP","name": "workshop","icon": "fas fa-hammer desktop-30px","items": [{"title": "MaxSites","icon": "fa fa-desktop desktop-20px","url": "/account/max-cards"}, {"title": "MaxWebs","icon": "fa fa-calendar-alt desktop-20px","url": "/account/max-webs"}, {"title": "Pages","icon": "fa fa-file desktop-20px","url": "/account/pages"}, {"title": "Resources","icon": "fa fa-handshake desktop-20px","url": "/account/resources"}, {"title": "Widgets","icon": "fas fa-th-large desktop-20px","url": "/account/widgets"}]}, {"title": "MAX CENTRAL","name": "max-central","icon": "fa fa-circle desktop-30px","items": [{"title": "My Team","icon": "fa fa-users desktop-20px","url": "/account/my-team"}, {"title": "My Journey","icon": "fa fa-map desktop-20px","url": "/account/journey"}, {"title": "My Courses","icon": "fa fa-industry desktop-20px","url": "/account/courses"}, {"title": "Video Tutorials","icon": "fa fa-video desktop-20px","url": "/account/video-tutorials"}, {"title": "Help Center","icon": "fas fa-question-circle desktop-20px","url": "/account/help-center"}, {"title": "Settings","icon": "fas fa-sliders-h desktop-20px","url": "/account/settings"}, {"title": "Chat With Us","icon": "fas fa-comments desktop-20px","url": "/account/chat-with-us"}]}, {"title": "SYSTEM","name": "system","icon": "fa fa-cog desktop-30px","items": [{"title": "Custom Fields","icon": "fa fa-pencil-alt desktop-20px","url": "/account/my-team"}, {"title": "Triggers","icon": "fa fa-bolt desktop-20px","url": "/account/journey"}, {"title": "Integrations","icon": "fa fa-puzzle-piece desktop-20px","url": "/account/courses"}, {"title": "Settings","icon": "fa fa-cogs desktop-20px","url": "/account/video-tutorials"}]}]', '2020-09-15 12:57:41', '2021-04-13 17:06:39', '3496bc17-72d8-421b-9175-b5ec7b1ac59b'),
(40, 1, 'website_logo_link', 'https://admin.maxcard.app/account', '2020-12-16 03:05:01', '2021-02-10 19:03:52', '9f529bec-4938-11eb-9e97-42010a52200a'),
(41, 1, 'portal_logo_dark', '/website/logos/max-community-logo.png', '2020-12-16 03:05:01', '2020-12-28 18:34:25', '9f5eb32d-4938-11eb-9e97-42010a52200a'),
(42, 1, 'website_logo', '/website/logos/max-community-logo-full.png', '2020-12-16 03:05:02', '2020-12-28 18:38:21', '9f6a7b92-4938-11eb-9e97-42010a52200a'),
(43, 1, 'website_logo_css', 'width: 125px; top: 8px;', '2020-12-16 03:05:03', '2020-12-16 09:05:04', '9f756c9f-4938-11eb-9e97-42010a52200a'),
(44, 1, 'stripe_account_type', 'connected', '2020-12-16 03:05:03', '2020-12-16 09:05:04', '9f815c62-4938-11eb-9e97-42010a52200a'),
(45, 1, 'portal_logo_light', '/website/logos/max-community-logo.png', '2020-12-16 03:05:02', '2020-12-28 18:34:43', '9f8d4139-4938-11eb-9e97-42010a52200a'),
(46, 1, 'default_persona_package_id', '14', '2020-12-16 03:05:02', '2020-12-28 18:34:43', '9f8d4139-4938-11eb-9e97-42010a52200a');

INSERT INTO company_setting (company_setting_id, company_id, label, value, created_on, last_updated, sys_row_id) VALUES
(47, 1, 'portal_theme_main_color', 'ed1e0b', '2020-12-28 12:42:42', '2020-12-28 18:42:44', '78166019-493c-11eb-9e97-42010a52200a'),
(48, 1, 'portal_theme_main_color_light', 'ed1e0b', '2020-12-28 12:45:48', '2020-12-28 18:45:49', 'e087907c-493c-11eb-9e97-42010a52200a'),
(49, 1, 'product_notification_email', 'support@maxcommunity.us', '2021-02-09 13:45:17', '2021-02-09 13:45:17', '54c1c566-6b0f-11eb-9e97-42010a52200a'),
(50, 1, 'cart_privacy_policy_url', 'https://maxcommunity.us/privacy-policy/', '2020-08-20 03:07:34', '2020-08-20 08:07:42', 'd84c4e8f-6bcd-11eb-9e97-42010a52200a'),
(51, 1, 'customer_support_email', 'support@maxcommunity.us', '2020-08-20 02:38:06', '2020-08-20 08:07:52', 'e4932fff-6bcd-11eb-9e97-42010a52200a'),
(52, 1, 'noreply_email', 'noreply@maxcard.app', '2020-11-06 16:54:20', '2021-02-20 08:07:47', 'b2672e45-7352-11eb-aa29-42010a52200c'),
(53, 1, 'default_site_template_1', '4', '2020-11-06 16:54:20', '2021-02-20 08:07:47', 'a65cfb27-09fa-4097-bfe2-9fa6f2c8fe31'),
(55, 1, 'default_site_template_2', '6', '2020-11-06 16:54:20', '2021-02-20 08:07:47', 'eee52cd2-1eb5-44df-8671-9c9b6ce4e654'),
(56, 1, 'portal_logo_dark', '/website/logos/total-business-365.png', '2020-12-16 03:05:01', '2020-12-28 18:34:25', '77838cce-3038-11ec-82cd-42010a522011'),
(57, 1, 'mailgun_key', 'c6ca08d1eac33fcf07dd0e214e501af8-2bf328a5-d53ea6ea', NULL, '2021-10-19 03:28:02', '00b244db-31e8-11ec-82cd-42010a522011'),
(58, 1, 'mailgun_domain', 'mg.maxcommunity.us', NULL, NULL, '00c4086c-31e8-11ec-82cd-42010a522011'),
(59, 1, 'customer_support_user_id', '1001', NULL, NULL, '00c4086c-31e8-11ec-82cd-42010a522011');

INSERT INTO company_setting (company_setting_id, company_id, label, value, created_on, last_updated, sys_row_id) VALUES
(80, 2, 'application_type', 'default', '2020-09-15 12:49:19', '2021-11-01 22:16:03', '2d517438-763f-40a5-af2d-1d5f4f873ec9'),
(81, 2, 'portal_theme', '1', '2020-09-15 12:49:19', '2021-11-01 22:16:03', '2d517438-763f-40a5-af2d-1d5f4f873ec9'),
(82, 2, 'website_theme', '1', '2020-09-15 12:57:41', '2021-04-13 17:06:39', '3496bc17-72d8-421b-9175-b5ec7b1ac59b'),
(83, 2, 'portal_logo_light', '/website/logos/ez-card-logo-initials-green.svg', '2020-09-23 05:26:54', '2020-12-16 09:50:50', '21e76d85-4407-4de4-896c-3c71f0310f91'),
(84, 2, 'website_logo_css', 'width: 125px; top: 8px;', '2020-10-14 21:52:39', '2020-10-20 13:44:17', '36f79545-d0d8-407e-93f9-ab9521de0f46'),
(85, 2, 'website_logo_link', 'https://www.ezcard.com', '2020-10-14 21:53:27', '2020-10-20 13:44:23', '28a5e56d-aa23-4abe-b61b-9463f049f49b'),
(86, 2, 'website_logo', '/website/logos/ez-card-logo-green.svg', '2020-10-22 23:10:00', '2020-10-23 04:10:12', '92d64ec7-f1cd-4ee1-9d87-f0f8c83f8af7'),
(87, 2, 'default_site_template_1', '1', '2020-11-06 16:54:20', '2021-02-20 08:07:47', 'eee52cd2-1eb5-44df-8671-9c9b6ce4e654'),
(88, 2, 'stripe_account_type', 'customer', '2021-04-22 12:21:42', '2021-04-22 17:21:43', '33a91b19-a38f-11eb-969d-42010a52200b');


INSERT INTO excell_main.`connection` (connection_id,company_id,division_id,user_id,connection_type_id,connection_label,connection_value,is_primary,connection_class,sys_row_id) VALUES
(1000,0,0,1000,6,NULL,'micah@zakgraphix.com',1,'user','ec7e9d11-3ceb-11ec-92c2-0242ac010007'),
(1001,0,0,1000,1,NULL,'6185818281',1,'user','ec806d45-3ceb-11ec-92c2-0242ac010007');

INSERT INTO connection_type (connection_type_id,abbreviation,name,`action`,font_awesome,sys_row_id) VALUES
(1,'mobile_phone','Mobile','phone','fas fa-mobile','de0f1980-ca61-11e8-95ec-6ef620543eb9'),
(2,'website','Website','link','fas fa-globe','2f8d6367-ca62-11e8-95ec-6ef620543eb9'),
(3,'business_phone','Business Phone','phone','fas fa-phone','652ddcbd-ca65-11e8-9461-52de8773d5f0'),
(4,'home_phone','Home Phone','phone','fas fa-home','532060e4-ca68-11e8-95ec-6ef620543eb9'),
(5,'fax_number','Fax Number','fax','fas fa-fax','5d46ca07-ca68-11e8-95ec-6ef620543eb9'),
(6,'email','E-mail','email','fas fa-envelope','0e040d89-d5ba-11e8-95ec-6ef620543eb9'),
(7,'blog','Blog','link','fas a-rss','511a825a-d5ba-11e8-9461-52de8773d5f0'),
(8,'facebook','Facebook','link','fab fa-facebook','694e3cb6-d5ba-11e8-9461-52de8773d5f0'),
(9,'mewe','MeWe','link','fas fa-globe','7e8f74b3-d5ba-11e8-9461-52de8773d5f0'),
(10,'instagram','Instagram','link','fab fa-instagram-square','9d54fb2c-d5ba-11e8-95ec-6ef620543eb9');
INSERT INTO connection_type (connection_type_id,abbreviation,name,`action`,font_awesome,sys_row_id) VALUES
(11,'linkedIn','LinkedIn','link','fab fa-linkedin-in','b2c701d2-d5ba-11e8-9461-52de8773d5f0'),
(12,'pinterest','Pinterest','link','fab fa-pinterest-square','c0ecab50-d5ba-11e8-9461-52de8773d5f0'),
(13,'snapchat','Snapchat','link','fab fa-snapchat','db3616ac-d5ba-11e8-95ec-6ef620543eb9'),
(14,'twitter','Twitter','link','fab fa-twitter-square','ec30b412-d5ba-11e8-9461-52de8773d5f0'),
(15,'vimeo','Vimeo','link','fab fa-vimeo','f7d422b0-d5ba-11e8-9461-52de8773d5f0'),
(16,'youtube','YouTube','link','fab fa-youtube','0602fa92-d5bb-11e8-9461-52de8773d5f0'),
(17,'bandcamp','Bandcamp','link','fas fa-globe','15909bdf-d5bb-11e8-95ec-6ef620543eb9'),
(18,'soundcloud','SoundCloud','link','fas fa-globe','2193bfd0-d5bb-11e8-9461-52de8773d5f0'),
(19,'twitch','Twitch','link','fab fa-twitch','2cb481bd-d5bb-11e8-9461-52de8773d5f0'),
(20,'gab','Gab','link','fas fa-globe','1c74072c-97f8-42c2-916b-396db15055f6');
INSERT INTO connection_type (connection_type_id,abbreviation,name,`action`,font_awesome,sys_row_id) VALUES
(21,'whatsapp','WhatsApp','link','fab fa-whatsapp','5ad58407-0ee3-4333-8f44-380e007af331');

INSERT INTO domain_ssl (domain_ssl_id,company_id,card_domain_id,domain,key_value) VALUES
(1,1,NULL,'maxr.app.crt','-----BEGIN CERTIFICATE-----\nMIIGJzCCBQ+gAwIBAgIQZVvDFqqQOdOFPG8nLgw1eDANBgkqhkiG9w0BAQsFADCB\njzELMAkGA1UEBhMCR0IxGzAZBgNVBAgTEkdyZWF0ZXIgTWFuY2hlc3RlcjEQMA4G\nA1UEBxMHU2FsZm9yZDEYMBYGA1UEChMPU2VjdGlnbyBMaW1pdGVkMTcwNQYDVQQD\nEy5TZWN0aWdvIFJTQSBEb21haW4gVmFsaWRhdGlvbiBTZWN1cmUgU2VydmVyIENB\nMB4XDTIzMTEwMjAwMDAwMFoXDTI0MTEwMjIzNTk1OVowFTETMBEGA1UEAwwKKi5t\nYXhyLmFwcDCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoCggEBAMbTWHftt/Z+\nOOf7Ghv/f23OqR7MUAagUDMnUbYpJaAJuba7kVlowiMgLJDNgcvt9XYo0RIwttUt\nWDvIsogObHIviOovgD1pYxYMN1iIKOvcthM5+SVuirLBWVm7SKTq/NwQVMhedBvQ\nqM3Ly60YNiA/CDR4ZphIh2+BwrAcHiRQ76mT27x2ZRKpXUm7JbpSRcYX5ZUKmieV\n0I7O9iJ3IqKw22xvXhXihLetAfNuwodVWEsm1bKgoskznKl8TnNmGKVL56IPDrjb\nooZ7oNbQZczmKD8mgWjglGJimahpuLPWZmlQiXsjSBWcaMk2nnbc6xqZ5khn7fug\nuW6HDms7U20CAwEAAaOCAvYwggLyMB8GA1UdIwQYMBaAFI2MXsRUrYrhd+mb+ZsF\n4bgBjWHhMB0GA1UdDgQWBBTJE/dG6Pq2eYOhb1kkJzMU3hz4SDAOBgNVHQ8BAf8E\nBAMCBaAwDAYDVR0TAQH/BAIwADAdBgNVHSUEFjAUBggrBgEFBQcDAQYIKwYBBQUH\nAwIwSQYDVR0gBEIwQDA0BgsrBgEEAbIxAQICBzAlMCMGCCsGAQUFBwIBFhdodHRw\nczovL3NlY3RpZ28uY29tL0NQUzAIBgZngQwBAgEwgYQGCCsGAQUFBwEBBHgwdjBP\nBggrBgEFBQcwAoZDaHR0cDovL2NydC5zZWN0aWdvLmNvbS9TZWN0aWdvUlNBRG9t\nYWluVmFsaWRhdGlvblNlY3VyZVNlcnZlckNBLmNydDAjBggrBgEFBQcwAYYXaHR0\ncDovL29jc3Auc2VjdGlnby5jb20wHwYDVR0RBBgwFoIKKi5tYXhyLmFwcIIIbWF4\nci5hcHAwggF+BgorBgEEAdZ5AgQCBIIBbgSCAWoBaAB2AHb/iD8KtvuVUcJhzPWH\nujS0pM27KdxoQgqf5mdMWjp0AAABi4602lgAAAQDAEcwRQIhAP8MRO28gOrgIgMt\ne1h5vIzjv3buAskt48290K9mH2PhAiAsBDre94U+vzxrEa+o6npClkkunGIVxZ8s\n74xwR/fA3QB2ANq2v2s/tbYin5vCu1xr6HCRcWy7UYSFNL2kPTBI1/urAAABi460\n2rwAAAQDAEcwRQIhAMfmr2taSf1wxf1HO/83zjR5Z8joivG1w1nR8f6mr7z4AiA3\nTgxHF8J2Xnc7Y8AUqe08Df9aaq5cpPxad5hYky9ePQB2AO7N0GTV2xrOxVy3nbTN\nE6Iyh0Z8vOzew1FIWUZxH7WbAAABi4602oIAAAQDAEcwRQIgKSNlJDzTjD3pK3Un\n6dSGsCSCoJVS/eb/Qtecl+ppFDUCIQCDPvHqtIH9z3bVTVsXV2KjiwIdeIKbyyrP\nSoa8cHYaDTANBgkqhkiG9w0BAQsFAAOCAQEABPKGCeaNcoNtGRF/SDYvVM1TDVQr\nEvVVmPt+u6FCzuwfB1IFOSetil2E9hohLRPUDDcQK2nvCQKZxQgE7ZSaFlVhsiQ5\nghX/mjOpt0cCrmlEW7xgHsSxjg8Kc0S3bjqWQiM6OIureNFIls4DpPAsSCd8gSjh\nAATU+7fbfMoBhi/qha+CzIZEFgPjG7ri2ewUH4TWpuBs38RjhUnqzgpScUQSU8KG\nPSfTanFFxRpiL0GmDC+E2Gj8B7BvtjxxPCHPzLhePBJRUbhkk4wmnHGy4w3mJSVt\nMgBL0mvOl+sWwAoBvE7OFw71HBT4DgSn5oX++uBJL6QP/lLNITOsp12GSg==\n-----END CERTIFICATE-----'),
(2,1,NULL,'maxr.app.key','-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDG01h37bf2fjjn\n+xob/39tzqkezFAGoFAzJ1G2KSWgCbm2u5FZaMIjICyQzYHL7fV2KNESMLbVLVg7\nyLKIDmxyL4jqL4A9aWMWDDdYiCjr3LYTOfklboqywVlZu0ik6vzcEFTIXnQb0KjN\ny8utGDYgPwg0eGaYSIdvgcKwHB4kUO+pk9u8dmUSqV1JuyW6UkXGF+WVCponldCO\nzvYidyKisNtsb14V4oS3rQHzbsKHVVhLJtWyoKLJM5ypfE5zZhilS+eiDw6426KG\ne6DW0GXM5ig/JoFo4JRiYpmoabiz1mZpUIl7I0gVnGjJNp523OsameZIZ+37oLlu\nhw5rO1NtAgMBAAECggEAJb/czTBiPDes4Eapp2U0MYoKTCGolAl+EKhHeFmJnkAa\ndZpZN2uPaJHkRD3wheKRNzT6tQRwwjrQxNEPLIvohSmHSkdohsBqorYBEBsSAe4u\n16mrJzM8vEG/kCzh1wYSqkmjf0OHsfxFAIXQDvZI2Ih/K08s0375z+8IIt3Dz0sE\nS2ctEDLgeWj9dTjt3C8ieJ3XNYH9iF9qvywcVIzbp+BJL3eZwLTuYtia1IYx3Zc2\nLUOSxpTgeMXfzwwmgb2/ukwYfefvcPZQA5rUy9Y36yRxLjNOR38MZYMJub4Q4qxR\n/CJc+g6lRs7OuA9yXsuFE5sxnkILzLEm9tKvKUQgwQKBgQD/85ccJKBQWBDvBCLj\n2m7F/rjO/7Lc3mMa/sG4dNxHmX6RK3VmBGwN6xXTPC5oZS0j60NzvGL5KrMK8wHn\nWfj1XSsJlhk+LtDRRTErHC1rTvqaLdoDWkc//arAYOL664PkiGOMakjA7XWQHfnl\nd/AYlfLsb7UWJ1h75H/zN5NFcQKBgQDG3PxOiENa8QDtiYA++Kje8BSimgJGYeNA\nLUziz4G1zYNUPLjZLjtALibbKbP4CrjNWgeiBorgAMFycTT5q18olr6cdRVoqgTf\nPzdRZwt/nhxZcnV8dNLQqxedb0d8CLGLeixFdNmi7BMQZ/UYqLkaNx/iN+vPkF53\nmVeHle5/vQKBgQDm2+eoUsDmtwhPDgQKULMpkx9OVgQWg+AQMUi5/23QhvpKJlC1\nu7datnfxF48kSl30z/b/JSSAaaskbRuCePy9E1QGSYRrOf7PQwGeSMQOziXrev/x\nljQ926dv7fPNLzC/qOVheVw15/jqDJ+iAhRlmJqL+BX17Xc6CFgAIFiNgQKBgQC5\nSAoYDWNcJvHrX1JK2ZlVZbCEMyPteaSnFc3uANJklh9Ha+/6AdYYnSd8ySUx9KNs\nSPaVoqzfujSCsTFfcakOgy0DTx9sTgSOEDM1N+IBvEnDmR4XoC0PWGl/OMAMs3jg\ncCsxZ4ajAntcrM8yc3lLEJM3TUz7LhKmMgvYevwkrQKBgHHms7ks9XC4NokiIoxK\ncO+Z/7yLEjB5JDjw0nv9FshpnnIQdpwAtiZU+4U2rQXMZjh3fa9DLLUVoP/eAlhL\nzMOep1xMHQL3+R7v/qEd4PDmmMfob/k/xaGKLUjT/2BNuP6emJXswdRFu5xrZbyM\n0WmXFmLatRMVv4q61AMYALQd\n-----END PRIVATE KEY-----');

INSERT INTO division (division_id,company_id,division_parent_id,division_name,address_1,address_2,address_3,city,state,zip,country,phone_number,fein,legal_name,logo_url,sys_row_id) VALUES
(0,0,NULL,'Excell, LCC','','','','',NULL,NULL,'USA','',0,'','','7d820f98-e3a6-4af2-9e46-a22561cf2299'),
(1,1,NULL,'Maxr, LCC','','','','',NULL,NULL,'USA','',0,'','','7d820f98-e3a6-4af2-9e46-a22561cf2299'),
(2,2,NULL,'EZcard, LCC','','','','',NULL,NULL,'USA','',0,'','','7d820f98-e3a6-4af2-9e46-a22561cf2299');

INSERT INTO `package` (`package_id`, `type`, `source`, `parent_id`, `company_id`, `division_id`, `enduser_id`, `bundle_id`, `name`, `description`, `content`, `currency`, `order`, `max_quantity`, `hide_line_items`, `image_url`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(1, "default", "system", null, 0, 0, 1, null, 'The Excell Site', 'Plain and simple. The Excell card.<ul><li>Mobile Website</li><li>Custom Build</li><li>Lead Tracking</li></ul>', '', 'usd', 1, 1, 1, 'http://ezcard.com/_ez/images/products/1001.png', '2020-08-13 17:45:50', '2021-06-25 17:50:37', '74cfb5dc-5ae2-4bf9-a2b4-66fd3744a437'),
(2, "default", "system", null, 0, 0, 1, null, 'Directory', 'Showcase your membership!', '', 'usd', 3, NULL, 1, 'http://ezcard.com/_ez/images/products/1003.png', '2020-08-13 19:14:40', '2021-06-25 17:53:55', 'de09f1f6-2826-4a42-b68e-0fa258a317a4'),
(3, "default", "system", null, 0, 0, 1, null, 'Extra Page', 'Everyone needs more!', '', 'usd', 2, NULL, 1, 'http://ezcard.com/_ez/images/products/1002.png', '2020-08-13 19:15:20', '2021-06-25 17:53:46', 'f0fbab0b-2273-4279-9d0f-9128b1905774');

INSERT INTO `package` (`package_id`, `type`, `source`, `parent_id`, `company_id`, `division_id`, `enduser_id`, `bundle_id`, `name`, `description`, `content`, `currency`, `order`, `max_quantity`, `hide_line_items`, `image_url`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(5, "default", "system", null, 2, 0, 1, null, 'The EZcard', 'Plain and simple. The EZcard.<ul><li>Mobile Website</li><li>Custom Build</li><li>Lead Tracking</li></ul>', '', 'usd', 1, 1, 1, 'http://ezcard.com/_ez/images/products/1001.png', '2020-08-13 17:45:50', '2021-06-25 17:50:37', '7cd02224-bf48-4fc6-ab9b-7f1795962a93'),
(6, "default", "system", null, 2, 0, 1, null, 'Directory', 'Showcase your membership!', '', 'usd', 3, NULL, 1, 'http://ezcard.com/_ez/images/products/1003.png', '2020-08-13 19:14:40', '2021-06-25 17:53:55', '7495772c-3a45-4900-bf34-50e4bcdfe3a0'),
(7, "default", "system", null, 2, 0, 1, null, 'Extra Page', 'Everyone needs more!', '', 'usd', 2, NULL, 1, 'http://ezcard.com/_ez/images/products/1002.png', '2020-08-13 19:15:20', '2021-06-25 17:53:46', '74a6dfaf-ce65-4f53-a112-e6b7167ac22d');

INSERT INTO `package` (`package_id`, `type`, `source`, `parent_id`, `company_id`, `division_id`, `enduser_id`, `bundle_id`, `name`, `description`, `content`, `currency`, `order`, `max_quantity`, `hide_line_items`, `image_url`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(10, "default", "system", null, 1, 0, 1, null, 'MaxCard Bronze', '<span style="line-height: 19px;display: block;">Web App & SMS Platform</span><ul><li>Mobile Website</li><li>Custom Build</li><li>Lead Tracking</li></ul>', '', 'usd', 1, 1, 1, 'https://app.ezcardmedia.com/images/users/5865fe8b-111f-4c6f-a098-8118e5c83af2/b3889ff7cb102198bac2ebfd9332c4859f092dfe.png', '2020-12-09 12:25:54', '2021-03-30 18:14:36', '122bd95c-3a4c-11eb-adc1-0242ac120002'),
(11, "default", "system", null, 1, 0, 1, null, 'MaxCard Silver', '<span style="line-height: 19px;display: block;">Tracking & SMS Messaging</span><ul><li>Vanity Keyword</li><li>Lead Tracking</li><li>250/mo SMS Messages</li></ul>', '', 'usd', 2, 1, 1, 'https://app.ezcardmedia.com/images/users/5865fe8b-111f-4c6f-a098-8118e5c83af2/40ff5acfee92c2844534f0453a6fc310c542f367.png', '2020-12-09 12:25:55', '2021-03-30 18:16:37', '122bdbb4-3a4c-11eb-adc1-0242ac120002'),
(12, "default", "system", null, 1, 0, 1, null, 'MaxCard Gold', '<span style="line-height: 19px;display: block;">Pro Member Directory</span><ul><li>Contact Info</li><li>Business Info</li><li>Social Media Links +</li></ul>', '', 'usd', 3, 1, 1, 'https://app.ezcardmedia.com/images/users/5865fe8b-111f-4c6f-a098-8118e5c83af2/d0d29076d143d10479313d5cd6b5573eccfb541e.png', '2020-12-09 12:25:56', '2021-03-30 18:27:58', '122bdca4-3a4c-11eb-adc1-0242ac120002'),
(13, "default", "system", null, 1, 0, 1, null, 'MaxCard Page', 'The Power of Your Message<ul><li>A Custom Card Page Build</li><li>One to One Presentation</li><li>Tailored Media Distribution</li></ul>', '', 'usd', 1, 6, 1, 'http://ezcard.com/_ez/images/products/1002.png', '2020-12-28 16:40:31', '2021-01-05 20:36:51', 'a8b238e4-b23e-4557-97c4-98aff205978f');

INSERT INTO `package` (`package_id`, `type`, `source`, `parent_id`, `company_id`, `division_id`, `enduser_id`, `bundle_id`, `name`, `description`, `content`, `currency`, `order`, `max_quantity`, `hide_line_items`, `image_url`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(14, "default", "system", null, 1, 0, 1, null, 'Member Directory', 'A Powerful Directory Tool<ul><li>1st Directory on a card is free</li><li>Promote BRANDS & EVENTS</li><li>Give Value, Empower Others</li></ul>', '', 'usd', 1, 6, 1, 'http://ezcard.com/_ez/images/products/1003.png', '2020-12-28 16:41:08', '2021-01-05 20:37:04', '142f5644-b14d-4975-8aaa-d0219a698863'),
(15, "default", "system", null, 1, 0, 3, null, 'Max PromoCard', '<i style="font-size:11px;top: -15px;position: relative;">Renews at $350.00/Year</i><br><span style="line-height: 19px;display: block;">Pro Directory w 5 Custom Pages</span><ul><li>First 10 Cards Are Free!</li><li>Pro MAX Member Directory</li><li>Pro SMS Marketing System</li></ul>', '', 'usd', 5, 1, 1, 'https://app.ezcardmedia.com/images/users/5865fe8b-111f-4c6f-a098-8118e5c83af2/b3889ff7cb102198bac2ebfd9332c4859f092dfe.png', '2021-01-22 13:00:52', '2021-03-24 22:29:59', '9445cdfb-9c09-44df-8e3b-3f0d052fefe4'),
(27, "default", "system", null, 1, 0, 1, null, 'MaxCard Platinum', '<i style="font-size:11px;top: -15px;position: relative;">Renews at $700.00/Year</i><br><span style="color:#008fff;line-height: 19px;display: block;">All Above + Pro Platinum Design</span><ul><li>Platinum Design</li><li>Leads + SMS Messages</li><li>Max Directory</li></ul>', '', 'usd', 4, 1, 1, 'https://app.ezcardmedia.com/images/users/5865fe8b-111f-4c6f-a098-8118e5c83af2/912edc43ec7b93f821167276f1cfad8e1e624204.png', '2020-12-09 12:25:56', '2021-03-30 18:27:19', '0c89d045-3f0b-47b3-9608-e0749b215beb'),
(28, "default", "system", null, 1, 0, 1, null, 'Standard Persona', 'Define yourself and showcase it to the world!', '', 'usd', 4, 1, 1, 'https://app.ezcardmedia.com/images/users/5865fe8b-111f-4c6f-a098-8118e5c83af2/912edc43ec7b93f821167276f1cfad8e1e624204.png', '2020-12-09 12:25:56', '2021-03-30 18:27:19', '76e9c481-f9df-4e3b-9c02-e15891d46ce7'),
(29, "default", "system", null, 1, 0, 1, null, 'Premium Persona', 'Capture an audience and give them your vision.', '', 'usd', 4, 1, 1, 'https://app.ezcardmedia.com/images/users/5865fe8b-111f-4c6f-a098-8118e5c83af2/912edc43ec7b93f821167276f1cfad8e1e624204.png', '2020-12-09 12:25:56', '2021-03-30 18:27:19', '115d045f-d290-4919-88a8-e0a69d17bee1'),
(30, "default", "system", null, 1, 0, 1, null, 'Standard Group', 'Collect a membership, manage interactions!', '', 'usd', 4, 1, 1, 'https://app.ezcardmedia.com/images/users/5865fe8b-111f-4c6f-a098-8118e5c83af2/b3889ff7cb102198bac2ebfd9332c4859f092dfe.png', '2020-12-09 12:25:56', '2021-03-30 18:27:19', 'cd58f2de-9ced-4c29-a60c-87ec1230be52'),
(31, "default", "system", null, 1, 0, 1, null, 'Premium Group', 'Create a tiered community that shares and grows through being involved.', '', 'usd', 4, 1, 1, 'https://app.ezcardmedia.com/images/users/5865fe8b-111f-4c6f-a098-8118e5c83af2/912edc43ec7b93f821167276f1cfad8e1e624204.png', '2020-12-09 12:25:56', '2021-03-30 18:27:19', '4d2cb6eb-5b4e-4abb-b747-01ce378945d5');

INSERT INTO `package_class` (`package_class_id`, `name`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(1, 'card', '2020-08-13 17:43:23', '2020-08-13 22:44:36', 'b8fe5a64-1c8f-4a6b-b628-6524ccd6e790'),
(2, 'card page', '2020-10-19 22:53:34', '2020-10-20 03:55:46', 'd9eaff65-f8b9-4af7-80a7-bd10c2463295'),
(3, 'account', '2020-12-28 16:42:11', '2020-12-28 22:42:17', '7ba442bc-f2f2-478f-8ddf-0f0dd3b9d998'),
(4, 'persona', '2020-12-28 16:42:11', '2020-12-28 22:42:17', '5bba16f9-5815-447e-bf0a-6293124dfced'),
(5, 'group', '2020-12-28 16:42:11', '2020-12-28 22:42:17', '6e31fe10-df50-4251-9c09-11c3008ed2f5'),
(6, 'directory', '2020-12-28 16:42:11', '2020-12-28 22:42:17', '22c414e5-6454-481c-94f6-4f8bba7961d7');

INSERT INTO `package_class_rel` (`package_class_rel_id`, `package_id`, `package_class_id`, `sys_row_id`) VALUES
(1, 1, 1, 'dec5ff13-2d8c-4a3c-bc79-de5f0afe806b'),
(2, 2, 1, 'd4fd3ad1-e413-4380-8366-92234c153fb5'),
(3, 3, 1, 'd12d3b2d-37a6-424c-9cd4-fd757555aaea'),
(4, 5, 1, 'd4fd3ad1-e413-4380-8366-92234c153fb5'),
(5, 6, 1, 'd12d3b2d-37a6-424c-9cd4-fd757555aaea'),
(6, 7, 1, 'd12d3b2d-37a6-424c-9cd4-fd757555aaea'),
(7, 10, 1, '4429d53f-8189-4640-8d5f-57580219f524'),
(8, 11, 1, 'aac98244-4942-11eb-9e97-42010a52200a'),
(9, 12, 1, 'b1ef156a-4942-11eb-9e97-42010a52200a'),
(10, 13, 2, 'd840d9bb-495d-11eb-9e97-42010a52200a'),
(11, 14, 2, 'dd882ad1-495d-11eb-9e97-42010a52200a'),
(12, 15, 1, 'b7ef4234-5ce5-11eb-9e97-42010a52200a'),
(13, 27, 1, '4fe7d5ce-8c88-11eb-969d-42010a52200b'),
(14, 28, 4, '4ca9dfaf-bceb-4e6d-ad76-aa85bfb4ea6b'),
(15, 29, 4, 'd989bb34-3b26-4a75-abb7-32b19bcb32c7'),
(16, 30, 6, 'ef3e0ee9-4e7c-4187-aa0f-c92cd6d5c4ff'),
(17, 31, 6, 'd92da126-d29b-46cd-956c-50f3398bb2d1'),
(18, 32, 5, '49286c5a-c9d4-4082-b218-06e114a0f475'),
(19, 33, 5, '0d36df72-052a-442f-af05-abcbc9031bb0');

INSERT INTO `package_variation` (`package_id`, `name`, `description`, `type`, `promo_price`, `regular_price`, `image`, `order`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(1,'The Excell Site','Plain and simple. The Excell card.<ul><li>Mobile Website</li><li>Custom Build</li><li>Lead Tracking</li></ul>','billing',15.00,30.00,NULL,1,NULL,NULL,'c4e84e80-befd-11ee-9a5f-0242ac010007'),
(2,'Directory','Showcase your membership!','billing',5.00,10.00,NULL,1,NULL,NULL,'00817ed9-beff-11ee-9a5f-0242ac010007'),
(3,'Extra Page','Everyone needs more!','billing',1.00,2.00,NULL,1,NULL,NULL,'008374cb-beff-11ee-9a5f-0242ac010007'),
(5,'The EZcard Site','Plain and simple. The Excell card.<ul><li>Mobile Website</li><li>Custom Build</li><li>Lead Tracking</li></ul>','billing',15.00,30.00,NULL,1,NULL,NULL,'14b480a0-beff-11ee-9a5f-0242ac010007'),
(6,'Directory','Showcase your membership!','billing',5.00,10.00,NULL,1,NULL,NULL,'14b5bbc1-beff-11ee-9a5f-0242ac010007'),
(7,'Extra Page','Everyone needs more!','billing',1.00,2.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(10,'MaxR Bronze','','billing',15.00,20.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(11,'MaxR Silver','','billing',15.00,20.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(12,'MaxR Gold','','billing',15.00,20.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(13,'MaxR Page','','billing',1.00,2.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(14,'Member Directory','','billing',5.00,10.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(15,'Max PromoCard','','billing',15.00,20.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(27,'MaxCard Platinum','','billing',15.00,20.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(28,'Standard Persona','','billing',3.00,5.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(29,'Premium Persona','','billing',7.00,10.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(30,'Standard Group','','billing',5.00,10.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007'),
(31,'Premium Group','','billing',10.00,20.00,NULL,1,NULL,NULL,'14b6ab83-beff-11ee-9a5f-0242ac010007');


INSERT INTO `package_line` (`package_line_id`, `package_variation_id`, `package_id`, `company_id`, `division_id`, `product_entity`, `product_entity_id`, `journey_id`, `name`, `description`, `quantity`, `cycle_type`, `promo_price`, `promo_price_duration`, `regular_price`, `regular_price_duration`, `currency`, `product_price_override`, `product_promo_price_override`, `order`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(1, 1, 1, 0, 0, 'product', 1000, NULL, 'The EZcard', '', 1, 5, 260.00, NULL, 260.00, NULL, 'usd', NULL, NULL, 1, '2020-08-15 16:30:28', '2021-04-22 17:22:50', '1a9fa071-0d40-4969-814c-949d039f4e8d'),
(2, 1, 1, 0, 0, 'product', 1001, 1000, 'Card Design', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', NULL, NULL, 2, '2020-08-15 16:51:01', '2021-04-22 17:22:56', 'c2eb94e6-a6d9-42f0-a631-78efd42ec3dd'),
(3, 1, 1, 0, 0, 'product', 1002, NULL, 'Card Page', '', 3, 5, 30.00, NULL, 30.00, NULL, 'usd', NULL, NULL, 3, '2020-08-15 16:52:50', '2021-04-22 17:23:10', '8fe595cf-97b7-444e-9df5-783aeb806d7d'),
(4, 2, 2, 0, 0, 'product', 1002, NULL, 'Card Page', '', 1, 5, 50.00, NULL, 50.00, NULL, 'usd', NULL, NULL, 1, '2020-08-15 16:52:50', '2021-04-22 17:23:15', 'aec71bd0-7e36-4d7f-96ce-f3dfca57befd'),
(5, 3, 3, 0, 0, 'product', 1006, NULL, 'Member Directory', '', 1, 5, 150.00, NULL, 150.00, NULL, 'usd', NULL, NULL, 1, '2020-08-15 17:04:48', '2021-04-22 17:23:20', '2b19a1c8-3c33-4d12-a56e-59d9a5a195dd');

INSERT INTO `package_line` (`package_line_id`, `package_variation_id`, `package_id`, `company_id`, `division_id`, `product_entity`, `product_entity_id`, `journey_id`, `name`, `description`, `quantity`, `cycle_type`, `promo_price`, `promo_price_duration`, `regular_price`, `regular_price_duration`, `currency`, `product_price_override`, `product_promo_price_override`, `order`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(6, 4, 5, 2, 0, 'product', 1000, NULL, 'The EZcard', '', 1, 5, 260.00, NULL, 260.00, NULL, 'usd', NULL, NULL, 1, '2020-08-15 16:30:28', '2021-04-22 17:22:50', '1a9fa071-0d40-4969-814c-949d039f4e8d'),
(7, 4, 5, 2, 0, 'product', 1001, 1000, 'Card Design', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', NULL, NULL, 2, '2020-08-15 16:51:01', '2021-04-22 17:22:56', 'c2eb94e6-a6d9-42f0-a631-78efd42ec3dd'),
(8, 4, 5, 2, 0, 'product', 1002, NULL, 'Card Page', '', 3, 5, 30.00, NULL, 30.00, NULL, 'usd', NULL, NULL, 3, '2020-08-15 16:52:50', '2021-04-22 17:23:10', '8fe595cf-97b7-444e-9df5-783aeb806d7d'),
(9, 5, 6, 2, 0, 'product', 1002, NULL, 'Card Page', '', 1, 5, 50.00, NULL, 50.00, NULL, 'usd', NULL, NULL, 1, '2020-08-15 16:52:50', '2021-04-22 17:23:15', 'aec71bd0-7e36-4d7f-96ce-f3dfca57befd'),
(10, 6, 7, 2, 0, 'product', 1006, NULL, 'Member Directory', '', 1, 5, 150.00, NULL, 150.00, NULL, 'usd', NULL, NULL, 1, '2020-08-15 17:04:48', '2021-04-22 17:23:20', '2b19a1c8-3c33-4d12-a56e-59d9a5a195dd'),
(11, 1, 1, 0, 0, 'product', 1006, NULL, 'Member Directory', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', NULL, NULL, 4, '2020-08-15 17:04:48', '2021-04-22 17:24:03', '5faf25eb-9c7b-11eb-969d-42010a52200b'),
(12, 4, 5, 2, 0, 'product', 1006, NULL, 'Member Directory', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', NULL, NULL, 4, '2020-08-15 17:04:48', '2021-04-22 17:24:03', '5faf25eb-9c7b-11eb-969d-42010a52200b');

INSERT INTO `package_line` (`package_line_id`, `package_variation_id`, `package_id`, `company_id`, `division_id`, `product_entity`, `product_entity_id`, `journey_id`, `name`, `description`, `quantity`, `cycle_type`, `promo_price`, `promo_price_duration`, `regular_price`, `regular_price_duration`, `currency`, `product_price_override`, `product_promo_price_override`, `order`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(21, 7, 10, 1, 0, 'product', 1000, NULL, 'The MaxCard', '', 1, 5, 397.00, NULL, 350.00, NULL, 'usd', 75.00, 110.00, 1, '2020-12-28 13:30:15', '2021-03-16 18:41:19', 'e4025d30-4942-11eb-9e97-42010a52200a'),
(22, 7, 10, 1, 0, 'product', 1001, 1001, 'Classic Build', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 2, '2020-12-28 13:31:00', '2021-03-24 07:08:00', '2cb224d1-4943-11eb-9e97-42010a52200a'),
(23, 7, 10, 1, 0, 'product', 1002, NULL, 'A card page', '', 3, 5, 0.00, NULL, 0.00, NULL, 'usd', 15.00, 30.00, 3, '2020-12-28 13:32:39', '2021-03-18 00:21:20', '641dde54-4943-11eb-9e97-42010a52200a'),
(24, 8, 11, 1, 0, 'product', 1000, NULL, 'The MaxCard', '', 1, 5, 497.00, NULL, 450.00, NULL, 'usd', 75.00, 110.00, 1, '2020-12-28 13:30:15', '2021-03-16 18:41:17', 'b29665b3-4944-11eb-9e97-42010a52200a'),
(25, 8, 11, 1, 0, 'product', 1001, 1001, 'Classic Build', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 2, '2020-12-28 13:31:00', '2021-03-24 07:06:54', 'b9e71bec-4944-11eb-9e97-42010a52200a'),
(26, 8, 11, 1, 0, 'product', 1002, NULL, 'A card page', '', 3, 5, 0.00, NULL, 0.00, NULL, 'usd', 15.00, 30.00, 3, '2020-12-28 13:32:39', '2021-03-17 23:15:30', 'becf008f-4944-11eb-9e97-42010a52200a'),
(27, 9, 12, 1, 0, 'product', 1000, NULL, 'The MaxCard', '', 1, 5, 597.00, NULL, 547.00, NULL, 'usd', 75.00, 110.00, 1, '2020-12-28 13:30:15', '2021-03-24 22:28:24', 'db99a2a4-4946-11eb-9e97-42010a52200a'),
(28, 9, 12, 1, 0, 'product', 1001, 1001, 'Classic Build', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 2, '2020-12-28 13:31:00', '2021-03-24 07:00:41', 'df6c6634-4946-11eb-9e97-42010a52200a'),
(29, 9, 12, 1, 0, 'product', 1002, NULL, 'A card page', '', 4, 5, 0.00, NULL, 0.00, NULL, 'usd', 15.00, 30.00, 3, '2020-12-28 13:32:39', '2021-03-18 00:23:22', 'e5968c8e-4946-11eb-9e97-42010a52200a');

INSERT INTO `package_line` (`package_line_id`, `package_variation_id`, `package_id`, `company_id`, `division_id`, `product_entity`, `product_entity_id`, `journey_id`, `name`, `description`, `quantity`, `cycle_type`, `promo_price`, `promo_price_duration`, `regular_price`, `regular_price_duration`, `currency`, `product_price_override`, `product_promo_price_override`, `order`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(30, 9, 12, 1, 0, 'product', 1006, NULL, 'Member Directory', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 4, '2020-12-28 13:32:39', '2021-01-07 03:46:44', 'f11aefbc-4946-11eb-9e97-42010a52200a'),
(31, 11, 14, 1, 0, 'product', 1006, NULL, 'Member Directory', '', 1, 5, 200.00, NULL, 200.00, NULL, 'usd', 50.00, 100.00, 1, '2020-08-15 17:04:48', '2021-02-16 22:39:57', '00c5b835-4f82-11eb-b74e-4201ac163005'),
(32, 10, 13, 1, 0, 'product', 1002, NULL, 'Card Page', '', 1, 5, 80.00, NULL, 65.00, NULL, 'usd', 15.00, 30.00, 1, '2020-08-15 16:52:50', '2021-02-16 22:39:12', '05e60c24-4f82-11eb-b74e-4201ac163005'),
(33, 23, 15, 1, 0, 'product', 1000, NULL, 'The Promo MaxCard', '', 1, 5, 397.00, NULL, 350.00, NULL, 'usd', 75.00, 110.00, 1, '2021-01-22 13:11:07', '2021-03-23 23:08:23', '27db17b5-0cac-4838-980e-75a0d9b16c5a'),
(34, 8, 11, 1, 0, 'product', 1006, NULL, 'Member Directory', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 4, '2020-12-28 13:32:39', '2021-03-24 05:36:28', 'df76ea60-8c62-11eb-8dcd-0242ac130003'),
(44, 12, 15, 1, 0, 'product', 1002, NULL, 'A card page', '', 4, 5, 0.00, NULL, 0.00, NULL, 'usd', 30.00, 30.00, 3, '2020-12-28 13:32:39', '2021-04-02 21:58:59', 'fac42e97-2f6d-42a5-9698-45933a2a7a31'),
(45, 12, 15, 1, 0, 'product', 1006, NULL, 'Member Directory', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 4, '2020-12-28 13:32:39', '2021-03-24 05:36:23', 'dc6f902e-8c62-11eb-8dcd-0242ac130003'),
(46, 13, 27, 1, 0, 'product', 1000, NULL, 'The MaxSite', '', 1, 5, 750.00, NULL, 697.00, NULL, 'usd', 75.00, 110.00, 1, '2020-12-28 13:30:15', '2021-03-24 22:33:11', '6e2bea17-8c88-11eb-969d-42010a52200b'),
(47, 13, 27, 1, 0, 'product', 1001, 1001, 'Classic Build', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 2, '2020-12-28 13:31:00', '2021-03-24 07:00:41', '8310e9eb-8c88-11eb-969d-42010a52200b'),
(48, 13, 27, 1, 0, 'product', 1002, NULL, 'A card page', '', 4, 5, 0.00, NULL, 0.00, NULL, 'usd', 15.00, 30.00, 3, '2020-12-28 13:32:39', '2021-03-18 00:23:22', '899bb179-8c88-11eb-969d-42010a52200b');


INSERT INTO `package_line` (`package_line_id`, `package_variation_id`, `package_id`, `company_id`, `division_id`, `product_entity`, `product_entity_id`, `journey_id`, `name`, `description`, `quantity`, `cycle_type`, `promo_price`, `promo_price_duration`, `regular_price`, `regular_price_duration`, `currency`, `product_price_override`, `product_promo_price_override`, `order`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(51, 14, 28, 1, 0, 'product', 1004, NULL, 'The MaxPersona', '', 1, 5, 5.00, NULL, 5.00, NULL, 'usd', 1.00, 1.00, 1, '2020-12-28 13:30:15', '2021-03-24 22:33:11', '3762f1fe-d588-48b2-b2dd-fb99be1c159b'),
(52, 15, 29, 1, 0, 'product', 1004, NULL, 'The MaxPersona', '', 1, 5, 10.00, NULL, 10.00, NULL, 'usd', 2.00, 3.00, 1, '2020-12-28 13:30:15', '2021-03-24 22:33:11', 'ae5cb41f-8f0c-4da8-835b-09344a9d2766'),
(53, 14, 28, 1, 0, 'product', 1002, NULL, 'A card page', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 2, '2020-12-28 13:32:39', '2021-03-18 00:23:22', '899bb179-8c88-11eb-969d-42010a52200b'),
(54, 15, 29, 1, 0, 'product', 1002, NULL, 'A card page', '', 3, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 2, '2020-12-28 13:32:39', '2021-03-18 00:23:22', 'fb227b2e-7b8b-4a35-bc3a-28da6d7882ee'),
(55, 16, 30, 1, 0, 'product', 1005, NULL, 'The Max Group', '', 1, 5, 10.00, NULL, 10.00, NULL, 'usd', 1.00, 1.00, 1, '2020-12-28 13:30:15', '2021-03-24 22:33:11', '982b0a28-9c29-4f13-809d-53a1abbae9a2'),
(56, 17, 31, 1, 0, 'product', 1005, NULL, 'The Max Group', '', 1, 5, 25.00, NULL, 25.00, NULL, 'usd', 2.00, 3.00, 1, '2020-12-28 13:30:15', '2021-03-24 22:33:11', '3fb46709-2cef-4148-af4a-4b91e1ea11d3'),
(57, 16, 30, 1, 0, 'product', 1006, NULL, 'The Max Directory', '', 1, 5, 10.00, NULL, 10.00, NULL, 'usd', 1.00, 1.00, 1, '2020-12-28 13:30:15', '2021-03-24 22:33:11', 'a7baf395-efa9-481c-b175-7c9678a2044c'),
(58, 17, 31, 1, 0, 'product', 1006, NULL, 'The Max Directory', '', 1, 5, 25.00, NULL, 25.00, NULL, 'usd', 2.00, 3.00, 1, '2020-12-28 13:30:15', '2021-03-24 22:33:11', 'e5eae375-caee-4ea7-a1a4-e307011b8189'),
(59, 16, 30, 1, 0, 'product', 1006, NULL, 'Directory Widget', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 1, '2020-12-28 13:32:39', '2021-01-07 03:46:44', '3e226bc3-c73a-4455-8c89-ae63c9dc90c0'),
(60, 17, 31, 1, 0, 'product', 1006, NULL, 'Directory Widget', '', 1, 5, 0.00, NULL, 0.00, NULL, 'usd', 0.00, 0.00, 1, '2020-12-28 13:32:39', '2021-01-07 03:46:44', '4649c708-6b29-4b3e-ae0f-29154768a295'),
(61, 16, 30, 1, 0, 'product', 1002, NULL, 'A card page', '', 3, 5, 0.00, NULL, 0.00, NULL, 'usd', 15.00, 30.00, 2, '2020-12-28 13:32:39', '2021-03-18 00:21:20', '357e2fdf-3274-4651-9ba2-00d5eed98b89'),
(62, 17, 31, 1, 0, 'product', 1002, NULL, 'A card page', '', 3, 5, 0.00, NULL, 0.00, NULL, 'usd', 15.00, 30.00, 2, '2020-12-28 13:32:39', '2021-03-18 00:21:20', 'bfdadc89-2c97-46b6-ad53-e8b7528404bb');

INSERT INTO `package_line_setting` (`package_line_setting_id`, `package_line_id`, `label`, `value`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(1, 11, 'default_template', '30595', '2020-08-20 02:43:28', '2020-08-20 07:52:31', 'f7bb6b49-3ec7-43c1-bc77-156fdfacd936'),
(2, 11, 'page_insertion_index', '5', '2020-08-20 05:01:13', '2020-10-08 19:35:56', '783f08f9-67af-4820-9161-d92347ed6f99'),
(3, 16, 'default_template', '30626', '2020-08-20 02:43:28', '2020-10-08 22:09:25', '2928c934-7be1-42f5-8309-048ef1ec2f66'),
(4, 16, 'page_insertion_index', '5', '2020-08-20 05:01:13', '2020-10-08 19:35:57', '803ec62f-5548-40ee-b7be-7b871e388db3'),
(7, 1, 'page_insertion_index', '2', '2020-08-20 05:01:13', '2021-01-05 01:58:25', '40e9ade3-4f3b-11eb-9e97-42010a52200a'),
(8, 1, 'default_template', '30361', '2020-08-20 02:43:28', '2020-10-08 22:09:25', '40f57c8a-4f3b-11eb-9e97-42010a52200a'),
(9, 3, 'page_content', '<p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/fbd9c58c08341dbdbde672346fcbc5b29a026cc2.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p><p style="text-align: center;"><br></p><p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/5a2e0cafcc18fc848fb7374f74aa6a0f552874ea.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p>\r\n', '2020-08-20 02:43:28', '2021-01-05 05:05:20', '41017caa-4f3b-11eb-9e97-42010a52200a');

INSERT INTO `package_line_setting` (`package_line_setting_id`, `package_line_id`, `label`, `value`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(10, 6, 'page_content', '<p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/fbd9c58c08341dbdbde672346fcbc5b29a026cc2.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p><p style="text-align: center;"><br></p><p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/5a2e0cafcc18fc848fb7374f74aa6a0f552874ea.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p>', '2020-08-20 02:43:28', '2021-01-05 05:05:23', '410e4da2-4f3b-11eb-9e97-42010a52200a'),
(11, 21, 'page_insertion_index', '2', '2020-08-20 05:01:13', '2021-01-05 18:32:15', '9ac388c8-4f3b-11eb-9e97-42010a52200a'),
(12, 21, 'default_template_id', '4', '2020-08-20 02:43:28', '2021-01-27 04:03:36', '9acf0a6c-4f3b-11eb-9e97-42010a52200a'),
(13, 24, 'page_insertion_index', '2', '2020-08-20 05:01:13', '2021-01-05 18:32:39', '9ada5642-4f3b-11eb-9e97-42010a52200a'),
(14, 24, 'default_template_id', '4', '2020-08-20 02:43:28', '2021-01-27 04:03:33', '9ae57a26-4f3b-11eb-9e97-42010a52200a'),
(15, 27, 'page_insertion_index', '2', '2020-08-20 05:01:13', '2021-01-05 18:32:44', '9af06056-4f3b-11eb-9e97-42010a52200a'),
(16, 27, 'default_template_id', '4', '2020-08-20 02:43:28', '2021-03-24 22:35:01', '9afc6189-4f3b-11eb-9e97-42010a52200a'),
(17, 23, 'page_content', '<p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/fbd9c58c08341dbdbde672346fcbc5b29a026cc2.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p><p style="text-align: center;"><br></p><p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/5a2e0cafcc18fc848fb7374f74aa6a0f552874ea.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p>\r\n', '2020-08-20 02:43:28', '2021-01-05 05:05:20', '9b07327d-4f3b-11eb-9e97-42010a52200a'),
(18, 26, 'page_content', '<p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/fbd9c58c08341dbdbde672346fcbc5b29a026cc2.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p><p style="text-align: center;"><br></p><p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/5a2e0cafcc18fc848fb7374f74aa6a0f552874ea.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p>', '2020-08-20 02:43:28', '2021-01-05 05:05:23', '9b13d30c-4f3b-11eb-9e97-42010a52200a');

INSERT INTO `package_line_setting` (`package_line_setting_id`, `package_line_id`, `label`, `value`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(19, 29, 'page_content', '<p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/fbd9c58c08341dbdbde672346fcbc5b29a026cc2.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p><p style="text-align: center;"><br></p><p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/5a2e0cafcc18fc848fb7374f74aa6a0f552874ea.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p>', '2020-08-20 02:43:28', '2021-01-05 05:05:23', '9b1f5c29-4f3b-11eb-9e97-42010a52200a'),
(20, 32, 'page_content', '<p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/fbd9c58c08341dbdbde672346fcbc5b29a026cc2.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p><p style="text-align: center;"><br></p><p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/5a2e0cafcc18fc848fb7374f74aa6a0f552874ea.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p>', '2020-08-20 02:43:28', '2021-01-05 05:05:23', 'd4650a53-a89d-4428-b927-a34b499ad5cf'),
(22, 46, 'default_template_id', '4', '2020-08-20 02:43:28', '2021-03-18 00:57:36', '43f2f9ea-e668-4d74-8182-f88e6a659057'),
(23, 46, 'page_insertion_index', '2', '2020-08-20 05:01:13', '2021-01-05 18:32:44', '4abea38e-ebbc-4d46-b1f6-e8c4c57e239d'),
(24, 48, 'page_content', '<p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/fbd9c58c08341dbdbde672346fcbc5b29a026cc2.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p><p style="text-align: center;"><br></p><p style="text-align: center;"><img src="https://app.ezcardmedia.com/images/users/1001/5a2e0cafcc18fc848fb7374f74aa6a0f552874ea.jpg" style="width: 1000px;" class="fr-fic fr-dib" data-success="true" data-message=""></p>', '2020-08-20 02:43:28', '2021-01-05 05:05:23', 'ab89ea2a-d801-4261-9409-e33b4a1176ca'),
(26, 44, 'page_insertion_index', '2', '2020-08-20 05:01:13', '2021-03-24 22:51:11', '88728366-ce1a-44fc-955d-c35a53e26162'),
(27, 33, 'default_template_id', '4', '2020-08-20 02:43:28', '2021-03-24 22:50:39', '78094431-7263-4c8c-a400-55309b4290b7');

INSERT INTO `promo_code` (`promo_code_id`, `company_id`, `entity_type`, `entity_id`, `promo_code`, `title`, `description`, `promo_discount_value`, `discount_value`, `discount_type`, `min_entity_value`, `expiration_date`, `test_only`, `expired`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(11, 1, 'purchase', NULL, 'gregTest396', '296 Dollars Off', NULL, NULL, 396.00, '$', 396.00, NULL, 0, 0, '2020-11-05 17:02:55', '2021-02-26 21:24:48', 'ce344125-4f90-11eb-9e97-42010a52200a'),
(12, 1, 'package', 15, 'maxCardPromo2021', '397 Dollars Off', NULL, 397.00, 397.00, '$', 397.00, NULL, 0, 0, '2021-01-22 13:04:24', '2021-02-26 21:24:14', '89e4dcf1-5ce4-11eb-9e97-42010a52200a'),
(17, 1, 'purchase', 10, 'BronzeMax10', '39.7 Dollars Off', NULL, 39.70, 39.70, '$', 397.00, NULL, 0, 0, '2021-03-12 11:46:02', '2021-03-12 17:52:07', '4319e595-835a-11eb-969d-42010a52200b'),
(18, 1, 'package', 11, 'SilverMax15', '74.55 Dollars Off', NULL, 74.55, 74.55, '$', 497.00, NULL, 0, 0, '2021-03-12 11:54:14', '2021-03-12 17:56:35', 'f7a2a168-835b-11eb-969d-42010a52200b'),
(19, 1, 'package', 12, 'GoldMax20', '119.4 Dollars Off', NULL, 119.40, 119.40, '$', 597.00, NULL, 0, 0, '2021-03-12 11:56:59', '2021-03-12 11:56:59', '3f1048bf-835c-11eb-969d-42010a52200b'),
(21, 0, 'purchase', NULL, '200JET', '143.72 Dollars off', NULL, 143.72, 143.72, '$', NULL, NULL, 0, 0, '2021-04-22 12:29:50', '2021-04-22 17:29:59', 'df37cd46-a38e-11eb-969d-42010a52200b'),
(25, 1, 'purchase', 13, 'Max10Off352', '10 Dollars Off', NULL, 10.00, 10.00, '$', 30.00, NULL, 0, 0, '2021-05-20 10:59:57', '2021-05-20 11:00:04', '4fa44969-b984-11eb-948b-42010a52200f');

INSERT INTO `promo_code` (`promo_code_id`, `company_id`, `entity_type`, `entity_id`, `promo_code`, `title`, `description`, `promo_discount_value`, `discount_value`, `discount_type`, `min_entity_value`, `expiration_date`, `test_only`, `expired`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(26, 1, 'purchase', 14, 'Max20Off856', '20 Dollars Off', NULL, 20.00, 20.00, '$', 30.00, NULL, 0, 0, '2021-05-20 11:02:08', '2021-05-20 16:02:23', '7e77b51f-b984-11eb-948b-42010a52200f'),
(27, 1, 'purchase', 23, 'Max30Off524', '30 Dollars Off', NULL, 30.00, 30.00, '$', 30.00, NULL, 0, 0, '2021-05-20 11:04:45', '2021-05-20 16:04:45', 'dc83ceb6-b984-11eb-948b-42010a52200f'),
(28, 1, 'purchase', 24, 'Max40Off465', '40 Dollars Off', NULL, 40.00, 40.00, '$', 40.00, NULL, 0, 0, '2021-05-20 11:04:46', '2021-05-20 11:04:47', '17acabe0-b985-11eb-948b-42010a52200f'),
(29, 1, 'purchase', 25, 'Max50Off348', '50 Dollars Off', NULL, 50.00, 50.00, '$', 50.00, NULL, 0, 0, '2021-05-20 11:06:32', '2021-05-20 16:06:37', '29f031a4-b985-11eb-948b-42010a52200f'),
(30, 1, 'purchase', 26, 'Max60Off662', '60 Dollars Off', NULL, 60.00, 60.00, '$', 60.00, NULL, 0, 0, '2021-05-20 11:10:38', '2021-05-20 16:10:39', '7799622a-b985-11eb-948b-42010a52200f'),
(31, 1, 'purchase', 27, 'Max70Off128', '70 Dollars Off', NULL, 70.00, 70.00, '$', 70.00, NULL, 0, 0, '2021-05-20 11:10:44', '2021-05-20 16:10:44', '90e9b87b-b985-11eb-948b-42010a52200f'),
(32, 1, 'purchase', 28, 'Max80Off490', '80 Dollars Off', NULL, 80.00, 80.00, '$', 80.00, NULL, 0, 0, '2021-05-20 11:10:42', '2021-05-20 16:10:43', 'abad81db-b985-11eb-948b-42010a52200f');

INSERT INTO `promo_code` (`promo_code_id`, `company_id`, `entity_type`, `entity_id`, `promo_code`, `title`, `description`, `promo_discount_value`, `discount_value`, `discount_type`, `min_entity_value`, `expiration_date`, `test_only`, `expired`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(33, 1, 'purchase', 29, 'Max90Off682', '90 Dollars Off', NULL, 90.00, 90.00, '$', 90.00, NULL, 0, 0, '2021-05-20 11:10:45', '2021-05-20 16:10:45', 'c28d1651-b985-11eb-948b-42010a52200f'),
(34, 1, 'purchase', 30, 'Max100Off769', '100 Dollars Off', NULL, 100.00, 100.00, '$', 100.00, NULL, 0, 0, '2021-05-21 18:47:37', '2021-05-21 23:47:38', 'ea4c0089-b985-11eb-948b-42010a52200f'),
(35, 2, 'purchase', NULL, 'EzCardPromo', '350 Dollar Off', NULL, 750.00, 750.00, '$', 750.00, NULL, 0, 0, '2021-05-21 18:47:37', '2021-05-21 23:47:38', 'e7040cd5-ba8e-11eb-948b-42010a52200f'),
(36, 1, 'purchase', 30, 'Max750OffForGreg', '700 Dollars Off', NULL, 750.00, 750.00, '$', 750.00, NULL, 0, 0, '2021-05-21 18:47:37', '2021-06-23 14:40:44', 'd90309d7-d430-11eb-948b-42010a52200f');

INSERT INTO `product` (`product_id`, `product_class_id`, `product_type_id`, `product_enduser_id`, `title`, `abbreviation`, `display_name`, `description`, `source_uuid`, `min_package_value`, `promo_value`, `promo_cycle_duration`, `value`, `value_duration`, `cycle_type`, `status`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(1000, 1, 1, 1, 'The Digital Card', 'DIGITALCARD', 'Digital Site', NULL, NULL, 200.00, 110.00, 1, 110.00, 0, 5, 'Active', '2020-08-15 16:33:47', '2021-03-23 23:45:27', '254b5825-df3f-11ea-82fd-4201ac163002'),
(1001, 1, 2, 1, 'A standard design for the Digital Site', 'SITEDESIGN', 'Standard Site Design', NULL, NULL, NULL, 0.00, 0, 0.00, 0, 8, 'Active', '2020-08-15 21:41:14', '2021-03-23 23:45:38', '0ad445b4-df40-11ea-82fd-4201ac163002'),
(1002, 1, 3, 1, 'A Digital Card Page', 'SITEPAGE', 'Site Page', NULL, NULL, NULL, 30.00, 1, 30.00, 0, 5, 'Active', '2020-08-15 21:47:55', '2021-03-23 23:45:30', 'f9f6eb51-df40-11ea-82fd-4201ac163002'),
(1003, 1, 5, 1, 'A Contact Widget', 'CONTACTME', 'Contact', NULL, 'df3e3930-6e14-4072-b877-85a11b28938a', NULL, 10.00, 1, 10.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', '215c79e9-e1a2-11ea-82fd-4201ac163002'),
(1004, 1, 1, 1, 'A Digital Persona', 'PERSONA', 'Persona Site', NULL, NULL, NULL, 100.00, 1, 100.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', '000ce690-29ac-4cbe-bc96-6ed37bb5f4fe'),
(1005, 1, 1, 1, 'The Digital Group', 'GROUP', 'Group Site', NULL, NULL   , NULL, 100.00, 1, 100.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', '94e38b60-75a7-4dec-946c-5f3efd38b8db');

INSERT INTO `product` (`product_id`, `product_class_id`, `product_type_id`, `product_enduser_id`, `title`, `abbreviation`, `display_name`, `description`, `source_uuid`, `min_package_value`, `promo_value`, `promo_cycle_duration`, `value`, `value_duration`, `cycle_type`, `status`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(1006, 1, 5, 1, 'The Directory', 'DIRECTORY', 'Directory', NULL, '4753fc48-e147-2f73-d174-c659179dd294'   , NULL, 100.00, 1, 100.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', '60cd79d0-0cbd-47af-aff8-c4329641a189'),
(1007, 1, 5, 1, 'Save & Share', 'SAVESHARE', 'Save & Share', NULL, 'a025b0d0-cb2b-4126-8e62-dfc86532581c', NULL, 0.00, 1, 0.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', '588e0122-b13b-4a20-a5b8-5452f6ac5f56'),
(1008, 1, 5, 1, 'Talk To Me', 'TALKTOME', 'Talk To Me', NULL, NULL, NULL, 0.00, 1, 0.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', 'd1183347-a406-4698-8663-e6e4cead83ca'),
(1009, 1, 5, 1, 'A Marketplace', 'MARKETPLACE', 'Marketplace', NULL, '0dde9e9f-e08e-430c-ac56-9b6cecca0461', NULL, 0.00, 1, 0.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', 'd1183347-a406-4698-8663-e6e4cead83ca'),
(1010, 1, 5, 1, 'Gallery', 'GALLERY', 'Gallery', NULL, '8fa781a4-5db5-4445-b2b7-7467818932bd', NULL, 0.00, 1, 0.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', 'd1183347-a406-4698-8663-e6e4cead83ca'),
(1011, 1, 5, 1, 'Blog', 'BLOG', 'Blog', NULL, '170a712b-7723-46ef-9f44-f4cb71d3a205', NULL, 0.00, 1, 0.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', 'd1183347-a406-4698-8663-e6e4cead83ca'),
(1012, 1, 5, 1, 'Videos', 'VIDEOS', 'Videos', NULL, '979391f0-aebb-4994-96cc-86a2b4ffca89', NULL, 0.00, 1, 0.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', 'd1183347-a406-4698-8663-e6e4cead83ca'),
(1013, 1, 5, 1, 'Tickets', 'TICKETS', 'Tickets', NULL, '359f995b-be83-4b99-93e7-20881cc72df7', NULL, 0.00, 1, 0.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', 'd1183347-a406-4698-8663-e6e4cead83ca'),
(1014, 1, 5, 1, 'Calendar', 'CALENDAR', 'Calendar', NULL, 'bcfe2bb5-c19a-45b3-859f-8095309459ec', NULL, 0.00, 1, 0.00, 0, 5, 'Active', '2020-08-18 17:28:12', '2021-03-23 23:45:33', 'd1183347-a406-4698-8663-e6e4cead83ca'),
(1100, 1, 1, 2, 'The Demo Card', 'DEMOSITE', 'Promo Site', NULL, NULL, 200.00, 110.00, 1, 110.00, 0, 5, 'Active', '2021-01-22 18:39:32', '2021-04-22 03:37:40', '2b5a2009-5ce1-11eb-9e97-42010a52200a'),
(1101, 1, 1, 5, 'The Family Card', 'FAMILYSITE', 'Family Site', NULL, NULL, 200.00, 0.00, 0, 0.00, 0, 5, 'Active', '2021-04-21 22:33:37', '2021-04-24 03:29:37', '88b3a5f5-a31b-11eb-969d-42010a52200b'),
(1200, 1, 1, 1, 'Phone Number', 'PHONENUMBER', 'Site Phone Number', NULL, NULL, 0.00, 0.00, 0, 0.00, 0, 5, 'Active', '2021-04-21 22:33:37', '2021-04-24 03:29:37', '91777e0e-4735-4481-9466-a81f559852c4'),
(1500, 1, 1, 1, 'Custom User Product', 'USERPRODUCT', 'User Product', NULL, NULL, 0.00, 0.00, 0, 0.00, 0, 8, 'Active', '2021-04-21 22:33:37', '2021-04-24 03:29:37', '72102f5a-5cd6-11ec-aa3d-42010a522013');

INSERT INTO `product_class` (`product_class_id`, `name`, `promo_code_prefix`, `class_type`, `user_class_type_id`, `sys_row_id`) VALUES
(1, 'Default', '', 'default', 0, '89efda72-d36e-11e8-95ec-6ef620543eb9'),
(2, 'BrandPartner', 'BP,EZ', 'discount', 2, 'bb59f9bd-d36e-11e8-9461-52de8773d5f0'),
(3, 'Non-Profit', 'NP', 'discount', 2, '04fa4429-d36f-11e8-95ec-6ef620543eb9');

INSERT INTO `product_cycle` (`product_cycle_id`, `name`, `description`, `seconds`, `sys_row_id`) VALUES
(1, 'Monthly', 'A cycle that recurs monthly.', 2628000, 'cfbcf144-42fe-4cb4-bc8e-148f6b47a1d8'),
(2, 'Daily', 'A cycle that occurs daily.', 86400, 'fc79010f-fe26-11e7-a35f-42010af00003'),
(3, 'Weekly', 'A cycle that occurs weekly.', 657000, '0f9ba4bc-fe27-11e7-a35f-42010af00003'),
(4, 'Bi-Monthly', 'A cycle that occurs bi-monthly.', 1314000, '235be4ee-fe27-11e7-a35f-42010af00003'),
(5, 'Yearly', 'A cycle that occurs annually.', 31536000, '3528b7dc-fe27-11e7-a35f-42010af00003'),
(6, 'Bi-Annually', 'A cycle that occurs bi-annually.', 15768000, '42c5fcd2-fe27-11e7-a35f-42010af00003'),
(7, 'Quarterly', 'A cycle that occurs quarterly.', 7884000, '4fc7a892-fe27-11e7-a35f-42010af00003'),
(8, 'One-Time', 'A one-time event', 0, 'de735946-fe27-11e7-a35f-42010af00003');

INSERT INTO `product_enduser` (`product_enduser_id`, `enduser_label`, `description`, `sys_row_id`) VALUES
(1, 'user', 'A product to sell to an end user.', '5af7cf21-c325-4954-ad23-b307759b3046'),
(3, 'sales', 'A product to use with a sales team.', 'b419ae90-b63b-47f6-821a-a3402f3e469f'),
(2, 'marketing', 'A prolduct to use with a marketing department.', '7325d470-e27d-4009-8228-53286cea6094'),
(5, 'family', 'A product to user for your family memeber.', 'e2b67839-87ac-476b-82d9-36973b0e9bec'),
(4, 'executive', 'A product to use for an executive team.', 'd0814e1c-0561-46d0-b16c-866685a800ee');

INSERT INTO `product_type` (`product_type_id`, `product_primary`, `abbreviation`, `name`, `description`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(1, 1, 'CARD', 'Card', 'The main EZCard Subscription.', '2018-01-20 20:39:54', '2020-08-19 17:14:01', '1214203e-fe22-11e7-a35f-42010af00003'),
(2, 0, 'DESIGN', 'Card Design', 'Make your card extraordinary!', '2018-01-20 20:42:40', '2020-08-19 17:13:56', '754636de-fe22-11e7-a35f-42010af00003'),
(3, 0, 'CARDPAGE', 'Card Page', 'Expand your horizons.', '2020-08-15 21:39:54', '2020-08-19 17:13:05', 'db2b9d69-df3f-11ea-82fd-4201ac163002'),
(4, 0, 'PHONENUMBER', 'Phone Number', 'Share, call, and send SMS to your audiences!', '2020-08-15 21:38:15', '2020-08-19 17:12:57', 'a0ac726f-df3f-11ea-82fd-4201ac163002');

INSERT INTO `product_type` (`product_type_id`, `product_primary`, `abbreviation`, `name`, `description`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(5, 0, 'APP', 'App', 'Powerful functionality for EZ Digital and Beyond', '2020-08-18 17:30:09', '2020-08-19 17:12:39', '60a807df-e1a2-11ea-82fd-4201ac163002'),
(6, 0, 'MODULE', 'Module', 'The power of an EZ Digital module!', '2020-08-19 15:34:06', '2020-08-19 15:34:07', '559a7b21-e25b-11ea-82fd-4201ac163002'),
(7, 0, 'USER', 'User Product', 'A user-generated product.', '2020-08-19 15:34:06', '2020-08-19 15:34:07', 'd3dcbb1f-5c76-44e7-8713-d4c181e28da4'),
(8, 0, 'ACCOUNT', 'Account', 'A user account level product.', '2020-08-19 15:34:06', '2020-08-19 15:34:07', 'b6bd34fc-34ae-4b1c-982b-350060a9f7cf');

INSERT INTO `excell_main`.`user` (`user_id`, `division_id`, `company_id`, `sponsor_id`, `first_name`, `last_name`, `name_prefx`, `middle_name`, `name_sufx`, `username`, `password`, `password_reset_token`, `pin`, `user_email`, `user_phone`, `created_on`, `created_by`, `last_updated`, `updated_by`, `status`, `preferred_name`, `last_login`, `sys_row_id`) VALUES
(1000, 0, 0, null, 'Micah', 'Zak', '', '', '', 'mz490464', '$2y$10$N2U0OThlMjg1M2FiNWFjO.sJ2FH.YA8UlTsO72yOXASj/lUl09nJi', NULL, NULL, 1000, 1001, '2018-01-20 00:00:00', NULL, '2021-08-27 04:44:47', NULL, 'Active', '', '2021-08-27 04:44:47', '5865fe8b-111f-4c6f-a098-8118e5c83af2'),
(1001, 0, 1, null, 'Greg', 'Sanders', '', '', '', 'GregSanders', '$2y$10$YWFhNGNhMGRlNzhiMWE2N.yyX5Kk2xtbUJqD1P0hiRFu8kx5BLfd2', NULL, NULL, NULL, NULL, '2018-10-06 21:17:27', 1000, '2021-08-27 03:42:05', NULL, 'Active', '', '2021-08-27 03:42:05', '73a0d297-57e9-11ea-b088-42010a522005');

INSERT INTO `user_class` (`user_class_id`, `user_id`, `user_class_type_id`, `sys_row_id`) VALUES
(1, 1000, 0, '79b8e57d-c83e-11e8-95ec-6ef620543eb9'),
(2, 1001, 0, '79b8e57d-c83e-11e8-95ec-6ef620543eb9');

INSERT INTO `user_class_type` (`user_class_type_id`, `name`, `sys_row_id`) VALUES
(0, 'Supreme', '0aa06096-dbeb-11ea-82fd-4201ac163002'),
(1, 'MaxTech Admin', '1999db9d-c83e-11e8-9461-52de8773d5f0'),
(2, 'MaxTech Team Member', '2192621d-c83e-11e8-9461-52de8773d5f0'),
(3, 'MaxTech Read-Only', '294f0c35-c83e-11e8-9461-52de8773d5f0'),
(5, 'Custom Platform Admin', '84e8f1a5-ce60-11e8-95ec-6ef620543eb9'),
(6, 'Custom Platform Team Member', 'be4549c2-da0a-11e8-95ec-6ef620543eb9'),
(7, 'Custom Platform Read-Only', '402ae2aa-8d0d-11eb-969d-42010a52200b'),
(8, 'Third-Party Affiliate', '4ed1bca4-8d0d-11eb-969d-42010a52200b'),
(9, 'Third-Party Read-Only', '54a30045-8d0d-11eb-969d-42010a52200b'),
(15, 'Members', '18524741-8d8d-11eb-969d-42010a52200b');

INSERT INTO `user_setting` (`user_setting_id`, `user_id`, `label`, `value`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(1, 1000, 'admin_portal_theme_shade', 'light', '2020-11-10 14:08:59', '2020-11-21 22:15:50', '1ab40526-3914-4c14-bf61-61dcdd9f6e01'),
(2, 1001, 'admin_portal_theme_shade', 'light', '2020-11-10 14:08:59', '2020-11-21 22:15:50', 'bc00fca8-eff1-4726-a649-8f77a1ba54c9');

-- CRM Database Data Load:
USE `excell_crm`;

INSERT INTO `journey` (`journey_id`, `company_id`, `division_id`, `parent_id`, `follows_id`, `delay_days`, `journey_type_id`, `ticket_queue_id`, `label`, `name`, `description`, `expected_duration`, `hierarchical_progression`, `sys_row_id`) VALUES
(1000, 0, 0, NULL, NULL, NULL, 1, NULL, 'EZ Digital Card Build Workflow', 'Card Build Workflow', 'A workflow for processing card builds.', NULL, NULL, 'f8a427d1-9cb0-434b-bd45-d7f371fb6159'),
(1001, 1, 0, NULL, NULL, NULL, 1, NULL, 'MaxCard Card Build Workflow', 'Card Build Workflow', 'A workflow for processing card builds.', NULL, NULL, '5fbe857c-c85c-430d-930b-4c396d2bcd4e'),
(1003, 0, 0, 1000, NULL, NULL, 1, 1000, 'EZ Digital Card Builders Stage', 'Card Builders Stage', ' A stage for working on card builds.', 172800, 1, '103ffe34-57bf-4a02-bbb5-78e19396a31b'),
(1004, 0, 0, 1000, 1003, NULL, 1, 1004, 'EZ Digital Build Review Stage', 'Builder Review Stage', ' A stage for reviewing on card builds.', 86400, 1, 'f36a3d2c-8806-48fc-b854-d205b201fe9f'),
(1005, 1, 0, 1001, NULL, NULL, 1, 1001, 'MaxCard Builders Stage', 'Card Builders Stage', ' A stage for working on card builds.', 172800, 1, 'abe6bedc-09f3-4600-8043-2b69902fe141'),
(1006, 1, 0, 1001, 1005, NULL, 1, 1005, 'MaxCard Build Review Stage', 'Builder Review Stage', ' A stage for reviewing on card builds.', 86400, 1, 'ce5822a3-8dab-11eb-969d-42010a52200b');

INSERT INTO `opportunity` (`opportunity_id`, `user_id`, `owner_id`, `division_id`, `company_id`, `campaign_id`, `creator_id`, `created_on`, `modified_by`, `last_updated`, `name`, `description`, `actual_value`, `actual_closed_date`, `discount_amount`, `estimated_value`, `estimated_close_date`, `budget_amount`, `confirm_interest`, `close_probability`, `need`, `present_proposal`, `present_final_proposal`, `priority_code`, `stage`, `state_code`, `status`, `version_number`, `sys_row_id`) VALUES (1000, 1000, 1000, 0, 0, 1000, 1000, '2018-12-04 13:42:17', 1000, '2018-12-04 14:04:10', 'New Opportunity From Florida Campaign', 'Test description', 1200.00, NULL, 0.00, 1200.00, NULL, NULL, 0, NULL, NULL, 0, 0, NULL, 'Pending', 0, 'Active', 1, 'b5158974-f7fc-11e8-95ec-6ef620543eb9');

INSERT INTO `opportunity_line` (`opportunity_line_id`, `opportunity_id`, `company_id`, `division_id`, `user_id`, `owner_id`, `product_plan_id`, `name`, `description`, `price_per_unit`, `quantity`, `sys_row_id`) VALUES (1000, 1000, 0, 0, 1000, 1000, 24, 'EZcard Executive Monthly Bundle', 'Test description', 149.97, 1, 'a7dc7c0f-f887-11e8-95ec-6ef620543eb9');


INSERT INTO `ticket` (`ticket_id`, `company_id`, `division_id`, `parent_ticket_id`, `journey_id`, `follows_id`, `user_id`, `assignee_id`, `summary`, `description`, `status`, `entity_id`, `entity_name`, `ticket_queue_id`, `type`, `ticket_opened`, `expected_completion`, `ticket_closed`, `duration`, `delayed`, `delayed_duration`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1, 4, 0, NULL, NULL, NULL, NULL, 1000, 'Question About VM Flavors', 'Micah keeps asking weird questions.', 'pending', 30656, 'card', 1003, 'informational', '2021-02-12 15:15:18', '2021-07-15 15:15:18', NULL, NULL, NULL, NULL, '2021-03-24 15:15:18', '2021-03-24 15:15:19', '103ffe34-57bf-4a02-bbb5-78e19396a31b');
INSERT INTO `ticket` (`ticket_id`, `company_id`, `division_id`, `parent_ticket_id`, `journey_id`, `follows_id`, `user_id`, `assignee_id`, `summary`, `description`, `status`, `entity_id`, `entity_name`, `ticket_queue_id`, `type`, `ticket_opened`, `expected_completion`, `ticket_closed`, `duration`, `delayed`, `delayed_duration`, `created_on`, `last_updated`, `sys_row_id`) VALUES (2, 4, 0, NULL, 1001, NULL, NULL, NULL, 'Main: 10914 - Card Build Workflow', NULL, 'open', 30678, 'card', NULL, 'operational', '2021-03-24 16:02:00', '2021-03-28 06:02:00', NULL, NULL, NULL, NULL, '2021-03-24 16:02:00', '2021-03-24 16:02:00', '1c0d413e-f470-46b6-8eab-e3e5ff9b10a2');
INSERT INTO `ticket` (`ticket_id`, `company_id`, `division_id`, `parent_ticket_id`, `journey_id`, `follows_id`, `user_id`, `assignee_id`, `summary`, `description`, `status`, `entity_id`, `entity_name`, `ticket_queue_id`, `type`, `ticket_opened`, `expected_completion`, `ticket_closed`, `duration`, `delayed`, `delayed_duration`, `created_on`, `last_updated`, `sys_row_id`) VALUES (3, 4, 0, 2, 1005, NULL, NULL, 91101, 'Child: 10914 - Card Builders Stage', NULL, 'open', 30678, 'card', 1001, 'operational', '2021-03-24 16:02:00', '2021-03-25 06:02:00', NULL, NULL, NULL, NULL, '2021-03-24 16:02:00', '2021-03-24 16:02:00', '78092c27-8dad-11eb-969d-42010a52200b');
INSERT INTO `ticket` (`ticket_id`, `company_id`, `division_id`, `parent_ticket_id`, `journey_id`, `follows_id`, `user_id`, `assignee_id`, `summary`, `description`, `status`, `entity_id`, `entity_name`, `ticket_queue_id`, `type`, `ticket_opened`, `expected_completion`, `ticket_closed`, `duration`, `delayed`, `delayed_duration`, `created_on`, `last_updated`, `sys_row_id`) VALUES (4, 4, 0, 2, 1006, NULL, NULL, 1001, 'Child: 10914 - Builder Review Stage', NULL, 'queued', 30678, 'card', 1005, 'operational', '2021-03-24 16:02:00', '2021-03-28 06:02:00', NULL, NULL, NULL, NULL, '2021-03-24 16:02:00', '2021-03-24 16:02:00', 'e3c38351-8dae-11eb-969d-42010a52200b');


INSERT INTO `ticket_queue` (`ticket_queue_id`, `company_id`, `division_id`, `company_department_id`, `queue_type_id`, `label`, `name`, `description`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1000, 0, 0, 1001, 1, 'EZ Digital Card Build Queue', 'Card Build Queue', 'A queue for processing card builds.', '2021-04-23 15:41:08', '2021-04-24 01:58:15', 'a267199e-8668-4ee7-ae1e-ed18b725c70d');
INSERT INTO `ticket_queue` (`ticket_queue_id`, `company_id`, `division_id`, `company_department_id`, `queue_type_id`, `label`, `name`, `description`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1001, 4, 0, 1006, 1, 'MaxCard Card Build Queue', 'Card Build Queue', 'A queue for processing card builds.', '2021-04-23 15:41:08', '2021-04-24 01:58:14', '8b9a64b7-0695-4b05-bea3-0fb633e280bb');
INSERT INTO `ticket_queue` (`ticket_queue_id`, `company_id`, `division_id`, `company_department_id`, `queue_type_id`, `label`, `name`, `description`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1003, 0, 0, 1003, NULL, 'EZ Digital Software Bug Queue', 'Bug Queue', 'A queue for processing bug tickets.', '2021-04-23 15:41:10', '2021-04-23 20:41:10', '87b8fe09-b990-4651-aea7-f44992f99368');
INSERT INTO `ticket_queue` (`ticket_queue_id`, `company_id`, `division_id`, `company_department_id`, `queue_type_id`, `label`, `name`, `description`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1004, 0, 0, 1000, 2, 'EZ Digital Card Build Review Queue', 'Card Build Review Queue', 'A queue for reviewing card builds.', '2021-04-23 15:41:10', '2021-04-24 01:58:51', 'd003c9b9-dfd4-4aa2-a8b7-27d1929b07dc');
INSERT INTO `ticket_queue` (`ticket_queue_id`, `company_id`, `division_id`, `company_department_id`, `queue_type_id`, `label`, `name`, `description`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1005, 4, 0, 1005, 2, 'MaxCard Card Build Review Queue', 'Card Build Review Queue', 'A queue for processing card builds.', '2021-04-23 15:41:11', '2021-04-24 01:58:53', '30b2fcdd-106f-4b3c-90d7-741662fad796');

INSERT INTO `ticket_queue_type` (`ticket_queue_type_id`, `label`, `description`, `action`) VALUES (1, 'Card Design', 'Build Cards!', 'card_design');
INSERT INTO `ticket_queue_type` (`ticket_queue_type_id`, `label`, `description`, `action`) VALUES (2, 'Card Design QA', 'Make sure they are awesome.', 'card_design_qa');


-- Financial Database Data Load:
USE `excell_financial`;

INSERT INTO excell_financial.user_payment_property_type (user_payment_property_type_id, name,sys_row_id) VALUES
(1, 'stripe_customer_key','f0dc62bb-afa0-46c4-9b9d-1e270adee6d5'),
(2, 'stripe_connected_account_key','cda0efe5-b9a4-4838-8c41-100c43274370');

INSERT INTO excell_financial.payment_type (payment_type_id,name,sys_row_id) VALUES
(1,'Stripe','9e54ccec-92fc-412d-bedb-7b490c5a7bf9'),
(2,'Paypal','6530c3a7-5c59-4594-ac52-c630278c5db1');


-- Modules Database Data Load:
USE `excell_modules`;

INSERT INTO `authorizations` (`authorization_id`, `authorization_uuid`, `company_id`, `type`, `record_uuid`, `parent_uuid`, `name`, `description`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1, 'b9dac32b-6972-4ac4-9be5-60f0068bf115', 0, 'module', '8aefa4fb-64e6-ced5-6b25-6a2438260a77', NULL, 'Excell', NULL, '2020-06-07 12:31:47', '2020-06-07 12:31:48', '5f504ec6-ad3a-4427-a957-2e8ed25fe40f');
INSERT INTO `authorizations` (`authorization_id`, `authorization_uuid`, `company_id`, `type`, `record_uuid`, `parent_uuid`, `name`, `description`, `created_on`, `last_updated`, `sys_row_id`) VALUES (2, '535d4725-cdff-42aa-9838-3963fe27a0bf', 0, 'app', '4753fc48-e147-2f73-d174-c659179dd294', '8aefa4fb-64e6-ced5-6b25-6a2438260a77', 'Directory', NULL, '2020-06-08 19:28:30', '2020-06-08 19:28:30', '8af26682-67b6-fde2-265b-c1013fb2566b');

INSERT INTO `modules` (`module_id`, `company_id`, `name`, `module_uuid`, `author`, `version`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1, 0, 'Excell', '8aefa4fb-64e6-ced5-6b25-6a2438260a77', 'Micah Zak', '1.0.0', 'membership', 'directories,membership,contacts', '2020-06-05 14:58:11', '2021-03-23 06:36:19', '51547cb7-58a4-4cf5-a455-68fe925aee0f');
INSERT INTO `modules` (`module_id`, `company_id`, `name`, `module_uuid`, `author`, `version`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (2, 0, 'Excell', '8aefa4fb-64e6-ced5-6b25-6a2438260a77', 'Micah Zak', '1.0.1', 'membership', 'directories,membership,contacts', '2020-06-05 14:58:11', '2021-03-23 06:36:17', '0632500a-6950-4475-9826-51951cb81877');

INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1000, 2, 0, '4753fc48-e147-2f73-d174-c659179dd294', 'Directory', 'Micah Zak', 'localhost:8080/api/v1/directories', '1.0.0', NULL, 'vue', 'business', 'directories,membership,contacts', '2020-06-08 20:03:16', '2021-10-11 17:25:35', 'ff252bad-0089-1662-0807-a122c395a9e7');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1001, 2, 0, '4753fc48-e147-2f73-d174-c659179dd294', 'Directory', 'Micah Zak', 'localhost:8080/api/v1/directories', '1.0.1', NULL, 'vue', 'business', 'directories,membership,contacts', '2020-06-16 14:08:03', '2021-10-11 17:25:35', '221ab166-63c2-431b-ae19-46a17b8fd93f');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1002, 2, 0, 'a025b0d0-cb2b-4126-8e62-dfc86532581c', 'Share Save', 'Micah Zak', 'localhost:8080/api/v1/share-save', '1.0.0', NULL, 'vue', 'business', 'sharing', '2021-03-22 22:21:40', '2021-10-11 17:25:35', '56ad70c5-d6a1-4b68-b40f-50adfd34f61c');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1003, 2, 0, 'df3e3930-6e14-4072-b877-85a11b28938a', 'Contact Me', 'Micah Zak', 'localhost:8080/api/v1/contact-me', '1.0.0', NULL, 'vue', 'business', 'information', '2021-03-22 22:21:40', '2021-10-11 17:25:35', '174e8119-48d9-4f06-8d25-be48c1943d32');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1004, 2, 0, '0dde9e9f-e08e-430c-ac56-9b6cecca0461', 'Marketplace', 'Micah Zak', 'localhost:8080/api/v1/marketplace', '1.0.0', NULL, 'vue', 'business', 'purchase', '2021-03-22 22:21:40', '2021-10-11 17:25:35', '2ced97d7-9b7b-4d02-8073-63bf9ea68972');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1005, 2, 0, 'b1c8eabf-2738-4805-821f-0398b59c5b62', 'Get A Card', 'Micah Zak', 'localhost:8080/api/v1/marketplace', '1.0.0', NULL, 'vue', 'business', 'purchase', '2021-03-22 22:21:40', '2021-10-11 17:25:35', '16e889d8-5723-44b9-ad23-32a4b3dc27f8');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1006, 2, 0, 'f7424d4d-f0b1-424d-aec0-138246408f00', 'Talk To Me', 'Micah Zak', 'localhost:8080/api/v1/talk-to-me', '1.0.0', 'https://app.ezcardmedia.com/images/users/5865fe8b-111f-4c6f-a098-8118e5c83af2/e442e1c110aa8ee434247e330d2b264172e56229.png', 'vue', 'business', 'communication,real-time,chatting', '2021-03-22 22:21:40', '2021-10-11 17:25:35', '923f95ee-43cc-4c4c-883d-5e7c03986d5b');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1007, 2, 0, '8fa781a4-5db5-4445-b2b7-7467818932bd', 'Gallery', 'Micah Zak', 'localhost:8080/api/v1/talk-to-me', '1.0.0', NULL, 'vue', 'business', 'communication,real-time,chatting', '2021-03-22 22:21:40', '2021-10-11 17:25:35', '359f995b-be83-4b99-93e7-20881cc72df7');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1008, 2, 0, '170a712b-7723-46ef-9f44-f4cb71d3a205', 'Blog', 'Micah Zak', 'localhost:8080/api/v1/talk-to-me', '1.0.0', NULL, 'vue', 'business', 'communication,real-time,chatting', '2021-03-22 22:21:40', '2021-10-11 17:25:35', '49eb8c5e-ec7f-4cab-97dd-b0dad048af59');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1009, 2, 0, '979391f0-aebb-4994-96cc-86a2b4ffca89', 'Videos', 'Micah Zak', 'localhost:8080/api/v1/talk-to-me', '1.0.0', NULL, 'vue', 'business', 'communication,real-time,chatting', '2021-03-22 22:21:40', '2021-10-11 17:25:35', 'fb3d8ab9-5f22-48af-8509-68dd7445b8e2');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1010, 2, 0, '359f995b-be83-4b99-93e7-20881cc72df7', 'Tickets', 'Micah Zak', 'localhost:8080/api/v1/talk-to-me', '1.0.0', NULL, 'vue', 'business', 'communication,real-time,chatting', '2021-03-22 22:21:40', '2021-10-11 17:25:35', 'a264f9f3-db52-48de-82ab-cae79721d60e');
INSERT INTO `module_apps` (`module_app_id`, `module_id`, `company_id`, `app_uuid`, `name`, `author`, `domain`, `version`, `logo`, `ui_type`, `category`, `tags`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1011, 2, 0, 'bcfe2bb5-c19a-45b3-859f-8095309459ec', 'Calendar', 'Micah Zak', 'localhost:8080/api/v1/talk-to-me', '1.0.0', NULL, 'vue', 'business', 'communication,real-time,chatting', '2021-03-22 22:21:40', '2021-10-11 17:25:35', 'eb2d9116-c094-4139-b006-5a6d0ff6351a');

INSERT INTO `module_app_events` (`module_app_event_id`, `module_app_id`, `label`, `name`, `description`) VALUES (1000, 1002, NULL, NULL, NULL);

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1000, 1001, 1, 1002, 'Card Page Directory Management', 'config-page', '1.0.0', 'user_id,first_name,last_name,card_id,page_id', NULL, '2020-06-08 16:22:11', '2020-11-28 06:57:13', '74866004-9a2f-42f6-addc-1e97fc462266');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1001, 1001, 1, 1000, 'Directory Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', '82c9da3e-8e08-4038-89e9-69bbcad04f95');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1002, 1001, 1, 1001, 'Directory Management', 'config-card', '1.0.0', NULL, NULL, '2020-11-28 00:27:08', '2020-11-28 06:57:16', 'd14e58c7-92ba-4ee4-ad9a-1dc51517a231');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1003, 1001, 1, 1003, 'Site Directory', 'public-full-card', '1.0.0', NULL, NULL, '2020-11-28 00:27:50', '2020-11-28 07:35:01', '39ea0b9f-f105-419b-8084-8218d966fd10');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1004, 1001, 1, 1004, 'Full Site Page Directory', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', 'c39e9b0c-c89e-4c38-ba2e-d2b987465acb');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1005, 1001, 1, 1004, 'Site View Directory Members', 'public-view-members', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', 'ff252bad-0089-1662-0807-a122c395a9e7');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1006, 1001, 1, 1004, 'Site View Directory Events', 'public-view-events', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', '5f504ec6-ad3a-4427-a957-2e8ed25fe40f');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1007, 1001, 1, 1004, 'Directory Signup', 'public-signup', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', '8af26682-67b6-fde2-265b-c1013fb2566b');

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1008, 1002, 1, 1000, 'ShareSave Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', '99b16b6a-9522-4c58-89a9-e176d7386943');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1009, 1002, 1, 1002, 'ShareSave Page Config Widget Management', 'config-page', '1.0.0', NULL, NULL, '2020-06-08 16:22:11', '2021-03-23 04:21:16', 'f82eb13a-eb97-4f5e-8063-599a8e43a364');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1010, 1002, 1, 1004, 'ShareSave Full Card Page Widget', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', 'ba84e529-0921-4a59-8837-3e04cbf69151');

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1011, 1003, 1, 1000, 'Contact Me Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', '179585ac-4891-43d6-8772-138671d3e879');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1012, 1003, 1, 1002, 'Contact Me Page Config Widget Management', 'config-page', '1.0.0', 'user_id,first_name,last_name,card_id,page_id', NULL, '2020-06-08 16:22:11', '2021-03-23 04:21:16', 'cdbaaaf5-0776-4d0d-a1a8-4b1c94b7df04');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1013, 1003, 1, 1004, 'Full Card Page Widget', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', '30a7dd6a-7d37-4262-8200-29bacc5c285c');

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1014, 1004, 1, 1000, 'Marketplace Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', '86259d27-a397-49f5-8a88-3502f458c775');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1015, 1004, 1, 1002, 'Marketplace Page Config Widget Management', 'config-page', '1.0.0', 'user_id,first_name,last_name,card_id,page_id', NULL, '2020-06-08 16:22:11', '2021-03-23 04:21:16', '6c9f188f-371d-460d-82bc-5b1730966954');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1016, 1004, 1, 1004, 'Full Card Page Widget', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', '7ed913a0-1688-4268-8f0b-d993ca222a3f');

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1017, 1005, 1, 1000, 'Get A Card Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', '324aa1e2-7cf8-4beb-9521-6abb0348fea7');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1018, 1005, 1, 1002, 'Get A Card Page Config Widget Management', 'config-page', '1.0.0', 'user_id,first_name,last_name,card_id,page_id', NULL, '2020-06-08 16:22:11', '2021-03-23 04:21:16', '544c8c00-c0d2-4b93-9b28-e8859e8c5acf');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1019, 1005, 1, 1004, 'Full Card Page Widget', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', '191a7513-9ab5-4729-9139-368d1bcea2dc');

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1020, 1006, 1, 1000, 'TalkToMe Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', '12572897-0036-43cc-8823-77ff38b55ff1');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1021, 1006, 1, 1002, 'TalkToMe Page Config Widget Management', 'config-page', '1.0.0', 'user_id,first_name,last_name,card_id,page_id', NULL, '2020-06-08 16:22:11', '2021-03-23 04:21:16', '9e789a8a-7e38-4132-833c-dd870c833b01');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1022, 1006, 1, 1004, 'Full Card Page Widget', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', 'df90ef99-5b3a-4617-a635-6ff31aae35ec');

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1023, 1007, 1, 1000, 'Gallery Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', '6824be6a-f018-4de9-97a2-a65c5ae5b9f7');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1024, 1007, 1, 1002, 'Gallery Page Config Widget Management', 'config-page', '1.0.0', 'user_id,first_name,last_name,card_id,page_id', NULL, '2020-06-08 16:22:11', '2021-03-23 04:21:16', '5f0878a6-83df-4b3a-88b4-f945dfee5d5a');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1025, 1007, 1, 1004, 'Full Card Page Widget', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', '2bab00a0-28c4-4615-a6b7-8920d780c20b');

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1026, 1008, 1, 1000, 'Blog Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', '3cb919cf-23c5-461d-a60f-d6f113e11e08');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1027, 1008, 1, 1002, 'Blog Page Config Widget Management', 'config-page', '1.0.0', 'user_id,first_name,last_name,card_id,page_id', NULL, '2020-06-08 16:22:11', '2021-03-23 04:21:16', '57f9bc60-5530-44d3-9be0-97fa2ca8bddd');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1028, 1008, 1, 1004, 'Full Card Page Widget', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', 'ff64bc69-83b6-498c-9214-6b006f052a03');

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1029, 1009, 1, 1000, 'Videos Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', 'f1c1ca13-15de-4b00-8db4-f904a7d76173');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1030, 1009, 1, 1002, 'Videos Page Config Widget Management', 'config-page', '1.0.0', 'user_id,first_name,last_name,card_id,page_id', NULL, '2020-06-08 16:22:11', '2021-03-23 04:21:16', 'aeb12a05-75ce-4973-a9c3-9588806100cd');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1031, 1009, 1, 1004, 'Full Card Page Widget', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', '34ed9456-18c9-4683-9cb7-9dcebfe50264');

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1032, 1010, 1, 1000, 'Tickets Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', '541a8a3e-a5e1-4e0b-98aa-c3d6b0a75b80');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1033, 1010, 1, 1002, 'Tickets Page Config Widget Management', 'config-page', '1.0.0', 'user_id,first_name,last_name,card_id,page_id', NULL, '2020-06-08 16:22:11', '2021-03-23 04:21:16', '0c1477b5-4a9f-4922-bad4-73fd82b6caf4');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1034, 1010, 1, 1004, 'Full Card Page Widget', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', 'e90d8d0a-7d21-4a22-b350-3e3812bb2123');

INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1035, 1011, 1, 1000, 'Calendar Dashboard Management', 'config-main', '1.0.0', NULL, NULL, '2020-11-28 00:25:56', '2020-11-28 06:57:15', 'e6da23af-c06b-4bf0-8bea-986b605ecdf2');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1036, 1011, 1, 1002, 'Calendar Page Config Widget Management', 'config-page', '1.0.0', 'user_id,first_name,last_name,card_id,page_id', NULL, '2020-06-08 16:22:11', '2021-03-23 04:21:16', '2d25b8cb-4880-453c-9c8a-62c2901d501c');
INSERT INTO `module_app_widgets` (`module_app_widget_id`, `module_app_id`, `widget_api_version`, `widget_class`, `name`, `endpoint`, `version`, `variables`, `data`, `created_on`, `last_updated`, `sys_row_id`) VALUES (1037, 1011, 1, 1004, 'Full Card Page Widget', 'public-full-page', '1.0.0', NULL, NULL, '2020-11-28 00:28:19', '2020-11-28 07:35:04', '25365495-5927-4dec-8e9c-9a8ab2b773c7');

INSERT INTO `module_app_widget_class` (`module_app_widget_class_id`, `tag`, `label`, `description`, `sys_row_id`) VALUES (1000, 'private-main', 'Private Main', 'The main application the user sees from My Modules.', 'a6406f12-f33b-436b-be13-8622b4da3fbc');
INSERT INTO `module_app_widget_class` (`module_app_widget_class_id`, `tag`, `label`, `description`, `sys_row_id`) VALUES (1001, 'private-card', 'Private Site', 'An application accessible from a card instance.', '9aaa45f8-ca42-44b6-89cc-a97bcd1072bf');
INSERT INTO `module_app_widget_class` (`module_app_widget_class_id`, `tag`, `label`, `description`, `sys_row_id`) VALUES (1002, 'private-page', 'Private Page', 'An application accessible from a card page instance.', '4a388916-9682-4ebf-b0b6-8218d7774a07');
INSERT INTO `module_app_widget_class` (`module_app_widget_class_id`, `tag`, `label`, `description`, `sys_row_id`) VALUES (1003, 'public-card', 'Public Site', 'An app widget attached to a cards module area.', 'd8266244-a593-49e4-89a6-f12ec2529c62');
INSERT INTO `module_app_widget_class` (`module_app_widget_class_id`, `tag`, `label`, `description`, `sys_row_id`) VALUES (1004, 'public-page', 'Public Page', 'An app widget attached to a cards page or page grid.', '7948a0f1-d6b5-4c80-845a-b804a071b726');
INSERT INTO `module_app_widget_class` (`module_app_widget_class_id`, `tag`, `label`, `description`, `sys_row_id`) VALUES (1005, 'protected-card', 'Protected Site', 'An app widget attached to a card portals module area.', '6ab58d20-8e9b-461d-a20e-b62471e791e6');
INSERT INTO `module_app_widget_class` (`module_app_widget_class_id`, `tag`, `label`, `description`, `sys_row_id`) VALUES (1006, 'protected-page', 'Protected Page', 'An app widget attached to a card portals page or page grid area.', '806dd69f-77cc-465e-815b-183909768073');
INSERT INTO `module_app_widget_class` (`module_app_widget_class_id`, `tag`, `label`, `description`, `sys_row_id`) VALUES (1007, 'dashboard-element', 'Dashboard Element', 'An general app widget available to be displayed via a dashboard.', '302f7870-6795-4667-93b8-6ac7490cda00');
INSERT INTO `module_app_widget_class` (`module_app_widget_class_id`, `tag`, `label`, `description`, `sys_row_id`) VALUES (1008, 'dashboard-report', 'Dashboard Report', 'An app widget for reporting available to be displayed via a dashboard.', '83022132-fc0c-4fa6-b40c-141afd954537');

-- Apps Database Data Load:
USE `excell_apps`;

INSERT INTO `directory_template` (`directory_template_id`, `template_name`, `created_on`, `last_updated`, `sys_row_id`) VALUES
(1, 'Default', '2020-07-13 11:56:00', '2020-07-13 16:56:19', '88c6ee0f-2dc0-4e0f-adc6-69f8f011facb');

INSERT INTO `directory_type` (`directory_type_id`, `title`, `label`, `last_updated`, `sys_row_id`) VALUES
(1, 'Default', '2020-07-13 11:56:00', '2020-07-13 16:56:19', '88c6ee0f-2dc0-4e0f-adc6-69f8f011facb');

SET FOREIGN_KEY_CHECKS=1;