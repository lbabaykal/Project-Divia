let table = new DataTable('#Users_Page');

const Notification = document.querySelector('#notification');
const Modal = document.querySelector('.modal_windows');

function User_Add() {
    let Form = document.getElementById('user_add');
    $.ajax({
        url: '/Users/User_Add',
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
                    location.href = '/Admin_Panel/Users';
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

function User_Edit($id_user) {
    let Form = document.getElementById('user_edit');
    let FormReady = new FormData(Form);
    FormReady.append('id_user', $id_user);
    $.ajax({
        url: '/Users/User_Edit',
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
                    location.href = '/Admin_Panel/Users';
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
    $(".modal_windows").load("/User/Template_User_Add");
    Modal.classList.toggle("show-modal");
}

function ShowEditModalWindow($id_user) {
    $(".modal_windows").load("/User/Template_User_Edit", { id_user: $id_user });
    Modal.classList.toggle("show-modal");
}

