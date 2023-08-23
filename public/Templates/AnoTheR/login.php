[AUTHORIZED]
    <div id="menu-change" class="header-profile">
        <div id="welcome" class="header-profile-up-text header-profile-text"></div>
        <div class="header-profile-down-text header-profile-text">{NICKNAME}</div>
        <img class="header-profile-avatar header-profile-text" src="/images/users_images/{AVATAR}" alt="Avatar">
    </div>
    <div id="menu-active" class="header-profile-menu" style="display: none;">
        <div class="profile-menu-info">
            <img src="/images/users_images/{AVATAR}" alt="Avatar">
            <div class="profile-menu-text">
                <div class="profile-menu-nickname profile-menu-hidden">{NICKNAME}<span>#{ID_USER}</span></div>
                <div class="profile-menu-email profile-menu-hidden">{EMAIL}</div>
            </div>
        </div>
        <div class="profile-menu">
            [ADMIN_PANEL]
            <a class="profile-menu-button" href="/admin_panel">
                <img src="/Templates/AnoTheR/images/admin.png" alt="">
                <span>Admin_Panel</span>
            </a>
            [/ADMIN_PANEL]
            <a class="profile-menu-button" href="/my_profile/">
                    <img src="/Templates/AnoTheR/images/profile.png" alt="">
                    <span>Мой профиль</span>
            </a>
            <a class="profile-menu-button" href="/my_profile/my_favorites">
                    <img src="/Templates/AnoTheR/images/favorite.png" alt="">
                    <span>Избранное</span>
            </a>
            <a class="profile-menu-button" href="/my_profile/settings">
                    <img src="/Templates/AnoTheR/images/settings.png" alt="">
                    <span>Настройки</span>
            </a>
            <a class="profile-menu-button" href="/login/logout">
                    <img src="/Templates/AnoTheR/images/exit.png" alt="">
                    <span>Выход</span>
            </a>
        </div>
    </div>
[/AUTHORIZED]
[NOT_AUTHORIZED]
<div onclick="ShowAuthorization()">
    <div id="menu-change" class="header-profile">
        <div class="header-profile-up-text header-profile-text">Авторизация</div>
        <div class="header-profile-down-text header-profile-text">Регистрация</div>
        <img class="header-profile-avatar header-profile-text" src="/images/users_images/default.jpg" alt="Avatar">
    </div>
</div>
[/NOT_AUTHORIZED]




<script>
    let MyDate = new Date,
        MyHours = MyDate.getHours(),
        elements = document.getElementById('welcome'),
        name = elements.innerText;
    switch (true){
        case (MyHours >= 6) && (MyHours < 12):elements.innerText = 'Доброе утро';
            break;
        case (MyHours >= 12) && (MyHours < 18):elements.innerText = 'Добрый день';
            break;
        case (MyHours >= 18) && (MyHours <= 23):elements.innerText = 'Добрый вечер';
            break;
        case (MyHours >= 0) && (MyHours < 6):elements.innerText = 'Доброй ночи';
            break;
        default:elements.innerText = 'Здравствуйте';
            break;
    }
</script>