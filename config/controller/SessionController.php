<?php

namespace App\Controller;

class SessionController
{
    public static $sessFolder = '/common/save/session/path';
    // login save session
    public function saveLoginSession(array $array)
    {
        $_SESSION['DELIVERY_DRIVER_CODE'] = $array['code'];
        $_SESSION['BRANCH_CODE'] = $array['branch_code'];
        $_SESSION['USER_EMAIL'] = $array['email'];
        $_SESSION['USER_NAME'] = $array['name'];
        $_SESSION['USER_TEL'] = isset($array['tel']) ? $array['tel'] : '010-0000-0000';
        $_SESSION['USER_POSITION'] = isset($array['position']) ? $array['position'] : '';
        $_SESSION['LOGIN_TIMESTAMP'] = strtotime(date('Y-m-d H:i'));

        session_write_close();
    }

    // Read Notification save session
    public function saveNotificationExchange(array $array)
    {

    }

    // load session
    public function loadSession()
    {
        if (!is_dir(self::$sessFolder)) {
            mkdir(self::$sessFolder, 0755);
        }

        if (!isset($_SESSION)) {
            session_save_path(self::$sessFolder);
            session_cache_expire(1440);
            ini_set("session.gc_maxlifetime", 10800); //세션 가비지 컬렉션(로그인시 세션지속 시간) : 초
            session_start();
        }
        return $_SESSION;
    }

    // session unset
    public static function unsetSession()
    {
        unset($_SESSION);
    }
}
