<?php

class Controller_Main extends Controller
{
    function action_index(){
        $this->view->setTemplateName('main/index_view.tpl');
        $this->view->getFinalPage();
    }

    function action_registration(){
        $this->model = new Model_Main();
        if(Auth::getInstance()->getUser()){
            $this->redirect('account');
        }

        $result = false;

        if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])){
            if($this->model->checkLogin($_POST['login'])){
                if($this->model->checkEmail($_POST['email'])){
                    $result['success'] = Auth::getInstance()->registration($_POST['login'], $_POST['password'], $_POST['email']);
                    $_SESSION['logged_user'] = &Auth::getInstance()->getUser();
                }
                else{
                    echo 'неверный email';
                }
            }
            else{
                echo 'неверный логин';
            }
        }

        if($result != false && $result['success'] === true){
            $this->view->setTemplateName('account/account_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->view->setTemplateName('main/registration_view.tpl');
            $this->view->getFinalPage();
        }
    }

    function action_login(){
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

}
