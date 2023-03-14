<?php

$GLOBALS['ROOT_DOCUMENT'] = realpath($_SERVER["DOCUMENT_ROOT"]);

function getUri() {
    return explode("?", $_SERVER['REQUEST_URI'])[0];
}

function controllers(string $name): string {
    return getPath('controllers') . $name . 'Controller.php';
}

function views(string $name): string {
    return getPath('views') . $name . 'View.twig';
}

function models(string $name): string {
    return getPath('models') . $name . 'Model.php';
}

function getPath(string $type) : string {
    return  $GLOBALS['ROOT_DOCUMENT'] . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR;
}
