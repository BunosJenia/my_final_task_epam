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
                <h1>Добавить новую категорию:</h1>
                <input type="submit" id="load_all_subcategories" value="Все подкатегории">
                <input type="submit" id="add_categories" value="Добавить категорию">
                <form id="add_subcategory">
                    <label for="categories"><div>Выберите существующую категорию:</div></label>
                    <select id="categories"></select>
                    <div id="add_new_category">
                        <label for="new_category"><div>Введите новую категорию:</div></label>
                        <input type="text" id="new_category">
                    </div>
                    <label for="new_subcategory"><div>Введите новую подкатегорию:</div></label>
                    <input type="text" id="new_subcategory"><br>
                    <input type="submit" value="Добавить">
                </form>
                <div id="subcategories"></div>
            </div>
        </div>
    </div>
</div>