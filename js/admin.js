$(document).ready(function(){
    // Функция, которая в зависимости от url выбирает какую функцию загрузить.
    selectFunction();

    //$("#load_all_questions").bind('click', requestQuestions);

    /*Байндим к к айдишникам выполнение функций на сценарий для страницы тренера*/
    $("#load_all_listeners").bind('click', requestAllListenersForCoach);// При клике, прогружаем всех слушателей
    $("#load_listeners_n_group").bind('click', requestListenersForCoach);// При клике, прогружаем слушателей которые не в группе
    $("#add_listeners_to_group").css('display', 'none').bind('submit', addUsersToGroup); // Добавляем слушателей в группу
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


    /*Байндик выполнение функций к основным страницам админки*/
    $("#add_roles_to_users").bind('submit', addRolesToUsers).css('display', 'none'); // При нажатии, выполняем функцию на допавление прав
    $("#load_all_users").bind('click', requestAllUsersForAdmin);// При нажатии, достает все роли и всех пользователей
    $("#load_users_n_rights").bind('click', requestUsersForAdmin);// При нажатии, достает все роли и пользователей без ролей
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
    requestGroup.fail(function(jqXHR, textStatus){
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
        $("#add_listeners_to_group").show();
        var outputData = '<table>';
        var string = JSON.parse(msg);
        var j = 1;
        $.each( string, function(key, val){
            outputData += '<tr><td>' + j++ + '</td><td>' + val + '</td><td><input type="checkbox" name="listener[]" value="' + key + '"></td></tr>';
        });
        $("#listeners").html(outputData);
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

    requestGroup.done(function(msg){
        var outputData = '<select>';
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<option value="' + key + '">' + val + '</option>';
        });
        $("#group").html(outputData);
    });
    requestListener.done(function(msg){
        $("#add_listeners_to_group").show();
        var outputData = '<table>';
        var string = JSON.parse(msg);
        var j = 1;
        $.each( string, function(key, val){
            outputData += '<tr><td>' + j++ + '</td><td>' + val + '</td><td><input type="checkbox" name="listener[]" value="' + key + '"></td></tr>';
        });
        $("#listeners").html(outputData);
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
    requestListenersForCoach();

    return false;
}
/* Функции для тренера*/

/* Функции для менеджера*/
// Функции к странице добавить подкатегорию/категорию
// Подгружаем категории для страница добавить категории
function listOfCategory(){
    var requestCategory = $.ajax({
        url:"/ajax/category"
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
        url:"/ajax/subcategories"
    });
    requestSubcategories.done(function(msg){
        var outputData = '<table>';
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

    return false;
}

// Функции к странице добавить тест
//Список всех категорий нового теста
function listOfCategoryAndSubcategory(){
    var requestCategory = $.ajax({
        url:"/ajax/category"
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
            outputData = '<h3>Выберите вопросы для нового теста</h3><table>';
            var string = JSON.parse(msg);
            var j = 1;
            $.each( string, function(key, val){
                outputData += '<tr><td>' + j++ + '</td><td>' + val + '</td><td><input type="checkbox" name="questions[]" value="' + key + '"></td></tr>';
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

// Функции для страницы создания нового вопроса
// Список возможных типов вопросов
function listOfQuestionsTypes(){
    var request = $.ajax({
        url:"/ajax/questions_types"
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
            output += 'Ответ-' + j + '(верный <input type="radio" name="correct" value="' + j + '">)' +
                        '<input type="text" id="answer[' + j++ + ']"><br>';
        }
        output += '<div class="center" onclick="add_answer(type)">Нажмите чтобы добавить еще ответ</div>';
    }
    else if(type == 2){//Вопрос с несколькими ответами ответами.
        while(j < 6){
            output += 'Ответ-' + j + '(верный <input type="checkbox" name="correct[]" value="' + j + '">)' +
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
        url:"/ajax/roles_of_users"
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
        var outputData = '<table>';
        var string = JSON.parse(msg);
        var j = 1;
        $.each( string, function(key, val){
            outputData += '<tr><td>' + j++ + '</td><td>' + val.login + '</td><td>' + val.fio + '</td><td><input type="checkbox" name="user[]" value="' + key + '"></td></tr>';
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
        url:"/ajax/roles_of_users"
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
        var outputData = '<table>';
        var string = JSON.parse(msg);
        var j = 1;
        $.each( string, function(key, val){
            outputData += '<tr><td>' + j++ + '</td><td>' + val.login + '</td><td>' + val.fio + '</td><td><input type="checkbox" name="user[]" value="' + key + '"></td></tr>';
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


/* Функции для страницы статистики*/
function requestQuestions(){
    var request = $.ajax({
        url:"/ajax/questions",
        type: "POST",
        data: {some_var : 999},
        dataType: "text"
    });

    request.done(function(msg){
        var outputData = '<table>';
        var i = 1;
        var string = JSON.parse(msg);
        $.each( string, function(key, val){
            outputData += '<tr><td>' + i++ + '</td><td>' + val + ' </td><td><input type="checkbox" value="' + key + '"></td></tr>';
        });
        $("#log").html(outputData);
    });

    request.fail(function(jqXHR, textStatus){
        $("#log").text("Request failed: " + textStatus);
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