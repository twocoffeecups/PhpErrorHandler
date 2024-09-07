<?php

namespace TwoCoffeCups\ErrorHandler\Render;

class ErrorRender
{
    protected const ERROR_PAGE = __DIR__ . '/../resources/templates/error.php';
    protected const MAX_LINE_IN_FILE = 6;

    public static function show($errno, $errstr, $errfile, $errline, $trace, $status = 500)
    {
        $file = self::getCode($errfile, $errline);
        echo self::render(compact('errno', 'errstr', 'errfile', 'errline', 'status', 'file'));
        die;
    }

    public static function getCode(string $file, $line)
    {
        $fileWithError = file($file);
        $str = "";
        foreach ($fileWithError as $lineInFile => $sting) {

            if(($lineInFile <= ($line + self::MAX_LINE_IN_FILE) && $lineInFile >= ($line - self::MAX_LINE_IN_FILE)) && $lineInFile !== $line - 1) {
                $str .= "<pre style='padding: 0; margin: 0'>$lineInFile : $sting</pre> <br>";
            }
            if($lineInFile === $line - 1) {
                $str .= "<pre style='padding: 0; margin: 0'>$lineInFile : <b style='color: white; background-color: red; padding: 4px'>$sting</b></pre> <br>";
            }
        }
        return str_replace(['<?php', '?>', '<?', '<?='], '', $str);

    }

    public static function render(array $variables)
    {
        ob_start();
        extract($variables);
        include(self::ERROR_PAGE);
        $page = ob_get_contents();
        ob_end_clean();
        return $page;
    }
}