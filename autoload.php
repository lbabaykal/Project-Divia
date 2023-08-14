<?php
spl_autoload_register(function ($ClassName) {
    $file = __DIR__ . '/' . str_replace('\\', '/', $ClassName) . '.php';
    if (file_exists($file)) {
        require $file;
    }
    else {
        echo 'File not found';
    }
});
