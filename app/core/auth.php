<?php

class Auth
{
    private static $instance = null;
    private $user_id = false;

    // Реализуем паттерн одиночка
    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new Auth();
        }
        return self::$instance;
    }

    // Метод который вызываем при выходе.
    public function processLogout(){
        unset($_SESSION['logged_user']);
        setcookie('long_auth', '---', -1000);
        $this->user_id = false;
        if($this->user_id && $_SESSION['logged_user']){
            return false;
        }
        return true;
    }

    // Сеттер и геттер для св-ва идентификатора пользователя
    public function setUser($user_id){
        $this->user_id = $user_id;
    }
    public function getUser(){
        return $this->user_id;
    }

    // Метод, в котором проверяем на длительную авторизацию и возвращаем св-во user_id
    public function processLoginByCookie(){
        $r = DB::getInstance()->executeQuery("SELECT `u_id`
                                                    FROM `users`
                                                    WHERE `u_long_auth`=:cookie;",
            array(array(':cookie', $_COOKIE['long_auth'])));
        if($r["rows"] === 1){
            $this->user_id = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["u_id"];
            return $this->user_id;
        }
        else{
            return false;
        }
    }

    // Метод в котором проверяем есть ли пользователь с таким логином и паролем, если есть, то возвращаем св-во user_id
    public function getAuthResult($login, $password){
        $login = Check::checkLogin($login);

        if($login && Check::checkPassword($password)){
            $r = DB::getInstance()->executeQuery("SELECT `u_id`
                                                        FROM `users`
                                                        WHERE `u_login`=:login AND `u_password`=:password;",
                array(array(':login', $login), array(':password', sha1($password))));
            if ($r["rows"] === 1) {
                $this->user_id = $r["stmt"]->fetch(PDO::FETCH_ASSOC)["u_id"];
                return $this->user_id;
            } else {
                return false;
            }
        }
        else{
            return false;
        }
    }

    // Регистрируем нового пользователя
    public function registration($login, $password, $email){
        // Проверяем данные, если они не корректны, возвращаем false
        $login = Check::checkLogin($login);
        $email = Check::checkEmail($email);

        if($login && $email && Check::checkPassword($password)){
            $r = DB::getInstance()->executeQuery("INSERT INTO `users`(`u_login`, `u_password`, `u_email`)
                                                      VALUES (:login, :password, :email);",
                array(array(':login', $login), array(':password', sha1($password)), array(':email', $email)));
            if($r["rows"] === 1){
                $this->user_id = DB::getInstance()->lastInsertId();
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

    }

    public function setLongAuth($remember){
        $r = DB::getInstance()->executeQuery("UPDATE `users`
                                                SET `u_long_auth`=:u_long_auth
                                                WHERE `u_id`=:user_id;",
            array(array(':user_id', $this->user_id), array(':u_long_auth', $remember)));
        if ($r["rows"] === 1) {
            return true;
        }
        return false;
    }

    // Метод для проверки прав.
    public function rightForAdmin($role){
        $r = DB::getInstance()->executeQuery("SELECT `ur_user`
                                                    FROM `users_roles`
                                                    INNER JOIN `roles_of_users` ON `ur_role` = `rou_id`
                                                    WHERE `ur_user`=:user_id AND `rou_name`=:role;",
            array(array(':user_id', $this->user_id), array(':role',$role)));
        if($r["rows"] === 1){
            return true;
        }
        else{
            return false;
        }
    }

    private function __construct(){
    }
    private function __clone(){
    }
    private function __wakeup(){
    }
    public function __destruct(){
    }
}