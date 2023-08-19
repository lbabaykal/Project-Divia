<div class="modal_window_content">
    <div class="window_heading">
        <div class="window_title">Подтверждение</div>
        <div onclick="HideModalWindow()" class="window_close">❌</div>
    </div>
    <div class="window_content">
        Вы действительно хотите удалить Книгу <span>ID: {ID_ARTICLE} {TITLE}</span>?<br>
        Данное действие невозможно будет отменить.
    </div>
    <div class="window_buttons">
        <button onclick="Article_Delete({ID_ARTICLE})" class="window_button button_save">Да</button>
        <button onclick="HideModalWindow()" class="window_button button_close">Нет</button>
    </div>
</div>

