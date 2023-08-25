<div class="modal_window_content">
    <div class="authorization_right">
        <div class="authorization_container">
            <img src="/admin/images/community.png" style="width: 80%;margin: 0 auto;">
        </div>
    </div>
    <div class="authorization_left">
        <img onclick="HideRegistration()" src="/admin/images/cancel.png" class="window_close" alt="Закрыть">
        <div class="authorization_container">
            <span>Регистрация</span>
            <div id="warning_r">&nbsp;</div>
            <form id="registration" method="POST" onsubmit="return false" autocomplete="off">
                <input id="nickname" type="text" name="nickname" placeholder="Никнейм" required>
                <input id="email" type="email" name="email" placeholder="E-mail" required>
                <input id="password" type="password" name="password" autocomplete="off" placeholder="Пароль" required>
                <input id="password-repeat" type="password" name="password_repeat" placeholder="Повторите пароль" autocomplete="off" required>
                <a href="/static_page?name_page=Privacy_Policy">✓ Политика конфиденциальности</a>
                <button onclick="Registration()" class="button button_auth">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="/AJAX/Registration.js"></script>