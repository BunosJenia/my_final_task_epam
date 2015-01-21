<?php

class Controller_Account extends Controller
{
    function __construct(){
        if(isset($_POST['login']) && isset($_POST['password'])){
            $auth = Auth::getInstance();
            if($auth->getAuthResult($_POST['login'], $_POST['password'])){
                $_SESSION['logged_user'] = &$auth->getUser();
            }
        }
        if(!Auth::getInstance()->getUser()){
            $this->redirect('main/login');
        }
        else{
            parent::__construct();
        }
    }

    function action_index(){
        $this->view->setTemplateName('account/account_view.tpl');
        $this->view->getFinalPage();
    }

}