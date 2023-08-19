<div class="modal_window_content">
    <div class="window_heading">
        <div class="window_title">Изменение информации о пользователе</div>
        <div onclick="HideModalWindow()" class="window_close">❌</div>
    </div>
    <div class="window_content">
        <form id="user_edit" method="POST" onsubmit="return false" autocomplete="off">
            <label for="nickname">Имя:
                <input id="nickname" type="text" name="nickname" value="{NICKNAME}"></label>

            <label for="birthday">День рождения:
                <input id="birthday" type="text" name="birthday" value="{BIRTHDAY}"></label>

            <label for="phone">Телефон:
                <input id="phone" type="tel" name="phone" value="{PHONE}"></label>

            <label for="email">E-mail:
                <input id="email" type="email" name="email" value="{EMAIL}"></label>

            <label>Группа пользователей:
                <select name="user_group">
                    {SELECT}
                </select></label>
        </form>
    </div>
    <div class="window_buttons">
        <button onclick="User_Edit({ID_USER})" class="window_button button_save">Сохранить</button>
        <button onclick="HideModalWindow()" class="window_button button_close">Отмена</button>
    </div>
</div>

<script type="text/javascript" src="/admin/js/jquery.mask.js"></script>
<script type="text/javascript">
    $('input[name="phone"]').mask('+7 (000) 000 0000');
    $('input[name="birthday"]').mask('00.00.0000');
</script>