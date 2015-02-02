<div class="wrapper form">
    <div class="col4 center">
        <h1>{LABEL="header_test_complete"} {DV="test_name"} {LABEL="header_test_made"}</h1>
    </div>
    <div class="col4">
        {DV="test_result"}
        <p class="center message">{LABEL="label_text_you_answered_on"} {DV="questions_count"}
            {LABEL="label_text_from"} {DV="correct_answers"} {LABEL="label_text_questions_dot"}</p>
        <form action="/test">
            <input type="submit" value="{LABEL="labe_go_away_from_test"}">
        </form>
    </div>
</div>