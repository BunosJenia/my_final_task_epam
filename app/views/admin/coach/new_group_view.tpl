<div class="wrapper form">
    {FILE="nav/nav_coach.tpl"}
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>{LABEL="header_add_group"}</h1>
                <form id="add_new_group">
                    <label for="group_name"><div>{LABEL="label_group_name"}</div></label>
                    <input type="text" id="group_name" name="group_name">
                    <label for="group_description"><div>{LABEL="label_group_description"}</div></label>
                    <textarea id="group_description" name="group_description"></textarea>
                    <input type="submit" value="{LABEL="label_add_group"}">
                </form>
                <input type="submit" id="load_all_groups" value="{LABEL="label_all_groups"}">
            </div>
            <div class="col4" id="log"></div>
        </div>
    </div>
</div>