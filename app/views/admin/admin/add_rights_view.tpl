<div class="wrapper form">
    {FILE="nav/nav_admin.tpl"}
    <div class="col3">

        <div class="wrapper">
            <div class="col4">
                <h1>{LABEL="header_add_rights"}</h1>
                <input type="submit" value="{LABEL="label_all_users_role"}" id="load_all_users">
                <input type="submit" value="{LABEL="label_users_n_role"}" id="load_users_n_rights">
                <form id="add_roles_to_users">
                    <label for="roles"><div>{LABEL="label_roles"}</div></label>
                    <select id="roles"></select>
                    <div id="users"></div>
                    <input type="submit" value="{LABEL="label_add_roles"}">
                </form>
            </div>
        </div>

    </div>
</div>