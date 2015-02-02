<div class="wrapper form">
    {FILE="nav/nav_manager.tpl"}
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>{LABEL="header_add_category"}</h1>
                <input type="submit" id="load_all_subcategories" value="{LABEL="label_all_subcategory"}">
                <input type="submit" id="add_categories" value="{LABEL="label_add_category"}">
                <form id="add_subcategory">
                    <label for="categories"><div>{LABEL="label_categories"}</div></label>
                    <select id="categories"></select>
                    <div id="add_new_category">
                        <label for="new_category"><div>{LABEL="label_new_category"}</div></label>
                        <input type="text" id="new_category">
                    </div>
                    <label for="new_subcategory"><div>{LABEL="label_new_subcategory"}</div></label>
                    <input type="text" id="new_subcategory"><br>
                    <input type="submit" value="{LABEL="label_add"}">
                </form>
                <div id="subcategories"></div>
            </div>
        </div>
    </div>
</div>