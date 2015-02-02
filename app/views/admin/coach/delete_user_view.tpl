<div class="wrapper form">
    {FILE="nav/nav_coach.tpl"}
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>{LABEL="header_delete_user_to_group"}</h1>
                <input type="submit" value="{LABEL="label_all_user"}" id="load_all_listeners">
                <form id="delete_listeners_to_group">
                    <label for="group"><div>{LABEL="label_group"}</div></label>
                    <select id="group"></select>
                    <div id="listeners"></div>
                    <input type="submit" value="{LABEL="label_delete_user"}">
                </form>
                <div id="message"></div>
            </div>
            <div class="col4" id="log"></div>
        </div>
    </div>
</div>