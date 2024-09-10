<?php

namespace TwoCoffeCups\PHPErrorHandler;

use TwoCoffeCups\PHPErrorHandler\Debugger\Debugger;
use TwoCoffeCups\PHPErrorHandler\ErrorInfo\ErrorInfo;
use TwoCoffeCups\PHPErrorHandler\Exception\UnspecifiedFilePathException;
use TwoCoffeCups\PHPErrorHandler\Logger\ErrorLogger;
use TwoCoffeCups\PHPErrorHandler\Render\ErrorRender;
use TwoCoffeCups\PHPErrorHandler\StackTrace\StackTrace;

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
        $trace = debug_backtrace();
        $traceCollection = StackTrace::get($trace);
        $traceAsString = $this->getTraceAsString($trace);
        $errorInfo = new ErrorInfo(
            'Error',
            $traceAsString,
            $errno,
            $errstr,
            $traceCollection,
        );
        if ($this->saveLog) ErrorLogger::write(
            $errno,
            $errstr,
            $errfile,
            $errline,
            $this->pathToLogFile);
        ErrorRender::show($errorInfo);
        return true;
    }

    /**
     * Fatal error handler
     * @return void
     */
    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & ( E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            ob_end_clean();
            $trace = $error['trace'];
            array_unshift($trace, [
                'file' => $error['file'],
                'line' => $error['line'],
            ]);
            $traceCollection = StackTrace::get($trace);
            $traceAsString = $this->getTraceAsString($trace);
            $errorInfo = new ErrorInfo(
                'Fatal Error',
                $traceAsString,
                $error['type'],
                $error['message'],
                $traceCollection,
            );
            if ($this->saveLog) ErrorLogger::write(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line'],
                $this->pathToLogFile);
            ErrorRender::show($errorInfo);
        } else {
            ob_end_flush();
        }
    }

    /**
     * Exception handler
     * @param \Exception $exception
     * @return true
     */
    public function exceptionHandler(\Throwable $exception)
    {

        $trace = $exception->getTrace();
        array_unshift($trace, [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
        $traceCollection = StackTrace::get($trace);
        $traceAsString = $this->getTraceAsString($trace);
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

    /**
     * Get processed trace string for error
     * @param $trace
     * @return string
     */
    function getTraceAsString($trace): string
    {
        $str = "";
        $count = 0;
        foreach ($trace as $frame) {
            $args = "";
            if (isset($frame['args'])) {
                $args = array();
                foreach ($frame['args'] as $arg) {
                    if (is_string($arg)) {
                        $args[] = "'" . $arg . "'";
                    } elseif (is_array($arg)) {
                        $args[] = "Array";
                    } elseif (is_null($arg)) {
                        $args[] = 'NULL';
                    } elseif (is_bool($arg)) {
                        $args[] = ($arg) ? "true" : "false";
                    } elseif (is_object($arg)) {
                        $args[] = get_class($arg);
                    } elseif (is_resource($arg)) {
                        $args[] = get_resource_type($arg);
                    } else {
                        $args[] = $arg;
                    }
                }
                $args = join(", ", $args);
            }
            $str .= sprintf(
                "#%s %s(%s): %s%s%s(%s)<br>",
                $count,
                $frame['file'],
                $frame['line'],
                $frame['class'] ?? '',
                $frame['type'] ?? '',
                $frame['function'] ?? '',
                $args
            );
            $count++;
        }
//        $str .= "#$count  {main}<br>";
        return $str;
    }
}