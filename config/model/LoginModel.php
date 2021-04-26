<?php

namespace App\Model;

use App\Model\DbConnection as DBO;

class LoginModel extends DBO
{
    private $email;
    private $pwd;

    public function __construct($email, $pwd)
    {
        $this->email = $email;
        $this->pwd = $pwd;
    }

    public function authMember()
    {
        $db = parent::connectionHost(); // DB Connector
        $query = "select * from bank_integrated_manager where email = :email and is_deliver = 'Y'";
        $sql = $db->prepare($query);

        $sql->execute(['email' => $this->email]);
        if ($sql->rowCount() < 1) {
            return false;
        }

        $data = $sql->fetch(\PDO::FETCH_ASSOC);

        if (!password_verify($this->pwd, $data['pw'])) {
            return false;
        }

        return $data;
    }
}
