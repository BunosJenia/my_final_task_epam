<div class="wrapper form">
    {FILE="nav/nav_manager.tpl"}
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>{LABEL="header_add_questions"}</h1>

                <form id="add_question">
                    <label for="questions_types"><div>{LABEL="label_questions_types"}</div></label>
                    <select id="questions_types"></select>
                    <div id="questins_params">
                        <label for="question_name"><div>{LABEL="label_questions_text"}</div></label>
                        <textarea name="question_name" id="question_name"></textarea>
                        <div id="questions"></div>
                        //тут еще будут различные параметры для вопросов<br>
                        <input type="submit" value="{LABEL="label_add"}">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>