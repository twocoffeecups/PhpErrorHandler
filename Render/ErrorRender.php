<?php

namespace TwoCoffeCups\PHPErrorHandler\Render;

use TwoCoffeCups\PHPErrorHandler\ErrorInfo\ErrorInfo;

class ErrorRender
{
    /**
     * Path to error page
     */
    protected const ERROR_PAGE = __DIR__ . '/../resources/templates/error.php';

    /**
     * @param ErrorInfo $errorInfo
     * @return void
     */
    public static function show(ErrorInfo $errorInfo): void
    {
        echo self::render($errorInfo);
        die;
    }

    /**
     * @param ErrorInfo $errorInfo
     * @return false|string
     */
    public static function render(ErrorInfo $errorInfo): string|false
    {
        ob_start();
        extract([$errorInfo]);
        include(self::ERROR_PAGE);
        $page = ob_get_contents();
        ob_end_clean();
        return $page;
    }
}