<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="UTF-8">
        <title>{LABEL="title_general"}</title>
        <link rel="stylesheet" type="text/css" href="/css/style.css" />
        <link href='http://fonts.googleapis.com/css?family=Lobster|Roboto+Slab:400&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    </head>
    <body>

        <div id="header">
            <ul>
                <li><a href="/main">{LABEL="url_main"}</a></li>
                <li><a href="/account">{LABEL="url_account"}</a></li>
                <li><a href="/test" id="nav_test">{LABEL="url_tests"}</a></li>
                <li><a href="/main/contact">{LABEL="url_contacts"}</a></li>
                <li><a href="/main/about">{LABEL="url_about"}</a></li>
            </ul>
        </div>

        <div id="main">
            <div id="content">
                {FILE="file"}
            </div>
        </div>

        {FILE="footer_template.tpl"}

    </body>
</html>