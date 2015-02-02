<?php

class Model_Account extends Model
{
    private $user_id;
    const TEST_DONE = 1;

    public function __construct(){
        $this->user_id = Auth::getInstance()->getUser();
    }

    public function getLastName(){
        $r = DB::getInstance()->executeQuery("SELECT `u_last_name`
                                                    FROM `users`
                                                    WHERE `u_id`=:user_id;",
            array(array(':user_id', $this->user_id)));
        if ($r["rows"] === 1){
            if($output = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["u_last_name"]){
                return $output;
            }
        }
        return false;
    }

    public function getFirstName(){
        $r = DB::getInstance()->executeQuery("SELECT `u_first_name`
                                                    FROM `users`
                                                    WHERE `u_id`=:user_id;",
            array(array(':user_id', $this->user_id)));
        if ($r["rows"] === 1) {
            if($output = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["u_first_name"]){
                return $output;
            }
        }
        return false;

    }

    public function getPatromynic(){
        $r = DB::getInstance()->executeQuery("SELECT `u_patronymic`
                                                    FROM `users`
                                                    WHERE `u_id`=:user_id;",
            array(array(':user_id', $this->user_id)));
        if ($r["rows"] === 1) {
            if($output = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["u_patronymic"]){
                return $output;
            }
        }
        return false;
    }

    public function getEmail(){
        $r = DB::getInstance()->executeQuery("SELECT `u_email`
                                                    FROM `users`
                                                    WHERE `u_id`=:user_id;",
            array(array(':user_id', $this->user_id)));
        if ($r["rows"] === 1){
            if($output = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["u_email"]){
                return $output;
            }
        }
        return false;
    }

    public function getGroup(){
        $r = DB::getInstance()->executeQuery("SELECT `tg_training_name`
                                                    FROM `training_groups`
                                                    INNER JOIN `users_in_groups` ON `tg_id` = `uig_group`
                                                    WHERE `uig_user`=:user_id;",
            array(array(':user_id', $this->user_id)));
        if ($r["rows"] === 1){
            if($output = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["tg_training_name"]){
                return $output;
            }
        }
        return false;
    }

    public function getCountOfListeners(){
        $r = DB::getInstance()->executeQuery("SELECT COUNT(`uig_user`) AS `user_count`
                                                    FROM `users_in_groups`
                                                    WHERE `uig_group` = (SELECT `uig_group`
                                                                          FROM `users_in_groups`
                                                                          WHERE `uig_user`=:user_id);",
            array(array(':user_id', $this->user_id)));
        if ($r["rows"] === 1){
            if($output = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["user_count"]){
                return $output;
            }
        }
        return false;
    }

    public function getCountEndedTests(){
        $r = DB::getInstance()->executeQuery("SELECT COUNT(`tpi_id`) AS `test_count`
                                                    FROM `test_passage_info`
                                                    WHERE `tpi_user`=:user_id
                                                    AND `tpi_done`=:test_done;",
            array(array(':user_id', $this->user_id), array(':test_done', Model_Account::TEST_DONE)));
        if ($r["rows"] === 1){
            return $output = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["test_count"];
        }
        return false;
    }

    public function getCountNotEndedTests(){
        $r = DB::getInstance()->executeQuery("SELECT COUNT(`tpi_id`) AS `test_count`
                                                    FROM `test_passage_info`
                                                    WHERE `tpi_user`=:user_id
                                                    AND `tpi_done`!=:test_done;",
            array(array(':user_id', $this->user_id), array(':test_done', Model_Account::TEST_DONE)));
        if ($r["rows"] === 1){
            return $output = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["test_count"];
        }
        return false;
    }

    public function getCountNewTests(){
        $r = DB::getInstance()->executeQuery("SELECT COUNT(`tfg_test`) AS `test_count`
                                                FROM `tests_for_groups`
                                                WHERE `tfg_group` = (SELECT `uig_group`
                                                                        FROM `users_in_groups`
                                                                        WHERE `uig_user`=:user_id)
                                                    AND `tfg_test` NOT IN(SELECT `tpi_test`
                                                                          FROM `test_passage_info`
                                                                          WHERE `tpi_user`=:user_id
                                                                          AND `tpi_test` IN(SELECT `tfg_test`
                                                                                              FROM `tests_for_groups`
                                                                                              WHERE `tfg_group` = (SELECT `uig_group`
                                                                                                                   FROM `users_in_groups`
                                                                                                                   WHERE `uig_user`=:user_id)
                                                                                                              ));",
            array(array(':user_id', $this->user_id)));
        if ($r["rows"] === 1){
            return $output = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["test_count"];
        }
        return false;
    }

    public function checkPassword($password){
        $r = DB::getInstance()->executeQuery("SELECT *
                                                    FROM `users`
                                                    WHERE `u_id`=:user_id AND `u_password`=:password;",
            array(array(':user_id', $this->user_id), array(':password', sha1($password))));
        if ($r["rows"] === 1) {
            return true;
        }
        return false;
    }

    public function changePass($password){
        $r = DB::getInstance()->executeQuery("UPDATE `users`
                                                SET `u_password`=:password
                                                WHERE `u_id`=:user_id;",
            array(array(':user_id', $this->user_id), array(':password', sha1($password))));
        if ($r["rows"] === 1) {
            return true;
        }
        return false;
    }

    public function changeName($last_name, $first_name, $patronymic){
        $last_name = Check::checkName($last_name);
        $first_name = Check::checkName($first_name);
        $patronymic = Check::checkName($patronymic);

        $r = DB::getInstance()->executeQuery("UPDATE `users`
                                                SET `u_last_name`=:last_name, `u_first_name`=:first_name, `u_patronymic`=:patronymic
                                                WHERE `u_id`=:user_id;",
            array(array(':user_id', $this->user_id), array(':last_name', $last_name),
                    array(':first_name', $first_name), array(':patronymic', $patronymic)));
        if ($r["rows"] === 1) {
            return true;
        }
        return false;
    }

    public function changeEmail($email){
        $email = Check::checkEmail($email);
        $r = DB::getInstance()->executeQuery("UPDATE `users`
                                                SET `u_email`=:email
                                                WHERE `u_id`=:user_id;",
            array(array(':user_id', $this->user_id), array(':email', $email)));
        if ($r["rows"] === 1) {
            return true;
        }
        return false;
    }

}