<?php

class Controller_Main extends Controller
{
    function action_index(){
        $this->view->setTemplateName('main/index_view.tpl');
        $this->view->getFinalPage();
    }

    function action_registration(){
        $this->model = new Model_Main();
        // Ставим значения псевдопеременным пустыми
        $this->view->setPlaceholder('lf_message', '');
        $this->view->setPlaceholder('lf_email', '');
        $this->view->setPlaceholder('lf_login', '');
        // Если уже зарегистрирован и вошел под своим логином, то переадресуем в кабинет
        if(Auth::getInstance()->getUser()){
            $this->redirect('account');
        }

        $result = false;

        if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])){
            // Проверяем логин на корректность
            if($this->model->checkLogin($_POST['login'])){
                // Проверяем email на корректность
                if($this->model->checkEmail($_POST['email'])){
                    // Проверяем пароль, чтобы был более 6 символов
                    if(Check::checkPassword($_POST['password'])){
                        if($result['success'] = Auth::getInstance()->registration($_POST['login'], $_POST['password'], $_POST['email'])){
                            // Проверяем на длительную авторизацию
                            if(isset($_POST['long_auth']) && $_POST['long_auth'] == 1){
                                $remember = sha1(microtime(TRUE).$_POST['login'].mt_rand(1000, 999999));
                                if(Auth::getInstance()->setLongAuth($remember)){
                                    setcookie('long_auth', $remember, time()+1209600);
                                }
                            }
                            $_SESSION['logged_user'] = Auth::getInstance()->getUser();
                        }

                    }
                    else{
                        $this->view->setPlaceholder('lf_login', htmlentities($_POST['login']));
                        $this->view->setPlaceholder('lf_email', htmlentities($_POST['email']));
                        $this->view->setPlaceholder('lf_message', $this->view->config_object->getMessageById('msg_short_password'));
                    }

                }
                else{
                    $this->view->setPlaceholder('lf_login', htmlentities($_POST['login']));
                    $this->view->setPlaceholder('lf_message', $this->view->config_object->getMessageById('msg_wrong_email'));
                }
            }
            else{
                $this->view->setPlaceholder('lf_email', htmlentities($_POST['email']));
                $this->view->setPlaceholder('lf_message', $this->view->config_object->getMessageById('msg_wrong_login'));
            }
        }

        // Проверяем прошел регистрацию или нет и в зависимости от этого отправляем по разным url.
        if($result != false && $result['success'] === true){
            $this->redirect('account');
        }
        else{
            $this->view->setTemplateName('main/registration_view.tpl');
            $this->view->getFinalPage();
        }
    }

    function action_login(){
        $this->view->setPlaceholder('lf_message', '');
        $this->view->setPlaceholder('lf_login', '');

        // Проверяем на сущ-е логина и пароля в POST, а так же проверяем корректность логина
        if(isset($_POST['login']) && isset($_POST['password']) && Check::checkLogin($_POST['login'])){
            $remember = '';

            $auth = Auth::getInstance();
            // Проверяем корректность пароля и есть ли такой пользователь с эти логином и паролем
            if(Check::checkPassword($_POST['password']) && $auth->getAuthResult($_POST['login'], $_POST['password'])){
                // Проверяем на длительную авторизацию
                if(isset($_POST['long_auth']) && $_POST['long_auth'] == 1){
                    $remember = sha1(microtime(TRUE).$_POST['login'].mt_rand(1000, 999999));
                    if($auth->setLongAuth($remember)){
                        setcookie('long_auth', $remember, time()+1209600);
                    }
                }
                $_SESSION['logged_user'] = $auth->getUser();
            }
            else{

                $this->view->setPlaceholder('lf_message', $this->view->config_object->getMessageById('msg_wrong_password_or_username'));
                $this->view->setPlaceholder('lf_login', htmlentities($_POST['login']));
            }
        }

        if(Auth::getInstance()->getUser()){
            $this->redirect('account');
        }
        $this->view->setTemplateName('main/login_view.tpl');
        $this->view->getFinalPage();
    }

    function action_about(){
        $this->view->setTemplateName('main/about_view.tpl');
        $this->view->getFinalPage();
    }

    function action_contact(){
        $this->view->setTemplateName('main/contact_view.tpl');
        $this->view->getFinalPage();
    }

    function action_logout(){
        if(Auth::getInstance()->processLogout()){
            $this->redirect('main/login');
        }
        else{
            $this->redirect('main');
        }
    }
}
