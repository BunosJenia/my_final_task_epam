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
                <h1>Добавить слушателя в группу:</h1>
                <input type="submit" value="Все слушатели" id="load_all_listeners">
                <input type="submit" value="Слушатели не в группе" id="load_listeners_n_group">
                <form id="add_listeners_to_group">
                    <label for="group"><div>Группа:</div></label>
                    <select id="group"></select>
                    <div id="listeners"></div>
                    <input type="submit" value="Добавить слушателя">
                </form>
            </div>
            <div class="col4" id="log"></div>
        </div>
    </div>
</div>