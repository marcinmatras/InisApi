<?php

namespace Marcinmatras\InisApi\Action;

use Marcinmatras\InisApi\Inis;
use Marcinmatras\InisApi\Request\Send;
use Marcinmatras\InisApi\Exception;

class RemoveEmail extends Inis {

    public function execute($email) {
        $response = $this->add($email, null, ['s_no_send' => 1]);
        if (!($response instanceof \Marcinmatras\InisApi\Response\Response)) {
            throw new Exception('Nie można pobrać mkey dla podanego adresu email', -200);
        }

        $params = $this->getParams($response->key());
        $url = $this->getUrl($params);
        $sObj = new Send($url, 'remove');
        return $sObj->execute();
    }

    private function getParams($key) {
        $params = [
            'u=' . urlencode($this->s_uid),
            'key=' . $this->s_key,
            'mkey=' . $key,
        ];

        return $params;
    }

    private function getUrl(array $params) {
        $requestString = implode('&', $params);
        return parent::HOST . '/rm.php?' . $requestString;
    }

}
