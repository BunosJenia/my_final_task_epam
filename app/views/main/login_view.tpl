<div class="wrapper">
    <div class="col4">
        <h1>{LABEL="header_login"}</h1>
        <p>{DV="lf_message"}</p>
    </div>
    <div class="col2 center form">
<<<<<<< HEAD
        <form method="post" action="/main/login">
=======
        <form method="post" action="/account">
>>>>>>> 91ee3bc47cf130dcd37d526dc3442c1a12f35b4e
            <fieldset class="login_form">
                <label for="login"><div>{LABEL="label_login"}</div></label>
                <input type="text" id="login" name="login" value="{DV="lf_login"}"><br>
                <label for="password"><div></div>{LABEL="label_password"}</label>
                <input type="password" id="password" name="password"><br>

                <input type="checkbox" name="long_auth" value="1" id="long_auth"/>
                <label for="long_auth">{LABEL="label_remember"}<span></span></label>

                <input type="submit" value="{LABEL="label_go"}">
            </fieldset>
        </form>
    </div>
    <div class="col2">
        <p class="yellow font_lobster">{LABEL="text_registration1"}</p>
        <p><strong>{LABEL="text_registration2"}</strong></p>
        <p>{LABEL="text_registration3"}</p>
        <p>{LABEL="text_registration4"}</p>
        <a href="/main/registration">{LABEL="url_text_registration"}</a>
    </div>
</div>