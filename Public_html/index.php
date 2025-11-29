<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// রাউটিং
$request = $_GET['path'] ?? 'home';

switch($request) {
    case 'home':
        include 'templates/home.php';
        break;
    case 'payment':
        include 'payment/initiate.php';
        break;
    case 'callback':
        include 'payment/callback.php';
        break;
    case 'success':
        include 'payment/success.php';
        break;
    case 'failed':
        include 'payment/failed.php';
        break;
    default:
        http_response_code(404);
        include 'templates/404.php';
}
?>
