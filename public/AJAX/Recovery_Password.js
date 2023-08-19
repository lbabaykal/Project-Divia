function Recovery_Password() {
    let Form = document.getElementById('recovery_password');
    const formWarning = document.querySelector('#warning');
    $.ajax({
        url: '/Login/Recovery_Password',
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
                setTimeout(() => {
                    location.href = '/';
                }, 1000);
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



