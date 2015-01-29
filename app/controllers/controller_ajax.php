<?php

class Controller_Ajax extends Controller
{
    // Этот котролер используем для отправки ajax запросов со страницы администрации
    // В конструкторе создаем модель
    function __construct(){
        $this->model = new Model_Ajax();
    }

    function action_index(){
        $this->redirect('main');
    }

    // Методы которые достают информацию из БД
    // Достаем все подкатегории
    function action_subcategories(){
        echo json_encode($this->model->get_list_of_subcategories());
        die;
    }
    // Достаем все категории
    function action_category(){
        echo json_encode($this->model->get_list_of_categories());
        die;
    }
    // Достаем все вопросы
    function action_questions(){
        echo json_encode($this->model->get_list_of_questions());
        die;
    }
    // Достаем все группы
    function action_groups(){
        echo json_encode($this->model->get_list_of_groups());
        die;
    }

    // Добавляем новую подкатегорию/категорию
    function action_add_subcategory(){
        if(isset($_POST['category']) && isset($_POST['subcategory'])){
            try{
                if($this->model->add_new_subcategory($_POST['category'], $_POST['subcategory'])){
                    echo 'Subcategory add';
                }
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
        }
        die;
    }

    // Методы для страницы создания нового вопроса(Достаем типы вопросов и добавляем новый(вместе с ответами))
    function action_questions_types(){
        echo json_encode($this->model->get_list_of_questions_types());
        die;
    }
    function action_add_question(){
        if(isset($_POST['type']) && isset($_POST['question']) && isset($_POST['answers']) && isset($_POST['correctAnswers'])){
            try{
                if($this->model->add_new_question($_POST['type'], $_POST['question'], $_POST['answers'], $_POST['correctAnswers'])){
                    echo 'Test add';
                }
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
        }
        die;
    }

    // Методы для страницы Создания нового теста(Достаем подкатегори, вопросы из этой подкатегории и добавлеяем новый тест)
    function action_subcat_for_test(){
        if(isset($_POST['category'])){
            echo json_encode($this->model->find_subcategory($_POST['category']));
        }
        die;
    }
    function action_add_test(){
        if(isset($_POST['test_name']) && isset($_POST['category']) && isset($_POST['subcategory']) && isset($_POST['questions'])){
            try{
                if($this->model->add_new_test($_POST['test_name'], $_POST['category'], $_POST['subcategory'], $_POST['questions'])){
                    echo 'Test add';
                }
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
        }
        die;
    }
    function action_questions_to_test(){
        if(isset($_POST['category']) && isset($_POST['subcategory'])){
            echo json_encode($this->model->get_list_of_questions_to_test($_POST['category'], $_POST['subcategory']));
            die;
        }
    }


    // Методы для страницы Добавления тестов в группы(Достаем тест, группы и добавляем тест в группу)
    function action_test_for_group(){
        if(isset($_POST['group'])){
            echo json_encode($this->model->get_list_of_groups());
            die;
        }
        elseif(isset($_POST['tests'])){
            echo json_encode($this->model->get_list_of_tests());
            die;
        }

    }
    function action_add_test_to_group(){
        if(isset($_POST['test']) && isset($_POST['group'])){
            try{
                if($this->model->add_test_to_group($_POST['group'], $_POST['test'])){
                    echo 'Test add to group';
                }
                else{
                    echo 'This group has this test yet';
                }
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
        }
        die;
    }

    // Методы для страницы Добавления группы(Достаем группы и добавляем новую)
    function action_add_group(){
        if(isset($_POST['group_name']) && isset($_POST['group_description'])){
            try{
                if($this->model->add_new_group($_POST['group_name'], $_POST['group_description'])){
                    echo 'Group add';
                }
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
        }
        die;
    }

    // Методы для страницы Добавления слушателей в группы
    // (Достаем слушателей(всех и которые не в группе),группы и добавляем слушателей в группу)
    function action_listeners_to_group(){
        if(isset($_POST['group'])){
            echo json_encode($this->model->get_list_of_groups());
            die;
        }
        elseif(isset($_POST['listeners'])){
            echo json_encode($this->model->get_list_of_listeners());
            die;
        }
        elseif(isset($_POST['listener_n_group'])){
            echo json_encode($this->model->get_list_of_listeners('not_all'));
            die();
        }

    }
    function action_add_listener_to_group(){
        if(isset($_POST['group']) && isset($_POST['listener'])){
            try{
                if($this->model->add_listener_to_group($_POST['group'], $_POST['listener'])){
                    echo 'Listeners add to group';
                }
                else{
                    echo 'err';
                }
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
        }
        die;
    }

    // Для страницы добавления прав пользователям
    // Методы, которые достают права пользователей, пользователей и добавляют права пользователям.
    function action_roles_of_users(){
        echo json_encode($this->model->get_list_of_roles());
        die;
    }
    function action_users(){
        if(isset($_POST['users'])){
            if($_POST['users'] === 'all'){
                echo json_encode($this->model->get_list_of_users($_POST['users']));
            }
            elseif($_POST['users'] === 'not_all'){
                echo json_encode($this->model->get_list_of_users($_POST['users']));
            }
            die;
        }
    }
    function action_add_role_to_user(){
        if(isset($_POST['role']) && isset($_POST['user'])){
            try{
                if($this->model->add_role_to_user($_POST['role'], $_POST['user'])){
                    echo 'Roles added';
                }
                else{
                    echo 'err';
                }
            }
            catch (Exception $e){
                echo $e->getMessage();
            }
        }
        die;
    }

}