const Notification = document.querySelector('#notification');
const Modal = document.querySelector('.modal_windows');

function Static_Page_Add() {
    let Form = document.getElementById('static_page_add');
    $.ajax({
        url: '/static_page/static_page_add',
        method: 'POST',
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        data: new FormData(Form),
        success: function(data) {
            let jsonData = JSON.parse(JSON.stringify(data));
            if (jsonData.success === "Yes") {
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                    location.href = '/Admin_Panel/Static_Pages';
                }, 1000);
            }
            if (jsonData.success === "No") {
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                }, 2000);
            }
        }
    });
}

function Static_Page_Edit($id_StaticPage) {
    let Form = document.getElementById('static_page_edit');
    let FormReady = new FormData(Form);
    FormReady.append('id_StaticPage', $id_StaticPage)
    $.ajax({
        url: '/static_page/static_page_edit',
        method: 'POST',
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        data: FormReady,
        success: function(data) {
            let jsonData = JSON.parse(JSON.stringify(data));
            if (jsonData.success === "Yes") {
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                    location.href = '/Admin_Panel/Static_Pages';
                }, 1000);
            }
            if (jsonData.success === "No") {
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                }, 2000);
            }
        }
    });
}

function Static_Page_Delete($id_StaticPage) {
    $.ajax({
        url: '/static_page/static_page_delete',
        method: 'POST',
        dataType: 'json',
        data: {id_StaticPage: $id_StaticPage},
        success: function(data) {
            let jsonData = JSON.parse(JSON.stringify(data));
            if (jsonData.success === "Yes") {
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                    location.href = '/Admin_Panel/Static_Pages';
                }, 1000);
            }
            if (jsonData.success === "No") {
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                }, 2000);
            }
        }
    });
}

function HideModalWindow () {
    Modal.classList.toggle("show-modal");
}

function ShowAddModalWindow() {
    $(".modal_windows").load("/Static_Page/Template_Static_Page_Add");
    Modal.classList.toggle("show-modal");
}

function ShowEditModalWindow($id_StaticPage) {
    $(".modal_windows").load("/Static_Page/Template_Static_Page_Edit", { id_StaticPage: $id_StaticPage });
    Modal.classList.toggle("show-modal");
}

function ShowDeleteModalWindow($id_StaticPage) {
    $(".modal_windows").load("/Static_Page/Template_Static_Page_Delete", { id_StaticPage : $id_StaticPage });
    Modal.classList.toggle("show-modal");
}