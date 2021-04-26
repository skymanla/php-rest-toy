<?php

namespace App\Model;

class DbConnection extends Mode
{
    private $ip;

    protected function connectionHost()
    {
        $mode = parent::getDevMode($_SERVER['REMOTE_ADDR']);
        $dbName = 'root';
        $dbUser = 'root';
        $dbPwd = 'password';
        $port = 3306;

        $dbHost = 'localhost';
        return $this->pdoConnection($dbHost, $dbName, $dbUser, $dbPwd, $port);
    }

    protected function pdoConnection($host, $db, $user, $pwd, $port)
    {
        try {
            $db = new \PDO('mysql:host='.$host.':'.$port.';dbname='.$db, $user, $pwd);
        } catch (PDOException $e) {
            echo 'Connect failed : '.$e->getMessage().'';

            return false;
        }

        return $db;
    }
}
