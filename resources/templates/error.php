<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
            padding: 0;
            margin: 0;
        }

        header {
            padding: 0;
            margin: 0;
        }

        .header__container {
            max-width: 1400px;
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
                <h3 class="d-flex text-white">ERROR HAS INTERCEPTED</h3>

                <span class="text-white">500 http Server error.</span>
            </div>
        </div>
        <div class="container-fluid" style="background-color: #AA3F3C">
            <div class="container d-flex justify-content-between header__container">
                <h4 class="text-white">New Exception</h4>
            </div>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="mx-auto" style="max-width: 1400px">
        <ul class="nav nav-pills mb-3" id="error__nav__tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                        class="nav-link  active"
                        id="error__tab"
                        data-bs-toggle="tab"
                        data-bs-target="#nav__error"
                        type="button" role="tab"
                        aria-controls="nav__error"
                        aria-selected="true">
                    Error
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                        class="nav-link"
                        id="trace__tab"
                        data-bs-toggle="tab"
                        data-bs-target="#nav__trace"
                        type="button" role="tab"
                        aria-controls="nav__trace"
                        aria-selected="false">
                    Trace
                </button>
            </li>
        </ul>
        <div class="tab-content" id="error__tab">
            <!-- Error tab -->
            <div class="tab-pane fade show active" id="nav__error" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">

                <!-- Error message -->
                <div class="card my-2 mx-auto" style="max-width: 1400px">
                    <div class="card-body error__info__container d-flex flex-column">
                        <ul class="list-unstyled">
                            <li>Error code: <b><?=$errorInfo->errNo?></b></li>
                            <li><?=$errorInfo->message?>.</li>
                        </ul>
                    </div>
                </div>
                <!-- Trace -->

                <!-- V1 -->
                <div class="d-flex align-items-start my-4" style="max-height: 600px; max-width: 1400px">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" style="max-width: 450px" aria-orientation="vertical">
                        <?php foreach ($errorInfo->stackTrace->getAll() as $id => $trace): ?>
                            <button
                                    class="btn btn-outline-primary rounded-0 <?=$id==0 ? 'active':'';?>"
                                    id="v-pills-home-tab"
                                    data-bs-toggle="pill"
                                    style="max-width: 430px; font-size: 0.9em"
                                    data-bs-target="#v-pills-<?=$id?>"
                                    type="button" role="tab"
                                    aria-controls="v-pills-<?=$id?>"
                                    aria-selected="true">
                                <div class="d-flex flex-column align-items-start">
                                    <span>
                                    In file:
                                    </span>
                                    <span>
                                        <b><?=$trace->fileName?></b>
                                    </span>
                                    <span>
                                        on line <b><?=$trace->line?></b>
                                    </span>
                                </div>
                            </button>
                        <?php endforeach;?>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent" style="overflow-x: auto; width: 100%; max-width: 950px">
                        <?php foreach ($errorInfo->stackTrace->getAll() as $id => $trace): ?>
                            <div
                                class="tab-pane fade <?=$id==0 ? 'show active':'';?>"
                                id="v-pills-<?=$id?>" role="tabpanel"
                                aria-labelledby="v-pills-<?=$id?>-tab"
                                tabindex="0">
                                <?=$trace->file?>
                            </div>
                        <?php endforeach;?>
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