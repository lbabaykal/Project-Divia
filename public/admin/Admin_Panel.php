<!DOCTYPE html >
<html lang="ru-Ru">
<head>
    <title>LIBRARY HARMONY - Admin_Panel</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="icon" type="image/png" sizes="256x256" href="/admin/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="/admin/css/admin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script type="text/javascript" src="/admin/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="/admin/css/jquery.dataTables.min.css">
</head>
<body>
<header class="header">
    <a class="header-logo" href="/">
        <span class="header-logo-left">LIBRARY</span>
        <span class="header-logo-right">HARMONY</span>
    </a>
    {LOGIN}
</header>


<section class="content_admin">
    <div class="sidebar">
        <div class="sidebar_name">
            <a href="/Admin_Panel">Admin Panel</a>
        </div>
        <div class="list_name">Настройки системы</div>
        <div class="list">
            <a href="/"><div class="list_item">Общие-</div></a>
            <a href="/"><div class="list_item">Безопасность-</div></a>
            <a href="/"><div class="list_item">Посетители-</div></a>
            <a href="/"><div class="list_item">Статьи-</div></a>
            <a href="/"><div class="list_item">Комментарии-</div></a>
            <a href="/"><div class="list_item">Файлы-</div></a>
            <a href="/"><div class="list_item">Изображения-</div></a>
        </div>
        <div class="list_name">Настройки скриптов</div>
        <div class="list">
            <a href="/Admin_Panel/Articles"><div class="list_item">Статьи</div></a>
            <a href="/"><div class="list_item">Главы</div></a>
            <a href="/"><div class="list_item">Категории</div></a>
            <a href="/"><div class="list_item">Персоны</div></a>
            <a href="/"><div class="list_item">Категории Персон</div></a>
        </div>
        <div class="list_name">Пользователи</div>
        <div class="list">
            <a href="/Admin_Panel/Users"><div class="list_item">Список пользователей</div></a>
            <a href="/"><div class="list_item">Группы пользователей----</div></a>
        </div>
        <div class="list_name">Другие разделы</div>
        <div class="list">
            <a href="/Admin_Panel/Static_Pages"><div class="list_item">Статические страницы</div></a>
        </div>
    </div>
    <div id="notification"></div>
    <div class="content_main">
        {CONTENT}
    </div>
</section>



<script type="text/javascript" src="/admin/js/JavaScript.js"></script>
</body>
</html>
