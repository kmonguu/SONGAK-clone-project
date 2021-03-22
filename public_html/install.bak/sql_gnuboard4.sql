## 마이에스큐엘 dump 10.11
##
## Host: db.sir.co.kr    Database: gnu4
## ######################################################
## Server version	5.0.92-log












##
## Table structure for table `$g4[auth_table]`
##

DROP TABLE IF EXISTS `$g4[auth_table]`;


CREATE TABLE `$g4[auth_table]` (
  `mb_id` varchar(255) NOT NULL default '',
  `au_menu` varchar(20) NOT NULL default '',
  `au_auth` set('r','w','d') NOT NULL default '',
  PRIMARY KEY  (`mb_id`,`au_menu`)
);


##
## Table structure for table `$g4[board_table]`
##

DROP TABLE IF EXISTS `$g4[board_table]`;


CREATE TABLE `$g4[board_table]` (
  `bo_table` varchar(20) NOT NULL default '',
  `gr_id` varchar(255) NOT NULL default '',
  `bo_subject` varchar(255) NOT NULL default '',
  `bo_admin` varchar(255) NOT NULL default '',
  `bo_list_level` tinyint(4) NOT NULL default '0',
  `bo_read_level` tinyint(4) NOT NULL default '0',
  `bo_write_level` tinyint(4) NOT NULL default '0',
  `bo_reply_level` tinyint(4) NOT NULL default '0',
  `bo_comment_level` tinyint(4) NOT NULL default '0',
  `bo_upload_level` tinyint(4) NOT NULL default '0',
  `bo_download_level` tinyint(4) NOT NULL default '0',
  `bo_html_level` tinyint(4) NOT NULL default '0',
  `bo_link_level` tinyint(4) NOT NULL default '0',
  `bo_trackback_level` tinyint(4) NOT NULL default '0',
  `bo_count_delete` tinyint(4) NOT NULL default '0',
  `bo_count_modify` tinyint(4) NOT NULL default '0',
  `bo_read_point` int(11) NOT NULL default '0',
  `bo_write_point` int(11) NOT NULL default '0',
  `bo_comment_point` int(11) NOT NULL default '0',
  `bo_download_point` int(11) NOT NULL default '0',
  `bo_use_category` tinyint(4) NOT NULL default '0',
  `bo_category_list` text NOT NULL,
  `bo_disable_tags` text NOT NULL,
  `bo_use_sideview` tinyint(4) NOT NULL default '0',
  `bo_use_file_content` tinyint(4) NOT NULL default '0',
  `bo_use_secret` tinyint(4) NOT NULL default '0',
  `bo_use_dhtml_editor` tinyint(4) NOT NULL default '0',
  `bo_use_rss_view` tinyint(4) NOT NULL default '0',
  `bo_use_comment` tinyint(4) NOT NULL default '0',
  `bo_use_good` tinyint(4) NOT NULL default '0',
  `bo_use_nogood` tinyint(4) NOT NULL default '0',
  `bo_use_name` tinyint(4) NOT NULL default '0',
  `bo_use_signature` tinyint(4) NOT NULL default '0',
  `bo_use_ip_view` tinyint(4) NOT NULL default '0',
  `bo_use_trackback` tinyint(4) NOT NULL default '0',
  `bo_use_list_view` tinyint(4) NOT NULL default '0',
  `bo_use_list_content` tinyint(4) NOT NULL default '0',
  `bo_use_pushmsg` tinyint(4) NOT NULL default '0',
  `bo_table_width` int(11) NOT NULL default '0',
  `bo_subject_len` int(11) NOT NULL default '0',
  `bo_page_rows` int(11) NOT NULL default '0',
  `bo_new` int(11) NOT NULL default '0',
  `bo_hot` int(11) NOT NULL default '0',
  `bo_image_width` int(11) NOT NULL default '0',
  `bo_skin` varchar(255) NOT NULL default '',
  `bo_image_head` varchar(255) NOT NULL default '',
  `bo_image_tail` varchar(255) NOT NULL default '',
  `bo_include_head` varchar(255) NOT NULL default '',
  `bo_include_tail` varchar(255) NOT NULL default '',
  `bo_content_head` text NOT NULL,
  `bo_content_tail` text NOT NULL,
  `bo_insert_content` text NOT NULL,
  `bo_gallery_cols` int(11) NOT NULL default '0',
  `bo_upload_size` int(11) NOT NULL default '0',
  `bo_reply_order` tinyint(4) NOT NULL default '0',
  `bo_use_search` tinyint(4) NOT NULL default '0',
  `bo_order_search` int(11) NOT NULL default '0',
  `bo_count_write` int(11) NOT NULL default '0',
  `bo_count_comment` int(11) NOT NULL default '0',
  `bo_write_min` int(11) NOT NULL default '0',
  `bo_write_max` int(11) NOT NULL default '0',
  `bo_comment_min` int(11) NOT NULL default '0',
  `bo_comment_max` int(11) NOT NULL default '0',
  `bo_notice` text NOT NULL,
  `bo_upload_count` tinyint(4) NOT NULL default '0',
  `bo_use_email` tinyint(4) NOT NULL default '0',
  `bo_sort_field` varchar(255) NOT NULL default '',
  `bo_1_subj` varchar(255) NOT NULL default '',
  `bo_2_subj` varchar(255) NOT NULL default '',
  `bo_3_subj` varchar(255) NOT NULL default '',
  `bo_4_subj` varchar(255) NOT NULL default '',
  `bo_5_subj` varchar(255) NOT NULL default '',
  `bo_6_subj` varchar(255) NOT NULL default '',
  `bo_7_subj` varchar(255) NOT NULL default '',
  `bo_8_subj` varchar(255) NOT NULL default '',
  `bo_9_subj` varchar(255) NOT NULL default '',
  `bo_10_subj` varchar(255) NOT NULL default '',
  `bo_1` varchar(255) NOT NULL default '',
  `bo_2` varchar(255) NOT NULL default '',
  `bo_3` varchar(255) NOT NULL default '',
  `bo_4` varchar(255) NOT NULL default '',
  `bo_5` varchar(255) NOT NULL default '',
  `bo_6` varchar(255) NOT NULL default '',
  `bo_7` varchar(255) NOT NULL default '',
  `bo_8` varchar(255) NOT NULL default '',
  `bo_9` varchar(255) NOT NULL default '',
  `bo_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`bo_table`)
);


##
## Table structure for table `$g4[board_table]_file`
##

DROP TABLE IF EXISTS `$g4[board_table]_file`;


CREATE TABLE `$g4[board_table]_file` (
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `bf_no` int(11) NOT NULL default '0',
  `bf_source` varchar(255) NOT NULL default '',
  `bf_file` varchar(255) NOT NULL default '',
  `bf_download` varchar(255) NOT NULL default '',
  `bf_content` text NOT NULL,
  `bf_filesize` int(11) NOT NULL default '0',
  `bf_width` int(11) NOT NULL default '0',
  `bf_height` smallint(6) NOT NULL default '0',
  `bf_type` tinyint(4) NOT NULL default '0',
  `bf_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bo_table`,`wr_id`,`bf_no`)
);


##
## Table structure for table `$g4[board_table]_good`
##

DROP TABLE IF EXISTS `$g4[board_table]_good`;


CREATE TABLE `$g4[board_table]_good` (
  `bg_id` int(11) NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `bg_flag` varchar(255) NOT NULL default '',
  `bg_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bg_id`),
  UNIQUE KEY `fkey1` (`bo_table`,`wr_id`,`mb_id`)
);


##
## Table structure for table `$g4[board_table]_new`
##

DROP TABLE IF EXISTS `$g4[board_table]_new`;


CREATE TABLE `$g4[board_table]_new` (
  `bn_id` int(11) NOT NULL auto_increment,
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` int(11) NOT NULL default '0',
  `wr_parent` int(11) NOT NULL default '0',
  `bn_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_id` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`bn_id`),
  KEY `mb_id` (`mb_id`)
);


##
## Table structure for table `$g4[config_table]`
##

DROP TABLE IF EXISTS `$g4[config_table]`;


CREATE TABLE `$g4[config_table]` (
  `cf_title` varchar(255) NOT NULL default '',
  `cf_admin` varchar(255) NOT NULL default '',
  `cf_use_point` tinyint(4) NOT NULL default '0',
  `cf_all_point` INT NOT NULL default '0',
  `cf_use_norobot` tinyint(4) NOT NULL default '0',
  `cf_use_copy_log` tinyint(4) NOT NULL default '0',
  `cf_use_email_certify` tinyint(4) NOT NULL default '0',
  `cf_login_point` int(11) NOT NULL default '0',
  `cf_cut_name` tinyint(4) NOT NULL default '0',
  `cf_nick_modify` int(11) NOT NULL default '0',
  `cf_new_skin` varchar(255) NOT NULL default '',
  `cf_login_skin` varchar(255) NOT NULL default '',
  `cf_new_rows` int(11) NOT NULL default '0',
  `cf_search_skin` varchar(255) NOT NULL default '',
  `cf_connect_skin` varchar(255) NOT NULL default '',
  `cf_read_point` int(11) NOT NULL default '0',
  `cf_write_point` int(11) NOT NULL default '0',
  `cf_comment_point` int(11) NOT NULL default '0',
  `cf_download_point` int(11) NOT NULL default '0',
  `cf_search_bgcolor` varchar(255) NOT NULL default '',
  `cf_search_color` varchar(255) NOT NULL default '',
  `cf_write_pages` int(11) NOT NULL default '0',
  `cf_link_target` varchar(255) NOT NULL default '',
  `cf_delay_sec` int(11) NOT NULL default '0',
  `cf_filter` text NOT NULL,
  `cf_possible_ip` text NOT NULL,
  `cf_intercept_ip` text NOT NULL,
  `cf_register_skin` varchar(255) NOT NULL default 'basic',
  `cf_member_skin` varchar(255) NOT NULL default '',
  `cf_use_homepage` tinyint(4) NOT NULL default '0',
  `cf_req_homepage` tinyint(4) NOT NULL default '0',
  `cf_use_tel` tinyint(4) NOT NULL default '0',
  `cf_req_tel` tinyint(4) NOT NULL default '0',
  `cf_use_hp` tinyint(4) NOT NULL default '0',
  `cf_req_hp` tinyint(4) NOT NULL default '0',
  `cf_use_addr` tinyint(4) NOT NULL default '0',
  `cf_req_addr` tinyint(4) NOT NULL default '0',
  `cf_use_signature` tinyint(4) NOT NULL default '0',
  `cf_req_signature` tinyint(4) NOT NULL default '0',
  `cf_use_profile` tinyint(4) NOT NULL default '0',
  `cf_req_profile` tinyint(4) NOT NULL default '0',
  `cf_register_level` tinyint(4) NOT NULL default '0',
  `cf_register_point` int(11) NOT NULL default '0',
  `cf_icon_level` tinyint(4) NOT NULL default '0',
  `cf_use_recommend` tinyint(4) NOT NULL default '0',
  `cf_recommend_point` int(11) NOT NULL default '0',
  `cf_leave_day` int(11) NOT NULL default '0',
  `cf_search_part` int(11) NOT NULL default '0',
  `cf_email_use` tinyint(4) NOT NULL default '0',
  `cf_email_wr_super_admin` tinyint(4) NOT NULL default '0',
  `cf_email_wr_group_admin` tinyint(4) NOT NULL default '0',
  `cf_email_wr_board_admin` tinyint(4) NOT NULL default '0',
  `cf_email_wr_write` tinyint(4) NOT NULL default '0',
  `cf_email_wr_comment_all` tinyint(4) NOT NULL default '0',
  `cf_email_mb_super_admin` tinyint(4) NOT NULL default '0',
  `cf_email_mb_member` tinyint(4) NOT NULL default '0',
  `cf_email_po_super_admin` tinyint(4) NOT NULL default '0',
  `cf_prohibit_id` text NOT NULL,
  `cf_prohibit_email` text NOT NULL,
  `cf_new_del` int(11) NOT NULL default '0',
  `cf_memo_del` int(11) NOT NULL default '0',
  `cf_visit_del` int(11) NOT NULL default '0',
  `cf_popular_del` int(11) NOT NULL default '0',
  `cf_use_jumin` tinyint(4) NOT NULL default '0',
  `cf_use_member_icon` tinyint(4) NOT NULL default '0',
  `cf_member_icon_size` int(11) NOT NULL default '0',
  `cf_member_icon_width` int(11) NOT NULL default '0',
  `cf_member_icon_height` int(11) NOT NULL default '0',
  `cf_login_minutes` int(11) NOT NULL default '0',
  `cf_image_extension` varchar(255) NOT NULL default '',
  `cf_flash_extension` varchar(255) NOT NULL default '',
  `cf_movie_extension` varchar(255) NOT NULL default '',
  `cf_formmail_is_member` tinyint(4) NOT NULL default '0',
  `cf_page_rows` int(11) NOT NULL default '0',
  `cf_visit` varchar(255) NOT NULL default '',
  `cf_max_po_id` int(11) NOT NULL default '0',
  `cf_stipulation` text NOT NULL,
  `cf_privacy` text NOT NULL,
  `cf_open_modify` int(11) NOT NULL default '0',
  `cf_memo_send_point` int(11) NOT NULL default '0',
   `cf_naver_verification` text NOT NULL,
  `cf_keyword` text NOT NULL,
  `cf_description` text NOT NULL,
  `cf_use_https` INT NOT NULL default 0,
  `cf_https_port` INT NOT NULL default 0,
  `cf_https_domain` varchar(255) NOT NULL default '',
  `cf_kakao_key` varchar(255) NOT NULL default '',
  `cf_naver_client_id` varchar(255) NOT NULL default '',
  `cf_naver_client_secret` varchar(255) NOT NULL default '',
  `cf_facebook_app_id` varchar(255) NOT NULL default '',
  `cf_facebook_app_ver` varchar(255) NOT NULL default '',
  `cf_use_kakao_id_login` INT NOT NULL default 0,
  `cf_use_naver_id_login` INT NOT NULL default 0,
  `cf_use_facebook_id_login` INT NOT NULL default 0,
  `cf_use_naver_log` INT NOT NULL default 0,
  `cf_use_naver_log_reg` INT NOT NULL default 0,
  `cf_use_naver_log_buy` INT NOT NULL default 0,
  `cf_use_naver_log_cart` INT NOT NULL default 0,
  `cf_naver_common_key` varchar(255) NOT NULL default '',
  `cf_1_subj` varchar(255) NOT NULL default '',
  `cf_2_subj` varchar(255) NOT NULL default '',
  `cf_3_subj` varchar(255) NOT NULL default '',
  `cf_4_subj` varchar(255) NOT NULL default '',
  `cf_5_subj` varchar(255) NOT NULL default '',
  `cf_6_subj` varchar(255) NOT NULL default '',
  `cf_7_subj` varchar(255) NOT NULL default '',
  `cf_8_subj` varchar(255) NOT NULL default '',
  `cf_9_subj` varchar(255) NOT NULL default '',
  `cf_10_subj` varchar(255) NOT NULL default '',
  `cf_1` varchar(255) NOT NULL default '',
  `cf_2` varchar(255) NOT NULL default '',
  `cf_3` varchar(255) NOT NULL default '',
  `cf_4` varchar(255) NOT NULL default '',
  `cf_5` varchar(255) NOT NULL default '',
  `cf_6` varchar(255) NOT NULL default '',
  `cf_7` varchar(255) NOT NULL default '',
  `cf_8` varchar(255) NOT NULL default '',
  `cf_9` varchar(255) NOT NULL default '',
  `cf_10` varchar(255) NOT NULL default ''
);


##
## Table structure for table `$g4[group_table]`
##

DROP TABLE IF EXISTS `$g4[group_table]`;


CREATE TABLE `$g4[group_table]` (
  `gr_id` varchar(10) NOT NULL default '',
  `gr_subject` varchar(255) NOT NULL default '',
  `gr_admin` varchar(255) NOT NULL default '',
  `gr_use_access` tinyint(4) NOT NULL default '0',
  `gr_1_subj` varchar(255) NOT NULL default '',
  `gr_2_subj` varchar(255) NOT NULL default '',
  `gr_3_subj` varchar(255) NOT NULL default '',
  `gr_4_subj` varchar(255) NOT NULL default '',
  `gr_5_subj` varchar(255) NOT NULL default '',
  `gr_6_subj` varchar(255) NOT NULL default '',
  `gr_7_subj` varchar(255) NOT NULL default '',
  `gr_8_subj` varchar(255) NOT NULL default '',
  `gr_9_subj` varchar(255) NOT NULL default '',
  `gr_10_subj` varchar(255) NOT NULL default '',
  `gr_1` varchar(255) NOT NULL default '',
  `gr_2` varchar(255) NOT NULL default '',
  `gr_3` varchar(255) NOT NULL default '',
  `gr_4` varchar(255) NOT NULL default '',
  `gr_5` varchar(255) NOT NULL default '',
  `gr_6` varchar(255) NOT NULL default '',
  `gr_7` varchar(255) NOT NULL default '',
  `gr_8` varchar(255) NOT NULL default '',
  `gr_9` varchar(255) NOT NULL default '',
  `gr_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`gr_id`)
);


##
## Table structure for table `$g4[group_member_table]`
##

DROP TABLE IF EXISTS `$g4[group_member_table]`;


CREATE TABLE `$g4[group_member_table]` (
  `gm_id` int(11) NOT NULL auto_increment,
  `gr_id` varchar(255) NOT NULL default '',
  `mb_id` varchar(255) NOT NULL default '',
  `gm_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`gm_id`),
  KEY `gr_id` (`gr_id`),
  KEY `mb_id` (`mb_id`)
);


##
## Table structure for table `$g4[login_table]`
##

DROP TABLE IF EXISTS `$g4[login_table]`;


CREATE TABLE `$g4[login_table]` (
  `lo_ip` varchar(255) NOT NULL default '',
  `mb_id` varchar(255) NOT NULL default '',
  `lo_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `lo_location` text NOT NULL,
  `lo_url` text NOT NULL,
  PRIMARY KEY  (`lo_ip`)
);


##
## Table structure for table `$g4[mail_table]`
##

DROP TABLE IF EXISTS `$g4[mail_table]`;


CREATE TABLE `$g4[mail_table]` (
  `ma_id` int(11) NOT NULL auto_increment,
  `ma_subject` varchar(255) NOT NULL default '',
  `ma_content` mediumtext NOT NULL,
  `ma_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ma_ip` varchar(255) NOT NULL default '',
  `ma_last_option` text NOT NULL,
  PRIMARY KEY  (`ma_id`)
);


##
## Table structure for table `$g4[member_table]`
##

DROP TABLE IF EXISTS `$g4[member_table]`;


CREATE TABLE `$g4[member_table]` (
  `mb_no` int(11) NOT NULL auto_increment,
  `mb_id` varchar(255) NOT NULL default '',
  `mb_password` varchar(255) NOT NULL default '',
  `mb_name` varchar(255) NOT NULL default '',
  `mb_nick` varchar(255) NOT NULL default '',
  `mb_nick_date` date NOT NULL default '0000-00-00',
  `mb_email` varchar(255) NOT NULL default '',
  `mb_homepage` varchar(255) NOT NULL default '',
  `mb_password_q` varchar(255) NOT NULL default '',
  `mb_password_a` varchar(255) NOT NULL default '',
  `mb_level` tinyint(4) NOT NULL default '0',
  `mb_jumin` varchar(255) NOT NULL default '',
  `mb_sex` char(1) NOT NULL default '',
  `mb_birth` varchar(255) NOT NULL default '',
  `mb_tel` varchar(255) NOT NULL default '',
  `mb_hp` varchar(255) NOT NULL default '',
  `mb_zip1` varchar(5) NOT NULL default '',
  `mb_zip2` varchar(5) NOT NULL default '',
  `mb_addr1` varchar(255) NOT NULL default '',
  `mb_addr2` varchar(255) NOT NULL default '',
  `mb_signature` text NOT NULL,
  `mb_recommend` varchar(255) NOT NULL default '',
  `mb_point` int(11) NOT NULL default '0',
  `mb_today_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_login_ip` varchar(255) NOT NULL default '',
  `mb_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_ip` varchar(255) NOT NULL default '',
  `mb_leave_date` varchar(8) NOT NULL default '',
  `mb_intercept_date` varchar(8) NOT NULL default '',
  `mb_email_certify` datetime NOT NULL default '0000-00-00 00:00:00',
  `mb_memo` text NOT NULL,
  `mb_lost_certify` varchar(255) NOT NULL,
  `mb_mailling` tinyint(4) NOT NULL default '0',
  `mb_sms` tinyint(4) NOT NULL default '0',
  `mb_open` tinyint(4) NOT NULL default '0',
  `mb_open_date` date NOT NULL default '0000-00-00',
  `mb_profile` text NOT NULL,
  `mb_memo_call` varchar(255) NOT NULL default '',
  `mb_is_naver` INT NOT NULL,
  `mb_naver_id` varchar(255)  NOT NULL,
  `mb_is_kakao` INT NOT NULL,
  `mb_kakao_id` varchar(255) NOT NULL,
  `mb_is_facebook` INT NOT NULL,
  `mb_facebook_id` varchar(255) NOT NULL,
  `mb_1` varchar(255) NOT NULL default '',
  `mb_2` varchar(255) NOT NULL default '',
  `mb_3` varchar(255) NOT NULL default '',
  `mb_4` varchar(255) NOT NULL default '',
  `mb_5` varchar(255) NOT NULL default '',
  `mb_6` varchar(255) NOT NULL default '',
  `mb_7` varchar(255) NOT NULL default '',
  `mb_8` varchar(255) NOT NULL default '',
  `mb_9` varchar(255) NOT NULL default '',
  `mb_10` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`mb_no`),
  UNIQUE KEY `mb_id` (`mb_id`),
  KEY `mb_today_login` (`mb_today_login`),
  KEY `mb_datetime` (`mb_datetime`)
);


##
## Table structure for table `$g4[memo_table]`
##

DROP TABLE IF EXISTS `$g4[memo_table]`;


CREATE TABLE `$g4[memo_table]` (
  `me_id` int(11) NOT NULL default '0',
  `me_recv_mb_id` varchar(255) NOT NULL default '',
  `me_send_mb_id` varchar(255) NOT NULL default '',
  `me_send_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `me_memo` text NOT NULL,
  PRIMARY KEY  (`me_id`)
);


##
## Table structure for table `$g4[point_table]`
##

DROP TABLE IF EXISTS `$g4[point_table]`;


CREATE TABLE `$g4[point_table]` (
  `po_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(20) NOT NULL default '',
  `po_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `po_content` varchar(255) NOT NULL default '',
  `po_point` int(11) NOT NULL default '0',
  `po_rel_table` varchar(20) NOT NULL default '',
  `po_rel_id` varchar(20) NOT NULL default '',
  `po_rel_action` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`po_id`),
  KEY `index1` (`mb_id`,`po_rel_table`,`po_rel_id`,`po_rel_action`)
);


##
## Table structure for table `$g4[poll_table]`
##

DROP TABLE IF EXISTS `$g4[poll_table]`;


CREATE TABLE `$g4[poll_table]` (
  `po_id` int(11) NOT NULL auto_increment,
  `po_subject` varchar(255) NOT NULL default '',
  `po_poll1` varchar(255) NOT NULL default '',
  `po_poll2` varchar(255) NOT NULL default '',
  `po_poll3` varchar(255) NOT NULL default '',
  `po_poll4` varchar(255) NOT NULL default '',
  `po_poll5` varchar(255) NOT NULL default '',
  `po_poll6` varchar(255) NOT NULL default '',
  `po_poll7` varchar(255) NOT NULL default '',
  `po_poll8` varchar(255) NOT NULL default '',
  `po_poll9` varchar(255) NOT NULL default '',
  `po_cnt1` int(11) NOT NULL default '0',
  `po_cnt2` int(11) NOT NULL default '0',
  `po_cnt3` int(11) NOT NULL default '0',
  `po_cnt4` int(11) NOT NULL default '0',
  `po_cnt5` int(11) NOT NULL default '0',
  `po_cnt6` int(11) NOT NULL default '0',
  `po_cnt7` int(11) NOT NULL default '0',
  `po_cnt8` int(11) NOT NULL default '0',
  `po_cnt9` int(11) NOT NULL default '0',
  `po_etc` varchar(255) NOT NULL default '',
  `po_level` tinyint(4) NOT NULL default '0',
  `po_point` int(11) NOT NULL default '0',
  `po_date` date NOT NULL default '0000-00-00',
  `po_ips` mediumtext NOT NULL,
  `mb_ids` text NOT NULL,
  PRIMARY KEY  (`po_id`)
);


##
## Table structure for table `$g4[poll_etc_table]`
##

DROP TABLE IF EXISTS `$g4[poll_etc_table]`;


CREATE TABLE `$g4[poll_etc_table]` (
  `pc_id` int(11) NOT NULL default '0',
  `po_id` int(11) NOT NULL default '0',
  `mb_id` varchar(255) NOT NULL default '',
  `pc_name` varchar(255) NOT NULL default '',
  `pc_idea` varchar(255) NOT NULL default '',
  `pc_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`pc_id`)
);


##
## Table structure for table `$g4[popular_table]`
##

DROP TABLE IF EXISTS `$g4[popular_table]`;


CREATE TABLE `$g4[popular_table]` (
  `pp_id` int(11) NOT NULL auto_increment,
  `pp_word` varchar(50) NOT NULL default '',
  `pp_date` date NOT NULL default '0000-00-00',
  `pp_ip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`pp_id`),
  UNIQUE KEY `index1` (`pp_date`,`pp_word`,`pp_ip`)
);


##
## Table structure for table `$g4[scrap_table]`
##

DROP TABLE IF EXISTS `$g4[scrap_table]`;


CREATE TABLE `$g4[scrap_table]` (
  `ms_id` int(11) NOT NULL auto_increment,
  `mb_id` varchar(255) NOT NULL default '',
  `bo_table` varchar(20) NOT NULL default '',
  `wr_id` varchar(15) NOT NULL default '',
  `ms_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`ms_id`),
  KEY `mb_id` (`mb_id`)
);


##
## Table structure for table `$g4[token_table]`
##

DROP TABLE IF EXISTS `$g4[token_table]`;


CREATE TABLE `$g4[token_table]` (
  `to_token` varchar(32) NOT NULL default '',
  `to_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `to_ip` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`to_token`),
  KEY `to_datetime` (`to_datetime`),
  KEY `to_ip` (`to_ip`)
);


##
## Table structure for table `$g4[visit_table]`
##

DROP TABLE IF EXISTS `$g4[visit_table]`;


CREATE TABLE `$g4[visit_table]` (
  `vi_id` int(11) NOT NULL default '0',
  `vi_ip` varchar(255) NOT NULL default '',
  `vi_date` date NOT NULL default '0000-00-00',
  `vi_time` time NOT NULL default '00:00:00',
  `vi_referer` text NOT NULL,
  `vi_agent` varchar(255) NOT NULL default '',
  `is_mobile` CHAR(1) NOT NULL default  'N',
  PRIMARY KEY  (`vi_id`),
  UNIQUE KEY `index1` (`vi_ip`,`vi_date`),
  KEY `index2` (`vi_date`)
);


##
## Table structure for table `$g4[visit_sum_table]`
##

DROP TABLE IF EXISTS `$g4[visit_sum_table]`;


CREATE TABLE `$g4[visit_sum_table]` (
  `vs_date` date NOT NULL default '0000-00-00',
  `vs_count` int(11) NOT NULL default '0',
  `vs_pc` int(11) NOT NULL default '0',
  `vs_mobile` int(11) NOT NULL default '0',
  PRIMARY KEY  (`vs_date`),
  KEY `index1` (`vs_count`)
);





DROP TABLE IF EXISTS `it9_gcm_msg`;



CREATE TABLE IF NOT EXISTS `it9_gcm_msg` (
  `msg_no` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL,
  `msg_title` varchar(255) NOT NULL,
  `msg_content` varchar(255) NOT NULL,
  `msg_type` int(11) NOT NULL DEFAULT '1',
  `msg_date` datetime NOT NULL,
  `bo_table` varchar(255) NOT NULL,
  `wr_id` int(11) NOT NULL,
  `is_read` int(11) NOT NULL,
  PRIMARY KEY (`msg_no`),
  KEY `IDX_IS_READ` (`is_read`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;






DROP TABLE IF EXISTS `helper_push_id`; 


CREATE TABLE IF NOT EXISTS `helper_push_id`  (
  `mb_id` varchar(20) NOT NULL,
  `fcm_id` varchar(255) NOT NULL,
  `device_serial` varchar(50) NOT NULL,
  `device_flatform` varchar(255) NOT NULL,
  `is_on` int(11) NOT NULL default '1',
  `apns_badge_cnt` int(11) NOT NULL,
  `reg_dt` datetime NOT NULL,
  PRIMARY KEY  (`device_serial`),
  UNIQUE KEY `mb_id` (`mb_id`,`device_serial`),
  KEY `IDX_FCM_MGID` (`mb_id`),
  KEY `is_on` (`is_on`,`reg_dt`),
  KEY `reg_dt` (`reg_dt`),
  KEY `device_flatform` (`device_flatform`),
  KEY `is_on_2` (`is_on`,`device_flatform`),
  KEY `is_on_3` (`is_on`,`device_flatform`,`reg_dt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;






DROP TABLE IF EXISTS `helper_analytics_config`; 


CREATE TABLE IF NOT EXISTS `helper_analytics_config` (
  `fcm_id` varchar(255) NOT NULL,
  `push_use` int(11) NOT NULL,
  `push1_time` varchar(20) NOT NULL,
  `push2_time` varchar(20) NOT NULL,
  PRIMARY KEY (`fcm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;








DROP TABLE IF EXISTS `it9_gcmid`; 


CREATE TABLE IF NOT EXISTS `it9_gcmid` (
  `mb_id` varchar(20) NOT NULL,
  `gcm_id` varchar(255) NOT NULL,
  `reg_dt` datetime NOT NULL,
  PRIMARY KEY (`mb_id`,`gcm_id`),
  KEY `IDX_GCM_MGID` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;






DROP TABLE IF EXISTS `it9_analytics_gcmid`; 


CREATE TABLE IF NOT EXISTS `it9_analytics_gcmid` (
  `mb_id` varchar(20) NOT NULL,
  `gcm_id` varchar(255) NOT NULL,
  `reg_dt` datetime NOT NULL,
  PRIMARY KEY (`mb_id`,`gcm_id`),
  KEY `IDX_GCM_MGID2` (`mb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;






DROP TABLE IF EXISTS `it9_analytics_config`; 


CREATE TABLE `it9_analytics_config` (
`gcm_id` VARCHAR( 255 ) NOT NULL ,
`push_use` CHAR( 1 ) NOT NULL DEFAULT  'Y',
`push1_time` VARCHAR( 20 ) NOT NULL ,
`push2_time` VARCHAR( 20 ) NOT NULL ,
PRIMARY KEY (  `gcm_id` )
) ENGINE = MYISAM;






DROP TABLE IF EXISTS `ninetalk_site_key`; 


CREATE TABLE IF NOT EXISTS `ninetalk_site_key` (
  `site_key` varchar(255) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `chat_id` varchar(255) NOT NULL,
  `chat_name` varchar(255) NOT NULL,
  PRIMARY KEY (`site_key`)
) ENGINE = MYISAM;





DROP TABLE IF EXISTS `blog_data`; 

CREATE TABLE IF NOT EXISTS `blog_data` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) NOT NULL,
  `link` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `bloggername` varchar(255) NOT NULL,
  `bloggerlink` varchar(255) NOT NULL,
  `disp_order` int(11) NOT NULL DEFAULT '99999',
  `reg_date` varchar(20) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `link` (`link`(333)),
  KEY `title` (`title`(333))
) ENGINE=MyISAM;





DROP TABLE IF EXISTS `blog_keyword`; 


CREATE TABLE IF NOT EXISTS `blog_keyword` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) NOT NULL,
  `reg_date` varchar(20) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM;






DROP TABLE IF EXISTS `g4_popup`; 


CREATE TABLE IF NOT EXISTS `g4_popup` (
  `pop_no` int(11) NOT NULL AUTO_INCREMENT,
  `pop_nm` varchar(255) NOT NULL,
  `pop_type` varchar(1) NOT NULL DEFAULT 'Y',
  `pop_image` varchar(255) NOT NULL,
  `pop_width` int(11) NOT NULL,
  `pop_height` int(11) NOT NULL,
  `pop_top` int(11) NOT NULL,
  `pop_left` int(11) NOT NULL,
  `pop_opt` varchar(255) NOT NULL,
  `pop_iscenter` varchar(1) NOT NULL,
  `pop_link` varchar(255) NOT NULL,
  `pop_map` varchar(255) NOT NULL,
  `pop_map_opt` text NOT NULL,
  `pop_link_type` varchar(1) NOT NULL DEFAULT '1',
  `pop_img_width_o` int(11) NOT NULL,
  `pop_img_height_o` int(11) NOT NULL,
  `pop_img_size` int(11) NOT NULL,
  `pop_img_width` int(11) NOT NULL,
  `pop_img_height` int(11) NOT NULL,
  `reg_dt` varchar(20) NOT NULL,
  `mod_dt` varchar(20) NOT NULL,
  `pop_sdate` varchar(10) NOT NULL,
  `pop_edate` varchar(10) NOT NULL,
  `is_mobile` tinyint(4) NOT NULL,
  PRIMARY KEY (`pop_no`)
) ENGINE=MyISAM;






DROP TABLE IF EXISTS `push_fcmid`; 


CREATE TABLE IF NOT EXISTS `push_fcmid` (
  `mb_id` varchar(20) NOT NULL,
  `fcm_id` varchar(255) NOT NULL,
  `device_serial` varchar(255) NOT NULL,
  `is_on` int(11) NOT NULL DEFAULT '1',
  `reg_dt` datetime NOT NULL,
  PRIMARY KEY (`mb_id`,`fcm_id`),
  UNIQUE KEY `mb_id` (`mb_id`,`device_serial`),
  KEY `IDX_FCM_MGID` (`mb_id`),
  KEY `is_on` (`is_on`,`reg_dt`),
  KEY `reg_dt` (`reg_dt`)
) ENGINE=MyISAM;






DROP TABLE IF EXISTS `g4_login_log`; 


CREATE TABLE IF NOT EXISTS `g4_login_log` (
  `no` int(11) NOT NULL auto_increment,
  `mb_id` varchar(255) NOT NULL,
  `login_date` varchar(50) NOT NULL,
  PRIMARY KEY  (`no`),
  KEY `mb_id` (`mb_id`,`login_date`)
) ENGINE=MyISAM;






DROP TABLE IF EXISTS `api_kko_config`; 


CREATE TABLE IF NOT EXISTS `api_kko_config` (
  `no` int(11) NOT NULL auto_increment,
  `com_id` varchar(50) NOT NULL,
  `sender_number` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `api_id` varchar(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `use_failback` varchar(10) NOT NULL,
  PRIMARY KEY  (`no`),
  UNIQUE KEY `com_id` (`com_id`)
) ENGINE=MyISAM;







DROP TABLE IF EXISTS `api_kko_message`; 


CREATE TABLE IF NOT EXISTS `api_kko_message` (
  `no` int(11) NOT NULL auto_increment,
  `msg_send_type` varchar(255) NOT NULL,
  `com_id` varchar(50) NOT NULL,
  `msg_name` varchar(255) NOT NULL,
  `msg_kko_template` varchar(50) NOT NULL,
  `msg_kko_url` varchar(255) NOT NULL,
  `msg_kko_btntxt` varchar(255) NOT NULL,
  `msg_content` text NOT NULL,
  `msg_kko_btntype_1` varchar(255) NOT NULL,
  `msg_kko_btntype_2` varchar(255) NOT NULL,
  `msg_kko_btntype_3` varchar(255) NOT NULL,
  `msg_kko_btntype_4` varchar(255) NOT NULL,
  `msg_kko_btntype_5` varchar(255) NOT NULL,
  `msg_kko_btnname_1` varchar(255) NOT NULL,
  `msg_kko_btnname_2` varchar(255) NOT NULL,
  `msg_kko_btnname_3` varchar(255) NOT NULL,
  `msg_kko_btnname_4` varchar(255) NOT NULL,
  `msg_kko_btnname_5` varchar(255) NOT NULL,
  `msg_kko_btnurl_m_1` varchar(1024) NOT NULL,
  `msg_kko_btnurl_m_2` varchar(1024) NOT NULL,
  `msg_kko_btnurl_m_3` varchar(1024) NOT NULL,
  `msg_kko_btnurl_m_4` varchar(1024) NOT NULL,
  `msg_kko_btnurl_m_5` varchar(1024) NOT NULL,
  `msg_kko_btnurl_p_1` varchar(1024) NOT NULL,
  `msg_kko_btnurl_p_2` varchar(1024) NOT NULL,
  `msg_kko_btnurl_p_3` varchar(1024) NOT NULL,
  `msg_kko_btnurl_p_4` varchar(1024) NOT NULL,
  `msg_kko_btnurl_p_5` varchar(1024) NOT NULL,
  `reg_date` varchar(20) NOT NULL,
  `reg_id` varchar(255) NOT NULL,
  `reg_ip` varchar(50) NOT NULL,
  `mod_date` varchar(20) NOT NULL,
  `mod_id` varchar(255) NOT NULL,
  `mod_ip` varchar(50) NOT NULL,
  `is_use` varchar(1) NOT NULL,
  PRIMARY KEY  (`no`),
  KEY `com_id` (`com_id`),
  KEY `msg_send_type` (`msg_send_type`)
) ENGINE=MyISAM;






DROP TABLE IF EXISTS `api_kko_result`; 


CREATE TABLE IF NOT EXISTS `api_kko_result` (
  `no` int(11) NOT NULL auto_increment,
  `com_id` varchar(50) NOT NULL,
  `mb_id` varchar(255) NOT NULL,
  `send_number` varchar(255) NOT NULL,
  `dest_number` varchar(255) NOT NULL,
  `msg_content` text NOT NULL,
  `is_fail` int(11) NOT NULL default '0',
  `api_status` varchar(50) NOT NULL,
  `kko_status` varchar(50) NOT NULL,
  `msg_status` varchar(50) NOT NULL,
  `cmid` varchar(255) NOT NULL,
  `umid` varchar(255) NOT NULL,
  `reg_date` varchar(20) NOT NULL,
  PRIMARY KEY  (`no`),
  KEY `com_id` (`com_id`),
  KEY `reg_date` (`reg_date`)
) ENGINE=MyISAM;





##
## Table structure for table `$g4[sms4_book_table]`
##

DROP TABLE IF EXISTS `$g4[sms4_book_table]`;


CREATE TABLE `$g4[sms4_book_table]` (
  `bk_no` int(11) NOT NULL auto_increment,
  `bg_no` int(11) NOT NULL default '0',
  `mb_no` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `bk_name` varchar(255) NOT NULL default '',
  `bk_hp` varchar(255) NOT NULL default '',
  `bk_receipt` tinyint(4) NOT NULL default '0',
  `bk_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `bk_memo` text NOT NULL,
  PRIMARY KEY  (`bk_no`),
  KEY `bk_name` (`bk_name`),
  KEY `bk_hp` (`bk_hp`),
  KEY `mb_no` (`mb_no`),
  KEY `bg_no` (`bg_no`,`bk_no`),
  KEY `mb_id` (`mb_id`)
);


##
## Table structure for table `$g4[sms4_book_table]_group`
##

DROP TABLE IF EXISTS `$g4[sms4_book_table]_group`;


CREATE TABLE `$g4[sms4_book_table]_group` (
  `bg_no` int(11) NOT NULL auto_increment,
  `bg_name` varchar(255) NOT NULL default '',
  `bg_count` int(11) NOT NULL default '0',
  `bg_member` int(11) NOT NULL default '0',
  `bg_nomember` int(11) NOT NULL default '0',
  `bg_receipt` int(11) NOT NULL default '0',
  `bg_reject` int(11) NOT NULL default '0',
  PRIMARY KEY  (`bg_no`),
  KEY `bg_name` (`bg_name`)
);


##
## Table structure for table `$g4[sms4_config_table]`
##

DROP TABLE IF EXISTS `$g4[sms4_config_table]`;


CREATE TABLE `$g4[sms4_config_table]` (
  `cf_id` varchar(255) NOT NULL default '',
  `cf_pw` varchar(255) NOT NULL default '',
  `cf_token` varchar(255) NOT NULL default '',
  `cf_ip` varchar(255) NOT NULL default '211.172.232.124',
  `cf_port` varchar(255) NOT NULL default '',
  `cf_phone` varchar(255) NOT NULL default '',
  `cf_register` varchar(255) NOT NULL default '',
  `cf_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `cf_member` tinyint(4) NOT NULL default '1',
  `cf_level` tinyint(4) NOT NULL default '2',
  `cf_point` int(11) NOT NULL default '0',
  `cf_day_count` int(11) NOT NULL default '0'
);


##
## Table structure for table `$g4[sms4_form_table]`
##

DROP TABLE IF EXISTS `$g4[sms4_form_table]`;


CREATE TABLE `$g4[sms4_form_table]` (
  `fo_no` int(11) NOT NULL auto_increment,
  `fg_no` tinyint(4) NOT NULL default '0',
  `fg_member` char(1) NOT NULL default '0',
  `fo_name` varchar(255) NOT NULL default '',
  `fo_content` text NOT NULL,
  `fo_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`fo_no`),
  KEY `fg_no` (`fg_no`,`fo_no`)
);


##
## Table structure for table `$g4[sms4_form_table]_group`
##

DROP TABLE IF EXISTS `$g4[sms4_form_table]_group`;


CREATE TABLE `$g4[sms4_form_table]_group` (
  `fg_no` int(11) NOT NULL auto_increment,
  `fg_name` varchar(255) NOT NULL default '',
  `fg_count` int(11) NOT NULL default '0',
  `fg_member` tinyint(4) NOT NULL,
  PRIMARY KEY  (`fg_no`),
  KEY `fg_name` (`fg_name`)
);


##
## Table structure for table `$g4[sms4_history_table]`
##

DROP TABLE IF EXISTS `$g4[sms4_history_table]`;


CREATE TABLE `$g4[sms4_history_table]` (
  `hs_no` int(11) NOT NULL auto_increment,
  `wr_no` int(11) NOT NULL default '0',
  `wr_renum` int(11) NOT NULL default '0',
  `bg_no` int(11) NOT NULL default '0',
  `mb_no` int(11) NOT NULL default '0',
  `mb_id` varchar(20) NOT NULL default '',
  `bk_no` int(11) NOT NULL default '0',
  `hs_name` varchar(30) NOT NULL default '',
  `hs_hp` varchar(255) NOT NULL default '',
  `hs_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `hs_flag` tinyint(4) NOT NULL default '0',
  `hs_code` varchar(255) NOT NULL default '',
  `hs_memo` varchar(255) NOT NULL default '',
  `hs_log` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`hs_no`),
  KEY `wr_no` (`wr_no`),
  KEY `mb_no` (`mb_no`),
  KEY `bk_no` (`bk_no`),
  KEY `hs_hp` (`hs_hp`),
  KEY `hs_code` (`hs_code`),
  KEY `bg_no` (`bg_no`),
  KEY `mb_id` (`mb_id`)
);


##
## Table structure for table `$g4[sms4_write_table]`
##

DROP TABLE IF EXISTS `$g4[sms4_write_table]`;


CREATE TABLE `$g4[sms4_write_table]` (
  `wr_no` int(11) NOT NULL default '1',
  `wr_renum` int(11) NOT NULL default '0',
  `wr_reply` varchar(255) NOT NULL default '',
  `wr_message` varchar(255) NOT NULL default '',
  `wr_booking` datetime NOT NULL default '0000-00-00 00:00:00',
  `wr_total` int(11) NOT NULL default '0',
  `wr_re_total` int(11) NOT NULL default '0',
  `wr_success` int(11) NOT NULL default '0',
  `wr_failure` int(11) NOT NULL default '0',
  `wr_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
  `wr_memo` text NOT NULL,
  KEY `wr_no` (`wr_no`,`wr_renum`)
);


##
## Table structure for table `$g4[sms4_member_history_table]`
##

DROP TABLE IF EXISTS `$g4[sms4_member_history_table]`;


CREATE TABLE `$g4[sms4_member_history_table]` (
  `mh_no` int(11) NOT NULL auto_increment,
  `mb_id` varchar(30) NOT NULL,
  `mh_reply` varchar(30) NOT NULL,
  `mh_hp` varchar(30) NOT NULL,
  `mh_datetime` datetime NOT NULL,
  `mh_booking` datetime NOT NULL,
  `mh_log` varchar(255) NOT NULL,
  `mh_ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`mh_no`),
  KEY `mb_id` (`mb_id`,`mh_datetime`)
);




DROP TABLE IF EXISTS `sms4_message`;

CREATE TABLE IF NOT EXISTS `sms4_message` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `msg_when` int(11) NOT NULL COMMENT '1=입금(결제)시 / 2=출고n일전 / 3=자동취소시',
  `msg_n_day` int(11) NOT NULL,
  `msg_n_time` varchar(50) NOT NULL,
  `msg_com_no` varchar(255) NOT NULL,
  `msg_pno` int(11) NOT NULL,
  `msg_send_number` varchar(50) NOT NULL,
  `msg_type` varchar(3) NOT NULL COMMENT 'ATK:알림톡 | SMS:SMS',
  `msg_sms_name` varchar(255) NOT NULL,
  `msg_sms_content` text NOT NULL,
  `reg_date` varchar(50) NOT NULL,
  `reg_id` varchar(255) NOT NULL,
  `reg_ip` varchar(50) NOT NULL,
  `mod_date` varchar(50) NOT NULL,
  `mod_id` varchar(255) NOT NULL,
  `mod_ip` varchar(50) NOT NULL,
  PRIMARY KEY (`no`),
  KEY `msg_when` (`msg_when`)
) 






## Dump completed on 2011-07-29 15:41:27
