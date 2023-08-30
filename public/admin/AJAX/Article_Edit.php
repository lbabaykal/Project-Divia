<div class="modal_window_content">
    <div class="window_heading">
        <div class="window_title">Редактирование статьи</div>
        <div onclick="HideModalWindow()" class="window_close">❌</div>
    </div>
    <div class="window_content">
        <form id="book_edit" method="POST" enctype="multipart/form-data" onsubmit="return false" autocomplete="off">
            <label for="title">Название:
                <input id="title" type="text" name="title" value="{TITLE}" required/>
            </label>

            <label for="title_eng">Оригинальное название:
                <input id="title_eng" type="text" name="title_eng" value="{TITLE_ENG}" required/>
            </label>

            <label>Раздел:
                <select name="chapter">
                    <option value="">--------</option>
                    {SELECT}
                </select>
            </label>

            <label>Жанр:
                <select class="genre_select" name="category[]" multiple>
                    {CHECKBOX}
                </select>
            </label>

            <label>Изображение:
                <input name="image" id="image" type="file" accept="image/png, image/jpeg"/>
            </label>
            <label></label>
            <label for="description">Описание:</label>
            <textarea id="description" name="description" rows="6" cols="10" required>{DESCRIPTION}</textarea>
        </form>
    </div>
    <div class="window_buttons">
        <button onclick="Article_Edit({ID_ARTICLE})" class="window_button button_save">Изменить</button>
        <button onclick="HideModalWindow()" class="window_button button_close">Отмена</button>
    </div>
</div>