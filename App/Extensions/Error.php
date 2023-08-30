<?php


namespace App\Extensions;


class Error
{

    public function __construct()
    {
        error_reporting(-1);
        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $this->displayError($errno, $errstr, $errfile, $errline);
    }

    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }

    public function exceptionHandler(\Throwable $e)
    {
        $this->displayError('Exception', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    protected function displayError($errno, $errstr, $errfile, $errline, $responce = 500)
    {
        if ($responce == 0) {
            $responce = 404;
        }
        http_response_code($responce);
        if ($responce == 404) {
            echo "Тype: {$errno}<br>";
            echo "Description: {$errstr}<br>";
            echo "File: {$errfile}<br>";
            echo "String: {$errline}<br>";
            //header('Location: /404.php');
        }
        else {
            echo "Тype: {$errno}<br>";
            echo "Description: {$errstr}<br>";
            echo "File: {$errfile}<br>";
            echo "String: {$errline}<br>";
        }
        die;
    }

}