<div class="wrapper">
    <div class="col4 center form">
        <h1>{LABEL="header_contacts"}</h1>
    </div>
    <div class="col3 form">
        <form method="post" action="/">
            <fieldset>
                <label for="guest_name"><div>{LABEL="label_guest_name"}</div></label>
                <input type="text" id="guest_name" name="guest_name"><br>
                <label for="guest_email"><div>{LABEL="label_guest_email"}</div></label>
                <input type="email" id="guest_email" name="guest_email"><br>
                <label for="guest_message"><div>{LABEL="label_guest_message"}</div></label>
                <textarea id="guest_message" name="guest_message"></textarea><br>
                <input type="submit" name="upload" value="{LABEL="label_sent"}">
            </fieldset>
        </form>
    </div>
    <div class="col1">
        <p class="font_lobster">{LABEL="email"}</p><p>{LABEL="my_email"}</p>
        <p class="font_lobster">{LABEL="phone"}</p><p>{LABEL="my_phone"}</p>
    </div>
</div>
