<div class="wrapper form">
    {FILE="nav/nav_coach.tpl"}
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>{LABEL="header_add_test_to_group"}</h1>
                <form id="add_test_to_group">
                    <label for="group"><div>{LABEL="label_group"}</div></label>
                    <select id="group"><option>{LABEL="label_test"}</option></select>
                    <label for="test"><div></div></label>
                    <select id="test"><option></option></select><br>
                    <input type="submit" value="{LABEL="label_add_test"}">
                </form>
            </div>
            <div class="col4" id="log"></div>
        </div>
    </div>
</div>