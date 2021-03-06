<?php

class Model_Ajax extends Model
{
    const CORRECT_ANSWER = 1;
    const TEST_DONE = 1;

    // Метод который достает данные(При введении параметров, производим выборку)
    public function get_list_of_questions(){
        $r = $this->db_connection->executeQuery("SELECT `q_id`, `q_name` FROM `questions`;");
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["q_id"]] = $data["q_name"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_questions_from_test($test_id){
        $r = $this->db_connection->executeQuery("SELECT `q_id`, `q_name` FROM `questions`
                                                  WHERE `q_id` IN(SELECT `qit_question`
                                                                  FROM `questions_in_test`
                                                                  WHERE `qit_test`=:test_id);",
            array(array(':test_id', (int)$test_id)));
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[] = array(
                    'question' => $data["q_name"],
                    'answers' => $this->getQuestionAnswers($data['q_id']),
                );
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_questions_to_test($category, $subcategory){
        $r = $this->db_connection->executeQuery("SELECT `q_id`, `q_name`
                                                  FROM `questions`
                                                  WHERE `q_id` IN (SELECT `qusc_qustion`
                                                                    FROM `qustion_category`
                                                                    WHERE `qusc_category` =
                                                                        (SELECT `coq_id`
                                                                          FROM `categories_of_questions`
                                                                          WHERE `coq_category`=:category
                                                                            AND `coq_subcategory`=:subcategory));",
            array(array(':category', $category), array(':subcategory', $subcategory)));
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["q_id"]] = $data["q_name"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_groups(){
        $r = $this->db_connection->executeQuery("SELECT `tg_training_name`, `tg_id` FROM `training_groups`;");
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["tg_id"]] = $data["tg_training_name"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_tests(){
        $r = $this->db_connection->executeQuery("SELECT `t_id`, `t_type` FROM `tests`;");
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["t_id"]] = $data["t_type"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_listeners($param = 'all'){
        if($param === 'not_all'){
            $r = $this->db_connection->executeQuery("SELECT `u_first_name`, `u_last_name`, `u_patronymic`, `u_id`, `tg_training_name`
                                                  FROM `users`
                                                  INNER JOIN `users_roles` ON `u_id` = `ur_user`
                                                  INNER JOIN `roles_of_users` ON `rou_id` = `ur_role`
                                                  LEFT JOIN `users_in_groups` ON `uig_user` = `u_id`
                                                  LEFT JOIN `training_groups` ON `uig_group` = `tg_id`
                                                  WHERE `rou_name` =:role AND `u_id` NOT IN(SELECT `uig_user`
                                                                                                    FROM `users_in_groups`);",
                array(array(':role', ROLE_LISTENER)));
        }
        else{
            $r = $this->db_connection->executeQuery("SELECT `u_first_name`, `u_last_name`, `u_patronymic`, `u_id`, `tg_training_name`
                                                  FROM `users`
                                                  INNER JOIN `users_roles` ON `u_id` = `ur_user`
                                                  INNER JOIN `roles_of_users` ON `rou_id` = `ur_role`
                                                  LEFT JOIN `users_in_groups` ON `uig_user` = `u_id`
                                                  LEFT JOIN `training_groups` ON `uig_group` = `tg_id`
                                                  WHERE `rou_name` =:role;",
                array(array(':role', ROLE_LISTENER)));
        }
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["u_id"]]['username'] = $data["u_last_name"].' '.$data["u_first_name"].' '.$data["u_patronymic"];
                if(!empty($data["tg_training_name"])){
                    $new_data[$data["u_id"]]['group'] = $data["tg_training_name"];
                }
                else{
                    $new_data[$data["u_id"]]['group'] = '';
                }
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_subcategories(){
        $r = $this->db_connection->executeQuery("SELECT `coq_id`, `coq_category`, `coq_subcategory`
                                                  FROM `categories_of_questions`
                                                  ORDER BY `coq_category`;");
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["coq_id"]]['category'] = $data["coq_category"];
                $new_data[$data["coq_id"]]['subcategory'] = $data["coq_subcategory"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_categories(){
        $r = $this->db_connection->executeQuery("SELECT DISTINCT (`coq_category`)
                                                  FROM `categories_of_questions`;");
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[] = $data["coq_category"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_questions_types(){
        $r = $this->db_connection->executeQuery("SELECT `qt_type_name`, `qt_id` FROM `questions_type`;");
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["qt_id"]] = $data["qt_type_name"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function find_subcategory($category){
        $r = $this->db_connection->executeQuery("SELECT `coq_id`, `coq_category`, `coq_subcategory`
                                                  FROM `categories_of_questions`
                                                  WHERE `coq_category`=:category;",
        array(array(':category', $category)));
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["coq_id"]] = $data["coq_subcategory"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_categories_to_questions(){
        $r = $this->db_connection->executeQuery("SELECT `coq_id`, `coq_category`, `coq_subcategory`
                                                  FROM `categories_of_questions`
                                                  ORDER BY `coq_category`, `coq_subcategory`;");
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[] = array(
                    'id' => $data['coq_id'],
                    'category' => $data["coq_category"].' - '.$data["coq_subcategory"],
                );

            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    // Достаем все роли пользователей
    public function get_list_of_roles(){
        $r = $this->db_connection->executeQuery("SELECT `rou_name`, `rou_id` FROM `roles_of_users`;");
        if ($r["rows"] > 0) {
            while ($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)) {
                $new_data[$data["rou_id"]] = $data["rou_name"];
            }
            return $new_data;
        } else {

        }
    }
    public function get_list_of_users($param){
        if($param === 'not_all'){
            $r = $this->db_connection->executeQuery("SELECT `u_first_name`, `u_last_name`, `u_patronymic`, `u_id`, `u_login`
                                                  FROM `users`
                                                  WHERE `u_id` NOT IN(SELECT `ur_user`
                                                                        FROM `users_roles`);");
        }
        else{
            $r = $this->db_connection->executeQuery("SELECT `u_first_name`, `u_last_name`, `u_patronymic`, `u_id`, `u_login`, `rou_name`
                                                      FROM `users`
                                                      LEFT JOIN `users_roles` ON `ur_user` = `u_id`
                                                      LEFT JOIN `roles_of_users` ON `rou_id` = `ur_role`;");
        }
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["u_id"]]['fio'] = $data["u_last_name"].' '.$data["u_first_name"].' '.$data["u_patronymic"];
                $new_data[$data["u_id"]]['login'] = $data["u_login"];
                if(isset($data["rou_name"])){
                    $new_data[$data["u_id"]]['role'] = $data["rou_name"];
                }
                else{
                    $new_data[$data["u_id"]]['role'] = '';
                }
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_questions_in_category($category){
        $r = $this->db_connection->executeQuery("SELECT `q_id`, `q_name`
                                                  FROM `questions`
                                                  WHERE `q_id` IN (SELECT `qusc_qustion`
                                                                    FROM `qustion_category`
                                                                    WHERE `qusc_category` =:category);",
            array(array(':category', $category)));
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["q_id"]] = $data["q_name"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function get_list_of_user_from_group($group_id){
        $r = $this->db_connection->executeQuery("SELECT `u_first_name`, `u_last_name`, `u_patronymic`, `u_id`
                                                  FROM `users`
                                                  WHERE `u_id` IN (SELECT `uig_user`
                                                                    FROM `users_in_groups`
                                                                    WHERE `uig_group`=:group_id);",
            array(array(':group_id', $group_id)));
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[] = $data["u_last_name"].' '.$data["u_first_name"].' '.$data["u_patronymic"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }

    // Методы для добавления данных в БД
    public function add_new_question($type, $question, $answers, $correctAnswer){
        $r = DB::getInstance()->executeQuery("INSERT INTO `questions`(`q_type`, `q_name`)
                                                      VALUES (:type_id, :question);",
            array(array(':type_id', $type), array(':question', $question)));
        if($r["rows"] === 1){
            $question_id = DB::getInstance()->lastInsertId();
            foreach($answers AS $k => $v){
                $flag = false;
                foreach ($correctAnswer as $correct) {
                    if($k == $correct){
                        $flag = true;
                        break;
                    }
                }
                if($flag){
                    $r = DB::getInstance()->executeQuery("INSERT INTO `questions_answer`(`qa_question`, `qa_value`, `qa_correct`)
                                                  VALUES (:question_id, :answer, :correct);",
                        array(array(':question_id', $question_id), array(':answer', $v), array(':correct', Model_Ajax::CORRECT_ANSWER)));
                    if($r["rows"] === 1){
                        continue;
                    }
                    else{
                        return false;
                    }
                }
                elseif(!empty($v)){
                    $r = DB::getInstance()->executeQuery("INSERT INTO `questions_answer`(`qa_question`, `qa_value`)
                                                  VALUES (:question_id, :answer);",
                        array(array(':question_id', $question_id), array(':answer', $v)));
                    if($r["rows"] === 1){
                        continue;
                    }
                    else{
                        return false;
                    }
                }
            }
            return true;
        }
    }
    public function add_new_group($group_name, $group_description){
        $r = DB::getInstance()->executeQuery("INSERT INTO `training_groups`(`tg_training_name`, `tg_description`)
                                                      VALUES (:group_name, :group_description);",
            array(array(':group_name', $group_name), array(':group_description', $group_description)));
        if($r["rows"] === 1){
            return true;
        }
    }
    public function add_new_subcategory($category, $subcategory){
        $r = DB::getInstance()->executeQuery("INSERT INTO `categories_of_questions`(`coq_category`, `coq_subcategory`)
                                                      VALUES (:category, :subcategory);",
            array(array(':category', $category), array(':subcategory', $subcategory)));
        if($r["rows"] === 1){
            return true;
        }
    }
    public function add_new_test($test_name, $category, $subcategory, $questions){
        $r = DB::getInstance()->executeQuery("INSERT INTO `tests`(`t_type`, `t_category`)
                                                      SELECT :test_name, `coq_id`
                                                      FROM `categories_of_questions`
                                                      WHERE `coq_category`=:category AND `coq_subcategory`=:subcategory;",
            array(array(':test_name',$test_name), array(':category', $category), array(':subcategory', $subcategory)));
        if($r["rows"] === 1){
            $test_id = DB::getInstance()->lastInsertId();
            foreach($questions as $question){
                $r = DB::getInstance()->executeQuery("INSERT INTO `questions_in_test`(`qit_test`, `qit_question`)
                                                  VALUES (:test_id, :question);",
                    array(array(':question', $question), array(':test_id', $test_id)));
                if($r["rows"] === 1){
                    continue;
                }
                else{
                    return false;
                }
            }
            return true;
        }
    }
    public function add_test_to_group($group, $test){
        $r = DB::getInstance()->executeQuery("SELECT `tfg_id`
                                                  FROM `tests_for_groups`
                                                  WHERE `tfg_test`=:test AND `tfg_group`=:group_id;",
            array(array(':test', $test), array(':group_id', $group)));
        if($r["rows"] === 1){
            return false;
        }
        else{
            $r = DB::getInstance()->executeQuery("INSERT INTO `tests_for_groups`(`tfg_group`, `tfg_test`)
                                                      VALUES (:group_id, :test);",
                array(array(':test', $test), array(':group_id', $group)));
            if($r["rows"] === 1){
                return true;
            }
        }
    }
    public function add_listener_to_group($group, $listeners){
        foreach($listeners as $listener){
            $r = DB::getInstance()->executeQuery("INSERT INTO `users_in_groups`(`uig_user`, `uig_group`)
                                                  VALUES (:listener, :group_id);",
                array(array(':listener', $listener), array(':group_id', $group)));
            if($r["rows"] === 1){
                continue;
            }
            else{
                return false;
            }
        }
        return true;
    }
    public function delete_listener_to_group($group, $listeners){
        foreach($listeners as $listener){
            $r = DB::getInstance()->executeQuery("DELETE
                                                    FROM `users_in_groups`
                                                    WHERE `uig_user`=:listener AND `uig_group`=:group_id;",
                array(array(':listener', (int)$listener), array(':group_id', (int)$group)));
            if($r["rows"] === 1){
                continue;
            }
            else{
                return false;
            }
        }
        return true;
    }
    public function add_role_to_user($role, $users){
        foreach($users as $user){
            $r = DB::getInstance()->executeQuery("INSERT INTO `users_roles`(`ur_user`, `ur_role`)
                                                  VALUES (:user_id, :role);",
                array(array(':user_id', $user), array(':role', $role)));
            if($r["rows"] === 1){
                continue;
            }
            else{
                return false;
            }
        }
        return true;
    }
    public function add_category_to_questions($category, $questions){
        foreach($questions as $question){
            $r = DB::getInstance()->executeQuery("INSERT INTO `qustion_category`(`qusc_category`, `qusc_qustion`)
                                                  VALUES (:cat_id, :question_id);",
                array(array(':question_id', $question), array(':cat_id', $category)));
            if($r["rows"] === 1){
                continue;
            }
            else{
                return false;
            }
        }
        return true;
    }

    // Методы, которые достают информацию о прохождении тестов(общую)
    public function statistics_test(){
        $r = $this->db_connection->executeQuery("SELECT COUNT(`tpi_id`) AS `test_count`
                                                  FROM `test_passage_info`
                                                  WHERE `tpi_done`=:done;",
            array(array(':done', Model_Ajax::TEST_DONE)));
        if($r["rows"] === 1){
            return $r['stmt']->fetch(PDO::FETCH_ASSOC)["test_count"];
        }
        else{
            return false;
        }
    }
    public function statistics_questions(){
        $r = $this->db_connection->executeQuery("SELECT COUNT(`ql_id`) AS `ql_count`
                                                  FROM `questions_log`;");
        if($r["rows"] === 1){
            return $r['stmt']->fetch(PDO::FETCH_ASSOC)["ql_count"];
        }
        else{
            return false;
        }
    }
    public function statistics_correct_questions(){
        $r = $this->db_connection->executeQuery("SELECT COUNT(`ql_id`) AS `ql_count`
                                                  FROM `questions_log`
                                                  WHERE `ql_correct`=:correct;",
            array(array(':correct', Model_Ajax::CORRECT_ANSWER)));
        if($r["rows"] === 1){
            return $r['stmt']->fetch(PDO::FETCH_ASSOC)["ql_count"];
        }
        else{
            return false;
        }
    }
    public function correct_percentage(){
        $r = $this->db_connection->executeQuery("SELECT COUNT(`ql_id`) AS `ql_count`
                                                  FROM `questions_log`
                                                  WHERE `ql_test_pass_info`;");
        if($r["rows"] === 1){
            $questions_count = $r['stmt']->fetch(PDO::FETCH_ASSOC)["ql_count"];
        }
        else{
            return false;
        }
        $r = $this->db_connection->executeQuery("SELECT COUNT(`ql_id`) AS `ql_count`
                                                  FROM `questions_log`
                                                  WHERE `ql_correct`=:correct;",
            array(array(':correct', Model_Ajax::CORRECT_ANSWER)));
        if($r["rows"] === 1){
            $correct_questions_count = $r['stmt']->fetch(PDO::FETCH_ASSOC)["ql_count"];
        }
        else{
            return false;
        }
        if($correct_questions_count && $questions_count){
            return round($correct_questions_count * 100 / $questions_count);
        }
    }

    // Методы, которые достают информацию о прохождении тестов(по группе)
    public function group_statistics($group_id){
        $r = $this->db_connection->executeQuery("SELECT COUNT(`uig_user`) AS `user_count`
                                                  FROM `users_in_groups`
                                                  WHERE `uig_group`=:group_id;",
            array(array(':group_id', (int)$group_id)));
        if($r["rows"] === 1){
            return $r['stmt']->fetch(PDO::FETCH_ASSOC)["user_count"];
        }
        else{
            return false;
        }
    }
    public function question_group_statistics($group_id){
        $r = $this->db_connection->executeQuery("SELECT COUNT(`tpi_id`) AS `test_count`
                                                  FROM `test_passage_info`
                                                  WHERE `tpi_user` IN (SELECT `uig_user`
                                                                        FROM `users_in_groups`
                                                                        WHERE `uig_group`=:group_id);",
            array(array(':group_id', (int)$group_id)));
        if($r["rows"] === 1){
            return $r['stmt']->fetch(PDO::FETCH_ASSOC)["test_count"];
        }
        else{
            return false;
        }
    }
    public function group_correct_percentage($group_id){
        $r = $this->db_connection->executeQuery("SELECT COUNT(`ql_id`) AS `ql_count`
                                                  FROM `questions_log`
                                                  WHERE `ql_test_pass_info`
                                                          IN (SELECT `tpi_id`
                                                                  FROM `test_passage_info`
                                                                  WHERE `tpi_user` IN (SELECT `uig_user`
                                                                        FROM `users_in_groups`
                                                                        WHERE `uig_group`=:group_id));",
            array(array(':group_id', (int)$group_id)));
        if($r["rows"] === 1){
            $questions_count = $r['stmt']->fetch(PDO::FETCH_ASSOC)["ql_count"];
        }
        else{
            return false;
        }
        $r = $this->db_connection->executeQuery("SELECT COUNT(`ql_id`) AS `ql_count`
                                                  FROM `questions_log`
                                                  WHERE `ql_correct`=:correct AND
                                                  `ql_test_pass_info` IN (SELECT `tpi_id`
                                                                          FROM `test_passage_info`
                                                                          WHERE `tpi_user` IN (SELECT `uig_user`
                                                                                FROM `users_in_groups`
                                                                                WHERE `uig_group`=:group_id));",
            array(array(':group_id', (int)$group_id), array(':correct', Model_Ajax::CORRECT_ANSWER)));
        if($r["rows"] === 1){
            $correct_questions_count = $r['stmt']->fetch(PDO::FETCH_ASSOC)["ql_count"];
        }
        else{
            return false;
        }
        if($correct_questions_count && $questions_count){
            return round($correct_questions_count * 100 / $questions_count);
        }
    }

    // Методы, которые достают информацию о прохождении тестов(по пользователю)
    public function user_statistics_users($group_id){

        $r = $this->db_connection->executeQuery("SELECT `u_first_name`, `u_last_name`, `u_patronymic`, `u_id`, `u_login`
                                                  FROM `users`
                                                  WHERE `u_id` IN (SELECT `uig_user`
                                                                    FROM `users_in_groups`
                                                                    WHERE `uig_group`=:group_id);",
            array(array(':group_id', $group_id)));

        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["u_id"]]= $data["u_last_name"].' '.$data["u_first_name"].' '.$data["u_patronymic"].'('.$data["u_login"].')';
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    public function user_statistics_tests($user){
        $r = $this->db_connection->executeQuery("SELECT `tpi_id`, `t_type`
                                                FROM `test_passage_info`
                                                INNER JOIN `tests` ON `tpi_test` = `t_id`
                                                WHERE `tpi_user`=:user_id AND `tpi_done`=:done;",
            array(array(':user_id', $user), array(':done', Model_Ajax::TEST_DONE)));
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["tpi_id"]]= $data["t_type"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }
    // Достаем информацию о прохождении теста пользователем
    public function test_result($tpi_id){
        //echo 1;die;
        // Достаем идентификаторы вопросов и составляем массив
        $r = DB::getInstance()->executeQuery("SELECT `ql_question`, `ql_correct`, `ql_id`
                                                    FROM `questions_log`
                                                    WHERE `ql_test_pass_info`=:tpi_id;",
            array(array(':tpi_id', (int)$tpi_id)));
        if ($r["rows"] > 0){
            $ouptput = array();
            $i = 0;
            while($questin_id = $r["stmt"]->fetch(PDO::FETCH_ASSOC)){

                if($questin_id['ql_correct'] == 1){
                    $questin_id['ql_correct'] = 'Правильно';
                }
                else{
                    $questin_id['ql_correct'] = 'Не правильно';
                }

                // Выходной массив, который мы подставляем вместо placeholder
                $ouptput[$i] = array(
                    'question' => $this->getQuestionInfo($questin_id['ql_question']),
                    'answers' => $this->getQuestionAnswers($questin_id['ql_question']),
                    'your_answers' => $this->getYourQuestionAnswers($questin_id['ql_id']),
                    'correct' => $questin_id['ql_correct'],
                );
                $i++;
            }
            return $ouptput;
        }
    }
    // Достает информацию о вопрос(тип, сам вопрос, идентификатор)
    private function getQuestionInfo($question_id){
        $outputData = array();
        $r = DB::getInstance()->executeQuery("SELECT `q_type`, `q_name`
                                                    FROM `questions`
                                                    WHERE `q_id`=:question_id;",
            array(array(':question_id', (int)$question_id)));
        if ($r["rows"] === 1){
            $data = $r["stmt"]->fetch(PDO::FETCH_ASSOC);
            $outputData['type'] = $data['q_type'];
            $outputData['name'] = $data['q_name'];
            return $outputData;
        }
        return false;
    }
    // Достаем все ответы
    private function getQuestionAnswers($question_id){
        $outputData = array();
        $r = DB::getInstance()->executeQuery("SELECT `qa_value`, `qa_correct`
                                                    FROM `questions_answer`
                                                    WHERE `qa_question`=:question_id;",
            array(array(':question_id', (int)$question_id)));
        if ($r["rows"] > 1){
            while($data = $r["stmt"]->fetch(PDO::FETCH_ASSOC)){
                $outputData[] = array(
                    'value' => $data['qa_value'],
                    'correct' => $data['qa_correct']
                );
            }
            // Перемешиваем наш массив ответов
            shuffle($outputData);
            return $outputData;
        }
        return false;
    }
    // Достаем ответы пользователя на вопрос.
    private function getYourQuestionAnswers($question_log_id){
        $outputData = array();
        $r = DB::getInstance()->executeQuery("SELECT `qal_value`
                                                    FROM `questions_answer_log`
                                                    WHERE `qal_qustion_log`=:question_id;",
            array(array(':question_id', (int)$question_log_id)));
        if ($r["rows"] > 0){
            while($data = $r["stmt"]->fetch(PDO::FETCH_ASSOC)){
                $outputData[] = array(
                    'value' => $data['qal_value']
                );
            }
            return $outputData;
        }
        return false;
    }

}