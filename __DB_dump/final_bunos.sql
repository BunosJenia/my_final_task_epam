/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50535
Source Host           : localhost:3306
Source Database       : final_bunos

Target Server Type    : MYSQL
Target Server Version : 50535
File Encoding         : 65001

Date: 2015-01-29 09:43:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `categories_of_questions`
-- ----------------------------
DROP TABLE IF EXISTS `categories_of_questions`;
CREATE TABLE `categories_of_questions` (
  `coq_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coq_category` varchar(255) NOT NULL,
  `coq_subcategory` varchar(255) NOT NULL,
  PRIMARY KEY (`coq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='This table contains all pairs of categories and subcategories';

-- ----------------------------
-- Records of categories_of_questions
-- ----------------------------
INSERT INTO `categories_of_questions` VALUES ('1', 'PHP', 'Основы');
INSERT INTO `categories_of_questions` VALUES ('2', 'PHP', 'Массивы');
INSERT INTO `categories_of_questions` VALUES ('3', 'PHP', 'ООП');
INSERT INTO `categories_of_questions` VALUES ('4', 'JAVA', 'Основы');
INSERT INTO `categories_of_questions` VALUES ('5', 'JAVA', 'ООП');
INSERT INTO `categories_of_questions` VALUES ('6', '.NET', 'Основы');
INSERT INTO `categories_of_questions` VALUES ('7', 'PHP', 'qweqwe');

-- ----------------------------
-- Table structure for `config`
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_name` varchar(100) NOT NULL,
  `c_value` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `UQ_config_c_name` (`c_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Config information';

-- ----------------------------
-- Records of config
-- ----------------------------

-- ----------------------------
-- Table structure for `guests`
-- ----------------------------
DROP TABLE IF EXISTS `guests`;
CREATE TABLE `guests` (
  `g_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `g_key` varchar(255) NOT NULL,
  `g_test` int(10) unsigned NOT NULL,
  `g_description` varchar(1000) NOT NULL,
  PRIMARY KEY (`g_id`),
  UNIQUE KEY `UQ_guests_g_key` (`g_key`),
  KEY `g_test` (`g_test`),
  CONSTRAINT `FK_guests_Tests` FOREIGN KEY (`g_test`) REFERENCES `tests` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table store unique key for guest and test_id';

-- ----------------------------
-- Records of guests
-- ----------------------------

-- ----------------------------
-- Table structure for `label`
-- ----------------------------
DROP TABLE IF EXISTS `label`;
CREATE TABLE `label` (
  `l_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `l_name` varchar(100) NOT NULL,
  `l_value` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`l_id`),
  UNIQUE KEY `UQ_label_l_name` (`l_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table, where we store all labels';

-- ----------------------------
-- Records of label
-- ----------------------------

-- ----------------------------
-- Table structure for `message`
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `m_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_name` varchar(100) NOT NULL,
  `m_value` varchar(1000) NOT NULL,
  PRIMARY KEY (`m_id`),
  UNIQUE KEY `UQ_message_m_name` (`m_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table, where we store error messages';

-- ----------------------------
-- Records of message
-- ----------------------------

-- ----------------------------
-- Table structure for `questions`
-- ----------------------------
DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `q_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `q_type` int(10) unsigned NOT NULL,
  `q_name` varchar(1000) NOT NULL,
  `q_weight` int(11) NOT NULL,
  `q_time` int(11) NOT NULL,
  `q_picture_hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`q_id`),
  UNIQUE KEY `UQ_questions_q_picture_hash` (`q_picture_hash`),
  KEY `q_type` (`q_type`),
  CONSTRAINT `FK_questions_questions_type` FOREIGN KEY (`q_type`) REFERENCES `questions_type` (`qt_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='All info about questions';

-- ----------------------------
-- Records of questions
-- ----------------------------
INSERT INTO `questions` VALUES ('1', '1', 'Сколько типов данных в PHP?', '0', '0', null);
INSERT INTO `questions` VALUES ('2', '2', 'Скалярные типы данных в PHP?', '0', '0', null);
INSERT INTO `questions` VALUES ('3', '2', 'Комплексные(составные) типы данных в PHP?', '0', '0', null);

-- ----------------------------
-- Table structure for `questions_answer`
-- ----------------------------
DROP TABLE IF EXISTS `questions_answer`;
CREATE TABLE `questions_answer` (
  `qa_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qa_question` int(10) unsigned NOT NULL,
  `qa_value` varchar(255) NOT NULL,
  `qa_correct` bit(1) DEFAULT NULL,
  PRIMARY KEY (`qa_id`),
  KEY `qa_question` (`qa_question`),
  CONSTRAINT `FK_questions_answer_questions` FOREIGN KEY (`qa_question`) REFERENCES `questions` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='All answers here, if answer is correct - pole qa_correct has - 1, else NULL';

-- ----------------------------
-- Records of questions_answer
-- ----------------------------
INSERT INTO `questions_answer` VALUES ('1', '1', '8', '');
INSERT INTO `questions_answer` VALUES ('2', '1', '7', null);
INSERT INTO `questions_answer` VALUES ('3', '1', '6', null);
INSERT INTO `questions_answer` VALUES ('5', '1', '9', null);
INSERT INTO `questions_answer` VALUES ('6', '1', '10', null);
INSERT INTO `questions_answer` VALUES ('7', '2', 'boolen', '');
INSERT INTO `questions_answer` VALUES ('8', '2', 'integer', '');
INSERT INTO `questions_answer` VALUES ('9', '2', 'float', '');
INSERT INTO `questions_answer` VALUES ('10', '2', 'string', '');
INSERT INTO `questions_answer` VALUES ('11', '2', 'NULL', null);
INSERT INTO `questions_answer` VALUES ('12', '3', 'array', '');
INSERT INTO `questions_answer` VALUES ('13', '3', 'object', '');
INSERT INTO `questions_answer` VALUES ('14', '3', 'string', null);
INSERT INTO `questions_answer` VALUES ('15', '3', 'resource', null);
INSERT INTO `questions_answer` VALUES ('16', '3', 'float', null);

-- ----------------------------
-- Table structure for `questions_answer_log`
-- ----------------------------
DROP TABLE IF EXISTS `questions_answer_log`;
CREATE TABLE `questions_answer_log` (
  `qal_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qal_answer` int(10) unsigned NOT NULL,
  `qal_qustion_log` int(10) unsigned NOT NULL,
  `qal_value` varchar(255) NOT NULL,
  PRIMARY KEY (`qal_id`),
  KEY `qal_answer` (`qal_answer`),
  KEY `qal_qustion_log` (`qal_qustion_log`),
  CONSTRAINT `FK_questions_answer_log_questions_answer` FOREIGN KEY (`qal_answer`) REFERENCES `questions_answer` (`qa_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_questions_answer_log_questions_log` FOREIGN KEY (`qal_qustion_log`) REFERENCES `questions_log` (`ql_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains all answers left from users and guests';

-- ----------------------------
-- Records of questions_answer_log
-- ----------------------------

-- ----------------------------
-- Table structure for `questions_in_test`
-- ----------------------------
DROP TABLE IF EXISTS `questions_in_test`;
CREATE TABLE `questions_in_test` (
  `qit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qit_test` int(10) unsigned NOT NULL,
  `qit_question` int(10) unsigned NOT NULL,
  PRIMARY KEY (`qit_id`),
  KEY `qit_question` (`qit_question`),
  KEY `qit_test` (`qit_test`),
  CONSTRAINT `FK_questions_in_test_questions` FOREIGN KEY (`qit_question`) REFERENCES `questions` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_questions_in_test_Tests` FOREIGN KEY (`qit_test`) REFERENCES `tests` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of questions_in_test
-- ----------------------------
INSERT INTO `questions_in_test` VALUES ('2', '3', '1');
INSERT INTO `questions_in_test` VALUES ('3', '3', '2');

-- ----------------------------
-- Table structure for `questions_log`
-- ----------------------------
DROP TABLE IF EXISTS `questions_log`;
CREATE TABLE `questions_log` (
  `ql_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ql_guest` int(10) unsigned DEFAULT NULL,
  `ql_test_pass_info` int(10) unsigned DEFAULT NULL,
  `ql_question` int(10) unsigned NOT NULL,
  `ql_time_sec` int(11) DEFAULT NULL,
  `ql_correct` bit(1) DEFAULT NULL,
  `ql_skip` int(11) DEFAULT NULL,
  PRIMARY KEY (`ql_id`),
  KEY `ql_guest` (`ql_guest`),
  KEY `ql_question` (`ql_question`),
  KEY `ql_test_pass_info` (`ql_test_pass_info`),
  CONSTRAINT `FK_questions_log_guests` FOREIGN KEY (`ql_guest`) REFERENCES `guests` (`g_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_questions_log_questions` FOREIGN KEY (`ql_question`) REFERENCES `questions` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_questions_log_test_passage_info` FOREIGN KEY (`ql_test_pass_info`) REFERENCES `test_passage_info` (`tpi_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains log about questions, who answered(guest or user - only in 1 pole can be 1,in ql_guest or in ql_test_pass_info), time, correct answer or not';

-- ----------------------------
-- Records of questions_log
-- ----------------------------

-- ----------------------------
-- Table structure for `questions_type`
-- ----------------------------
DROP TABLE IF EXISTS `questions_type`;
CREATE TABLE `questions_type` (
  `qt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qt_type_name` varchar(255) NOT NULL,
  `qt_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`qt_id`),
  UNIQUE KEY `UQ_questions_type_qt_type_name` (`qt_type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Types of questions and there descriptions';

-- ----------------------------
-- Records of questions_type
-- ----------------------------
INSERT INTO `questions_type` VALUES ('1', 'Вопрос с одним ответом', 'На выбор предлогается несколько ответов, только один из них правильный.');
INSERT INTO `questions_type` VALUES ('2', 'Вопрос с несколькими ответами', 'На выбор предоставляется возможность отметить как правильные несколько ответов. В таких вопросах количество правильных ответов должно быть более одного, но менее общего количества возможных ответов.');
INSERT INTO `questions_type` VALUES ('3', 'Вопрос на соответствие', 'Слушателю показаны два набора с текстовыми пунктами и/или картинками. Слушатель должен составить из них корректные пары.');
INSERT INTO `questions_type` VALUES ('4', 'Вопрос на классификацию', 'Слушателю отображается две колонки. Первая из нихсодержит текстовые опции и/или картинки, вторая -  дроп-боксы с вариантами ответов. Правильных ответов может быть нескалько. в таком случае дроп-бокс заменяется на список с возможностью выбрать несколько пунктов.');
INSERT INTO `questions_type` VALUES ('5', 'Вопрос на упорядочивание', 'Слушателю отображаются текстовые строки и/или картинки, размещённые в случайном порядке, слушатель должен выстроить их в верном порядке.');
INSERT INTO `questions_type` VALUES ('6', 'Вопрос на заполнение', 'Слушателю отображается текст с пропущенными фрагментами. Слушатель должен их заполнить опираясь на собственные знания и/или подсказки. ');
INSERT INTO `questions_type` VALUES ('7', 'Вопрос со свободным ответом', 'Слушателю отображается вопрос(возможно, с картинкой) и поле для ввода текста. Ответ сохраняется и передается тренеру на проверку. Тренер может оценить правильность ответа в заранее определенном диапазоне баллов. В этом вопросе так же предполагается отдельное поле для хранения верного ответа.');
INSERT INTO `questions_type` VALUES ('8', 'Вопрос с картинкой', 'Слушателю отображается картинка, он должен кликнуть по ней в одной или нескольких областях, отмечая верные ответы.');
INSERT INTO `questions_type` VALUES ('9', 'Вопрос на перемещение врагментов', 'Слушателю отображается картинка с кодом, в которой пропущены некоторые области; он должен перетянуть в такие области соответствующие фрагменты кода.');

-- ----------------------------
-- Table structure for `qustion_category`
-- ----------------------------
DROP TABLE IF EXISTS `qustion_category`;
CREATE TABLE `qustion_category` (
  `qusc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qusc_qustion` int(10) unsigned NOT NULL,
  `qusc_category` int(10) unsigned NOT NULL,
  PRIMARY KEY (`qusc_id`),
  KEY `qusc_category` (`qusc_category`),
  KEY `qusc_qustion` (`qusc_qustion`),
  CONSTRAINT `FK_qustion_category_categories_of_questions` FOREIGN KEY (`qusc_category`) REFERENCES `categories_of_questions` (`coq_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_qustion_category_questions` FOREIGN KEY (`qusc_qustion`) REFERENCES `questions` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of qustion_category
-- ----------------------------
INSERT INTO `qustion_category` VALUES ('1', '1', '1');
INSERT INTO `qustion_category` VALUES ('2', '2', '1');
INSERT INTO `qustion_category` VALUES ('3', '3', '1');
INSERT INTO `qustion_category` VALUES ('4', '2', '2');
INSERT INTO `qustion_category` VALUES ('5', '3', '2');

-- ----------------------------
-- Table structure for `roles_of_users`
-- ----------------------------
DROP TABLE IF EXISTS `roles_of_users`;
CREATE TABLE `roles_of_users` (
  `rou_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rou_name` varchar(100) NOT NULL,
  `rou_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`rou_id`),
  UNIQUE KEY `UQ_roles_of_users_rou_name` (`rou_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Here all roles and description to this roles.';

-- ----------------------------
-- Records of roles_of_users
-- ----------------------------
INSERT INTO `roles_of_users` VALUES ('1', 'listener', 'Проходит тестирование по назначенным тестам.');
INSERT INTO `roles_of_users` VALUES ('2', 'coach', 'Отвечает за создание в PTS групп слушателей, назначение группам слушателей тестов.');
INSERT INTO `roles_of_users` VALUES ('3', 'RD-manager', 'Отвечает за создание в PTS направлений обучения и тестов.');
INSERT INTO `roles_of_users` VALUES ('4', 'admin', 'Имеет право выполнять любые операции без каких бы то ни было ограничений.');

-- ----------------------------
-- Table structure for `tests`
-- ----------------------------
DROP TABLE IF EXISTS `tests`;
CREATE TABLE `tests` (
  `t_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `t_type` varchar(100) NOT NULL,
  `t_description` varchar(1000) DEFAULT NULL,
  `t_stop_prop` bit(1) DEFAULT NULL,
  `t_show_answers_in_end_prop` bit(1) DEFAULT NULL,
  `t_show_verdict_prop` bit(1) DEFAULT NULL,
  `t_show_answers_prop` bit(1) DEFAULT NULL,
  `t_show_mark` bit(1) DEFAULT NULL,
  `t_skip_qust` bit(1) DEFAULT NULL,
  `t_time` int(11) DEFAULT NULL,
  `t_min_mark` int(11) DEFAULT NULL,
  `t_category` int(10) unsigned NOT NULL,
  PRIMARY KEY (`t_id`),
  KEY `t_category` (`t_category`),
  CONSTRAINT `FK_Tests_categories_of_questions` FOREIGN KEY (`t_category`) REFERENCES `categories_of_questions` (`coq_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tests
-- ----------------------------
INSERT INTO `tests` VALUES ('1', 'Первый тип PHP', null, null, null, null, null, null, null, null, null, '1');
INSERT INTO `tests` VALUES ('3', 'Test1', null, null, null, null, null, null, null, null, null, '1');

-- ----------------------------
-- Table structure for `tests_for_groups`
-- ----------------------------
DROP TABLE IF EXISTS `tests_for_groups`;
CREATE TABLE `tests_for_groups` (
  `tfg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tfg_test` int(10) unsigned NOT NULL,
  `tfg_group` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tfg_id`),
  KEY `tfg_test` (`tfg_test`),
  KEY `tfg_group` (`tfg_group`),
  CONSTRAINT `FK_tests_for_groups_Tests` FOREIGN KEY (`tfg_test`) REFERENCES `tests` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_tests_for_groups_training_groups` FOREIGN KEY (`tfg_group`) REFERENCES `training_groups` (`tg_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tests_for_groups
-- ----------------------------
INSERT INTO `tests_for_groups` VALUES ('1', '1', '1');

-- ----------------------------
-- Table structure for `test_passage_info`
-- ----------------------------
DROP TABLE IF EXISTS `test_passage_info`;
CREATE TABLE `test_passage_info` (
  `tpi_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tpi_user` int(10) unsigned NOT NULL,
  `tpi_test` int(10) unsigned NOT NULL,
  `tpi_mark` int(11) DEFAULT NULL,
  `tpi_percentage` int(11) DEFAULT NULL,
  `tpi_time_minut` int(11) DEFAULT NULL,
  `tpi_date` datetime DEFAULT NULL,
  PRIMARY KEY (`tpi_id`),
  KEY `tpi_test` (`tpi_test`),
  KEY `tpi_user` (`tpi_user`),
  CONSTRAINT `FK_test_passage_info_Tests` FOREIGN KEY (`tpi_test`) REFERENCES `tests` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_test_passage_info_users` FOREIGN KEY (`tpi_user`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Test passage information, which contains: user, test, mark and etc.';

-- ----------------------------
-- Records of test_passage_info
-- ----------------------------

-- ----------------------------
-- Table structure for `training_groups`
-- ----------------------------
DROP TABLE IF EXISTS `training_groups`;
CREATE TABLE `training_groups` (
  `tg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tg_training_name` varchar(255) NOT NULL,
  `tg_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`tg_id`),
  UNIQUE KEY `UQ_training_groups_tg_training_name` (`tg_training_name`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of training_groups
-- ----------------------------
INSERT INTO `training_groups` VALUES ('1', 'php1', null);
INSERT INTO `training_groups` VALUES ('2', 'java1', null);
INSERT INTO `training_groups` VALUES ('68', 'asdas', '');
INSERT INTO `training_groups` VALUES ('69', 'asdsasda', 'asdsaasdas');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `u_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `u_login` varchar(100) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_first_name` varchar(255) NOT NULL,
  `u_patronymic` varchar(255) DEFAULT NULL,
  `u_last_name` varchar(255) NOT NULL,
  `u_long_auth` varchar(200) DEFAULT NULL,
  `u_password` varchar(100) NOT NULL,
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `UQ_users_u_email` (`u_email`),
  UNIQUE KEY `UQ_users_u_login` (`u_login`),
  UNIQUE KEY `UQ_users_u_long_auth` (`u_long_auth`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='User and information about user';

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('3', 'listener1', 'listener1@gmail.com', 'слушатель1', 'слушатель1', 'слушатель1', null, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a');
INSERT INTO `users` VALUES ('4', 'coach1', 'coach1@gmail.com', '', null, '', null, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a');
INSERT INTO `users` VALUES ('5', 'manager1', 'manager1@gmail.com', '', null, '', null, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a');
INSERT INTO `users` VALUES ('6', 'admin1', 'admin1@gmail.by', '', null, '', null, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a');
INSERT INTO `users` VALUES ('12', 'listener2', 'listener2@gmail.com', 'слушатель2', 'слушатель2', 'слушатель2', null, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a');
INSERT INTO `users` VALUES ('13', 'listener3', 'listener3@gmail.com', 'слушатель3', 'слушатель3', 'слушатель3', null, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a');
INSERT INTO `users` VALUES ('14', 'listener4', 'listener4@gmail.com', 'слушатель4', 'слушатель4', 'слушатель4', null, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a');
INSERT INTO `users` VALUES ('15', 'listener5', 'listener5@gmail.com', 'слушатель5', 'слушатель5', 'слушатель5', null, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a');
INSERT INTO `users` VALUES ('16', 'user1', 'user1@gmail.com', 'user1', 'user1', 'user1', null, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a');
INSERT INTO `users` VALUES ('17', 'jenia', 'jenia@gmail.com', '', null, '', null, '02ed8106ce00bb10a6e18f7c9afff99403ec9247');

-- ----------------------------
-- Table structure for `users_in_groups`
-- ----------------------------
DROP TABLE IF EXISTS `users_in_groups`;
CREATE TABLE `users_in_groups` (
  `uig_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uig_user` int(10) unsigned NOT NULL,
  `uig_group` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uig_id`),
  KEY `uig_group` (`uig_group`),
  KEY `uig_user` (`uig_user`),
  CONSTRAINT `FK_users_in_groups_training_groups` FOREIGN KEY (`uig_group`) REFERENCES `training_groups` (`tg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_users_in_groups_users` FOREIGN KEY (`uig_user`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_in_groups
-- ----------------------------
INSERT INTO `users_in_groups` VALUES ('1', '13', '1');
INSERT INTO `users_in_groups` VALUES ('6', '12', '1');
INSERT INTO `users_in_groups` VALUES ('7', '14', '1');

-- ----------------------------
-- Table structure for `users_roles`
-- ----------------------------
DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE `users_roles` (
  `ur_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ur_user` int(10) unsigned NOT NULL,
  `ur_role` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ur_id`),
  KEY `ur_role` (`ur_role`),
  KEY `ur_user` (`ur_user`),
  CONSTRAINT `FK_users_roles_roles_of_users` FOREIGN KEY (`ur_role`) REFERENCES `roles_of_users` (`rou_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_users_roles_users` FOREIGN KEY (`ur_user`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users_roles
-- ----------------------------
INSERT INTO `users_roles` VALUES ('1', '4', '2');
INSERT INTO `users_roles` VALUES ('2', '5', '3');
INSERT INTO `users_roles` VALUES ('3', '6', '4');
INSERT INTO `users_roles` VALUES ('4', '3', '1');
INSERT INTO `users_roles` VALUES ('5', '12', '1');
INSERT INTO `users_roles` VALUES ('7', '14', '1');
INSERT INTO `users_roles` VALUES ('8', '17', '2');
INSERT INTO `users_roles` VALUES ('9', '17', '3');
