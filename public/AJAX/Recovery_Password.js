function Recovery_Password() {
    const formWarning = document.querySelector('#warning_rp');
    let Form = document.getElementById('recovery_password');
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
                }, 5000);
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



