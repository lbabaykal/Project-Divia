<div class="modal_window_content">
    <div class="window_heading">
        <div class="window_title">Добавление статической страницы</div>
        <div onclick="HideModalWindow()" class="window_close">❌</div>
    </div>
    <div class="window_content">
        <form id="static_page_add" method="POST" onsubmit="return false" autocomplete="off">
            <label for="name">Название:<input name="name"></label>
            <label for="name_eng">Название на Английском:<input name="name_eng"></label>

            <label for="description">Описание:</label>
            <textarea id="comment" rows="1" cols="1" name="description"></textarea>
        </form>
    </div>
    <div class="window_buttons">
        <button onclick="Static_Page_Add()" class="window_button button_save">Добавить</button>
        <button onclick="HideModalWindow()" class="window_button button_close">Отмена</button>
    </div>
</div>