<?php

class Controller_Test extends Controller
{


    function __construct(){
        $this->model = new Model_Test();
        parent::__construct();
    }

    function action_index(){
        if(Auth::getInstance()->getUser()){
            if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_COACH)
                || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_MANAGER)){
                $this->view->setTemplateName('test/index_admin_view.tpl');
            }
            else{
                $this->view->setTemplateName('test/index_view.tpl');
            }
            $this->view->getFinalPage();
        }
        else{
            $this->view->setTemplateName('test/guest/guest_view.tpl');
            $this->view->getFinalPage();
        }
    }

    function action_statistics(){
        if(Auth::getInstance()->getUser()){
            if(Auth::getInstance()->rightForAdmin(ADMIN_ROLE_ADMIN) || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_COACH)
                || Auth::getInstance()->rightForAdmin(ADMIN_ROLE_MANAGER)){
                $this->view->setTemplateName('test/statistics_admin_view.tpl');
            }
            else{
                if((int)$this->params && !$this->model->checkTestForUser((int)$this->params)){
                    $this->view->setTemplateName('test/test_statistics.tpl');
                    $this->view->setPlaceholder('test_result', $this->model->setResult((int)$this->params));
                    $this->view->setPlaceholder('correct_answers', $this->model->countOfQuestions((int)$this->params));
                    $this->view->setPlaceholder('questions_count', $this->model->yourCountOfQuestions((int)$this->params));
                    $this->view->setPlaceholder('test_name', $this->model->getTestName((int)$this->params));
                }
                else{
                    $test_result = $this->model->setStatics($this->model->getEndedTests());
                    $this->view->setPlaceholder('tests', $test_result);
                    $this->view->setTemplateName('test/statistics_view.tpl');
                }

            }
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('test');
        }
    }
    //
    function action_new(){
        if(Auth::getInstance()->rightForAdmin(ROLE_LISTENER)){
            $test_result = $this->model->setTests($this->model->getNewTests());
            $this->view->setPlaceholder('tests', $test_result);
            $this->view->setTemplateName('test/new_test_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('test');
        }
    }

    //
    function action_not_completed(){
        if(Auth::getInstance()->rightForAdmin(ROLE_LISTENER)){
            $test_result = $this->model->setTests($this->model->setTestsNotCompleted());
            $this->view->setPlaceholder('tests', $test_result);
            $this->view->setTemplateName('test/not_completed_test_view.tpl');
            $this->view->getFinalPage();
        }
        else{
            $this->redirect('test');
        }
    }

    function action_testing(){
        if((int)$this->params && isset($_POST['answer']) && isset($_POST['question']) && !empty($_POST['answer'])){
            //TODO CHECK DATA
            $check = $this->model->logAnswer((int)$this->params, $_POST['question'], $_POST['answer']);
            if($this->model->testEnded((int)$this->params)){
                // Когда прошли все вопросы, выводим результат
                $this->view->setTemplateName('test/test_ended_view.tpl');
                $this->view->setPlaceholder('test_result', $this->model->setResult((int)$this->params));
                $this->view->setPlaceholder('correct_answers', $this->model->countOfQuestions((int)$this->params));
                $this->view->setPlaceholder('questions_count', $this->model->yourCountOfQuestions((int)$this->params));
                $this->view->setPlaceholder('test_name', $this->model->getTestName((int)$this->params));
                $this->view->getFinalPage();
                die;
            }
            $this->redirect(substr($_SERVER["REDIRECT_URL"], 1));
        }
        /*
         *  Делаем проверки:
         * - чтобы сущ-ал парамет(это id нашего теста)
         * - чтобы пользователю был доступен этот тест(этот тест добавлен в группу пользователя)
         * - чтобы пользователь полностью не проходил этот тест
         * */
        if((int)$this->params){
            if($this->model->checkTestForUser((int)$this->params)){
                if(Auth::getInstance()->rightForAdmin(ROLE_LISTENER)){
                    $test_info = $this->model->questionForUser((int)$this->params);


                    $this->view->setPlaceholder('questions_count', $this->model->countOfQuestionsInTest($this->params));
                    $this->view->setPlaceholder('answered_questions', $this->model->countOfAnsweredQuestionInTest($this->params)+1);
                    //----
                    $this->view->setPlaceholder('question_id', $test_info['question']['id']);
                    $this->view->setPlaceholder('test_question', $test_info['question']['name']);
                    $this->view->setPlaceholder('test_id', (int)$this->params);

                    $answer_result = $this->model->setAnswers($test_info['question']['type'], $test_info['answers']);

                    $this->view->setPlaceholder('answers', $answer_result);
                    $this->view->setPlaceholder('test_name', $this->model->getTestName((int)$this->params));


                    $this->view->setTemplateName('test/test_view.tpl');
                    $this->view->getFinalPage();
                }
                else{
                    $this->redirect('test');
                }
            }
            else{
                $this->redirect('test');
            }
        }
        else{
            $this->redirect('test');
        }

    }

    function action_test_for_guest(){

    }

}
