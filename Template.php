<?php

require_once 'vendor/autoload.php';

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

$loader = new \Twig\Loader\FilesystemLoader("$root/views/Templates");
$twig = new \Twig\Environment($loader, [
    'cache' => False,
]);


