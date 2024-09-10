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
            max-width: 900px;
            padding: 8px;
        }

        .error__info__container {

        }

        .error__file__info {
            overflow: auto;
            padding: 10px;
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
                <h4 class="text-white"><?=$errorInfo->errorType?></h4>
            </div>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="mx-auto" style="max-width: 900px">
        <ul class="nav nav-pills mb-3" id="error__nav__tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="error__tab" data-bs-toggle="tab" data-bs-target="#nav__error" type="button" role="tab" aria-controls="nav__error" aria-selected="true">Error</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="trace__tab" data-bs-toggle="tab" data-bs-target="#nav__trace" type="button" role="tab" aria-controls="nav__trace" aria-selected="false">Trace</button>
            </li>
        </ul>
        <div class="tab-content" id="error__tab">
            <!-- Error tab -->
            <div class="tab-pane fade show active" id="nav__error" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">

                <!-- Error message -->
                <div class="card my-2 mx-auto" style="max-width: 900px">
                    <div class="card-body error__info__container d-flex flex-column">
                        <ul class="list-unstyled">
                            <li>Error code: <b><?=$errorInfo->errNo?></b></li>
                            <li><?=$errorInfo->message?>.</li>
                        </ul>
                    </div>
                </div>

                <!-- Files -->
                <div class="mx-auto" style="max-width: 900px">
                    <div class="accordion" id="error__stack__trace">
                        <?php foreach ($errorInfo->stackTrace as $id => $trace): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse-<?=$id?>"
                                            aria-expanded="<?=$id==0 ? 'true' : 'false' ?>"
                                            aria-controls="collapse-<?=$id?>">
                                        <ul class="list-unstyled">
                                            <li>
                                                <span>
                                                    <?=$trace->class && $trace->type ? $trace->class . $trace->type:''?><?=$trace->function ? $trace->function.'()': ''?>
                                                </span><br>
                                            </li>
                                            <li class="mt-1">
                                                <span>
                                                    In file <b><?=$trace->fileName?></b> on line <b><?=$trace->line?></b>
                                                </span>
                                            </li>
                                        </ul>
                                    </button>
                                </h2>
                                <div id="collapse-<?=$id?>"
                                     class="accordion-collapse collapse show"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?=$trace->file?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>

            <!-- Trace tab -->
            <div class="tab-pane fade" id="nav__trace" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                <div class="card">
                    <div class="card-body">
                        <code style="font-size: 0.8em; color: black;">
                            <?=$errorInfo->traceAsString?>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>