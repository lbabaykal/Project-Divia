<div class="modal_window_content">
    <div class="window_heading">
        <div class="window_title">Подтверждение</div>
        <div onclick="HideModalWindow()" class="window_close">❌</div>
    </div>
    <div class="window_content">
        Вы действительно хотите удалить статическую страницу <span>ID: {ID_STATIC_PAGE} {NAME}</span>?<br>
        Данное действие невозможно будет отменить.
    </div>
    <div class="window_buttons">
        <button onclick="Static_Page_Delete({ID_STATIC_PAGE})" class="window_button button_save">Да</button>
        <button onclick="HideModalWindow()" class="window_button button_close">Нет</button>
    </div>
</div>'

