<?php
// Get request URI
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

/**
 * Todo: setup routes for views
 */
switch ($request_uri[0]) {
    // Home page
    case '/':
        require 'views/modules/display.php';
        break;
    // Login page
    case '/login':
        require '../views/login.php';
        break;
    // Everything else
    default:
        header('HTTP/1.0 404 Not Found');
        //require '../views/404.php';
        break;
}