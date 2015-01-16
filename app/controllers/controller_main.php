<?php

class Controller_Main extends Controller
{
    function action_index(){
        $this->view->setTemplateName('main/index_view.tpl');
        $this->view->getFinalPage();
    }

    function action_registration(){
        $this->view->setTemplateName('main/registration_view.tpl');
        $this->view->getFinalPage();
    }

    function action_login(){
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