<?php

class Check
{
    public static function checkName($name){
        if(preg_match("/^[^\!\@\#\$\№\^\&\?\d]{2,}$/u", self::checkData($name)) === 1){
            return self::checkData($name);
        }
        else{
            return false;
        }
    }

    private static function checkData($name){
        return htmlspecialchars(trim($name));
    }

    public static function checkEmail($email){
        if(preg_match("/@/u", self::checkData($email)) === 1){
            return self::checkData($email);
        }
        else{
            return false;
        }
    }

    public static function checkLogin($login){
        if(preg_match("/[\w-]{4,}/u", self::checkData($login)) === 1){
            return self::checkData($login);
        }
        else{
            return false;
        }
    }
}