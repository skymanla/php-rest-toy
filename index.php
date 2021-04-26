<?php
/*
 * skymanla
 * ryan-dev@kakao.com
 * PHP MVC
 */

require __DIR__.'/vendor/autoload.php';

// Route Class 를 사용할게요
use App\Model\Route;
use App\Providers\XssProvider;

$request_uri = $_SERVER['REQUEST_URI'];

$xss = new XssProvider($_SERVER['REQUEST_URI']);
$xssPath = $xss->reChangeRequest();

$route = new Route($xssPath); // 현재 들어온 request_parameters 를 생성자에 전달
$route->setRoute(); // Route setting