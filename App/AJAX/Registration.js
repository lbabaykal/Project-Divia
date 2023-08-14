function Registration() {
    const formWarning = document.querySelector('#warning_r');
    let Form = document.getElementById('registration');
    $.ajax({
        url: '/Login/Registration',
        method: 'POST',
        dataType: 'json',
        data: $(Form).serialize(),
        success: function(data) {
            let jsonData = JSON.parse(JSON.stringify(data));
            if (jsonData.success === "Yes")
            {
                formWarning.classList.remove('warning_RED');
                formWarning.classList.add('warning_GREEN');
                formWarning.innerText = jsonData.text;
                location.href = '/';
            }
            if (jsonData.success === "No")
            {
                formWarning.classList.remove('warning_GREEN');
                formWarning.classList.add('warning_RED');
                formWarning.innerText = jsonData.text;
            }
        }
    });
}

