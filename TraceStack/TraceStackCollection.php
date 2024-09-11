<?php

namespace TwoCoffeCups\PHPErrorHandler\TraceStack;

class TraceStackCollection
{
    /**
     *
     * @var array
     */
    private array $traceStack;

    /**
     * Set trace stack in array
     * @param TraceStackProperties $stackTrace
     * @return void
     */
    public function setItem(TraceStackProperties $stackTrace): void
    {
        $this->traceStack[] = $stackTrace;
    }

    /**
     * Get all trace stack objects
     * @return array
     */
    public function getAll(): array
    {
        return $this->traceStack;
    }

    /**
     * Add the main file if the error is fatal or an exception
     * @param string $fileName
     * @param int $line
     * @return $this
     */
    public function pushMainFile(string $fileName, int $line): TraceStackCollection
    {
        $file = TraceStackDispatcher::getFile($fileName, $line);
        $traceProperties = new TraceStackProperties($fileName, $line, $file,);
        array_unshift($this->traceStack, $traceProperties);
        return $this;
    }
}