TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `tgr_product` BEFORE INSERT ON `product` FOR EACH ROW SET NEW.sys_row_id = UUID()'
sql_modes=1436549152
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_general_ci'
db_cl_names='utf8mb4_unicode_ci'
created=166276925215
