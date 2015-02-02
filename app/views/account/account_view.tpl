<div class="wrapper form">
    {FILE="nav/nav_account.tpl"}
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>{LABEL="header_room"}</h1>
                <p class="font_lobster">{LABEL="label_ypur_data"}</p>
                    <p>{LABEL="label_surname"} {DV="us_last_name"}</p>
                    <p>{LABEL="label_name"} {DV="us_first_name"}</p>
                    <p>{LABEL="label_patronymic"} {DV="us_patronymic"}</p><hr>

                <p class="font_lobster">Группа: {DV="lf_message_not_in_group"}</p>
                    <p><a href="/account/group">{DV="us_group"}</a></p><hr>

                <p class="font_lobster">{LABEL="label_text_tests"}</p>
                    <p>{LABEL="label_text_test_ended"} {DV="c_test_ended"}</p>
                    <p>{LABEL="label_text_not_ended_test"} {DV="c_test"}</p>
                    <p>{LABEL="label_text_new_test"} {DV="c_new_test"}</p>

            </div>
        </div>
    </div>
</div>