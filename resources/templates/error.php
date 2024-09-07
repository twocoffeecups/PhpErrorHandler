<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        header {
            padding: 0;
            margin: 0;
        }

        .header__container {
            max-width: 800px;
            padding: 8px;
        }

        .error__info__container {

        }

        .error__file__info {
            overflow: auto;
            padding: 8px;
        }
    </style>
</head>
<body>

<header>
    <div class="row m-0">
        <div class="container-fluid" style="background-color: #993836">
            <div class="container header__container d-flex justify-content-between align-items-center">
                <h3 class="d-flex text-white">Error page</h3>

                <span class="text-white">500 http Server error.</span>
            </div>
        </div>
        <div class="container-fluid " style="background-color: #AA3F3C">
            <div class="container header__container">
                <h4 class="text-white">Error type</h4>
            </div>
        </div>
    </div>
</header>

<div class="container my-4">
    <div class="card mx-auto" style="max-width: 800px">
        <div class="card-body error__info__container d-flex flex-column">
            <ul class="list-unstyled">
                <li>Error code: <b><?=$errno?></b></li>
                <li>Error! <?=$errstr?>.</li>
<!--                <li>In file <b>--><?php //=$errfile?><!--</b></li>-->
<!--                <li>On line <b>--><?php //=$errline?><!--</b></li>-->
            </ul>
        </div>
    </div>
</div>

<div class="container my-1">
    <div class="card mx-auto" style="max-width: 800px">
        <div class="card-header">
            Error in file <b><?=$errfile?></b> on line <b><?=$errline?></b>
        </div>
        <div class="card-body error__file__info">
             <pre>
                 <?=$file?>
             </pre>
        </div>
    </div>
</div>


<!--<div class="container">-->
<!--    <div class="d">-->
<!--        <h1 class="heading">ERROR PAGE.</h1>-->
<!--        <br>-->
<!--        <div class="error__info">-->
<!--            <p>Error code: <b>--><?php //=$errno?><!--</b></p>-->
<!--            <p>Error! --><?php //=$errstr?><!--.</p>-->
<!--            <p>In file <b>--><?php //=$errfile?><!--</b></p>-->
<!--            <p>On line <b>--><?php //=$errline?><!--</b></p>-->
<!---->
<!--        </div>-->
<!--        <div class="error__file__preview">-->
<!--            <pre>-->
<!--                --><?php //=$file?>
<!--            </pre>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>