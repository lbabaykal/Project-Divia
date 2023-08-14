<div class="modal_window_content">
    <div class="window_heading">
        <div class="window_title">Изменение статической страницы</div>
        <div onclick="HideModalWindow()" class="window_close">❌</div>
    </div>
    <div class="window_content">
        <form id="static_page_edit" method="POST" onsubmit="return false" autocomplete="off">
            <label for="name">Название:<input name="name" value="{NAME}"></label>
            <label for="name_eng">Название на Английском:<input name="name_eng" value="{NAME_ENG}"></label>

            <label for="description">Описание:</label>
            <textarea id="comment" rows="1" cols="1" name="description">{DESCRIPTION}</textarea>
        </form>
    </div>
    <div class="window_buttons">
        <button onclick="Static_Page_Edit({ID_STATIC_PAGE})" class="window_button button_save">Изменить</button>
        <button onclick="HideModalWindow()" class="window_button button_close">Отмена</button>
    </div>
</div>