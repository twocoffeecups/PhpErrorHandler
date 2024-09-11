<?php

namespace TwoCoffeCups\PHPErrorHandler\ErrorInfo;

use TwoCoffeCups\PHPErrorHandler\TraceStack\TraceStackCollection;

class ErrorInfo
{
    /**
     * Error type
     * @var string
     */
    public string $errorType;

    /**
     * Trace as sting
     * @var string
     */
    public string $traceAsString;

    /**
     * Error number or code
     * @var int
     */
    public int $errNo;

    /**
     * Error message
     * @var string
     */
    public string $message;

    /**
     * Trace stack collection
     * @var TraceStackCollection
     */
    public TraceStackCollection $stackTrace;


    /**
     * @param string $errorType
     * @param string $traceAsString
     * @param int $errNo
     * @param string $errMsg
     * @param TraceStackCollection $trace
     */
    public function __construct(string $errorType, string $traceAsString, int $errNo, string $errMsg, TraceStackCollection $trace,)
    {
        $this->errorType = $errorType;
        $this->traceAsString = $traceAsString;
        $this->errNo = $errNo;
        $this->message = $errMsg;
        $this->stackTrace = $trace;
    }
}