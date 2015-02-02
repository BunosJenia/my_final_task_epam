-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 02 2015 г., 11:34
-- Версия сервера: 5.5.40-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `final_bunos`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories_of_questions`
--

CREATE TABLE IF NOT EXISTS `categories_of_questions` (
  `coq_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `coq_category` varchar(255) NOT NULL,
  `coq_subcategory` varchar(255) NOT NULL,
  PRIMARY KEY (`coq_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table contains all pairs of categories and subcategories' AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `categories_of_questions`
--

INSERT INTO `categories_of_questions` (`coq_id`, `coq_category`, `coq_subcategory`) VALUES
(1, 'PHP', 'Основы'),
(2, 'PHP', 'Массивы'),
(3, 'PHP', 'ООП'),
(4, 'JAVA', 'Основы'),
(5, 'JAVA', 'ООП'),
(6, '.NET', 'Основы');

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `c_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_name` varchar(100) NOT NULL,
  `c_value` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `UQ_config_c_name` (`c_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Config information' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `guests`
--

CREATE TABLE IF NOT EXISTS `guests` (
  `g_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `g_key` varchar(255) NOT NULL,
  `g_test` int(10) unsigned NOT NULL,
  `g_description` varchar(1000) NOT NULL,
  PRIMARY KEY (`g_id`),
  UNIQUE KEY `UQ_guests_g_key` (`g_key`),
  KEY `g_test` (`g_test`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table store unique key for guest and test_id' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `label`
--

CREATE TABLE IF NOT EXISTS `label` (
  `l_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `l_name` varchar(100) NOT NULL,
  `l_value` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`l_id`),
  UNIQUE KEY `UQ_label_l_name` (`l_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Table, where we store all labels' AUTO_INCREMENT=169 ;

--
-- Дамп данных таблицы `label`
--

INSERT INTO `label` (`l_id`, `l_name`, `l_value`) VALUES
(1, 'title_general', 'Mega Task - Bunos - EPAM'),
(2, 'title_admin', 'Mega Task - Bunos - EPAM - Admin room'),
(3, 'url_main', 'ГЛАВНАЯ'),
(4, 'url_account', 'КАБИНЕТ'),
(5, 'url_tests', 'ТЕСТЫ'),
(6, 'url_about', 'О НАС'),
(7, 'url_contacts', 'КОНТАКТЫ'),
(8, 'url_admin', 'ADMIN'),
(9, 'url_coach', 'COACH'),
(10, 'url_manager', 'MANAGER'),
(11, 'url_add_rights', 'Добавить пользователям права'),
(12, 'url_statistics', 'Статистика тестов'),
(13, 'url_create_group', 'Создание групп'),
(14, 'url_add_test_to_group', 'Назначение тестов'),
(15, 'url_add_user_to_group', 'Добавить слушателей в группу'),
(16, 'url_add_question', 'Добавить вопросы'),
(17, 'url_add_test', 'Создать новый тест'),
(18, 'url_add_category', 'Добавить категорию и подкагеторию'),
(19, 'header_about', 'Обо мне'),
(20, 'header_contacts', 'Контакты'),
(21, 'header_main', 'Добро пожаловать!'),
(22, 'header_login', 'Войдите'),
(23, 'header_registration', 'Регистрация'),
(24, 'header_error', 'Ошибка 404(Страница не найдена)'),
(25, 'header_add_rights', 'Добавить пользователям права:'),
(26, 'header_add_user_to_group', 'Добавить слушателя в группу:'),
(27, 'header_add_group', 'Введите данные о новой группе:'),
(28, 'header_add_test_to_group', 'Добавить тест в группу:'),
(29, 'header_add_category', 'Добавить новую категорию:'),
(30, 'header_add_questions', 'Добавить вопрос:'),
(31, 'header_add_test', 'Создать новый тест:'),
(32, 'url_logout', 'Выйти'),
(33, 'text_error', 'Пожалуйста, проверьте правильность адреса или нажмите на любую ссылку снизу:'),
(34, 'label_guest_name', 'Ваше имя:'),
(35, 'label_guest_email', 'Ваша почта:'),
(36, 'label_guest_message', 'Ваше письмо:'),
(37, 'my_email', 'bunos.jenia@gmail.com'),
(38, 'my_phone', '(+375-29) 135-59-42'),
(39, 'email', 'email'),
(40, 'phone', 'phone'),
(41, 'label_login', 'Логин:'),
(42, 'label_password', 'Пароль:'),
(44, 'label_go', 'Войти'),
(45, 'label_email', 'Email:'),
(46, 'label_reg', 'Зарегистрироваться'),
(47, 'text_registration', 'Пожалуйста, заполняйте все поля. Все поля являются обязательными!'),
(48, 'my_name', 'JENIA BUNOS'),
(49, 'text_registration1', 'Не зарегистрированы?'),
(50, 'text_registration2', 'Преимущества получения статуса зарегистрированного пользователя:'),
(51, 'text_registration3', '- Возможность проходить тесты и видеть результат их прохождения!'),
(52, 'text_registration4', '- Получить доступ к статистике прохождения!'),
(53, 'url_text_registration', 'Зарегистрируйте новую учетную запись'),
(54, 'text_error_admin', 'You dont have enough rights!'),
(55, 'label_categories', 'Выберите существующую категорию:'),
(56, 'label_new_category', 'Введите новую категорию:'),
(57, 'label_new_subcategory', 'Введите новую подкатегорию:'),
(58, 'label_add', 'Добавить'),
(59, 'label_questions_types', 'Выберите тип вопроса:'),
(60, 'label_questions_text', 'Введите текст вопроса:'),
(61, 'label_test_category', 'Выберите категорию и подкатегорию теста:'),
(62, 'label_test_text', 'Введите название теста:'),
(63, 'label_add_test', 'Добавить тест'),
(64, 'label_group', 'Группа:'),
(65, 'label_test', 'Тест:'),
(66, 'label_add_user', 'Добавить слушателя'),
(67, 'label_all_user', 'Все слушатели'),
(68, 'label_user_in_group', 'Слушатели не в группе'),
(69, 'label_group_name', 'Название группы:'),
(70, 'label_group_description', 'Описание группы:'),
(71, 'label_add_group', 'Добавить группу'),
(72, 'label_all_groups', 'Просмотреть все группы'),
(73, 'label_all_users_role', 'Все польз-ли'),
(74, 'label_users_n_role', 'Польз-ли без прав'),
(75, 'label_roles', 'Права:'),
(76, 'label_add_roles', 'Добавить права'),
(77, 'footer_year', 'MMXV'),
(78, 'comma', ','),
(79, 'city', 'MINSK'),
(80, 'copy', '&copy'),
(81, 'footer_manuf', 'MANF. BY'),
(82, 'for_epam', 'FOR EPAM'),
(83, 'label_sent', 'Отправить'),
(84, 'url_account_statistics', 'Результаты прохождения тестов'),
(86, 'url_account_settings', 'Настройки'),
(87, 'url_adminroom', 'Админка'),
(88, 'url_account_group', 'Группа'),
(89, 'label_user_last_name', 'Фамилия:'),
(90, 'label_user_first_name', 'Имя:'),
(92, 'label_change', 'изменить'),
(93, 'label_user_patronymic', 'Отчество:'),
(94, 'label_user_password', 'Старый пароль:'),
(95, 'label_user_new_password', 'Новый пароль:'),
(96, 'label_user_email', 'Email:'),
(97, 'url_delete_user_from_group', 'Удалить слушателей из группы'),
(98, 'header_delete_user_to_group', 'Удалить слушателя из группы'),
(99, 'label_delete_user', 'Удалить слушателя'),
(100, 'header_statistics', 'Статистика'),
(101, 'choose_group', 'Выберите группу:'),
(102, 'header_user_statistics', 'Статистика выполнения тестов пользователей'),
(104, 'choose_user', 'Выберите пользователя:'),
(105, 'choose_test', 'Выберите тест:'),
(106, 'label_dot', '.'),
(107, 'header_add_category_to_question', 'Сопоставить вопрос с категорией и подкатегорией'),
(108, 'url_add_category_to_questions', 'Сопоставить вопрос с категорией/подкатегорией'),
(109, 'label_all_question', 'Все вопроcы'),
(110, 'url_category_to_questions', 'Просмотр вопросов по категориям'),
(111, 'header_category_to_question', 'Вопросы по категориям'),
(112, 'url_group_statistics', 'Просмотр выполнения тестов по группам'),
(113, 'url_user_statistics', 'Просмотр выполнения тестов по пользователям'),
(114, 'url_users_from_group', 'Просмотр пользователей по группам'),
(115, 'header_user_from_group', 'Пользователи по группам'),
(116, 'label_question_', 'Вопрос - '),
(117, 'label_question_answer_variants', 'Варианты ответов:'),
(118, 'label_question_result', 'Результат:'),
(119, 'label_question_your_variants', 'Вы ответили:'),
(121, 'url_stat', 'Статистика'),
(122, 'url_new_tests', 'Новые тест'),
(123, 'url_not_ended_tests', 'Незавершенные тесты'),
(124, 'header_room', 'Кабинет пользователя'),
(125, 'label_ypur_data', 'Ваши данные:'),
(126, 'label_surname', 'Фамилия:'),
(127, 'label_patronymic', 'Отчество:'),
(128, 'label_name', 'Имя:'),
(129, 'label_text_tests', 'Тесты:'),
(130, 'label_text_test_ended', 'Пройденных:'),
(131, 'label_text_not_ended_test', 'Не законченных:'),
(132, 'label_text_new_test', 'новых:'),
(133, 'header_group_info', 'Информация о группе:'),
(134, 'label_group_coach', 'Преподаватель:'),
(135, 'label_group_peple_count', 'Количество человек:'),
(136, 'header_settings', 'Настройки'),
(137, 'label_change_email', 'Изменить email:'),
(138, 'label_change_pass', 'Изменить пароль:'),
(139, 'label_change_name', 'Изменить ФИО:'),
(140, 'label_add_category', 'Добавить категорию'),
(141, 'label_all_subcategory', 'Все подкатегории'),
(142, 'label_remember', 'Запомнить '),
(143, 'label_text_test_for_everyone', 'TESTS for everyone'),
(144, 'label_text_mainpage1', 'Вы зашли на страничку экспериментального ПО '),
(145, 'label_text_mainpage2', 'Данное программное\r\n            средство призванно проводить входное, промежуточное и конечное тестирование слушателей RD-треннингов по различным дисциплинам\r\n            (например, "Программирование на PHP", "Тестирование ПО", "Фронт-енд разработка" и т.д.).'),
(146, 'label_text_mainpage3', 'Получите ключ уникальный ключ у администратора и возможность пройти тест.'),
(147, 'label_text_mainpage_pts', '"PHP Testing System"'),
(148, 'header_test_result', 'Результаты прохождения тестов'),
(149, 'header_testing', 'Тестирование'),
(150, 'text_testing1', 'На это странице вы можете:'),
(151, 'text_testing2', '-  просмотреть результаты прохождения ваших тестов.'),
(152, 'text_testing3', '-  пройти новый тест, который ваш тренер задал вашей группе.'),
(153, 'text_testing4', '-  продолжить прохождение теста, если вы его не прошли до  конца.'),
(154, 'header_new_test', 'Тесты которые вы не проходили'),
(155, 'header_not_ended_test', 'Тесты, которые вы прошли не доконца'),
(156, 'header_test_name', 'Тест -'),
(157, 'label_text_from', 'из'),
(158, 'label_text_question', 'Вопрос'),
(159, 'label_text_you_answered_on', 'Вы ответили на'),
(160, 'label_text_questions_dot', 'вопросов.'),
(161, 'header_test_complete', 'Тест'),
(162, 'header_test_made', 'пройден'),
(163, 'labe_go_away_from_test', 'Выйти из теста'),
(164, 'header_res_test', 'Результат тестa -'),
(165, 'header_questios_from_test', 'Вопросы тестов'),
(166, 'label_tests', 'Выберите тест:'),
(168, 'url_questions_from_test', 'Просмотр тестов');

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `m_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_name` varchar(100) NOT NULL,
  `m_value` varchar(1000) NOT NULL,
  PRIMARY KEY (`m_id`),
  UNIQUE KEY `UQ_message_m_name` (`m_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Table, where we store error messages' AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`m_id`, `m_name`, `m_value`) VALUES
(1, 'msg_wrong_email', 'Неверный email'),
(2, 'msg_wrong_login', 'Неверный логин'),
(3, 'msg_short_password', 'Слишком короткий пароль(должен быть 6 или более символов)'),
(4, 'msg_wrong_password_or_username', 'Неверный пароль или логин!'),
(5, 'msg_not_in_a_group', 'Вы не состоите ни в одной из групп'),
(6, 'msg_name_change', 'Имя изменено'),
(7, 'msg_not_correct_patronymic', 'Некорректная введено отчество!'),
(8, 'msg_not_correct_name', 'Некорректная введено имя!'),
(9, 'msg_not_correct_surname', 'Некорректная введена фамилия!'),
(10, 'msg_pass_changed', 'Пароль заменен'),
(11, 'msg_short_new_pass', 'Новый пароль слишком короткий'),
(12, 'msg_not_correct_pass', 'Неправильный пароль'),
(13, 'msg_email_changed', 'Email заменен'),
(14, 'msg_mot_correct_email', 'Email некорректен'),
(15, 'msg_mot_changed_email', 'По непонятным причинам Email не заменен, попробуйте позже');

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `q_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `q_type` int(10) unsigned NOT NULL,
  `q_name` varchar(1000) NOT NULL,
  `q_weight` int(11) NOT NULL,
  `q_time` int(11) NOT NULL,
  `q_picture_hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`q_id`),
  UNIQUE KEY `UQ_questions_q_picture_hash` (`q_picture_hash`),
  KEY `q_type` (`q_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='All info about questions' AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`q_id`, `q_type`, `q_name`, `q_weight`, `q_time`, `q_picture_hash`) VALUES
(1, 1, 'Сколько типов данных в PHP?', 0, 0, NULL),
(2, 2, 'Скалярные типы данных в PHP?', 0, 0, NULL),
(3, 2, 'Комплексные(составные) типы данных в PHP?', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `questions_answer`
--

CREATE TABLE IF NOT EXISTS `questions_answer` (
  `qa_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qa_question` int(10) unsigned NOT NULL,
  `qa_value` varchar(255) NOT NULL,
  `qa_correct` int(1) DEFAULT NULL,
  PRIMARY KEY (`qa_id`),
  KEY `qa_question` (`qa_question`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='All answers here, if answer is correct - pole qa_correct has - 1, else NULL' AUTO_INCREMENT=27 ;

--
-- Дамп данных таблицы `questions_answer`
--

INSERT INTO `questions_answer` (`qa_id`, `qa_question`, `qa_value`, `qa_correct`) VALUES
(1, 1, '8', 1),
(2, 1, '7', NULL),
(3, 1, '6', NULL),
(5, 1, '9', NULL),
(6, 1, '10', NULL),
(7, 2, 'boolen', 1),
(8, 2, 'integer', 1),
(9, 2, 'float', 1),
(10, 2, 'string', 1),
(11, 2, 'NULL', NULL),
(12, 3, 'array', 1),
(13, 3, 'object', 1),
(14, 3, 'string', NULL),
(15, 3, 'resource', NULL),
(16, 3, 'float', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `questions_answer_log`
--

CREATE TABLE IF NOT EXISTS `questions_answer_log` (
  `qal_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qal_answer` int(10) unsigned NOT NULL,
  `qal_qustion_log` int(10) unsigned NOT NULL,
  `qal_value` varchar(255) NOT NULL,
  PRIMARY KEY (`qal_id`),
  KEY `qal_answer` (`qal_answer`),
  KEY `qal_qustion_log` (`qal_qustion_log`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table contains all answers left from users and guests' AUTO_INCREMENT=125 ;

-- --------------------------------------------------------

--
-- Структура таблицы `questions_in_test`
--

CREATE TABLE IF NOT EXISTS `questions_in_test` (
  `qit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qit_test` int(10) unsigned NOT NULL,
  `qit_question` int(10) unsigned NOT NULL,
  PRIMARY KEY (`qit_id`),
  KEY `qit_question` (`qit_question`),
  KEY `qit_test` (`qit_test`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `questions_in_test`
--

INSERT INTO `questions_in_test` (`qit_id`, `qit_test`, `qit_question`) VALUES
(4, 4, 1),
(5, 4, 2),
(6, 4, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `questions_log`
--

CREATE TABLE IF NOT EXISTS `questions_log` (
  `ql_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ql_guest` int(10) unsigned DEFAULT NULL,
  `ql_test_pass_info` int(10) unsigned DEFAULT NULL,
  `ql_question` int(10) unsigned NOT NULL,
  `ql_time_sec` int(11) DEFAULT NULL,
  `ql_correct` int(1) DEFAULT NULL,
  `ql_skip` int(11) DEFAULT NULL,
  PRIMARY KEY (`ql_id`),
  KEY `ql_guest` (`ql_guest`),
  KEY `ql_question` (`ql_question`),
  KEY `ql_test_pass_info` (`ql_test_pass_info`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table contains log about questions, who answered(guest or user - only in 1 pole can be 1,in ql_guest or in ql_test_pass_info), time, correct answer or not' AUTO_INCREMENT=63 ;

-- --------------------------------------------------------

--
-- Структура таблицы `questions_type`
--

CREATE TABLE IF NOT EXISTS `questions_type` (
  `qt_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qt_type_name` varchar(255) NOT NULL,
  `qt_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`qt_id`),
  UNIQUE KEY `UQ_questions_type_qt_type_name` (`qt_type_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Types of questions and there descriptions' AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `questions_type`
--

INSERT INTO `questions_type` (`qt_id`, `qt_type_name`, `qt_description`) VALUES
(1, 'Вопрос с одним ответом', 'На выбор предлогается несколько ответов, только один из них правильный.'),
(2, 'Вопрос с несколькими ответами', 'На выбор предоставляется возможность отметить как правильные несколько ответов. В таких вопросах количество правильных ответов должно быть более одного, но менее общего количества возможных ответов.'),
(3, 'Вопрос на соответствие', 'Слушателю показаны два набора с текстовыми пунктами и/или картинками. Слушатель должен составить из них корректные пары.'),
(4, 'Вопрос на классификацию', 'Слушателю отображается две колонки. Первая из нихсодержит текстовые опции и/или картинки, вторая -  дроп-боксы с вариантами ответов. Правильных ответов может быть нескалько. в таком случае дроп-бокс заменяется на список с возможностью выбрать несколько пунктов.'),
(5, 'Вопрос на упорядочивание', 'Слушателю отображаются текстовые строки и/или картинки, размещённые в случайном порядке, слушатель должен выстроить их в верном порядке.'),
(6, 'Вопрос на заполнение', 'Слушателю отображается текст с пропущенными фрагментами. Слушатель должен их заполнить опираясь на собственные знания и/или подсказки. '),
(7, 'Вопрос со свободным ответом', 'Слушателю отображается вопрос(возможно, с картинкой) и поле для ввода текста. Ответ сохраняется и передается тренеру на проверку. Тренер может оценить правильность ответа в заранее определенном диапазоне баллов. В этом вопросе так же предполагается отдельное поле для хранения верного ответа.'),
(8, 'Вопрос с картинкой', 'Слушателю отображается картинка, он должен кликнуть по ней в одной или нескольких областях, отмечая верные ответы.'),
(9, 'Вопрос на перемещение врагментов', 'Слушателю отображается картинка с кодом, в которой пропущены некоторые области; он должен перетянуть в такие области соответствующие фрагменты кода.');

-- --------------------------------------------------------

--
-- Структура таблицы `qustion_category`
--

CREATE TABLE IF NOT EXISTS `qustion_category` (
  `qusc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qusc_qustion` int(10) unsigned NOT NULL,
  `qusc_category` int(10) unsigned NOT NULL,
  PRIMARY KEY (`qusc_id`),
  KEY `qusc_category` (`qusc_category`),
  KEY `qusc_qustion` (`qusc_qustion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `qustion_category`
--

INSERT INTO `qustion_category` (`qusc_id`, `qusc_qustion`, `qusc_category`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 2, 2),
(5, 3, 2),
(6, 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `roles_of_users`
--

CREATE TABLE IF NOT EXISTS `roles_of_users` (
  `rou_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rou_name` varchar(100) NOT NULL,
  `rou_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`rou_id`),
  UNIQUE KEY `UQ_roles_of_users_rou_name` (`rou_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Here all roles and description to this roles.' AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `roles_of_users`
--

INSERT INTO `roles_of_users` (`rou_id`, `rou_name`, `rou_description`) VALUES
(1, 'listener', 'Проходит тестирование по назначенным тестам.'),
(2, 'coach', 'Отвечает за создание в PTS групп слушателей, назначение группам слушателей тестов.'),
(3, 'RD-manager', 'Отвечает за создание в PTS направлений обучения и тестов.'),
(4, 'admin', 'Имеет право выполнять любые операции без каких бы то ни было ограничений.');

-- --------------------------------------------------------

--
-- Структура таблицы `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
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
  KEY `t_category` (`t_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tests`
--

INSERT INTO `tests` (`t_id`, `t_type`, `t_description`, `t_stop_prop`, `t_show_answers_in_end_prop`, `t_show_verdict_prop`, `t_show_answers_prop`, `t_show_mark`, `t_skip_qust`, `t_time`, `t_min_mark`, `t_category`) VALUES
(4, 'TEST_test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tests_for_groups`
--

CREATE TABLE IF NOT EXISTS `tests_for_groups` (
  `tfg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tfg_test` int(10) unsigned NOT NULL,
  `tfg_group` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tfg_id`),
  KEY `tfg_test` (`tfg_test`),
  KEY `tfg_group` (`tfg_group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tests_for_groups`
--

INSERT INTO `tests_for_groups` (`tfg_id`, `tfg_test`, `tfg_group`) VALUES
(1, 4, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `test_passage_info`
--

CREATE TABLE IF NOT EXISTS `test_passage_info` (
  `tpi_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tpi_user` int(10) unsigned NOT NULL,
  `tpi_test` int(10) unsigned NOT NULL,
  `tpi_mark` int(11) DEFAULT NULL,
  `tpi_percentage` int(11) DEFAULT NULL,
  `tpi_time_minut` int(11) DEFAULT NULL,
  `tpi_date` datetime DEFAULT NULL,
  `tpi_done` int(1) NOT NULL COMMENT 'Если тест пройдет, то значение должно быть 1',
  PRIMARY KEY (`tpi_id`),
  KEY `tpi_test` (`tpi_test`),
  KEY `tpi_user` (`tpi_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Test passage information, which contains: user, test, mark and etc.' AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Структура таблицы `training_groups`
--

CREATE TABLE IF NOT EXISTS `training_groups` (
  `tg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tg_training_name` varchar(255) NOT NULL,
  `tg_description` varchar(1000) DEFAULT NULL,
  `tg_coach` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tg_id`),
  UNIQUE KEY `UQ_training_groups_tg_training_name` (`tg_training_name`),
  KEY ```tg_coach``` (`tg_coach`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `training_groups`
--

INSERT INTO `training_groups` (`tg_id`, `tg_training_name`, `tg_description`, `tg_coach`) VALUES
(1, 'php1', NULL, 0),
(2, 'java1', NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='User and information about user' AUTO_INCREMENT=31 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`u_id`, `u_login`, `u_email`, `u_first_name`, `u_patronymic`, `u_last_name`, `u_long_auth`, `u_password`) VALUES
(3, 'listener1', 'listener1@gmail.com', 'Asdas', 'Федорович', 'О''Брауни', '3412145860fa2504e9fa8d8a0a7d3fe24ce97bb5', 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a'),
(4, 'coach1', 'coach1@gmail.com', '', NULL, '', NULL, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a'),
(5, 'manager1', 'manager1@gmail.com', '', NULL, '', NULL, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a'),
(6, 'admin1', 'admin1@gmail.by', '', NULL, '', 'ba36d5390856333942a5fc5003e2e1db119f0614', 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a'),
(12, 'listener2', 'listener2@gmail.com', 'слушатель2', 'слушатель2', 'слушатель2', NULL, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a'),
(13, 'listener3', 'listener3@gmail.com', 'слушатель3', 'слушатель3', 'слушатель3', NULL, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a'),
(14, 'listener4', 'listener4@gmail.com', 'слушатель4', 'слушатель4', 'слушатель4', NULL, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a'),
(15, 'listener5', 'listener5@gmail.com', 'слушатель5', 'слушатель5', 'слушатель5', NULL, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a'),
(16, 'user1', 'user1@gmail.com', 'user1', 'user1', 'user1', NULL, 'f0578f1e7174b1a41c4ea8c6e17f7a8a3b88c92a');

-- --------------------------------------------------------

--
-- Структура таблицы `users_in_groups`
--

CREATE TABLE IF NOT EXISTS `users_in_groups` (
  `uig_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uig_user` int(10) unsigned NOT NULL,
  `uig_group` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uig_id`),
  UNIQUE KEY `uig_user_2` (`uig_user`),
  KEY `uig_group` (`uig_group`),
  KEY `uig_user` (`uig_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `users_in_groups`
--

INSERT INTO `users_in_groups` (`uig_id`, `uig_user`, `uig_group`) VALUES
(6, 12, 1),
(9, 13, 1),
(10, 14, 1),
(20, 3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users_roles`
--

CREATE TABLE IF NOT EXISTS `users_roles` (
  `ur_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ur_user` int(10) unsigned NOT NULL,
  `ur_role` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ur_id`),
  KEY `ur_role` (`ur_role`),
  KEY `ur_user` (`ur_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `users_roles`
--

INSERT INTO `users_roles` (`ur_id`, `ur_user`, `ur_role`) VALUES
(1, 4, 2),
(2, 5, 3),
(3, 6, 4),
(4, 3, 1),
(5, 12, 1),
(7, 14, 1),
(10, 13, 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `guests`
--
ALTER TABLE `guests`
  ADD CONSTRAINT `FK_guests_Tests` FOREIGN KEY (`g_test`) REFERENCES `tests` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK_questions_questions_type` FOREIGN KEY (`q_type`) REFERENCES `questions_type` (`qt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions_answer`
--
ALTER TABLE `questions_answer`
  ADD CONSTRAINT `FK_questions_answer_questions` FOREIGN KEY (`qa_question`) REFERENCES `questions` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions_answer_log`
--
ALTER TABLE `questions_answer_log`
  ADD CONSTRAINT `FK_questions_answer_log_questions_answer` FOREIGN KEY (`qal_answer`) REFERENCES `questions_answer` (`qa_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_questions_answer_log_questions_log` FOREIGN KEY (`qal_qustion_log`) REFERENCES `questions_log` (`ql_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions_in_test`
--
ALTER TABLE `questions_in_test`
  ADD CONSTRAINT `FK_questions_in_test_questions` FOREIGN KEY (`qit_question`) REFERENCES `questions` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_questions_in_test_Tests` FOREIGN KEY (`qit_test`) REFERENCES `tests` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `questions_log`
--
ALTER TABLE `questions_log`
  ADD CONSTRAINT `FK_questions_log_guests` FOREIGN KEY (`ql_guest`) REFERENCES `guests` (`g_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_questions_log_questions` FOREIGN KEY (`ql_question`) REFERENCES `questions` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_questions_log_test_passage_info` FOREIGN KEY (`ql_test_pass_info`) REFERENCES `test_passage_info` (`tpi_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `qustion_category`
--
ALTER TABLE `qustion_category`
  ADD CONSTRAINT `FK_qustion_category_categories_of_questions` FOREIGN KEY (`qusc_category`) REFERENCES `categories_of_questions` (`coq_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_qustion_category_questions` FOREIGN KEY (`qusc_qustion`) REFERENCES `questions` (`q_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `FK_Tests_categories_of_questions` FOREIGN KEY (`t_category`) REFERENCES `categories_of_questions` (`coq_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tests_for_groups`
--
ALTER TABLE `tests_for_groups`
  ADD CONSTRAINT `FK_tests_for_groups_Tests` FOREIGN KEY (`tfg_test`) REFERENCES `tests` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_tests_for_groups_training_groups` FOREIGN KEY (`tfg_group`) REFERENCES `training_groups` (`tg_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `test_passage_info`
--
ALTER TABLE `test_passage_info`
  ADD CONSTRAINT `FK_test_passage_info_Tests` FOREIGN KEY (`tpi_test`) REFERENCES `tests` (`t_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_test_passage_info_users` FOREIGN KEY (`tpi_user`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_in_groups`
--
ALTER TABLE `users_in_groups`
  ADD CONSTRAINT `FK_users_in_groups_training_groups` FOREIGN KEY (`uig_group`) REFERENCES `training_groups` (`tg_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users_in_groups_users` FOREIGN KEY (`uig_user`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `FK_users_roles_roles_of_users` FOREIGN KEY (`ur_role`) REFERENCES `roles_of_users` (`rou_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users_roles_users` FOREIGN KEY (`ur_user`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
