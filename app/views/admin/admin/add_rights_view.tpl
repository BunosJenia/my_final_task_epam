<div class="wrapper form">
    <div class="col1">
        <ul class="menulist">
            <li><a href="/admin/add_rights">Добавить пользователям права</a></li>
            <li><a href="/admin/statistics">Статистика тестов</a></li>
            <li><a href="/admin/">Просмотр выполнения тестов по группам</a></li>
        </ul>
    </div>
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>Добавить пользователям права:</h1>
                <input type="submit" value="Все польз-ли" id="load_all_users">
                <input type="submit" value="Польз-ли без прав" id="load_users_n_rights">
                <form id="add_roles_to_users">
                    <label for="roles"><div>Права:</div></label>
                    <select id="roles"></select>
                    <div id="users"></div>
                    <input type="submit" value="Добавить права">
                </form>
            </div>
        </div>
    </div>
</div>