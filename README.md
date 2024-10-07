# PhpErrorHandler

An easy-to-use PHP error handler that helps with code debugging and allows you to save logs.

![Screenshot 2024-10-07 231526](https://github.com/user-attachments/assets/c7888e1b-74e7-4ff7-b51e-614aea04cedc)

### Installation
<hr>

Use this command: 
```
composer install twocoffeecups/php-error-handler
```

### Usage
<hr>

Add the class <b>\TwoCoffeCups\PHPErrorHandler\ErrorHandler()</b> to the beginning of your index file:
```
<?php

require_once "../vendor/autoload.php";

// new ErrorHandler object
new \TwoCoffeCups\PHPErrorHandler\ErrorHandler();

// your code:
...
```

### Log files
<hr>

You can save the error log to a file by adding two optional parameters to the class declaration.

- $saveLog: By default, it takes the value is <b>false</b>. To enable saving logs, set the value - <b>true</b>.
- $pathToLogFile: By default, it takes the value is <b>null</b>. Add a string variable with the path to the folder containing the log file.

Usage example:
```
$saveLog = true;

// path to logs dir
$pathToLogFile = __DIR__ . "/logs";

// new ErrorHandler object
new \TwoCoffeCups\PHPErrorHandler\ErrorHandler(
    $saveLog,
    $pathToLogFile,
);
```

### Debug
<hr>

If you want to use the funds for debugging, add to the beginning of the script:
```
use TwoCoffeCups\PHPErrorHandler\Debugger\Debugger;
```

And use it in your code:
```
$str = "Some text";

// if you need the script not to shut down
Debugger::dump($str)

// if you need the script to shut down
Debugger::dd($str)
```

### Known problems
<hr>

- If you have enabled the saving of log files and receive the "access error" message, please check that you have permission to write files to the specified folder.