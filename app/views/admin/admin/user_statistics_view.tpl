<div class="wrapper form">
    {FILE="nav/nav_admin.tpl"}
    <div class="col3">
        <h1>{LABEL="header_user_statistics"}</h1>
        <form>
            <label for="user_stat_group"><div>{LABEL="choose_group"}</div></label>
            <select id="user_stat_group"></select>
            <label for="user_stat_user"><div>{LABEL="choose_user"}</div></label>
            <select id="user_stat_user"></select>
            <label for="user_stat_test"><div>{LABEL="choose_test"}</div></label>
            <select id="user_stat_test"></select>
        </form>
        <div id="result"></div>
    </div>
</div>