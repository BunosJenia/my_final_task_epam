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
                <h1>Добавить тест в группу:</h1>
                <form id="add_test_to_group">
                    <label for="group"><div>Группа:</div></label>
                    <select id="group"><option></option></select>
                    <label for="test"><div>Тест:</div></label>
                    <select id="test"><option></option></select><br>
                    <input type="submit" value="Добавить тест">
                </form>
            </div>
            <div class="col4" id="log"></div>
        </div>
    </div>
</div>