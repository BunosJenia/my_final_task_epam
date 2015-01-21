<?php

class Model_Main extends Model
{
    // функция для проверки не занятости email и login (при регистрации)
    function checkEmail($email){
        $r = $this->db_connection->executeQuery("SELECT *
                                                    FROM `users`
                                                    WHERE `u_email`=:email;",
            array(array(':email', $email)));
        if($r["rows"] === 1){
            return false;
        }
        else{
            return true;
        }
    }

    function checkLogin($login){
        $r = $this->db_connection->executeQuery("SELECT *
                                                    FROM `users`
                                                    WHERE `u_login`=:login;",
            array(array(':login', $login)));
        if($r["rows"] === 1){
            return false;
        }
        else{
            return true;
        }
    }

}
