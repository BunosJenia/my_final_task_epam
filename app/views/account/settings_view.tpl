<div class="wrapper form">
    {FILE="nav/nav_account.tpl"}
    <div class="col3">
        <div class="wrapper">
            <div class="col4">
                <h1>{LABEL="header_settings"}</h1>

                <form method="post" action="/account/settings">
                    <p class="font_lobster center">{LABEL="label_change_name"}</p>
                    <fieldset>
                        <p class="center message_eror">{DV="lf_message_name"}</p>
                        <label for="user_last_name"><div>{LABEL="label_user_last_name"}</div></label>
                        <input type="text" id="user_last_name" name="user_last_name" value="{DV="us_last_name"}">
                        <label for="user_first_name"><div>{LABEL="label_user_first_name"}</div></label>
                        <input type="text" id="user_first_name" name="user_first_name" value="{DV="us_first_name"}">
                        <label for="user_patronymic"><div>{LABEL="label_user_patronymic"}</div></label>
                        <input type="text" id="user_patronymic" name="user_patronymic" value="{DV="us_patronymic"}"><br>
                        <input type="submit" value="{LABEL="label_change"}">
                    </fieldset>
                </form>

                <form method="post" action="/account/settings">
                    <p class="font_lobster center">{LABEL="label_change_pass"}</p>
                    <fieldset>
                        <p class="center message_eror">{DV="lf_message_password"}</p>
                        <label for="user_password"><div>{LABEL="label_user_password"}</div></label>
                        <input type="password" id="user_password" name="user_password">
                        <label for="user_new_password"><div>{LABEL="label_user_new_password"}</div></label>
                        <input type="password" id="user_new_password" name="user_new_password"><br>
                        <input type="submit" value="{LABEL="label_change"}">
                    </fieldset>
                </form>

                <form method="post" action="/account/settings">
                    <p class="font_lobster center">{LABEL="label_change_email"}</p>
                    <fieldset>
                        <p class="center message_eror">{DV="lf_message_email"}</p>
                        <label for="user_email"><div>{LABEL="label_user_email"}</div></label>
                        <input type="email" id="user_email" name="user_email" value="{DV="us_email"}"><br>
                        <input type="submit" value="{LABEL="label_change"}">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>