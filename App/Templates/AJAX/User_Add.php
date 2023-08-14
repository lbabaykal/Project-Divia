<div class="modal_window_content">
    <div class="window_heading">
        <div class="window_title">Регистрация читателя</div>
        <div onclick="HideModalWindow()" class="window_close">❌</div>
    </div>
    <div class="window_content">
        <form id="user_add" method="POST" onsubmit="return false" autocomplete="off">
            <label for="nickname">Никнейм:
            <input id="nickname" type="text" name="nickname" required></label>

            <label for="birthday">День рождения:
            <input id="birthday" type="text" name="birthday" required></label>

            <label for="phone">Телефон:
            <input id="phone" type="tel" name="phone" required></label>

            <label for="email">E-mail:
            <input id="email" type="email" name="email" required></label>

            <label for="password">Пароль:
            <input id="password" type="password" name="password" autocomplete="off" required></label>

            <label for="password-repeat">Повторите пароль:
            <input id="password-repeat" type="password" name="password_repeat" autocomplete="off" required></label>
        </form>
    </div>
    <div class="window_buttons">
        <button onclick="User_Add()" class="window_button button_save">Зарегистрировать</button>
        <button onclick="HideModalWindow()" class="window_button button_close">Отмена</button>
    </div>
</div>
<script type="text/javascript" src="/Templates/AnoTheR/js/jquery.mask.js"></script>
<script type="text/javascript">
    $('input[name="phone"]').mask('+7 (000) 000 0000');
    $('input[name="birthday"]').mask('00.00.0000');
</script>