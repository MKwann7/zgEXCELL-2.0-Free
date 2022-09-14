TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `tgr_user_class_type_sysrowid` BEFORE INSERT ON `user_class_type` FOR EACH ROW SET NEW.sys_row_id = UUID()'
sql_modes=524288
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_general_ci'
db_cl_names='utf8mb4_unicode_ci'
created=166276925218
