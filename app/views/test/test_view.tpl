<div class="wrapper">
    <div class="col4 form">
        <h1>{LABEL="header_test_name"} {DV="test_name"}</h1>
        <form method="post" action="">
            <fieldset>
                <p class="center message">{LABEL="label_text_question"} {DV="answered_questions"} {LABEL="label_text_from"} {DV="questions_count"} </p>
                <h2 class="question">{DV="test_question"}</h2>
                <input hidden="hidden" name="question" value="{DV="question_id"}">
                {DV="answers"}
                <input type="submit">
            </fieldset>
        </form>
    </div>
</div>