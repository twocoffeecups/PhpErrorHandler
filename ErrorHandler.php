<?php

namespace TwoCoffeCups\PHPErrorHandler;

use ErrorException;
use TwoCoffeCups\PHPErrorHandler\ErrorInfo\ErrorInfo;
use TwoCoffeCups\PHPErrorHandler\Exception\UnspecifiedFilePathException;
use TwoCoffeCups\PHPErrorHandler\Logger\ErrorLogger;
use TwoCoffeCups\PHPErrorHandler\Render\ErrorRender;
use TwoCoffeCups\PHPErrorHandler\TraceStack\TraceStackDispatcher;

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
     * Register error handler functions and errors config
     * @return void
     */
    private function register(): void
    {
        error_reporting(E_ALL | E_STRICT);
        ini_set('display_errors', 1);

        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        ob_start();
        register_shutdown_function([$this, 'handleFatalError']);
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @param $errcontext
     * @return mixed
     * @throws ErrorException
     * @throws Exception\PermissionException
     */
    public function handleError($errno, $errstr, $errfile, $errline, $errcontext = null)
    {
        $trace = debug_backtrace();
        if ($this->saveLog) ErrorLogger::write(
            $errno,
            $errstr,
            $errfile,
            $errline,
            $this->pathToLogFile);
        throw new ErrorException($errstr);
    }

    /**
     * @return void
     * @throws Exception\PermissionException
     * @throws ErrorException
     */
    public function handleFatalError()
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            ob_end_clean();
            $trace = $error['trace'];
            $traceCollection = TraceStackDispatcher::createStackTraceCollection($trace);
            $traceAsString = TraceStackDispatcher::getTraceAsString($trace);
            if ($this->saveLog) ErrorLogger::write(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line'],
                $this->pathToLogFile);
            throw new ErrorException($error['message']);

        } else {
            ob_end_flush();
        }
    }

    /**
     * Exception handler
     * @param \Exception $exception
     * @return true
     */
    public function handleException(\Throwable $exception)
    {

        $trace = $exception->getTrace();
        $traceCollection = TraceStackDispatcher::createStackTraceCollection($trace);
        if (!($exception instanceof \ErrorException)) {
            $traceCollection->pushMainFile($exception->getFile(), $exception->getLine());
        }
        $traceAsString = TraceStackDispatcher::getTraceAsString($exception->getTrace());
        $errorInfo = new ErrorInfo(
            'Exception',
            $traceAsString,
            $exception->getCode(),
            $exception->getMessage(),
            $traceCollection,
        );
        if ($this->saveLog) ErrorLogger::write(
            $exception->getCode(),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $this->pathToLogFile);
        ErrorRender::show($errorInfo);
        return true;
    }
}