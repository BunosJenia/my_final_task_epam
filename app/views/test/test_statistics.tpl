<div class="wrapper form">
    {FILE="/nav/nav_test.tpl"}
    <div class="col3">
        <div class="wrapper">
            <h1>{LABEL="header_res_test"} {DV="test_name"}</h1>
            <div class="col4">
                {DV="test_result"}
                <p class="center message">{LABEL="label_text_you_answered_on"} {DV="questions_count"}
                    {LABEL="label_text_from"} {DV="correct_answers"} {LABEL="label_text_questions_dot"}</p>
            </div>
        </div>
    </div>
</div>