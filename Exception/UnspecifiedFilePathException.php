<?php

namespace TwoCoffeCups\PHPErrorHandler\Exception;

use TwoCoffeCups\PHPErrorHandler\Render\ErrorRender;
use Throwable;

class UnspecifiedFilePathException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        ErrorRender::show($this->getCode(), $message, $this->getFile(), $this->getLine(), $this->getTrace());
    }
}