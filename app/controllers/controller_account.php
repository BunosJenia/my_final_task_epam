<?php

class Controller_Account extends Controller
{
    function __construct(){
        $this->model = new Model_Account();
        if(Auth::getInstance()->getUser()){
            parent::__construct();
        }
        else{
            $this->redirect('main/login');
        }
    }

    function action_index(){
        if($data = $this->model->getLastName()){
            $this->view->setPlaceholder('us_last_name', $data);
        }
        else{
            $this->view->setPlaceholder('us_last_name', '');
        }
        if($data = $this->model->getFirstName()){
            $this->view->setPlaceholder('us_first_name', $data);
        }
        else{
            $this->view->setPlaceholder('us_first_name', '');
        }
        if($data = $this->model->getPatromynic()){
            $this->view->setPlaceholder('us_patronymic', $data);
        }
        else{
            $this->view->setPlaceholder('us_patronymic', '');
        }
        if($data = $this->model->getEmail()){
            $this->view->setPlaceholder('us_email', $data);
        }
        else{
            $this->view->setPlaceholder('us_email', '');
        }

        // Проверяем права, если пользователь имеет права выше чем слушатель, то запускаем другое представление
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_COACH)
            || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_MANAGER)){

            $this->view->setTemplateName('account/account_admin_view.tpl');
        }
        else{
            $this->view->setPlaceholder('c_test_ended', $this->model->getCountEndedTests());
            $this->view->setPlaceholder('c_test', $this->model->getCountNotEndedTests());
            $this->view->setPlaceholder('c_new_test', $this->model->getCountNewTests());
            if($this->model->getGroup()){
                $this->view->setPlaceholder('lf_message_not_in_group', '');
                $this->view->setPlaceholder('us_group', $this->model->getGroup());
            }
            else{
                $this->view->setPlaceholder('us_group', '');
                $this->view->setPlaceholder('lf_message_not_in_group', $this->view->config_object->getMessageById('msg_not_in_a_group'));
            }

            $this->view->setTemplateName('account/account_view.tpl');
        }
        $this->view->getFinalPage();
    }

    function action_group(){
        if(Auth::getInstance()->rightForAdmin(ROLE_LISTENER)){
            if($this->model->getGroup()){
                $this->view->setPlaceholder('lf_message_not_in_group', '');
                $this->view->setPlaceholder('us_group', $this->model->getGroup());
                $this->view->setPlaceholder('us_listeners_count', $this->model->getCountOfListeners());
            }
            else{
                $this->view->setPlaceholder('us_group', '');
                $this->view->setPlaceholder('us_listeners_count', '');
                $this->view->setPlaceholder('lf_message_not_in_group', $this->view->config_object->getMessageById('msg_not_in_a_group'));
            }

            $this->view->setTemplateName('account/group_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('account');
        }
    }

    function action_settings(){

        $this->view->setPlaceholder('lf_message_name', '');
        $this->view->setPlaceholder('lf_message_password', '');
        $this->view->setPlaceholder('lf_message_email', '');

        if(isset($_POST['user_last_name']) && isset($_POST['user_first_name']) && isset($_POST['user_patronymic'])){
            if(Check::checkName($_POST['user_last_name'])){
                if(Check::checkName($_POST['user_first_name'])){
                    if(Check::checkName($_POST['user_patronymic'])){
                        if($this->model->changeName($_POST['user_last_name'], $_POST['user_first_name'], $_POST['user_patronymic'])){
                            $this->view->setPlaceholder('lf_message_name', $this->view->config_object->getMessageById('msg_name_change'));
                        }
                    }
                    else{
                        $this->view->setPlaceholder('lf_message_name', $this->view->config_object->getMessageById('msg_not_correct_patronymic'));
                    }
                }
                else{
                    $this->view->setPlaceholder('lf_message_name', $this->view->config_object->getMessageById('msg_not_correct_name'));
                }
            }
            else{
                $this->view->setPlaceholder('lf_message_name', $this->view->config_object->getMessageById('msg_not_correct_surname'));
            }
        }

        if(isset($_POST['user_password']) && isset($_POST['user_new_password'])){
            if($this->model->checkPassword($_POST['user_password'])){
                if(Check::checkPassword($_POST['user_new_password'])){
                    if($this->model->changePass($_POST['user_new_password'])){
                        $this->view->setPlaceholder('lf_message_password', $this->view->config_object->getMessageById('msg_pass_changed'));
                    }
                }
                else{
                    $this->view->setPlaceholder('lf_message_password', $this->view->config_object->getMessageById('msg_short_new_pass'));
                }
            }
            else{
                $this->view->setPlaceholder('lf_message_password', $this->view->config_object->getMessageById('msg_not_correct_pass'));
            }
        }

        if(isset($_POST['user_email'])){
            if(Check::checkEmail($_POST['user_email'])){
                if($this->model->changeEmail($_POST['user_email'])){
                    $this->view->setPlaceholder('lf_message_email', $this->view->config_object->getMessageById('msg_email_changed'));
                }
                else{
                    $this->view->setPlaceholder('lf_message_email', $this->view->config_object->getMessageById('msg_mot_changed_email'));
                }
            }
            else{
                $this->view->setPlaceholder('lf_message_email', $this->view->config_object->getMessageById('msg_mot_correct_email'));
            }
        }

        $this->view->setPlaceholder('us_last_name', $this->model->getLastName());
        $this->view->setPlaceholder('us_first_name', $this->model->getFirstName());
        $this->view->setPlaceholder('us_patronymic', $this->model->getPatromynic());
        $this->view->setPlaceholder('us_email', $this->model->getEmail());
        if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_COACH)
            || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_MANAGER)){

            $this->view->setTemplateName('account/settings_admin_view.tpl');
        }
        else{
            $this->view->setTemplateName('account/settings_view.tpl');
        }
        $this->view->getFinalPage();
    }

}