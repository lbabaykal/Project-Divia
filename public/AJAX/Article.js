let table = new DataTable('#Books');
const Notification = document.querySelector('#notification');
const Modal = document.querySelector('.modal_windows');

function Article_Add() {
    let Form = document.getElementById('book_add');
    $.ajax({
        url: '/article/article_add',
        method: 'POST',
        dataType: 'json',
        data: new FormData(Form),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            let jsonData = JSON.parse(JSON.stringify(data));
            if (jsonData.success === "Yes") {
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                    location.href = '/Admin_Panel/Articles';
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

function Article_Edit($id_article) {
    let Form = document.getElementById('book_edit');
    let FormReady = new FormData(Form);
    FormReady.append('id_article', $id_article);
    $.ajax({
        url: '/article/article_edit',
        method: 'POST',
        dataType: 'json',
        data: FormReady,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            let jsonData = JSON.parse(JSON.stringify(data));
            if (jsonData.success === "Yes") {
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                    location.href = '/Admin_Panel/Articles';
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

function Article_Delete($id_article) {
    $.ajax({
        url: '/article/article_delete',
        method: 'POST',
        dataType: 'json',
        data: { id_article: $id_article },
        success: function(data) {
            let jsonData = JSON.parse(JSON.stringify(data));
            if (jsonData.success === "Yes") {
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                    location.href = '/Admin_Panel/Articles';
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
    $(".modal_windows").load("/Article/Template_Article_Add");
    Modal.classList.toggle("show-modal");
}

function ShowEditModalWindow($id_article) {
    $(".modal_windows").load("/Article/Template_Article_Edit", { id_article : $id_article });
    Modal.classList.toggle("show-modal");
}

function ShowDeleteModalWindow($id_article) {
    $(".modal_windows").load("/Article/Template_Article_Delete", { id_article : $id_article });
    Modal.classList.toggle("show-modal");
}


