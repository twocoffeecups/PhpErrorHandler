<?php

namespace TwoCoffeCups\ErrorHandler;

use TwoCoffeCups\ErrorHandler\Render\ErrorRender;

class Handler
{

    public function __construct()
    {
        set_error_handler([$this, 'errorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext = null)
    {
        $trace = array_reverse(debug_backtrace());
        ErrorRender::show($errno, $errstr, $errfile, $errline, $trace);
        return true;
    }

    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if(!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            ob_get_clean();
            $trace = array_reverse(debug_backtrace());
            ErrorRender::show($error['type'], $error['message'], $error['file'], $error['line'], $trace);
        }else {
            ob_end_flush();
        }
    }

    public function exceptionHandler(\Exception $exception)
    {
        ErrorRender::show($exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTrace());
        return true;
    }
}