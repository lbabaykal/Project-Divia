<div class="static_page_cont">
    <div class="static_page_head">
        <div class="static_page_title">Список пользователей</div>
        <div onclick="ShowAddModalWindow()" class="static_page_add_new">+ Добавить пользователя</div>
    </div>
    <div class="static_page_content">
        <table id="Users_Page" class="flat-table table-bordered table-hover dt-responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nickname</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Подписка</th>
                <th>Группа</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            {USER_ITEMS}
            </tbody>
        </table>
    </div>
</div>

<div class="modal_windows"></div>


<script type="text/javascript" src="/AJAX/Users.js"></script>

