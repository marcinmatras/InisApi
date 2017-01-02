<?php

namespace Marcinmatras\InisApi\Action;

use Marcinmatras\InisApi\Inis;
use Marcinmatras\InisApi\Request\Send;

class CheckEmail extends Inis {

    public function execute($email, $name = null) {
        $params = $this->getParams($email, $name);
        $url = $this->getUrl($params);
        $sObj = new Send($url, 'check');
        return $sObj->execute();
    }

    private function getParams($email, $name = null) {
        $params = [
            's_uid=' . urlencode($this->s_uid),
            's_key=' . $this->s_key,
            's_email=' . $email,
        ];

        return $params;
    }

    private function getUrl(array $params) {
        $requestString = implode('&', $params);
        return parent::HOST . '/chk.php?' . $requestString;
    }

}
