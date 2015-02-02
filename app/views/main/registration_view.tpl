<div class="wrapper">
    <div class="col4">
        <h1>{LABEL="header_registration"}</h1>
        <p>{DV="lf_message"}</p>
    </div>
    <div class="col2 center form">
        <form method="post" action="/main/registration">
            <fieldset class="login_form">
                <label for="login"><div>{LABEL="label_login"}</div></label>
                <input type="text" id="login" name="login" value="{DV="lf_login"}"><br>
                <label for="password"><div>{LABEL="label_password"}</div></label>
                <input type="password" id="password" name="password"><br>
                <label for="email"><div>{LABEL="label_email"}</div></label>
                <input type="email" id="email" name="email" value="{DV="lf_email"}"><br>

                <input type="checkbox" name="long_auth" value="1" id="long_auth"/>
                <label for="long_auth">{LABEL="label_remember"} <span></span></label>

                <input type="submit" value="{LABEL="label_reg"}">
            </fieldset>
        </form>
    </div>
    <div class="col2">
        <p>{LABEL="text_registration"}</p>
    </div>
</div>