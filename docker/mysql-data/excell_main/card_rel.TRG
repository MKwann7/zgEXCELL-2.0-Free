TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `tgr_card_rel` BEFORE INSERT ON `card_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()' 'CREATE DEFINER=`root`@`localhost` TRIGGER `tgr_card_rel_sysrowid` BEFORE INSERT ON `card_rel` FOR EACH ROW SET NEW.sys_row_id = UUID()'
sql_modes=1436549152 524288
definers='root@localhost' 'root@localhost'
client_cs_names='utf8mb4' 'utf8mb4'
connection_cl_names='utf8mb4_general_ci' 'utf8mb4_general_ci'
db_cl_names='utf8mb4_unicode_ci' 'utf8mb4_unicode_ci'
created=166276925194 166276925195
