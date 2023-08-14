<div class="static_page_cont">
    <div class="static_page_head">
        <div class="static_page_title">Список статических страниц</div>
        <div onclick="ShowAddModalWindow()" class="static_page_add_new">+ Добавить статическую страницу</div>
    </div>
    <div class="static_page_content">
        <table id="Static_Page" class="flat-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>NAME_ENG</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            {STATIC_PAGES_ITEMS}
            </tbody>
        </table>
    </div>
</div>

<div class="modal_windows"></div>

<script type="text/javascript" src="/App/AJAX/Static_Page.js"></script>