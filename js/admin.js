$(document).ready(function(){
    // Функция, которая в зависимости от url выбирает какую функцию загрузить.
    selectFunction();

    //$("#load_all_questions").bind('click', requestQuestions);

    /*Байндим к к айдишникам выполнение функций на сценарий для страницы тренера*/
    $("#load_all_listeners").bind('click', requestAllListenersForCoach);// При клике, прогружаем всех слушателей
    $("#load_listeners_n_group").bind('click', requestListenersForCoach);// При клике, прогружаем слушателей которые не в группе
    $("#add_listeners_to_group").css('display', 'none').bind('submit', addUsersToGroup); // Добавляем слушателей в группу
    // Для страницы удаления слушателей из группы.
    $("#delete_listeners_to_group").css('display', 'none').bind('submit', deleteUsersToGroup); // Добавляем слушателей в группу
    // Функции для страницы "Добавить новую группу"
    $("#add_new_group").bind('submit', addNewGroup);// Добавляем новую группу
    $("#load_all_groups").bind('click', requestGroups);// Просмотр существующих групп
    // Функции для страницы "Добавления тестов в группу"
    $("#add_test_to_group").bind('submit', addTestToGroup);// Выбираем Тест


    /*Байндим к айдишникам выполнение функций на сценарий для страницы менеджера*/
    // К странице "Добавить подкатегорию/категорию"
    $("#add_categories").bind('click', function(){$("#add_new_category").show();});// При клике на поле с id=add_categories, показываем нашу форму
    $("#load_all_subcategories").bind('click', requestAllSubcategories);// Достаем все подкатегории
    $("#add_subcategory").bind('submit', addSubcategory);// При отправке форму, запускаем функцию на добавление подкатегории
    $("#add_new_category").css('display', 'none');// При загрузке страницы Добавить категории, делаем скрытым нашу форму
    // К страницу добавить тест
    $("#test_categories").bind('click', listOfSubcategory);// Достаем список всех подкатегорий
    $("#test_subcategories").bind('click', questionsToTest);// Достаем вопросы по данной категории/подкатегории для теста
    $("#add_test").bind('submit', addNewTest);// Добавляем новый тест
    // На странице добавить вопрос.
    $("#questions_types").bind('click', checkTypeOfQuestion);// При выборе типа вопроса, прогружаем форму для добавления нового вопроса
    $("#questins_params").css('display', 'none');// Делаем невидимой форму добавления при загрузке.
    $("#add_question").bind('submit', addQuestion);// Добавляем вопрос
    // К странице сопоставления подкатегорий с вопросом.
    $("#load_all_questions").bind('click', requestQuestions);
    $("#add_category_to_questions").bind('submit', addCategoryToQuestion);

    $("#category_to_question").bind('click', requestQuestionFromCategory);
    // Для просмотра вопросов из теста
    $("#users_tests").bind('click', requestAllQuestionsFromTest);


    /*Байндик выполнение функций к основным страницам админки*/
    $("#add_roles_to_users").bind('submit', addRolesToUsers).css('display', 'none'); // При нажатии, выполняем функцию на допавление прав
    $("#load_all_users").bind('click', requestAllUsersForAdmin);// При нажатии, достает все роли и всех пользователей
    $("#load_users_n_rights").bind('click', requestUsersForAdmin);// При нажатии, достает все роли и пользователей без ролей
    $("#users_groups").bind('click', requestUsersFromGroup)

    // Байндим выполнение функций к страницам статистики
    $("#groups_statistics").bind('click', getAllTestsOfGroup);

    $("#user_stat_group").bind('click', getAllUserFromGroup);
    $("#user_stat_user").bind('click', getAllUserTests);
    $("#user_stat_test").bind('click', testResultInfo);


});

// Функция, которая по url опрределяет что подгрузить
function selectFunction(){
    var URL = location.href;
    var url = URL.substr(URL.lastIndexOf('/') + 1);
    if(url === 'add_category'){
        listOfCategory();
    }
    else if(url === 'add_question'){
        listOfQuestionsTypes();
    }
    else if(url === 'add_test'){
        listOfCategoryAndSubcategory();
    }
    else if(url === 'add_test_to_group'){
        requestGroupAndTest();
    }
    else if(url === 'statistics'){
        getStatistics();
    }
    else if(url === 'group_statistics'){
        getGroupStatistics();
    }
    else if(url === 'user_statistics'){
        getGroupsForUserStat();
    }
    else if(url === 'add_category_to_questions'){
        getCategoriesAndSubcategories();
    }
    else if(url === 'category_to_questions'){
        getCategoriesForQuestions();
    }
    else if(url === 'users_from_group'){
        getGroupForUsers();
    }
    else if(url === 'questions_from_test'){
        getGroupForQuestions();
    }
}

/* Функции для тренера*/
// Достаем группы и тесты при загрузке страницы добавления тестов в группу
// Достаем группы и тесты
function requestGroupAndTest(){
    var requestGroup = $.ajax({
        url:"/ajax/test_for_group",
        type: "POST",
        data: {group: 1},
        dataType: "text"
    });
    var requestTest = $.ajax({
        url:"/ajax/test_for_group",
        type: "POST",
        data: {tests: 1},
        dataType: "text"
    });

    requestGroup.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#group").html(outputData);
    });
    requestTest.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#test").html(outputData);
    });
    requestTest.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    requestGroup.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
// Добавляем тест в группу
function addTestToGroup(){
    var test = $("#test").val();
    var group = $("#group").val();

    var request = $.ajax({
        url:"/ajax/add_test_to_group",
        type: "POST",
        data: {test : test, group : group},
        dataType: "text"
    });

    request.done(function(msg){
        if((msg)){
            alert(msg);
        }
    });

    request.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

    clearInputs()

    return false;
}
// К страницу добавления группы
// Функцию для добавления новой группы
function addNewGroup(){
    var groupName = $("#group_name").val();
    var groupDescription = $("#group_description").val();

    var request = $.ajax({
        url:"/ajax/add_group",
        type: "POST",
        data: {group_name : groupName, group_description : groupDescription},
        dataType: "text"
    });

    request.done(function(msg){
        if((msg)){
            alert(msg);
            requestGroups();
        }
    });

    request.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

    return false;
}
// Функцию достаем все группы
function requestGroups(){
    var request = $.ajax({
        url:"/ajax/groups",
        type: "POST",
        data: {groups : 1},
        dataType: "text"
    });

    request.done(function(msg){
        var outputData = '<table>';
        var i = 1;
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<tr><td>' + i++ + '</td><td>' + val + ' </td></tr>';
        });
        $("#log").html(outputData);
    });

    request.fail(function(jqXHR, textStatus){
        $("#log").text("Request failed: " + textStatus);
    });
}
// Функции к страницу добавления слушателей в группы
//Достаем всех слушателей
function requestAllListenersForCoach(){
    var requestGroup = $.ajax({
        url:"/ajax/listeners_to_group",
        type: "POST",
        data: {group: 1},
        dataType: "text"
    });
    var requestListener = $.ajax({
        url:"/ajax/listeners_to_group",
        type: "POST",
        data: {listeners: 1},
        dataType: "text"
    });

    requestGroup.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#group").html(outputData);
    });
    requestListener.done(function(msg){

        var outputData = '<table>' +
                            '<thead>' +
                                '<tr>' +
                                '<th>ФИО</th><th>Название группы</th><th>Выбрать</th>' +
                            '</thead>';
        var string = JSON.parse(msg);
        var output = outputData;
        $.each(string, function(key, val){
            outputData += '<tr>' +
                            '<td>' + val.username + '</td>' +
                            '<td>' + val.group + '</td>' +
                            '<td>' +
                            '<input type="checkbox" name="listener[]" value="' + key + '" id="' + key + '" >' +
                            '<label for="' + key + '"><span></span></label>' +
                            '</td></tr>';
        });

        if(output !== outputData){
            $("#delete_listeners_to_group").show();
            $("#add_listeners_to_group").show();
            $("#message").html('');
            $("#listeners").html(outputData);
        }
        else{

            $("#message").html('Нет пользователей с ролью "слушатель"');
            $("#add_listeners_to_group").hide();
            $("#delete_listener_to_group").show();
        }
    });
    requestGroup.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    requestGroup.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
// Достаем слушателей которые не нах-ся ни в одной из групп
function requestListenersForCoach() {
    var requestGroup = $.ajax({
        url:"/ajax/listeners_to_group",
        type: "POST",
        data: {group: 1},
        dataType: "text"
    });
    var requestListener = $.ajax({
        url:"/ajax/listeners_to_group",
        type: "POST",
        data: {listener_n_group: 1},
        dataType: "text"
    });

    requestListener.done(function(msg){
        var outputData = '<table>' +
            '<thead>' +
            '<tr>' +
            '<th>ФИО</th><th>Выбрать</th>' +
            '</thead>';
        var string = JSON.parse(msg);
        var output = outputData;
        $.each( string, function(key, val){
            outputData += '<tr>' +
            '               <td>' + val.username + '</td>' +
            '               <td>' +
            '                   <input type="checkbox" name="listener[]" value="' + key + '" id="' + key + '" >' +
            '                   <label for="' + key + '"><span></span></label>' +
            '               </td></tr>';
        });
        if(output !== outputData){
            $("#add_listeners_to_group").show();
            $("#message").html('');
            $("#listeners").html(outputData);
        }
        else{
            $("#message").html('Нет пользователей с ролью "слушатель"');
            $("#add_listeners_to_group").hide();
        }
    });

    requestGroup.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#group").html(outputData);
    });
    requestGroup.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    requestGroup.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
// Добавляем слушателей в группу
function addUsersToGroup(){
    var listener = new Array();
    var j = 0;
    $("input[name='listener[]']:checked").each(function(){
        listener[j++] = $(this).val();
    });
    var group = $("#group").val();
    var request = $.ajax({
        url:"/ajax/add_listener_to_group",
        type: "POST",
        data: {listener : listener, group : group},
        dataType: "text"
    });

    request.done(function(msg){
        if((msg)){
            alert(msg);
        }
    });
    requestAllListenersForCoach();

    return false;
}
// Удаляем слушателя из группы
function deleteUsersToGroup(){
    var listener = new Array();
    var j = 0;
    $("input[name='listener[]']:checked").each(function(){
        listener[j++] = $(this).val();
    });
    var group = $("#group").val();
    var request = $.ajax({
        url:"/ajax/delete_listener_to_group",
        type: "POST",
        data: {listener : listener, group : group},
        dataType: "text"
    });

    request.done(function(msg){
        if((msg)){
            alert(msg);
        }
    });
    requestAllListenersForCoach();

    return false;
}

/* Функции для тренера*/

/* Функции для менеджера*/
// Функции к странице добавить подкатегорию/категорию
// Подгружаем категории для страница добавить категории
function listOfCategory(){
    var requestCategory = $.ajax({
        url:"/ajax/category",
        type: "POST",
        data: {category: 1},
        dataType: "text"
    });

    requestCategory.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option>' + val + '</option>';
        });
        $("#categories").html(outputData);
    });
    requestCategory.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
// Функция достает все подкатегории
function requestAllSubcategories(){
    var requestSubcategories = $.ajax({
        url:"/ajax/subcategories",
        type: "POST",
        data: {subcategories: 1},
        dataType: "text"
    });
    requestSubcategories.done(function(msg){
        var outputData = '<table>' +
                            '<thead>' +
                            '<tr>' +
                            '<th>№</th><th>Категория</th><th>Подкатегория</th>' +
                            '</thead>';
        var string = JSON.parse(msg);
        var j = 1;
        $.each( string, function(key, val){
            outputData += '<tr><td>' + j++ + '</td><td>' + val.category + '</td><td>' + val.subcategory + '</td></tr>';
        });
        $("#subcategories").html(outputData);
    });

    requestSubcategories.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
// Добавляем новую подкатегорию
function addSubcategory(){
    var category;
    if($("#new_category").val() == ''){
        category = $("#categories").val();
    }
    else{
        category = $("#new_category").val();
    }
    var subcategory = $("#new_subcategory").val();

    var request = $.ajax({
        url:"/ajax/add_subcategory",
        type: "POST",
        data: {category : category, subcategory : subcategory},
        dataType: "text"
    });

    request.done(function(msg){
        if((msg)){
            alert(msg);
        }
    });

    requestAllSubcategories();
    return false;
}

// Функции к странице добавить тест
//Список всех категорий нового теста
function listOfCategoryAndSubcategory(){
    var requestCategory = $.ajax({
        url:"/ajax/category",
        type: "POST",
        data: {category: 1},
        dataType: "text"
    });

    requestCategory.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option>' + val + '</option>';
        });
        $("#test_categories").html(outputData);
    });
    requestCategory.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    //listOfSubcategory();
}
// Список всех подкатегорий для нового теста
function listOfSubcategory(){
    var category = $("#test_categories").val();

    var requestCategory = $.ajax({
        url:"/ajax/subcat_for_test",
        type: "POST",
        data: {category : category},
        dataType: "text"
    });

    requestCategory.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option>' + val + '</option>';
        });
        $("#test_subcategories").html(outputData);
    });
    requestCategory.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
// Добавляем новый тест
function addNewTest(){
    var category = $("#test_categories").val();
    var subcategory = $("#test_subcategories").val();
    var test_name = $("#new_test_name").val();
    var questions = new Array();
    var j = 0;
    $("input[name='questions[]']:checked").each(function(){
        questions[j++] = $(this).val();
    });


    var request = $.ajax({
        url:"/ajax/add_test",
        type: "POST",
        data: {category : category, subcategory : subcategory, test_name: test_name, questions: questions},
        dataType: "text"
    });

    request.done(function(msg){
        if((msg)){
            alert(msg);
        }
    });

    request.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

    clearInputs();
    return false;
}
// Достаем возможные вопросы для теста по виду категории и подкатегории
function questionsToTest(){
    var category = $("#test_categories").val();
    var subcategory = $("#test_subcategories").val();
    var request = $.ajax({
        url:"/ajax/questions_to_test",
        type: "POST",
        data: {category : category, subcategory : subcategory},
        dataType: "text"
    });

    request.done(function(msg){
        var outputData;
        if(msg !== 'false'){
            outputData = '<h3>Выберите вопросы для нового теста</h3>' +
                         '<table>' +
                            '<thead>' +
                            '<tr>' +
                            '<th>№</th><th>Вопрос</th><th>Выбрать</th>' +
                            '</thead>';
            var string = JSON.parse(msg);
            var j = 1;
            $.each( string, function(key, val){
                outputData += '<tr>' +
                                '<td>' + j++ + '</td>' +
                                '<td>' + val + '</td>' +
                                '<td>' +
                                '<input type="checkbox" name="questions[]" value="' + key + '" id="' + key + '" >' +
                                '<label for="' + key + '"><span></span></label>' +
                                '</td></tr>';
                //outputData += '<tr><td>' + j++ + '</td><td>' + val + '</td><td><input type="checkbox" name="questions[]" value="' + key + '"></td></tr>';
            });
        }
        else{
            outputData = '<h3>Нету вопросов по данной категории и подкатегории. ' +
            'Создайте сразу вопросы по данной категории и подкатегории, а только потом приступайте к созданию теста!</h3>';
        }
        $("#questions").html(outputData);
    });

    request.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

}

// Добавление категории/подкатегории к вопрос
function requestQuestions(){
    var request = $.ajax({
        url:"/ajax/questions",
        type: "POST",
        data: {questions : 999},
        dataType: "text"
    });

    request.done(function(msg){

        var outputData = '<table>' +
            '<thead>' +
            '<tr>' +
            '<th>№</th><th>Вопрос</th><th>Выбрать</th></tr>' +
            '</thead>';
        var i = 1;
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<tr>' +
            '<td>' + i++ + '</td>' +
            '<td>' + val + '</td>' +
            '<td>' +
            '<input type="checkbox" name="question[]" value="' + key + '" id="' + key + '" >' +
            '<label for="' + key + '"><span></span></label>' +
            '</td></tr>';
        });
        $("#questions").html(outputData);
    });

    request.fail(function(jqXHR, textStatus){
        $("#log").text("Request failed: " + textStatus);
    });
}
function getCategoriesAndSubcategories(){
    var requestCategory = $.ajax({
        url:"/ajax/categories_to_questions",
        type: "POST",
        data: {category: 1},
        dataType: "text"
    });

    requestCategory.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);

        $.each( string, function(key, val){
            outputData += '<option value="' + val.id + '">' + val.category + '</option>';
        });
        $("#categories_subcategories").html(outputData);
    });
    requestCategory.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

}
function addCategoryToQuestion(){
    var category = $("#categories_subcategories").val();
    var questions = new Array();
    var j = 0;
    $("input[name='question[]']:checked").each(function(){
        questions[j++] = $(this).val();
    });

    var request = $.ajax({
        url:"/ajax/add_category_to_question",
        type: "POST",
        data: {category : category, questions : questions},
        dataType: "text"
    });

    request.done(function(msg){
        if((msg)){
            alert(msg);
        }
    });
    requestUsersForAdmin();
    clearInputs();
    return false;
}
// Просмотр вопросов по категориям
function getCategoriesForQuestions(){
    var requestCategory = $.ajax({
        url:"/ajax/categories_to_questions",
        type: "POST",
        data: {category: 1},
        dataType: "text"
    });

    requestCategory.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);

        $.each( string, function(key, val){
            outputData += '<option value="' + val.id + '">' + val.category + '</option>';
        });
        $("#category_to_question").html(outputData);
    });
    requestCategory.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
function requestQuestionFromCategory(){
    var category = $("#category_to_question").val();

    var requestCategory = $.ajax({
        url:"/ajax/question_in_category",
        type: "POST",
        data: {category: category},
        dataType: "text"
    });

    requestCategory.done(function(msg){
        var outputData = '<table>' +
            '<thead>' +
            '<tr>' +
            '<th>№</th><th>Вопрос</th></tr>' +
            '</thead>';
        var i = 1;
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<tr>' +
            '<td>' + i++ + '</td>' +
            '<td>' + val + '</td></tr>';
        });
        $("#questions").html(outputData);
    });
    requestCategory.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}

// Функции для страницы создания нового вопроса
// Список возможных типов вопросов
function listOfQuestionsTypes(){
    var request = $.ajax({
        url:"/ajax/questions_types",
        type: "POST",
        data: {questions_types: 1},
        dataType: "text"

    });

    request.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#questions_types").html(outputData);
    });
    request.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
// Отрисовываем форму в зависимости от типа вопроса
function checkTypeOfQuestion(){
    var type = $("#questions_types").val();
    var output = '';
    var j = 1;
    $("#questins_params").show();
    if(type == 1){//Вопрос с одним ответом
        while(j < 6){
            output += 'Ответ-' + j + '(верный) ' +
            '<input type="radio" name="correct" value="' + j + '" id="' + j + '" >' +
            '<label for="' + j + '"><span></span></label>' +
            '<input type="text" id="answer[' + j++ + ']"><br>';
        }
        output += '<div class="center" onclick="add_answer(type)">Нажмите чтобы добавить еще ответ</div>';
    }
    else if(type == 2){//Вопрос с несколькими ответами ответами.
        while(j < 6){
            output += 'Ответ-' + j + '(верный) ' +
            '<input type="checkbox" name="correct[]" value="' + j + '" id="' + j + '" >' +
            '<label for="' + j + '"><span></span></label>' +
            '<input type="text" id="answer[' + j++ + ']"><br>';
        }
        output += '<div class="center" onclick="add_answer(type)">Нажмите чтобы добавить еще ответ</div>';
    }
    $("#questions").html(output);
}
//TODO Добавить еще поле для ответа
function add_answer(typeOfQuestion){
    var output = '';
    if(typeOfQuestion == 1){
        output += '123';
    }
    else if(typeOfQuestion == 2){
        output += '321';
    }
    $("#questions").html(output);
}
// Добавляем новый вопрос
function addQuestion(){
    var type = $("#questions_types").val();
    var question = $("#question_name").val();
    var correctAnswers = new Array();
    var answers = new Array();
    var j = 0;
    $("input[name='correct']:checked").each(function(){
        correctAnswers[j++] = $(this).val();
    });
    $("input[name='correct[]']:checked").each(function(){
        correctAnswers[j++] = $(this).val();
    });
    var i = 1;
    $("input[type='text']").each(function(){
        answers[i++] = $(this).val();
    });

    //alert(correctAnswers + ' ' + answers + ' ' + question + ' ' + type);return false;
    var request = $.ajax({
        url:"/ajax/add_question",
        type: "POST",
        data: {type : type, question : question, answers: answers, correctAnswers: correctAnswers},
        dataType: "text"
    });

    request.done(function(msg){
        if((msg)){
            alert(msg);
        }
    });

    request.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

    clearInputs();
    return false;
}
/* Функции для менеджера*/


/* Функции для страницы добавления прав пользователям */
// Достаем всех пользователей и все роли
function requestAllUsersForAdmin(){
    var requestRole = $.ajax({
        url:"/ajax/roles_of_users",
        type: "POST",
        data: {roles_of_users: 1},
        dataType: "text"

    });

    var requestUsers = $.ajax({
        url:"/ajax/users",
        type: "POST",
        data: {users: 'all'},
        dataType: "text"
    });

    requestRole.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#roles").html(outputData);
    });

    requestUsers.done(function(msg){
        $("#add_roles_to_users").show();
        var outputData = '<table>' +
                            '<thead>' +
                            '<tr>' +
                            '<th>Логин</th><th>Фио</th><th>Права</th><th>Выбрать</th>' +
                            '</thead>';
        var string = JSON.parse(msg);
        var j = 1;
        $.each( string, function(key, val){
            outputData += '<tr>' +
                            '<td>' + val.login + '</td>' +
                            '<td>' + val.fio + '</td>' +
                            '<td>' + val.role + '</td>' +
                            '<td>' +
                            '   <input type="checkbox" name="user[]" value="' + key + '" id="' + key + '" >' +
                            '   <label for="' + key + '"><span></span></label>' +
                            '</td></tr>';
            });
        $("#users").html(outputData);
    });
    requestRole.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    requestUsers.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
// Достаем роли и пользователей без ролей.
function requestUsersForAdmin(){
    var requestRole = $.ajax({
        url:"/ajax/roles_of_users",
        type: "POST",
        data: {roles_of_users: 1},
        dataType: "text"
    });

    var requestUsers = $.ajax({
        url:"/ajax/users",
        type: "POST",
        data: {users: 'not_all'},
        dataType: "text"
    });

    requestRole.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#roles").html(outputData);
    });

    requestUsers.done(function(msg){
        $("#add_roles_to_users").show();
        var outputData = '<table>' +
                            '<thead>' +
                            '<tr>' +
                            '<th>Логин</th><th>Фио</th><th>Выбрать</th>' +
                            '</thead>';
        var string = JSON.parse(msg);
        var j = 1;
        $.each( string, function(key, val){
            outputData += '<tr>' +
            '<td>' + val.login + '</td>' +
            '<td>' + val.fio + '</td>' +
            '<td>' +
            '   <input type="checkbox" name="user[]" value="' + key + '" id="' + key + '" >' +
            '   <label for="' + key + '"><span></span></label>' +
            '</td></tr>';
            //outputData += '<tr><td>' + j++ + '</td><td>' + val.login + '</td><td>' + val.fio + '</td><td><input type="checkbox" name="user[]" value="' + key + '"></td></tr>';
        });
        $("#users").html(outputData);
    });
    requestRole.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    requestUsers.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
// Дают роли польователям
function addRolesToUsers(){
    // Массив пользователей, которых выбрал админ
    var user = new Array();
    var j = 0;
    $("input[name='user[]']:checked").each(function(){
        user[j++] = $(this).val();
    });
    // Права
    var role = $("#roles").val();
    var request = $.ajax({
        url:"/ajax/add_role_to_user",
        type: "POST",
        data: {user : user, role : role},
        dataType: "text"
    });

    request.done(function(msg){
        if((msg)){
            alert(msg);
        }
    });
    requestUsersForAdmin();
    return false;
}
// Просмотр всех пользователей по группам
function getGroupForUsers(){
    var requestGroup = $.ajax({
        url:"/ajax/test_for_group",
        type: "POST",
        data: {group: 1},
        dataType: "text"
    });

    requestGroup.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#users_groups").html(outputData);
    });

    requestGroup.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
function requestUsersFromGroup(){
    var group = $("#users_groups").val();

    var requestUsers = $.ajax({
        url:"/ajax/users_from_group",
        type: "POST",
        data: {group: group},
        dataType: "text"
    });

    requestUsers.done(function(msg){
        var outputData = '<table>' +
            '<thead>' +
            '<tr>' +
            '<th>№</th><th>ФИО</th></thead>';
        var string = JSON.parse(msg);
        $.each(string, function(key, val){
            outputData += '<tr>' +
            '<td>' + ++key + '</td>' +
            '<td>' + val + '</td></tr>';
        });
        $("#users").html(outputData);
    });
    requestUsers.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

}

function getGroupForQuestions(){
    var requestTest = $.ajax({
        url:"/ajax/questions_from_test",
        type: "POST",
        data: {test: 1},
        dataType: "text"
    });

    requestTest.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#users_tests").html(outputData);
    });

    requestTest.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
function requestAllQuestionsFromTest(){
    var test_id = $("#users_tests").val();
    var requestQuestions = $.ajax({
        url:"/ajax/questions_from_test",
        type: "POST",
        data: {test_id: test_id},
        dataType: "text"
    });

    requestQuestions.done(function(msg){
        var outputData = '';
        var string = JSON.parse(msg);
        var i = 0;
        $.each( string, function(key, val){
            outputData += '<h3>Вопрос - ' + ++i + '</h3>';
            outputData += '<h4 class="yellow">' + val.question + '</h4>';
            outputData += '<p class="yellow">Варианты ответов:</p>';
            var j = 1;
            $.each(val.answers, function(key1, val1){
                if(val1.correct){
                    val1.correct = ' (Правильный ответ)'
                }
                else{
                    val1.correct = '';
                }
                outputData += '<span class="answer_number">'+ j++ +'.</span> ' + val1.value + val1.correct +'<br>';
            });
            outputData += '<hr>'
        });
        $("#questions").html(outputData);
    });



    requestQuestions.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}

/* Функции для страницы статистики*/
// Общей
function getStatistics(){
    var requestTest = $.ajax({
        url:"/ajax/statistics",
        type: "POST",
        data: {tests: 1},
        dataType: "text"
    });
    var requestQuestions = $.ajax({
        url:"/ajax/statistics",
        type: "POST",
        data: {questions: 1},
        dataType: "text"
    });
    var requestCorrectQuestions = $.ajax({
        url:"/ajax/statistics",
        type: "POST",
        data: {correct: 1},
        dataType: "text"
    });
    var requestPercentage = $.ajax({
        url:"/ajax/statistics",
        type: "POST",
        data: {percentage: 1},
        dataType: "text"
    });


    requestTest.done(function(msg){
        var outputData = '<p> Пройденно тестов - ';
        var string = JSON.parse(msg);
        outputData += string;
        $("#tests_count").html(outputData);
    });
    requestQuestions.done(function(msg){
        var outputData = '<p> Отвеченно вопросов - ';
        var string = JSON.parse(msg);
        outputData += string;
        $("#questions_count").html(outputData);
    });
    requestCorrectQuestions.done(function(msg){
        var outputData = '<p> Из них правильно - ';
        var string = JSON.parse(msg);
        outputData += string;
        $("#correct_questions_count").html(outputData);
    });
    requestPercentage.done(function(msg){
        var outputData = '<p> Правильных ответов (на группу) - ';
        var string = JSON.parse(msg);
        outputData += string + '%';
        $("#percentage_count").html(outputData);
    });

    requestPercentage.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    requestCorrectQuestions.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    requestQuestions.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    requestGroup.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

}
function getGroupStatistics(){
    var requestGroup = $.ajax({
        url:"/ajax/test_for_group",
        type: "POST",
        data: {group: 1},
        dataType: "text"
    });

    requestGroup.done(function(msg){
        var outputData = '';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#groups_statistics").html(outputData);
    });

    requestGroup.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
function getAllTestsOfGroup(){
    var groupNumber = $("#groups_statistics").val();

    var requestUserCount = $.ajax({
        url:"/ajax/group_statistics",
        type: "POST",
        data: {group: groupNumber},
        dataType: "text"
    });
    var requestTestCount = $.ajax({
        url:"/ajax/group_statistics",
        type: "POST",
        data: {test_count: groupNumber},
        dataType: "text"
    });
    var requestPersentage = $.ajax({
        url:"/ajax/group_statistics",
        type: "POST",
        data: {percentage: groupNumber},
        dataType: "text"
    });

    requestUserCount.done(function(msg){
        var outputData = '<p>Количество слушателей в группе - ';
        var string = JSON.parse(msg);
        outputData += string;
        $("#users_count").html(outputData);
    });
    requestTestCount.done(function(msg){
        var outputData = '<p>Количество пройденных тестов(на группу) - ';
        var string = JSON.parse(msg);
        outputData += string;
        $("#test_count").html(outputData);
    });
    requestPersentage.done(function(msg){
        var outputData = '<p>Правильных ответов (на группу) - ';
        var string = JSON.parse(msg);
        outputData += string + '%';
        if(string !== null){
            $("#percentage").html(outputData);
        }
        else{
            $("#percentage").hide();
        }
    });

    requestPersentage.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    requestTestCount.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
    requestUserCount.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

}
// По группе
function getGroupsForUserStat(){
    var requestGroup = $.ajax({
        url:"/ajax/test_for_group",
        type: "POST",
        data: {group: 1},
        dataType: "text"
    });

    requestGroup.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#user_stat_group").html(outputData);
    });
    requestGroup.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
function getAllUserFromGroup(){
    var groupNumber = $("#user_stat_group").val();

    var requestUserCount = $.ajax({
        url:"/ajax/user_statistics",
        type: "POST",
        data: {users: groupNumber},
        dataType: "text"
    });

    requestUserCount.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#user_stat_user").html(outputData);
    });

    requestUserCount.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });
}
function getAllUserTests(){
    var groupNumber = $("#user_stat_group").val();
    var user = $("#user_stat_user").val();
    var requestTests = $.ajax({
        url:"/ajax/user_statistics",
        type: "POST",
        data: {user: user, group: groupNumber},
        dataType: "text"
    });

    requestTests.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#user_stat_test").html(outputData);
    });

    requestTests.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

}
// Пользователя
function testResultInfo(){
    var test_passage_info = $("#user_stat_test").val();
    var requestTests = $.ajax({
        url:"/ajax/user_statistics",
        type: "POST",
        data: {test_passage_info: test_passage_info},
        dataType: "text"
    });

    requestTests.done(function(msg){
        var outputData = '';
        var string = JSON.parse(msg);
        var i = 0;
        var correct_answers = 0;
        $.each( string, function(key, val){
            outputData += '<h3>Вопрос - ' + ++i + '</h3>';
            outputData += '<h4 class="yellow">' + val.question.name + '</h4>';
            outputData += '<p class="yellow">Варианты ответов:</p>';
            var j = 1;
            $.each(val.answers, function(key1, val1){
                if(val1.correct){
                    val1.correct = ' (Правильный ответ)'
                }
                else{
                    val1.correct = '';
                }
                outputData += '<span class="answer_number">'+ j++ +'.</span> ' + val1.value + val1.correct +'<br>';
            });
            outputData += '<p class="yellow">Ответы пользователя:</p>';
            j = 1;

            $.each(val.your_answers, function(key2, val2){
                outputData += '<span class="answer_number">'+ j++ +'.</span> ' + val2.value +'<br>';
            });
            if(val.correct === 'Правильно'){
                correct_answers++;
            }
            outputData += '<p class="yellow">Результат:</p>';
            outputData += '<p>' + val.correct;
            outputData += '<hr>'
        });
        outputData += '<p class="center message">Пользователь ответил на ' + correct_answers + '' +
                      ' из ' + i + ' вопросов.</p>'
        $("#result").html(outputData);
    });

    requestTests.fail(function(jqXHR, textStatus){
        alert("Request failed: " + textStatus);
    });

}




// Функция которая очищает формы после их отправления
function clearInputs(){
    $("input:text").val('');
    $("input:checkbox").prop({'checked':false});
    $("input:radio").prop({'checked':false});
    $("textarea").val('');
    $("select").val('');
}