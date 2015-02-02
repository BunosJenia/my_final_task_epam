<?php

class Model_Test extends Model
{

    const TEST_DONE = 1;
    const CORRECT_ANSWER = 1;

    // Функция, для проверки, проходил ли тест пользователь, если нет, то делаем запись в БД
    private function checkTestBegin($test_id){
        // Проверяем, начал ли проходить этот тест юзер
        $r = DB::getInstance()->executeQuery("SELECT `tpi_id`, `tpi_done`
                                                    FROM `test_passage_info`
                                                    WHERE `tpi_user`=:user_id
                                                    AND `tpi_test`=:test_id;",
            array(array(':test_id', (int)$test_id), array(':user_id', Auth::getInstance()->getUser())));
        if ($r["rows"] === 1){
            // Если он начал проходить, смотрим чтобы метка о выполнии не равнялась выполненому тесту!
            if($r["stmt"]->fetch(PDO::FETCH_ASSOC)['tpi_done'] == Model_Test::TEST_DONE){
                return false;
            }
        }
        else{
            // Если нет закиси в таблице, test_passage_info, создаем ее - это является показателем что пользователь начал выполнять этот тест.
            $r = DB::getInstance()->executeQuery("INSERT INTO `test_passage_info`(`tpi_user`, `tpi_test`)
                                                      VALUES (:user_id, :test_id);",
                array(array(':test_id', (int)$test_id), array(':user_id', Auth::getInstance()->getUser())));
        }
        return true;
    }

    // Делаем проверку, может ли пользователь пройти этот тест
    public function checkTestForUser($test_id){
        // Проверяем чтобы был доступен этот тест у пользователя
        $r = DB::getInstance()->executeQuery("SELECT `tfg_id`
                                                    FROM `tests_for_groups`
                                                    WHERE `tfg_test`=:test_id AND
                                                           `tfg_group` = (SELECT `uig_group`
                                                                            FROM `users_in_groups`
                                                                            WHERE `uig_user`=:user_id);",
            array(array(':test_id', (int)$test_id), array(':user_id', Auth::getInstance()->getUser())));
        if ($r["rows"] === 1){
            return $this->checkTestBegin($test_id);
        }
        return false;
    }

    // Достаем полную информацию о вопросе и передаем ее пользователю
    public function questionForUser($test_id){
        $outputData = array();
        $test_id = (int)$test_id;

        $r = DB::getInstance()->executeQuery("SELECT `qit_question`
                                                    FROM `questions_in_test`
                                                    WHERE `qit_test`=:test_id AND
                                                    `qit_question` NOT IN
                                                    (SELECT `ql_question`
                                                    FROM `questions_log`
                                                    WHERE `ql_test_pass_info` =
                                                    (SELECT `tpi_id`
                                                    FROM `test_passage_info`
                                                    WHERE `tpi_test`=:test_id AND `tpi_user`=:user_id));",
            array(array(':test_id', (int)$test_id), array(':user_id', Auth::getInstance()->getUser())));
        if ($r["rows"] > 0){
            $questin_id = $r["stmt"]->fetch(PDO::FETCH_ASSOC)['qit_question'];
            $outputData['question'] = $this->getQuestionInfo($questin_id);
            $outputData['question']['id'] = $questin_id;
            $outputData['answers'] = $this->getQuestionAnswers($questin_id);
            return $outputData;
        }
        return false;
    }

    // Достает информацию о вопрос(тип, сам вопрос, идентификатор)
    private function getQuestionInfo($question_id){
        $outputData = array();
        $r = DB::getInstance()->executeQuery("SELECT `q_type`, `q_name`
                                                    FROM `questions`
                                                    WHERE `q_id`=:question_id;",
            array(array(':question_id', (int)$question_id)));
        if ($r["rows"] === 1){
            $data = $r["stmt"]->fetch(PDO::FETCH_ASSOC);
            $outputData['type'] = $data['q_type'];
            $outputData['name'] = $data['q_name'];
            return $outputData;
        }
        return false;
    }

    // Достаем все ответы
    private function getQuestionAnswers($question_id){
        $outputData = array();
        $r = DB::getInstance()->executeQuery("SELECT `qa_value`, `qa_correct`
                                                    FROM `questions_answer`
                                                    WHERE `qa_question`=:question_id;",
            array(array(':question_id', (int)$question_id)));
        if ($r["rows"] > 1){
            while($data = $r["stmt"]->fetch(PDO::FETCH_ASSOC)){
                $outputData[] = array(
                    'value' => $data['qa_value'],
                    'correct' => $data['qa_correct']
                );
            }
            // Перемешиваем наш массив ответов
            shuffle($outputData);
            return $outputData;
        }
        return false;
    }

    // Достаем ответы пользователя на вопрос.
    private function getYourQuestionAnswers($question_log_id){
        $outputData = array();
        $r = DB::getInstance()->executeQuery("SELECT `qal_value`
                                                    FROM `questions_answer_log`
                                                    WHERE `qal_qustion_log`=:question_id;",
            array(array(':question_id', (int)$question_log_id)));
        if ($r["rows"] > 0){
            while($data = $r["stmt"]->fetch(PDO::FETCH_ASSOC)){
                $outputData[] = array(
                    'value' => $data['qal_value']
                );
            }
            // Перемешиваем наш массив ответов
            shuffle($outputData);
            return $outputData;
        }
        return false;
    }

    //
    private function getTestPassageInfoId($test_id){
        $r = DB::getInstance()->executeQuery("SELECT `tpi_id`
                                                    FROM `test_passage_info`
                                                    WHERE `tpi_user`=:user_id
                                                    AND `tpi_test`=:test_id;",
            array(array(':test_id', (int)$test_id),  array(':user_id', Auth::getInstance()->getUser())));
        if ($r["rows"] === 1){
            return $r["stmt"]->fetch(PDO::FETCH_ASSOC)['tpi_id'];
        }
        else{
            return false;
        }
    }

    // Делаем лог вопроса(указывает пользователя, вопрос и идентификатор на поле test_passage_info)
    private function setQuestionsLog($test_passage_info_id, $question_id, $correct){
        $r = DB::getInstance()->executeQuery("INSERT INTO `questions_log`(`ql_test_pass_info`, `ql_question`, `ql_correct`)
                                                      VALUES (:tpi_id, :question_id, :correct);",
            array(array(':tpi_id', (int)$test_passage_info_id), array(':question_id', (int)$question_id), array(':correct', $correct)));
        if($r["rows"] === 1) {
            return true;
        }
        return false;
    }

    // Делаем лог ответов на вопрос
    private function setQuestionsLogAnswers($question_log_id, $question_id, $answers){
        foreach ($answers as $answer){
            $r = DB::getInstance()->executeQuery("INSERT INTO `questions_answer_log`(`qal_value`, `qal_qustion_log`, `qal_answer`)
                                                      SELECT :answer, :question_log_id, `qa_id`
                                                      FROM `questions_answer`
                                                      WHERE `qa_question`=:question_id AND `qa_value`=:answer;",
                array(array(':question_log_id', (int)$question_log_id), array(':answer', $answer), array(':question_id', $question_id)));
            if($r["rows"] === 1){
                continue;
            }
            else{
                return false;
            }
        }
    }

    // Проверка, чтобы пользователь не ответил дважды на один и тот же вопрос в тесте
    private function NotRepeateToLog($tpi_id, $question_id){
        $r = DB::getInstance()->executeQuery("SELECT `ql_id`
                                                    FROM `questions_log`
                                                    WHERE `ql_test_pass_info`=:tpi_id
                                                    AND `ql_question`=:question_id;",
            array(array(':tpi_id', (int)$tpi_id),  array(':question_id', (int)$question_id)));
        if ($r["rows"] === 1){
            return true;
        }
        else{
            return false;
        }
    }
    // Делаем лог на ответы и вопрос
    public function logAnswer($test_id, $question_id, $answers){
        $test_passage_info_id = false;

        // Достаем идентификатор из таблицы информации о прохождении теста
        $test_passage_info_id = $this->getTestPassageInfoId((int)$test_id);

        //TODO Проверяем, отвечали на этот вопрос или нет(если да, то не делаем новую запись)
        if($this->NotRepeateToLog((int)$test_passage_info_id, (int)$question_id)){
            return false;
        }

        // Проверить ответы на правильные, если да, поставить метку что на вопрос ответили правильно
        $correct = $this->checkAnswers($question_id, $answers);

        // Проверяем на сущ-е переменной, если сущ-ет, то продолжаем
        if($test_passage_info_id){
            // Делаем инсерт в БД, указание что был прислан ответ на вопрос
            if($this->setQuestionsLog($test_passage_info_id, $question_id, $correct)){
                $question_log_id = DB::getInstance()->lastInsertId();
                // Делаем запись в БД(лог ответов на вопрос)
                if($this->setQuestionsLogAnswers($question_log_id, $question_id, $answers)){
                    return true;
                }
            }
        }
        return false;
    }

    // Проверяем массив ответов на правильность
    private function checkAnswers($question_id, $answers){
        $correct_answers = array();
        $r = DB::getInstance()->executeQuery("SELECT `qa_value`
                                                    FROM `questions_answer`
                                                    WHERE `qa_question`=:question_id
                                                    AND `qa_correct`=:correct;",
            array(array(':question_id', (int)$question_id), array(':correct', Model_Test::CORRECT_ANSWER)));
        if($r['rows'] > 0){
            while($data = $r['stmt']->fetch(PDO::FETCH_ASSOC)){
                $correct_answers[] = $data["qa_value"];
            }
        }

        $some_answers = array_intersect($correct_answers, $answers);
        if(count($some_answers) === count($correct_answers)){
            return Model_Test::CORRECT_ANSWER;
        }
        return false;
    }

    // Проверка, закончился ли тест, если да, то ставим метку в таблице test_passage_info
    public function testEnded($test_id){
        // Считаем  количество вопросов в тесте, на которое ответил пользователь
        $log_questions = $this->countOfAnsweredQuestionInTest((int)$test_id);
        // Количество вопросов в тесте
        $questions_in_test = $this->countOfQuestionsInTest((int)$test_id);

        if($log_questions === $questions_in_test && $questions_in_test !== false){
            $r = DB::getInstance()->executeQuery("UPDATE `test_passage_info`
                                                SET `tpi_done`=:done
                                                WHERE `tpi_user`=:user_id AND `tpi_test`=:test_id;",
                array(array(':user_id', Auth::getInstance()->getUser()), array(':done', Model_Test::TEST_DONE), array(':test_id', (int)$test_id)));
            if ($r["rows"] === 1) {
                return true;
            }
            return false;
        }
        return false;
    }

    // Считаем  количество вопросов в тесте, на которое ответил пользователь
    public function countOfAnsweredQuestionInTest($test_id){
        $r = DB::getInstance()->executeQuery("SELECT COUNT(`ql_id`) AS `log_count_of_question`
                                                    FROM `questions_log`
                                                    INNER JOIN `test_passage_info` ON `tpi_id` = `ql_test_pass_info`
                                                    WHERE `tpi_user`=:user_id
                                                    AND `tpi_test`=:test_id;",
            array(array(':test_id', (int)$test_id), array(':user_id', Auth::getInstance()->getUser())));
        if($r['rows'] === 1){
            return $r["stmt"]->fetch(PDO::FETCH_ASSOC)['log_count_of_question'];
        }
        return false;
    }

    // Количество вопросов в тесте
    public function countOfQuestionsInTest($test_id){
        $r = DB::getInstance()->executeQuery("SELECT COUNT(`qit_question`) AS `count_of_question`
                                                    FROM `questions_in_test`
                                                    WHERE `qit_test`=:test_id;",
            array(array(':test_id', (int)$test_id)));
        if($r['rows'] === 1){
            return $r["stmt"]->fetch(PDO::FETCH_ASSOC)['count_of_question'];
        }
        return false;
    }

    // Достаем массив идентификаторов тестов, которые пользователь еще не начинал проходить
    public function getNewTests(){
        $r = DB::getInstance()->executeQuery("SELECT `tfg_test`, `t_type`, `coq_category`, `coq_subcategory`
                                                FROM `tests_for_groups`
                                                INNER JOIN `tests` ON `tfg_test` = `t_id`
                                                INNER JOIN `categories_of_questions` ON `coq_id` = `t_category`
                                                WHERE `tfg_group` = (SELECT `uig_group`
                                                                        FROM `users_in_groups`
                                                                        WHERE `uig_user`=:user_id)
                                                    AND `tfg_test` NOT IN(SELECT `tpi_test`
                                                                          FROM `test_passage_info`
                                                                          WHERE `tpi_user`=:user_id
                                                                          AND `tpi_test` IN(SELECT `tfg_test`
                                                                                              FROM `tests_for_groups`
                                                                                              WHERE `tfg_group` = (SELECT `uig_group`
                                                                                                                   FROM `users_in_groups`
                                                                                                                   WHERE `uig_user`=:user_id)
                                                                                                              ));",
            array(array(':user_id', Auth::getInstance()->getUser())));
        if ($r["rows"] > 0){
            $output = array();
            $i = 0;
            while($data = $r["stmt"]->fetch(PDO::FETCH_ASSOC)){
                $output[$i]['test_id'] = $data["tfg_test"];
                $output[$i]['test_name'] = $data["t_type"];
                $output[$i]['test_category'] = $data["coq_category"];
                $output[$i]['test_subcategory'] = $data["coq_subcategory"];
                $i++;
            }
            return $output;
        }
        return false;
    }
    // Достаем массив идентификаторов тестов, которые пользователь прошел
    public function getEndedTests(){
        $r = DB::getInstance()->executeQuery("SELECT `tpi_test`, `t_type`, `coq_category`, `coq_subcategory`
                                                FROM `test_passage_info`
                                                INNER JOIN `tests` ON `tpi_test` = `t_id`
                                                INNER JOIN `categories_of_questions` ON `coq_id` = `t_category`
                                                WHERE `tpi_user`=:user_id AND `tpi_done`=:done;",
            array(array(':user_id', Auth::getInstance()->getUser()), array(':done', Model_Test::TEST_DONE)));
        if ($r["rows"] > 0){
            $output = array();
            $i = 0;
            while($data = $r["stmt"]->fetch(PDO::FETCH_ASSOC)){
                $output[$i]['test_id'] = $data["tpi_test"];
                $output[$i]['test_name'] = $data["t_type"];
                $output[$i]['test_category'] = $data["coq_category"];
                $output[$i]['test_subcategory'] = $data["coq_subcategory"];
                $i++;
            }
            return $output;
        }
        return false;
    }

    public function getTestName($test_id){
        // Проверяем чтобы был доступен этот тест у пользователя
        $r = DB::getInstance()->executeQuery("SELECT `t_type`
                                                    FROM `tests`
                                                    WHERE `t_id`=:test_id;",
            array(array(':test_id', (int)$test_id)));
        if ($r["rows"] === 1){
            return $r["stmt"]->fetch(PDO::FETCH_ASSOC)['t_type'];
        }
        return false;
    }

    // Достаем массив идентификаторов тестов, которые пользователь еще начинал проходить, но не прошел до конца
    public function setTestsNotCompleted(){
        $r = DB::getInstance()->executeQuery("SELECT `tpi_test`, `t_type`, `coq_category`, `coq_subcategory`
                                                    FROM `test_passage_info`
                                                    INNER JOIN `tests` ON `tpi_test` = `t_id`
                                                    INNER JOIN `categories_of_questions` ON `coq_id` = `t_category`
                                                    WHERE `tpi_user`=:user_id
                                                    AND `tpi_done`!=:test_done;",
            array(array(':user_id', Auth::getInstance()->getUser()), array(':test_done', Model_Test::TEST_DONE)));
        if ($r["rows"] > 0) {
            $output = array();
            $i = 0;
            while ($data = $r["stmt"]->fetch(PDO::FETCH_ASSOC)) {
                $output[$i]['test_id'] = $data["tpi_test"];
                $output[$i]['test_name'] = $data["t_type"];
                $output[$i]['test_category'] = $data["coq_category"];
                $output[$i]['test_subcategory'] = $data["coq_subcategory"];
                $i++;
            }
            return $output;
        }
        return false;
    }

    //
    public function setTests($tests){
        if(!is_array($tests)){
        return 'Нету тестов для прохождения!';
        }
        $file_path = $_SERVER["DOCUMENT_ROOT"].'/app/views/templates/test/tests_view.tpl';
        $result = '';
        $file = file_get_contents($file_path);

        foreach ($tests as $test){
            //var_dump($answer);die;
            $copy = $file;
            $copy = str_replace('{NAME}', $test['test_name'], $copy);
            $copy = str_replace('{ID}', $test['test_id'], $copy);
            $copy = str_replace('{CATEGORY}', $test['test_category'], $copy);
            $copy = str_replace('{SUBCATEGORY}', $test['test_subcategory'], $copy);
            $result .= $copy;
        }

        return $result;
    }
    public function setAnswers($question_type, $answers){
        $file_path = $_SERVER["DOCUMENT_ROOT"].'/app/views/templates/test/'.$question_type.'_view.tpl';
        $result = '';
        $file = file_get_contents($file_path);

        $i = 1;
        foreach ($answers as $answer){
            //var_dump($answer);die;
            $copy = $file;
            $copy = str_replace('{ANSWER}', $answer['value'], $copy);
            $copy = str_replace('{NUMBER}', $i.'.', $copy);
            $result .= $copy;
            $i++;
        }

        return $result;
    }
    public function setStatics($tests){
        if(!is_array($tests)){
            return 'Вы не прошли ни один тест!';
        }
        $file_path = $_SERVER["DOCUMENT_ROOT"].'/app/views/templates/test/statistics_view.tpl';
        $result = '';
        $file = file_get_contents($file_path);

        foreach ($tests as $test){
            //var_dump($answer);die;
            $copy = $file;
            $copy = str_replace('{NAME}', $test['test_name'], $copy);
            $copy = str_replace('{ID}', $test['test_id'], $copy);
            $copy = str_replace('{CATEGORY}', $test['test_category'], $copy);
            $copy = str_replace('{SUBCATEGORY}', $test['test_subcategory'], $copy);
            $result .= $copy;
        }

        return $result;
    }

    // Формируем выходную строку для Результата теста
    public function setResult($test_id){

        if($test_result = $this->getResult((int)$test_id)){
            // Достаем вопросы и их параметры, вместе с ответами
            $file_path = $_SERVER["DOCUMENT_ROOT"].'/app/views/templates/test/test_result_view.tpl';
            $result = '';
            $file = file_get_contents($file_path);

            $i = 1;
            foreach ($test_result as $test){
                //echo '<pre>';
                //var_dump($this->setAnswersForStatics('answers.tpl' ,$test['your_answers']));die;
                $copy = $file;
                $copy = str_replace('{QUESTION_NUMBER}', $i, $copy);
                $copy = str_replace('{QUESTION}', $test['question']['name'], $copy);
                $copy = str_replace('{ANSWERS}', $this->setAnswersForStatics('answers.tpl' ,$test['answers']), $copy);
                $copy = str_replace('{YOUR_ANSWERS}', $this->setAnswersForStatics('answers.tpl' ,$test['your_answers']), $copy);
                $copy = str_replace('{RESULT}', $test['correct'], $copy);
                $result .= $copy;
                $i++;
            }
            return $result;
        }else{
            return false;
        }
    }

    private  function setAnswersForStatics($path, $answers){
        //$file_path = '';
        $file_path = $_SERVER["DOCUMENT_ROOT"].'/app/views/templates/test/'.$path;
        $result = '';

        $file = file_get_contents($file_path);

        $i = 1;
        foreach ($answers as $answer){
            $copy = $file;
            $copy = str_replace('{NUMBER}', $i, $copy);
            $copy = str_replace('{ANSWER}', $answer['value'], $copy);
            if(isset($answer['correct']) && !empty($answer['correct'])){
                $copy = str_replace('{CORRECT}', '(Правильный ответ)', $copy);
            }
            else{
                $copy = str_replace('{CORRECT}', '', $copy);
            }
            $result .= $copy;
            $i++;
        }
        return $result;
    }

    private function getResult($test_id){

        // Достаем индентификатор прохождения теста
        if ($tpi_id = $this->getTestPassageInfoId((int)$test_id)){
            // Достаем идентификаторы вопросов и составляем массив
            $r = DB::getInstance()->executeQuery("SELECT `ql_question`, `ql_correct`, `ql_id`
                                                    FROM `questions_log`
                                                    WHERE `ql_test_pass_info`=:tpi_id;",
                array(array(':tpi_id', (int)$tpi_id)));
            if ($r["rows"] > 0){
                $ouptput = array();
                $i = 0;
                while($questin_id = $r["stmt"]->fetch(PDO::FETCH_ASSOC)){

                    if($questin_id['ql_correct'] == 1){
                        $questin_id['ql_correct'] = 'Правильно';
                    }
                    else{
                        $questin_id['ql_correct'] = 'Не правильно';
                    }

                    // Выходной массив, который мы подставляем вместо placeholder
                    $ouptput[$i] = array(
                        'question' => $this->getQuestionInfo($questin_id['ql_question']),
                        'answers' => $this->getQuestionAnswers($questin_id['ql_question']),
                        'your_answers' => $this->getYourQuestionAnswers($questin_id['ql_id']),
                        'correct' => $questin_id['ql_correct'],
                    );
                    $i++;
                }
                return $ouptput;
            }
        }
        return false;
    }

    // Количество вопросов в тесте
    public function countOfQuestions($test_id){
        $r = DB::getInstance()->executeQuery("SELECT COUNT(`qit_id`) AS `count_of_question`
                                                    FROM `questions_in_test`
                                                    WHERE `qit_test`=:test_id;",
            array(array(':test_id', (int)$test_id)));
        if ($r["rows"] === 1){
            return $r["stmt"]->fetch(PDO::FETCH_ASSOC)['count_of_question'];
        }
        return false;
    }

    //
    public function yourCountOfQuestions($test_id){
        $tpi_id = $this->getTestPassageInfoId((int)$test_id);
        $r = DB::getInstance()->executeQuery("SELECT COUNT(`ql_id`) AS `count_of_question`
                                                    FROM `questions_log`
                                                    WHERE `ql_test_pass_info`=:tpi_id
                                                    AND `ql_correct`=:correct;",
            array(array(':tpi_id', (int)$tpi_id), array(':correct', Model_Test::CORRECT_ANSWER)));
        if ($r["rows"] === 1){
            return $r["stmt"]->fetch(PDO::FETCH_ASSOC)['count_of_question'];
        }
        return false;
    }
}