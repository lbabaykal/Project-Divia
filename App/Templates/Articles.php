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
                    <th>Автор</th>
                    <th>Раздел</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            {BOOKS_ITEMS}
            </tbody>
        </table>
    </div>
</div>

<div class="modal_windows"></div>


<script type="text/javascript" src="/Templates/AnoTheR/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="/Templates/AnoTheR/css/jquery.dataTables.min.css">
<script type="text/javascript" src="/App/AJAX/Article.js"></script>