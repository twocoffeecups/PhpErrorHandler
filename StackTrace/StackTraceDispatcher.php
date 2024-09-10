<?php

namespace TwoCoffeCups\PHPErrorHandler\StackTrace;

use TwoCoffeCups\PHPErrorHandler\Debugger\Debugger;

class StackTraceDispatcher
{
    /**
     * Trace map array
     * @var array
     */
    public array $trace;

    /**
     * @param $trace
     */
    public function __construct($trace)
    {
        $this->trace = $trace;
    }

    /**
     * Get processed trace stack
     * @return array
     */
    public function getProcessedStack()
    {
        return $this->process();
    }

    /**
     * Start process
     * @return array
     */
    private function process()
    {
        $objects = [];
        foreach ($this->trace as $frame) {
            $file = $this->getFile($frame['file'], $frame['line']);
            $obj = new StackTraceProperties(
                $frame['file'],
                $frame['line'],
                $file,
                $frame['function'] ?? null,
                $frame['class'] ?? null,
                $frame['type'] ?? null,
            );
            $objects[] = $obj;
        }
        return $objects;
    }

    /**
     * Get file
     * @param string $file
     * @param int $line
     * @return string
     */
    private function getFile(string $file, int $line): string
    {
        $fileWithError = file($file);
        $maxLineInFile = 5;
        $str = "";
        foreach ($fileWithError as $lineInFile => $sting) {

            if(($lineInFile <= ($line + $maxLineInFile) && $lineInFile >= ($line - $maxLineInFile)) && $lineInFile !== $line - 1) {
                $str .= "<pre style='padding: 0; margin: 0'>$lineInFile : $sting</pre> <br>";
            }
            if($lineInFile === $line - 1) {
                $str .= "<pre style='padding: 0; margin: 0'>$lineInFile : <b style='color: white; background-color: red; padding: 4px'>$sting</b></pre> <br>";
            }
        }
        $str = str_replace(['<?php', '?>', '<?', '<?='], '', $str);
        return $str;
    }
}