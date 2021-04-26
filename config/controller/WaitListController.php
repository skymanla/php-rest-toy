<?php

namespace App\Controller;

use App\Model\DbConnection as DBO;
use App\Model\SetAlert;
use App\Model\ApiModel;
use App\Model\WaitListModel;
use App\Controller\MemberController as Member;


class WaitListController extends DBO
{
    private $path;
    private $fullPath;
    private $getParams;
    private $sess;

    // data list
    private $items;

    public function __construct($parentPath, $fullPath, $getParams, $sessArray)
    {
        $this->path = $parentPath;
        $this->fullPath = $fullPath;
        $this->getParams = $getParams;
        $this->sess = $sessArray;
    }

    // start routing
    public function startApp()
    {
        $alert = new SetAlert();
        $member = new Member();

        // session이 없으면 alert 띄우고 index로 이동
        if (isset($this->sess) && count($this->sess) < 1) {
            session_destroy();
            $alert->loadType('msglink', '인증된 회원만 접근 가능합니다', '/');
            exit;
        }

        $checkMember = $member->startApp();
        if ($checkMember['msg'] === 'fail') {
            session_destroy();
            $alert->loadType('msglink', '인증된 회원만 접근 가능합니다', '/');
            exit;
        }

        // http method
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                $this->getListPage(); // 리스트 출룍 페이지
                break;
            default:
                break;
        }
    }

    // 리스트 출력 컨트롤러
    private function getListPage()
    {
        $parentPath = $this->path;
        $model = new WaitListModel($this->getParams, $this->fullPath, $this->path);
        $list = $model->getItems();

        $api = new ApiModel();
        $notification = $api->getNewExchangeList();

        include_once 'resource/wlist.php';
    }
}