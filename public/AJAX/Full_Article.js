const Notification = document.querySelector('#notification');
let url = new URL(document.location.href);
//let url_id_article = url.searchParams.get('id');

$(':radio').click(function () {
    if ($(':radio:checked').length === 1) {

        const Warning = document.querySelector('#warning_rating');
        const WarningText = document.querySelector('#warning_rating span');

        $.ajax({
            url: '/rating/do_rating',
            method: 'POST',
            dataType: 'json',
            data: { rating: +$("input[name='rating']:checked").val(),
                    id_article: url.pathname
                    },
               success: function(data) {
                let jsonData = JSON.parse(JSON.stringify(data));
                if (jsonData.success === "Yes") {
                    Warning.classList.remove('warning__RED');
                    Warning.classList.add('warning__GREEN');
                    WarningText.innerText = jsonData.text;
                    setTimeout(() => { Warning.classList.remove('warning__GREEN'); }, 2000);
                }
                if (jsonData.success === "No") {
                    Warning.classList.add('warning__RED');
                    WarningText.innerText = jsonData.text;
                    setTimeout(() => { Warning.classList.remove('warning__RED'); }, 2000);
                }
            }
        });
    }
});

function Do_Favourite() {
    const Favourite = document.querySelector('#favourite');

    $.ajax({
        url: '/favorites/do_favourite',
        method: 'POST',
        dataType: 'json',
        data: { id_article: url.pathname },
        success: function (data) {
            let jsonData = JSON.parse(JSON.stringify(data));
            if (jsonData.success === "Yes") {
                Favourite.classList.add('favourite_active');
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                }, 4000);
            }
            if (jsonData.success === "Yess") {
                Favourite.classList.remove('favourite_active');
                Notification.classList.add('notification');
                Notification.innerText = jsonData.text;
                setTimeout(() => {
                    Notification.classList.remove('notification');
                }, 2000);
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

function comment_add() {
    let Form = document.getElementById('add_comment');
    let FormReady = new FormData(Form);
    FormReady.append('id_article', url.pathname);

    $.ajax({
        url: '/comments/comment_add',
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
                    location.reload();
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


