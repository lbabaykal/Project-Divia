<!DOCTYPE html>
<html lang="ru-Ru">
<head>
    <title>{TITLE}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="{DESCRIPTION}" />
    <meta name="keywords" content="{KEYWORDS}" />
    <link rel="icon" type="image/png" sizes="256x256" href="{TEMPLATE}/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="{TEMPLATE}/css/style.css">
    <script src="{TEMPLATE}/js/jquery-3.7.0.min.js"></script>
</head>
<body>

<header class="header">
    <a  href="/">
        <div class="header-logo">
            <span class="header-logo-left">LIBRARY</span>
            <span class="header-logo-right">HARMONY</span>
        </div>
    </a>

    <div class="header-nav">
        <a href="/"><div class="header-nav-items">Главная</div></a>
        <a href="/chapter/anime"><div class="header-nav-items">Аниме</div></a>
        <a href="/chapter/dorams"><div class="header-nav-items">Дорамы</div></a>
        <a href="/chapter/manga"><div class="header-nav-items">Манга</div></a>
    </div>

    <img id="search-change" class="header-search" src="{TEMPLATE}/images/loupe.svg" alt="Search" onclick="">
        {LOGIN}
    <div id="search-active" class="search" style="display: none;">
        <form action="/search" method="GET">
            <input type="text" name="search" />
            <button type="submit">Поиск</button>
        </form>
    </div>
</header>

<div class="modal_authorization"></div>
<div class="modal_registration"></div>
<div class="modal_recovery_password"></div>
<div id="notification"></div>

<section class="content">
    <div class="content_group">
        <div class="group_articles">
            {CONTENT}
        </div>
    </div>
</section>

<footer class="footer">
    <div class="footer_copyright">
        <span class="copyright_left">COPYRIGHT &copy; 2016 – 2023</span>
        <span class="copyright_right">harmony@libharmony.com</span>
    </div>

    <div class="footer_links">
        <a href="/static_page/privacy_policy">Политика конфиденциальности</a>
        <a href="/static_page/site_rules">Пользовательское соглашение</a>
        <a href="/static_page/legal_information">Правовая информация</a>
        <a href="/static_page/contacts">Контакты</a>
    </div>
</footer>

<script type="text/javascript" src="{TEMPLATE}/js/JavaScript.js"></script>

</body>
</html>
