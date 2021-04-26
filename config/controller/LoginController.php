<?php

namespace App\Controller;

use App\Model\SetAlert;
use App\Controller\SessionController;
use App\Model\LoginModel;

class LoginController
{
    private $path;
    private $fullPath;
    private $getParams;
    private $sess;

    public function __construct($parentPath, $fullPath, $getParams, $sessArray)
    {
        $this->path = $parentPath;
        $this->fullPath = $fullPath;
        $this->getParams = $getParams;
        $this->sess = $sessArray;
    }

    public function startApp()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'GET':
                unset($_SESSION);
                $this->checkLogin();
                break;
            case 'POST':
                $this->validateLogin($this->getParams);
                break;
            default:
                break;
        }
    }

    public function checkLogin()
    {
        $alert = new SetAlert();

        $parentPath = $this->path;
        if (isset($this->sess) && count($this->sess) < 1) {
            include_once 'resource/index.php';
            return false;
        } else {
            $alert->loadType('nomsglink', '', '/list/1');
            return false;
        }
        return true;
    }

    public function validateLogin($request)
    {
        $sess = new SessionController();
        $alert = new SetAlert();

        if (isset($request['emailSave'])) {
            setcookie('SAVE_ID', $request['userEmail'], time() + 86400 * 30, '/');
        }

        $email = isset($request['userEmail']) && !empty($request['userEmail']) ? $request['userEmail'] : '';
        $pw = isset($request['userPwd']) && !empty($request['userPwd']) ? $request['userPwd'] : '';
        if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
            $alert->loadType('msglink', 'email 형식 오류입니다', '/');
            exit;
        }
        if(strlen($pw) > 20 || empty($pw)) {
            $alert->loadType('msglink', '패스워드 형식 오류입니다', '/');
            exit;
        }

        $model = new LoginModel($email, $pw);
        $member = $model->authMember();

        if ($member === false) {
            $alert->loadType('msglink', '회원인증에 실패했습니다.\n입력하신 사용자 정보를 다시 확인해 주시기 바랍니다.', '/');
            exit;
        }

        $sess->saveLoginSession($member);

        $alert->loadType('nomsglink', '', '/list/1');
        exit;
    }

    public function testSession()
    {
        print_r($_SESSION);
    }
}