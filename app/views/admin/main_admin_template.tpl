<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>{LABEL="title_admin"}</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
    <script src="/js/jquery-2.1.3.min.js"></script>
    <script src="/js/admin.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Lobster|Roboto+Slab:400&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
</head>
<body>

<div id="header">
    <ul>
        <li><a href="/main">{LABEL="url_main"}</a></li>
        <li><a href="/admin">{LABEL="url_admin"}</a></li>
        <li><a href="/admin/manager">{LABEL="url_manager"}</a></li>
        <li><a href="/admin/coach">{LABEL="url_coach"}</a></li>
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