<?php

namespace TwoCoffeCups\PHPErrorHandler\TraceStack;

class TraceStackProperties
{
    /**
     * File name
     * @var string
     */
    public string $fileName;
    public string $file;

    /**
     * Еhe line where the error appears
     * @var int
     */
    public int $line;

    /**
     * Function name
     * @var string|null
     */
    public string|null $function;

    /**
     * Class name
     * @var string|null
     */
    public string|null $class;

    /**
     * Type: -> or ::
     * @var string|null
     */
    public string|null $type;

    /**
     * @param string $fileName
     * @param int $line
     * @param string $file
     * @param string|null $function
     * @param string|null $class
     * @param string|null $type
     */
    public function __construct(
        string $fileName,
        int $line,
        string $file,
        string|null $function = null,
        string|null $class = null,
        string|null $type = null,
    )
    {
        $this->fileName = $fileName;
        $this->function = $function;
        $this->line = $line;
        $this->file = $file;
        $this->class = $class;
        $this->type = $type;
    }
}