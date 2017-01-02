<?php

namespace Marcinmatras\InisApi\Action;

use Marcinmatras\InisApi\Inis;
use Marcinmatras\InisApi\Request\Send;
use Marcinmatras\InisApi\Exception;

class UpdateEmail extends Inis {

    public function execute($email, $name) {
        $response = $this->add($email, null, ['s_no_send' => 1]);
        if (!($response instanceof \Marcinmatras\InisApi\Response\Response)) {
            throw new Exception('Nie można pobrać mkey dla podanego adresu email', -200);
        }

        $params = $this->getParams($response->key(), $name);
        $url = $this->getUrl($params);
        $sObj = new Send($url, 'remove');
        return $sObj->execute();
    }

    private function getParams($mkey, $name = null) {
        $params = [
            's_uid=' . urlencode($this->s_uid),
            's_mkey=' . $mkey,
            's_encoded=' . $this->s_encoded,
            's_ip=' . urlencode($_SERVER['REMOTE_ADDR']),
            's_rv=1',
            's_no_send=' . $this->s_no_send,
        ];

        if (null !== $name) {
            $params[] = 's_name=' . urlencode($name);
        }

        if (is_array($this->s_group)) {
            foreach ($this->s_group as $group) {
                $params[] = 's_group_' . $group . '=1';
            }
        } elseif ($this->s_group) {
            $params[] = 's_group_' . $this->s_group . '=1';
        }
        return $params;
    }

    private function getUrl(array $params) {
        $requestString = implode('&', $params);
        return parent::HOST . '/upd.php?' . $requestString;
    }

}
