<?php

namespace TwoCoffeCups\PHPErrorHandler;

use TwoCoffeCups\PHPErrorHandler\Exception\UnspecifiedFilePathException;
use TwoCoffeCups\PHPErrorHandler\Logger\ErrorLogger;
use TwoCoffeCups\PHPErrorHandler\Render\ErrorRender;

class ErrorHandler
{

    /**
     * The path to the folder for storing error logs
     * @var string
     */
    public string $pathToLogFile;

    /**
     * Whether to save logs
     * @var bool
     */
    public bool $saveLog;

    public function __construct(bool $saveLog = false, string|null $pathToLogFile = null)
    {
        $this->saveLog = $saveLog;
        // if log saving is enabled, specify a folder for storing them
        if ($this->saveLog) {
            $pathToLogFile
                ? $this->pathToLogFile = $pathToLogFile
                : throw new UnspecifiedFilePathException("Error log file path not specified!");
        }
        /**
         * Register errors handler methods
         */
        $this->register();
    }

    /**
     * Register error handler functions
     * @return void
     */
    private function register(): void
    {
        set_error_handler([$this, 'errorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }

    /**
     * Error handler
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @param $errcontext
     * @return true
     */
    public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext = null)
    {
        $trace = array_reverse(debug_backtrace());
        if ($this->saveLog) ErrorLogger::write(
            $errno,
            $errstr,
            $errfile,
            $errline,
            $this->pathToLogFile);
        ErrorRender::show(
            $errno,
            $errstr,
            $errfile,
            $errline,
            $trace);
        return true;
    }

    /**
     * Fatal error handler
     * @return void
     */
    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            ob_get_clean();
            $trace = array_reverse(debug_backtrace());
            if ($this->saveLog) ErrorLogger::write(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line'],
                $this->pathToLogFile);
            ErrorRender::show(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line'],
                $trace);
        } else {
            ob_end_flush();
        }
    }

    /**
     * Exception handler
     * @param \Exception $exception
     * @return true
     */
    public function exceptionHandler(\Exception $exception)
    {
        if ($this->saveLog) ErrorLogger::write(
            $exception->getCode(),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $this->pathToLogFile);
        ErrorRender::show(
            $exception->getCode(),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTrace());
        return true;
    }
}