<div class="modal_window_content">
        <div class="authorization_left">
            <div class="authorization_container">
                <span>Авторизация</span>
                <div id="warning_a">&nbsp;</div>
                <form id="authorization" method="POST" onsubmit="return false" autocomplete="off">
                    <input type="email" name="email" placeholder="Email" required/>
                    <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                    <a href="/Login/Template_Recovery_Password">Забыли пароль?</a>
                    <button onclick="Authorization()" class="button button_auth">Авторизоваться</button>
                </form>
            </div>
        </div>
        <div class="authorization_right">
            <img onclick="HideAuthorization()" src="/admin/images/cancel.png" class="window_close" alt="Закрыть">
            <div class="authorization_container">
                <div class="logo">LIBRARY HARMONY</div>
                <div class="text">Привет, Друг!<br>Присоединяйся к нам...</div>
                <button onclick="ShowRegistration()" class="button button_reg">Зарегистрируйся!</button>
            </div>
        </div>
</div>
<script type="text/javascript" src="/AJAX/Authorization.js"></script>
