<div class="wrapper form">
    <div class="col1">
        <ul class="menulist">
            <li><a href="/admin/create_group">Создание групп</a></li>
            <li><a href="/admin/add_test_to_group">Назначение тестов</a></li>
            <li><a href="/admin/add_user_to_group">Добавить слушателей в группу</a></li>
        </ul>
    </div>
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>Введите данные о новой группе:</h1>
                <form id="add_new_group">
                    <label for="group_name"><div>Название группы:</div></label>
                    <input type="text" id="group_name" name="group_name">
                    <label for="group_description"><div>Описание группы:</div></label>
                    <textarea id="group_description" name="group_description"></textarea>
                    <input type="submit" value="Добавить группу">
                </form>
                <input type="submit" id="load_all_groups" value="Просмотреть все группы">
            </div>
            <div class="col4" id="log"></div>
        </div>
    </div>
</div>