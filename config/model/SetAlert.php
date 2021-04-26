<?php

namespace App\Model;

class SetAlert
{
    public function loadType($type, $message = '', $link = '')
    {
        switch ($type) {
            case 'msglink':
                $this->getMsgType($message, $link);
                break;
            case 'nomsglink':
                $this->getNoMsgType($link);
                break;
            case 'msgback':
                $this->getMsgBackType($message);
                break;
        }
        return true;
    }

    private function getMsgType($message, $link)
    {
        echo '<html><script>alert("'.$message.'");</script><meta http-equiv="refresh" content="0; url='.$link.'"></meta></html>';
        return;
    }

    private function getNoMsgType($link)
    {
        echo '<html><meta http-equiv="refresh" content="0; url=' .$link. '"></meta></html>';
        return;
    }

    private function getMsgBackType($message)
    {
        echo '<html><script>alert("'.$message.'");history.back();</script></html>';
        return;
    }
}