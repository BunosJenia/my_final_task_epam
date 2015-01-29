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
                <h1>Создать новый тест:</h1>

                <form id="add_test">
                    <label for="test_categories"><div>Выберите категорию и подкатегорию теста:</div></label>
                    <select id="test_categories"></select>
                    <select id="test_subcategories"></select>
                    <label for="new_test_name"><div>Введите название теста:</div></label>
                    <input type="text" id="new_test_name"><br>
                    <div id="questions"></div>
                    //тут еще будут различные параметры для теста<br>
                    <input type="submit" value="Добавить">
                </form>

            </div>
        </div>
    </div>
</div>