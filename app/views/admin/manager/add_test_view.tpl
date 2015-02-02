<div class="wrapper form">
    {FILE="nav/nav_manager.tpl"}
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>{LABEL="header_add_test"}</h1>

                <form id="add_test">
                    <label for="test_categories"><div>{LABEL="label_test_category"}</div></label>
                    <select id="test_categories"></select>
                    <select id="test_subcategories"></select>
                    <label for="new_test_name"><div>{LABEL="label_test_text"}</div></label>
                    <input type="text" id="new_test_name"><br>
                    <div id="questions"></div>
                    //тут еще будут различные параметры для теста<br>
                    <input type="submit" value="{LABEL="label_add"}">
                </form>

            </div>
        </div>
    </div>
</div>