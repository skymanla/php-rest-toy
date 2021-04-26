<?php
/*
 * skymanla
 * ryan-dev@kakao.com
 * Route Class
 */
namespace App\Model;

use App\Controller\SessionController;


// Monolog
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Logger;
use Monolog\Handler\FirePHPHandler;

class Route
{
    private $uri;
    private $getParam;
    private $getUri;

    public function __construct($requestUri)
    {
        $this->uri = $requestUri;
    }

    // route 생성
    public function setRoute()
    {
        $this->cutRequestUri(); // uri 컷팅

        $sess = new SessionController();
        $sessArray = $sess->loadSession();

        $APP_URL = 'php-rest-toy-project';
        // Create some handlers
        $stream = new StreamHandler('/save/logs/path/'.$APP_URL.'/accessg-'.date('Y-m-d', time()).'.log', Logger::INFO);
        $firephp = new FirePHPHandler();

        // Create the main logger of the app
        $logger = new Logger('project');
        $logger->pushHandler($stream);
        $logger->pushHandler($firephp);

        // Create a logger for the security-related stuff with a different channel
        $securityLogger = new Logger('security');
        $securityLogger->pushHandler($stream);
        $securityLogger->pushHandler($firephp);

        // Or clone the first one to only change the channel
        $securityLogger = $logger->withName('security');


        $logger->info('Request Uri', array('Request' => $_SERVER['REQUEST_URI'], 'session' => [$sessArray['DELIVERY_DRIVER_CODE'] ?? '', $sessArray['BRANCH_CODE'] ?? '', $sessArray['USER_EMAIL'] ?? '', $sessArray['USER_NAME'] ?? ''], 'data' => $_REQUEST));

        if (isset($this->getUri[0]) && !empty($this->getUri[0])) { // 불러올 수 있는 컨트롤러가 있으면
            $parentPath = $this->getUri[0];
            switch ($parentPath) {
                default: // 엄한 경로면 이쪽으로 보냄
                    $parentPath = '';
                    $inPath = new \App\Controller\LoginController($parentPath, $this->getUri, $this->getParam, $sessArray);
                    $inPath->startApp();
                    break;
            }
        } else {
            $parentPath = '';
            $inPath = new \App\Controller\LoginController($parentPath, $this->getUri, $this->getParam, $sessArray);
            $inPath->startApp();
        }
    }

    private function cutRequestUri()
    {
        $paramArray = array_values(array_filter(explode('?', $this->uri))); // uri cutting
//        $getParams = array_pop($paramArray); // request parameter save
        $getUri = array_shift($paramArray); // request uri save
        $uriArray = array_values(array_filter(explode('/', $getUri))); // uri cutting

        $this->getUri = $uriArray;
        if (isset($_REQUEST) && count($_REQUEST) > 0) {
            $this->getParam = $_REQUEST;
        }
    }
}
