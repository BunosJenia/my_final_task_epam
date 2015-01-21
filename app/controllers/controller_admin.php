<?php

class Controller_Admin extends Controller
{
    function __construct(){
        $this->model = new Model_Admin();
        $user = Auth::getInstance()->getUser();
        // Проверяем права, чтобы в нашу админку могли заходить пользователи только с определенными правами
        if($this->model->rightForAdmin($user, ADMIN_ROLE_ADMIN) || $this->model->rightForAdmin($user, ADMIN_ROLE_COACH)
            || $this->model->rightForAdmin($user, ADMIN_ROLE_MANAGER)){
            $this->view = new View();
            $this->view->setMainTemplate($_SERVER["DOCUMENT_ROOT"].'/app/views/admin/main_admin_template.tpl');
        }
        else{
            $this->redirect('main');
        }
    }

    function action_index(){
        $this->view->setTemplateName('admin/admin_view.tpl');
        $this->view->getFinalPage();
    }

    function action_tests(){
        if($this->model->rightForAdmin(Auth::getInstance()->getUser(), ADMIN_ROLE_ADMIN) || $this->model->rightForAdmin(Auth::getInstance()->getUser(), ADMIN_ROLE_MANAGER)){
            $this->view->setTemplateName('admin/admin_tests_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }

    function action_groups(){
        if($this->model->rightForAdmin(Auth::getInstance()->getUser(), ADMIN_ROLE_ADMIN) || $this->model->rightForAdmin(Auth::getInstance()->getUser(), ADMIN_ROLE_COACH)){
            $this->view->setTemplateName('admin/admin_groups_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }

    function action_error(){
        $this->view->setTemplateName('admin/admin_error_view.tpl');
        $this->view->getFinalPage();
    }
}