<?php

class Model_Admin extends Model
{
    // Метод для проверки прав пользователя
    function rightForAdmin($user_id, $role){
        $r = $this->db_connection->executeQuery("SELECT `ur_user`
                                                    FROM `users_roles`
                                                    INNER JOIN `roles_of_users` ON `ur_role` = `rou_id`
                                                    WHERE `ur_user`=:user_id AND `rou_name`=:role;",
            array(array(':user_id', $user_id), array(':role',$role)));
        if($r["rows"] === 1){
            $this->user_id = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["u_id"];
            return true;
        }
        else{
            return false;
        }
    }

    // Метод который достает все вопросы
    function get_list_of_questions(){
        $r = $this->db_connection->executeQuery("SELECT `questions`.`q_name` FROM `questions`;");
        if($r["rows"] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $new_data[]=$data["q_name"];
            }
            return $new_data;
        }
        else{
            return false;
        }
    }


}
