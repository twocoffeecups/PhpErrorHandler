<?php

namespace TwoCoffeCups\PHPErrorHandler\StackTrace;

class StackTrace
{
    /**
     * Get the processed trace stack (files and info)
     * @param array $trace
     * @return array
     */
    public static function get(array $trace): array
    {
        $dispatcher = new StackTraceDispatcher($trace);
        return $dispatcher->getProcessedStack();
    }
}