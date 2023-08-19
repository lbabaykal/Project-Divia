<!DOCTYPE html>
<html lang="ru-Ru">
<head>
    <title>LIBRARY HARMONY</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="{DESCRIPTION}" />
    <meta name="keywords" content="{KEYWORDS}" />
    <link rel="icon" type="image/png" sizes="256x256" href="/Templates/AnoTheR/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="/Templates/AnoTheR/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
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
        <a href="/chapter?chapter_name_eng=anime"><div class="header-nav-items">Аниме</div></a>
        <a href="/chapter?chapter_name_eng=manga"><div class="header-nav-items">Манга</div></a>
        <a href="/chapter?chapter_name_eng=dorams"><div class="header-nav-items">Дорамы</div></a>
    </div>

    <img id="search-change" class="header-search" src="/Templates/AnoTheR/images/loupe.svg" alt="Search" onclick="">
        {LOGIN}
    <div id="search-active" class="search" style="display: none;">
        <form action="search" method="GET">
            <input type="text" name="search" />
            <button type="submit">Поиск</button>
        </form>
    </div>

</header>
<div class="modal_authorization"></div>
<div class="modal_registration"></div>
<div id="notification"></div>

{CONTENT}

<footer class="footer">
    <div class="footer_copyright">
        <span class="copyright_left">COPYRIGHT &copy; 2016 – <?php echo date('Y')?></span>
        <span class="copyright_right">harmony@libharmony.com</span>
    </div>

    <div class="footer_links">
        <a href="">Политика конфиденциальности</a>
        <a href="">Пользовательское соглашение</a>
        <a href="">Правовая информация</a>
        <a href="">Контакты</a>
    </div>
</footer>

<script type="text/javascript" src="/Templates/AnoTheR/js/JavaScript.js"></script>

</body>
</html>
