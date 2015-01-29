<div class="wrapper form">
    <div class="col1">
        <ul class="menulist">
            <li><a href="/admin/add_question">Добавить вопросы</a></li>
            <li><a href="/admin/add_test">Создать новый тест</a></li>
            <li><a href="/admin/add_category">Добавить категорию и подкагеторию</a></li>
        </ul>
    </div>
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>Добавить вопрос:</h1>

                <form id="add_question">
                    <label for="questions_types"><div>Выберите тип вопроса:</div></label>
                    <select id="questions_types"></select>
                    <div id="questins_params">
                        <label for="question_name"><div>Введите текст вопроса:</div></label>
                        <textarea name="question_name" id="question_name"></textarea>
                        <div id="questions"></div>
                        //тут еще будут различные параметры для вопросов<br>
                        <input type="submit" value="Добавить">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>