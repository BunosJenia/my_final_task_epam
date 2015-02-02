<div class="wrapper form">
    {FILE="nav/nav_manager.tpl"}
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>{LABEL="header_add_category_to_question"}</h1>
                <input type="submit" id="load_all_questions" value="{LABEL="label_all_question"}">
                <form id="add_category_to_questions">
                    <label for="categories_subcategories"><div>{LABEL="label_categories"}</div></label>
                    <select id="categories_subcategories"></select><br>
                    <div id="questions"></div>
                    <input type="submit" value="{LABEL="label_add"}">
                </form>
            </div>
        </div>
    </div>
</div>