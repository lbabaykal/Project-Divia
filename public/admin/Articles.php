<div class="static_page_cont">
    <div class="static_page_head">
        <div class="static_page_title">Список статей</div>
        <div onclick="ShowAddModalWindow()" class="static_page_add_new">+ Добавить статью</div>
    </div>
    <div class="static_page_content">
        <table id="Books" class="flat-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Раздел</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            {ARTICLES_ITEMS}
            </tbody>
        </table>
    </div>
</div>

<div class="modal_windows"></div>

<script type="text/javascript" src="/AJAX/Article.js"></script>