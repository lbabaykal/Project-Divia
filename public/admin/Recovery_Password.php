<div class="modal_window_content">
    <div class="authorization_left">
        <div class="authorization_container">
            <span>Восстановление пароля</span>
            <div id="warning_rp">&nbsp;</div>
            <form id="recovery_password" method="POST" onsubmit="return false" autocomplete="off">
                <input id="email" type="email" name="email" placeholder="example@gmail.com" required>
                <button onclick="Recovery_Password()" class="button button_auth">Восстановить пароль</button>
            </form>
        </div>
    </div>
    <div class="authorization_right">
        <img onclick="HideRecovery_Password()" src="/admin/images/cancel.png" class="window_close" alt="Закрыть">
        <div class="authorization_container">
            <img src="/admin/images/moonlight.png" style="width: 80%;margin: 0 auto;">
        </div>
    </div>
</div>
<script type="text/javascript" src="/AJAX/Recovery_Password.js"></script>