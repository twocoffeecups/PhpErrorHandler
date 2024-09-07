<?php

namespace TwoCoffeCups\PHPErrorHandler\Logger;

use TwoCoffeCups\PHPErrorHandler\Exception\PermissionException;

class Logger
{

    /**
     * The name of the file for storing logs
     * @var string
     */
    private const FILE_NAME = 'error.log';

    /**
     * Write error logs in file
     * @param string $dir
     * @param string $message
     * @return bool
     * @throws PermissionException
     */
    public function write(string $dir, string $message)
    {
        if(!$this->dirExists($dir)){
            $this->makeDirectory($dir);
        }
        if(!$this->checkHasPermissions($dir)) { // isFileWritable
            throw new PermissionException("Unable to write log file on path {$dir}: Permission denied.");
        }
        return error_log($message, 3, $dir . "/" . self::FILE_NAME);
    }

    /**
     * Сreate a folder for storing logs
     * @param string $dir
     * @return bool|mixed
     * @throws PermissionException
     */
    private function makeDirectory(string $dir)
    {
        return $this->checkHasPermissions($dir)
            ? mkdir($dir, 0777, true)
            : throw new PermissionException("Unable to dir on path {$dir}: Permission denied");
    }

    /**
     * Сheck if the folder exists
     * @param string $dir
     * @return bool
     */
    public function dirExists(string $dir): bool
    {
        return file_exists($dir);
    }

    /**
     * Сheck if there are permissions to work with dir and files
     * @param string $dir
     * @return bool
     */
    public function checkHasPermissions(string $dir): bool
    {
        return is_writable(dirname($dir));
    }
}