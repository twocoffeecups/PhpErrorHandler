<?php

namespace TwoCoffeCups\PHPErrorHandler\Logger;

class ErrorLogger
{
    private function __construct(){}

    /**
     * Сreate an error message and call the logger
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param string $pathToLogFile
     * @return void
     * @throws \TwoCoffeCups\PHPErrorHandler\Exception\PermissionException
     */
    public static function write(int $errno, string $errstr, string $errfile, int $errline, string $pathToLogFile)
    {
        $message = "Date: " . date("Y-m-d H-i-s") . "
               \nError code: $errno.
               \nError message: $errstr,
               \nin file: $errfile, on line: $errline
               \n########################################################################################################################\n";
        $logger = new Logger();
        $logger->write($pathToLogFile, $message);
    }
}