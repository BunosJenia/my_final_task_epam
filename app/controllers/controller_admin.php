<?php

class Controller_Admin extends Controller
{
    function __construct(){
        $this->model = new Model_Admin();
        // Проверяем права, чтобы в нашу админку могли заходить пользователи только с определенными правами
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_COACH)
            || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_MANAGER)){
            $this->view = new View();
            $this->view->setMainTemplate($_SERVER["DOCUMENT_ROOT"].'/app/views/admin/main_admin_template.tpl');
        }
        else{
            $this->redirect('main');
        }
    }

    // Главная страница админки
    function action_index(){
        $this->view->setTemplateName('admin/admin_view.tpl');
        $this->view->getFinalPage();
    }
    // Страница где добавляем пользователям права, может заходить только админ
    function action_add_rights(){
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN)){
            $this->view->setTemplateName('admin/admin/add_rights_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }
    // Страница статистики
    function action_statistics(){
        $this->view->setTemplateName('admin/admin/statistics_view.tpl');
        $this->view->getFinalPage();
    }

    /*Станицы для менеджера*/
    // Основная страница
    function action_manager(){
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_MANAGER)){
            $this->view->setTemplateName('admin/admin_manager_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }
    // Добавление вопросов
    function action_add_question(){
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_MANAGER)){
            $this->view->setTemplateName('admin/manager/add_questions_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }
    // Создание тесто
    function action_add_test(){
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_MANAGER)){
            $this->view->setTemplateName('admin/manager/add_test_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }
    // Добавление категории и подкатегории
    function action_add_category(){
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_MANAGER)){
            $this->view->setTemplateName('admin/manager/add_category_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }

    /*Станицы для тренера*/
    // Основная
    function action_coach(){
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_COACH)){
            $this->view->setTemplateName('admin/admin_coach_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }
    // Создание группы
    function action_create_group(){
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_COACH)){
            $this->view->setTemplateName('admin/coach/new_group_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }
    // Добавление тестов в группу
    function action_add_test_to_group(){
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_COACH)){
            //$this->view->setPlaceholder('');
            $this->view->setTemplateName('admin/coach/add_test_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }
    // Страница, для добавления пользователей в группу
    function action_add_user_to_group(){
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_COACH)){
            $this->view->setTemplateName('admin/coach/add_user_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('admin/error');
        }
    }

    // Переадресуем на эту страницу, если нет прав(только менеджера или тренера)
    function action_error(){
        $this->view->setTemplateName('admin/admin_error_view.tpl');
        $this->view->getFinalPage();
    }
}