<?php
//require_once 'migration1.php';
require_once './helpers.php';

switch (getUri()) {
    case '/':
        require_once controllers('home');
        break;
    case '/post':
        require_once controllers('post');
        break;
    case '/connection':
        require_once controllers('connection');
        break;
    case '/addCalendar':
        require_once controllers('addCalendar');
        break;
    default:
        require_once controllers('error');
}
