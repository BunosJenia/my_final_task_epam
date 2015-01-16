--   -------------------------------------------------- 
--   Generated by Enterprise Architect Version 9.0.908
--   Created On : �������, 16 ������, 2015 
--   DBMS       : MySql 
--   -------------------------------------------------- 


SET FOREIGN_KEY_CHECKS=0;


--  Drop Tables, Stored Procedures and Views 

DROP TABLE IF EXISTS `categories_of_questions` CASCADE
;
DROP TABLE IF EXISTS `config` CASCADE
;
DROP TABLE IF EXISTS `correct_question_answer` CASCADE
;
DROP TABLE IF EXISTS `guests` CASCADE
;
DROP TABLE IF EXISTS `label` CASCADE
;
DROP TABLE IF EXISTS `message` CASCADE
;
DROP TABLE IF EXISTS `questions` CASCADE
;
DROP TABLE IF EXISTS `questions_answer` CASCADE
;
DROP TABLE IF EXISTS `questions_answer_log` CASCADE
;
DROP TABLE IF EXISTS `questions_categories` CASCADE
;
DROP TABLE IF EXISTS `questions_in_test` CASCADE
;
DROP TABLE IF EXISTS `questions_log` CASCADE
;
DROP TABLE IF EXISTS `questions_type` CASCADE
;
DROP TABLE IF EXISTS `qustion_category` CASCADE
;
DROP TABLE IF EXISTS `roles_of_users` CASCADE
;
DROP TABLE IF EXISTS `test_passage_info` CASCADE
;
DROP TABLE IF EXISTS `tests` CASCADE
;
DROP TABLE IF EXISTS `tests_for_groups` CASCADE
;
DROP TABLE IF EXISTS `training_groups` CASCADE
;
DROP TABLE IF EXISTS `users` CASCADE
;
DROP TABLE IF EXISTS `users_in_groups` CASCADE
;
DROP TABLE IF EXISTS `users_roles` CASCADE
;

--  Create Tables 
CREATE TABLE `categories_of_questions`
(
	`coq_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`coq_category` VARCHAR(255) NOT NULL,
	`coq_subcategory` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`coq_id`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='This table contains all pairs of categories and subcategories'
;


CREATE TABLE `config`
(
	`c_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`c_name` VARCHAR(100) NOT NULL,
	`c_value` VARCHAR(1000),
	PRIMARY KEY (`c_id`),
	UNIQUE `UQ_config_c_name`(`c_name`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='Config information'
;


CREATE TABLE `correct_question_answer`
(
	`cqa_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`cqa_qustion` INTEGER UNSIGNED NOT NULL,
	`cqa_answer` INTEGER UNSIGNED NOT NULL,
	PRIMARY KEY (`cqa_id`),
	KEY (`cqa_qustion`),
	KEY (`cqa_answer`)

) 
;


CREATE TABLE `guests`
(
	`g_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`g_key` VARCHAR(255) NOT NULL,
	`g_test` INTEGER UNSIGNED NOT NULL,
	`g_description` VARCHAR(1000) NOT NULL,
	PRIMARY KEY (`g_id`),
	UNIQUE `UQ_guests_g_key`(`g_key`),
	KEY (`g_test`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='This table store unique key for guest and test_id'
;


CREATE TABLE `label`
(
	`l_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`l_name` VARCHAR(100) NOT NULL,
	`l_value` VARCHAR(1000),
	PRIMARY KEY (`l_id`),
	UNIQUE `UQ_label_l_name`(`l_name`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='Table, where we store all labels'
;


CREATE TABLE `message`
(
	`m_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`m_name` VARCHAR(100) NOT NULL,
	`m_value` VARCHAR(1000) NOT NULL,
	PRIMARY KEY (`m_id`),
	UNIQUE `UQ_message_m_name`(`m_name`)

) DEFAULT CHARACTER SET utf8 DEFAULT CHARSET utf8 COLLATE utf8_general_ci ENGINE=InnoDB COMMENT='Table, where we store error messages'
;


CREATE TABLE `questions`
(
	`q_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`q_type` INTEGER UNSIGNED NOT NULL,
	`q_name` VARCHAR(1000) NOT NULL,
	`q_weight` INTEGER NOT NULL,
	`q_time` INTEGER NOT NULL,
	`q_picture_hash` VARCHAR(255),
	PRIMARY KEY (`q_id`),
	UNIQUE `UQ_questions_q_picture_hash`(`q_picture_hash`),
	KEY (`q_type`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='All info about questions'
;


CREATE TABLE `questions_answer`
(
	`qa_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`qa_question` INTEGER UNSIGNED NOT NULL,
	`qa_value` VARCHAR(255) NOT NULL,
	`qa_correct` BIT,
	PRIMARY KEY (`qa_id`),
	KEY (`qa_question`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='All answers here, if answer is correct - pole qa_correct has - 1, else NULL'
;


CREATE TABLE `questions_answer_log`
(
	`qal_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`qal_answer` INTEGER UNSIGNED NOT NULL,
	`qal_qustion_log` INTEGER UNSIGNED NOT NULL,
	`qal_value` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`qal_id`),
	KEY (`qal_answer`),
	KEY (`qal_qustion_log`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='This table contains all answers left from users and guests'
;


CREATE TABLE `questions_categories`
(
	`qc_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`qc_category` VARCHAR(255) NOT NULL,
	`qc_subcategory` VARCHAR(255),
	PRIMARY KEY (`qc_id`)

) 
;


CREATE TABLE `questions_in_test`
(
	`qit_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`qit_test` INTEGER UNSIGNED NOT NULL,
	`qit_question` INTEGER UNSIGNED NOT NULL,
	PRIMARY KEY (`qit_id`),
	KEY (`qit_question`),
	KEY (`qit_test`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
;


CREATE TABLE `questions_log`
(
	`ql_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`ql_guest` INTEGER UNSIGNED,
	`ql_test_pass_info` INTEGER UNSIGNED,
	`ql_question` INTEGER UNSIGNED NOT NULL,
	`ql_time_sec` INTEGER,
	`ql_correct` BIT,
	`ql_skip` INTEGER,
	PRIMARY KEY (`ql_id`),
	KEY (`ql_guest`),
	KEY (`ql_question`),
	KEY (`ql_test_pass_info`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='This table contains log about questions, who answered(guest or user - only in 1 pole can be 1,in ql_guest or in ql_test_pass_info), time, correct answer or not'
;


CREATE TABLE `questions_type`
(
	`qt_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`qt_type_name` VARCHAR(255) NOT NULL,
	`qt_description` VARCHAR(1000),
	PRIMARY KEY (`qt_id`),
	UNIQUE `UQ_questions_type_qt_type_name`(`qt_type_name`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='Types of questions and there descriptions'
;


CREATE TABLE `qustion_category`
(
	`qusc_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`qusc_qustion` INTEGER UNSIGNED NOT NULL,
	`qusc_category` INTEGER UNSIGNED NOT NULL,
	PRIMARY KEY (`qusc_id`),
	KEY (`qusc_category`),
	KEY (`qusc_qustion`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
;


CREATE TABLE `roles_of_users`
(
	`rou_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`rou_name` VARCHAR(100) NOT NULL,
	`rou_description` VARCHAR(1000),
	PRIMARY KEY (`rou_id`),
	UNIQUE `UQ_roles_of_users_rou_name`(`rou_name`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='Here all roles and description to this roles.'
;


CREATE TABLE `test_passage_info`
(
	`tpi_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`tpi_user` INTEGER UNSIGNED NOT NULL,
	`tpi_test` INTEGER UNSIGNED NOT NULL,
	`tpi_mark` INTEGER,
	`tpi_percentage` INTEGER,
	`tpi_time_minut` INTEGER,
	`tpi_date` DATETIME,
	PRIMARY KEY (`tpi_id`),
	KEY (`tpi_test`),
	KEY (`tpi_user`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='Test passage information, which contains: user, test, mark and etc.'
;


CREATE TABLE `tests`
(
	`t_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`t_type` VARCHAR(100) NOT NULL,
	`t_description` VARCHAR(1000),
	`t_stop_prop` BIT,
	`t_show_answers_in_end_prop` BIT,
	`t_show_verdict_prop` BIT,
	`t_show_answers_prop` BIT,
	`t_show_mark` BIT,
	`t_skip_qust` BIT,
	`t_time` INTEGER,
	`t_min_mark` INTEGER,
	`t_category` INTEGER UNSIGNED NOT NULL,
	PRIMARY KEY (`t_id`),
	KEY (`t_category`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
;


CREATE TABLE `tests_for_groups`
(
	`tfg_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`tfg_test` INTEGER UNSIGNED NOT NULL,
	`tfg_group` INTEGER UNSIGNED NOT NULL,
	PRIMARY KEY (`tfg_id`),
	KEY (`tfg_test`),
	KEY (`tfg_group`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
;


CREATE TABLE `training_groups`
(
	`tg_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`tg_training_name` VARCHAR(255) NOT NULL,
	`tg_description` VARCHAR(1000),
	PRIMARY KEY (`tg_id`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
;


CREATE TABLE `users`
(
	`u_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`u_login` VARCHAR(100) NOT NULL,
	`u_email` VARCHAR(255) NOT NULL,
	`u_first_name` VARCHAR(255) NOT NULL,
	`u_patronymic` VARCHAR(255),
	`u_last_name` VARCHAR(255) NOT NULL,
	`u_long_auth` VARCHAR(200),
	PRIMARY KEY (`u_id`),
	UNIQUE `UQ_users_u_email`(`u_email`),
	UNIQUE `UQ_users_u_login`(`u_login`),
	UNIQUE `UQ_users_u_long_auth`(`u_long_auth`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT='User and information about user'
;


CREATE TABLE `users_in_groups`
(
	`uig_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`uig_user` INTEGER UNSIGNED NOT NULL,
	`uig_group` INTEGER UNSIGNED NOT NULL,
	PRIMARY KEY (`uig_id`),
	KEY (`uig_group`),
	KEY (`uig_user`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
;


CREATE TABLE `users_roles`
(
	`ur_id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	`ur_user` INTEGER UNSIGNED NOT NULL,
	`ur_role` INTEGER UNSIGNED NOT NULL,
	PRIMARY KEY (`ur_id`),
	KEY (`ur_role`),
	KEY (`ur_user`)

) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci
;



SET FOREIGN_KEY_CHECKS=1;


--  Create Foreign Key Constraints 
ALTER TABLE `correct_question_answer` ADD CONSTRAINT `FK_correct_question_answer_questions` 
	FOREIGN KEY (`cqa_qustion`) REFERENCES `questions` (`q_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `correct_question_answer` ADD CONSTRAINT `FK_correct_question_answer_questions_answer` 
	FOREIGN KEY (`cqa_answer`) REFERENCES `questions_answer` (`qa_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `guests` ADD CONSTRAINT `FK_guests_Tests` 
	FOREIGN KEY (`g_test`) REFERENCES `tests` (`t_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `questions` ADD CONSTRAINT `FK_questions_questions_type` 
	FOREIGN KEY (`q_type`) REFERENCES `questions_type` (`qt_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `questions_answer` ADD CONSTRAINT `FK_questions_answer_questions` 
	FOREIGN KEY (`qa_question`) REFERENCES `questions` (`q_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `questions_answer_log` ADD CONSTRAINT `FK_questions_answer_log_questions_answer` 
	FOREIGN KEY (`qal_answer`) REFERENCES `questions_answer` (`qa_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `questions_answer_log` ADD CONSTRAINT `FK_questions_answer_log_questions_log` 
	FOREIGN KEY (`qal_qustion_log`) REFERENCES `questions_log` (`ql_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `questions_in_test` ADD CONSTRAINT `FK_questions_in_test_questions` 
	FOREIGN KEY (`qit_question`) REFERENCES `questions` (`q_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `questions_in_test` ADD CONSTRAINT `FK_questions_in_test_Tests` 
	FOREIGN KEY (`qit_test`) REFERENCES `tests` (`t_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `questions_log` ADD CONSTRAINT `FK_questions_log_guests` 
	FOREIGN KEY (`ql_guest`) REFERENCES `guests` (`g_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `questions_log` ADD CONSTRAINT `FK_questions_log_questions` 
	FOREIGN KEY (`ql_question`) REFERENCES `questions` (`q_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `questions_log` ADD CONSTRAINT `FK_questions_log_test_passage_info` 
	FOREIGN KEY (`ql_test_pass_info`) REFERENCES `test_passage_info` (`tpi_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `qustion_category` ADD CONSTRAINT `FK_qustion_category_categories_of_questions` 
	FOREIGN KEY (`qusc_category`) REFERENCES `categories_of_questions` (`coq_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `qustion_category` ADD CONSTRAINT `FK_qustion_category_questions` 
	FOREIGN KEY (`qusc_qustion`) REFERENCES `questions` (`q_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `test_passage_info` ADD CONSTRAINT `FK_test_passage_info_Tests` 
	FOREIGN KEY (`tpi_test`) REFERENCES `tests` (`t_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `test_passage_info` ADD CONSTRAINT `FK_test_passage_info_users` 
	FOREIGN KEY (`tpi_user`) REFERENCES `users` (`u_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `tests` ADD CONSTRAINT `FK_Tests_categories_of_questions` 
	FOREIGN KEY (`t_category`) REFERENCES `categories_of_questions` (`coq_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `tests_for_groups` ADD CONSTRAINT `FK_tests_for_groups_Tests` 
	FOREIGN KEY (`tfg_test`) REFERENCES `tests` (`t_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `tests_for_groups` ADD CONSTRAINT `FK_tests_for_groups_training_groups` 
	FOREIGN KEY (`tfg_group`) REFERENCES `training_groups` (`tg_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `users_in_groups` ADD CONSTRAINT `FK_users_in_groups_training_groups` 
	FOREIGN KEY (`uig_group`) REFERENCES `training_groups` (`tg_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `users_in_groups` ADD CONSTRAINT `FK_users_in_groups_users` 
	FOREIGN KEY (`uig_user`) REFERENCES `users` (`u_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `users_roles` ADD CONSTRAINT `FK_users_roles_roles_of_users` 
	FOREIGN KEY (`ur_role`) REFERENCES `roles_of_users` (`rou_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;

ALTER TABLE `users_roles` ADD CONSTRAINT `FK_users_roles_users` 
	FOREIGN KEY (`ur_user`) REFERENCES `users` (`u_id`)
	ON DELETE CASCADE ON UPDATE CASCADE
;
