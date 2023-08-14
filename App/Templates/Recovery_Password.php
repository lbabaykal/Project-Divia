<!DOCTYPE html >
<html lang="ru-Ru">
<head>
    <title>{TITLE}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="{DESCRIPTION}" />
    <meta name="keywords" content="{KEYWORDS}" />
    <link rel="icon" type="image/png" sizes="256x256" href="/Templates/AnoTheR/images/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/App/Templates/admin.css">
    <link rel="stylesheet" type="text/css" href="/Templates/AnoTheR/css/main.css">
</head>
<body>

<div class="limiter">
    <div class="forms_block">
        <span>Восстановление пароля</span>
        <div class="forms_cont">
            <div id="warning"></div>
            <form id="recovery_password" method="POST" onsubmit="return false" autocomplete="off">
                <label for="email">Email:</label>
                <input id="email" type="email" name="email" placeholder="example@gmail.com" required>

                <button onclick="Recovery_Password()" type="submit">Восстановить</button>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script type="text/javascript" src="/App/AJAX/Recovery_Password.js"></script>


</body>
</html>