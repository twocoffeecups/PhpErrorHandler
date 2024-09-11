<?php

namespace TwoCoffeCups\PHPErrorHandler\TraceStack;

class TraceStackDispatcher
{
    /**
     * Fill the collection with processed objects
     * @return TraceStackCollection
     */
    public static function createStackTraceCollection(array $stackTrace): TraceStackCollection
    {
        $collection = new TraceStackCollection();
        foreach ($stackTrace as $frame) {
            $file = self::getFile($frame['file'], $frame['line']);
            $obj = new TraceStackProperties(
                $frame['file'],
                $frame['line'],
                $file,
                $frame['function'] ?? null,
                $frame['class'] ?? null,
                $frame['type'] ?? null,
            );
            $collection->setItem($obj);
        }
        return $collection;
    }

    /**
     * Get file
     * @param string $file
     * @param int $line
     * @return string
     */
    public static function getFile(string $file, int $line): string
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

    /**
     * Get processed trace string for error
     * @param $trace
     * @return string
     */
    public static function getTraceAsString($trace): string
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
        return $str;
    }
}