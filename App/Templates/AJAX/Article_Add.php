<div class="modal_window_content">
    <div class="window_heading">
        <div class="window_title">Добавление Книги</div>
        <div onclick="HideModalWindow()" class="window_close">❌</div>
    </div>
    <div class="window_content">
        <form id="book_add" method="POST" enctype="multipart/form-data" onsubmit="return false" autocomplete="off">
            <label for="title">Название:
            <input id="title" type="text" name="title" required /></label>

            <label for="title_eng">Оригинальное название:
            <input id="title_eng" type="text" name="title_eng" required /></label>

            <label for="author">Автор:
            <input id="author" type="text" name="author" required /></label>

            <label>Раздел:
            <select name="chapter">
                <option value="">--------</option>
                {SELECT}
            </select></label>

            <label>Жанр:
                <select class="genre_select" name="category[]" multiple>
                    {CHECKBOX}
                </select>
            </label>

            <label>Изображение:
            <input name="image" id="image" type="file" accept="image/png, image/jpeg" required /></label>
            <label></label>
            <label for="description">Описание:</label>
            <textarea id="description" name="description" rows="6" cols="10" required></textarea>
        </form>
    </div>
    <div class="window_buttons">
        <button onclick="Article_Add()" class="window_button button_save">Добавить</button>
        <button onclick="HideModalWindow()" class="window_button button_close">Отмена</button>
    </div>
</div>

<script type="text/javascript" src="/Templates/AnoTheR/js/jquery.mask.js"></script>
<script type="text/javascript">
    $('input[name="ISBN"]').mask('999-0-00-000000-0');
    $('input[name="year"]').mask('0000');
</script>
