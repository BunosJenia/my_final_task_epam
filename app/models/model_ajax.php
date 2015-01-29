<?php

class Model_Ajax extends Model
{
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
            $r = $this->db_connection->executeQuery("SELECT `u_first_name`, `u_last_name`, `u_patronymic`, `u_id`
                                                  FROM `users`
                                                  INNER JOIN `users_roles` ON `u_id` = `ur_user`
                                                  INNER JOIN `roles_of_users` ON `rou_id` = `ur_role`
                                                  WHERE `rou_name` = 'listener' AND `u_id` NOT IN(SELECT `uig_user`
                                                                                                    FROM `users_in_groups`);");
        }
        else{
            $r = $this->db_connection->executeQuery("SELECT `u_first_name`, `u_last_name`, `u_patronymic`, `u_id`
                                                  FROM `users`
                                                  INNER JOIN `users_roles` ON `u_id` = `ur_user`
                                                  INNER JOIN `roles_of_users` ON `rou_id` = `ur_role`
                                                  WHERE `rou_name` = 'listener';");
        }
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["u_id"]]= $data["u_last_name"].' '.$data["u_first_name"].' '.$data["u_patronymic"];
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
            $r = $this->db_connection->executeQuery("SELECT `u_first_name`, `u_last_name`, `u_patronymic`, `u_id`, `u_login`
                                                  FROM `users`;");
        }
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[$data["u_id"]]['fio'] = $data["u_last_name"].' '.$data["u_first_name"].' '.$data["u_patronymic"];
                $new_data[$data["u_id"]]['login'] = $data["u_login"];
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
                                                  VALUES (:question_id, :answer, 1);",
                        array(array(':question_id', $question_id), array(':answer', $v)));
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

}