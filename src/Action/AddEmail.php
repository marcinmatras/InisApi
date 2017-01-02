<?php

namespace Marcinmatras\InisApi\Action;

use Marcinmatras\InisApi\Inis;
use Marcinmatras\InisApi\Request\Send;

class AddEmail extends Inis {

    public function execute($email, $name = null) {
        $params = $this->getParams($email, $name);
        $url = $this->getUrl($params);
        $sObj = new Send($url, 'add');
        return $sObj->execute();
    }

    private function getParams($email, $name = null) {
        $params = [
            's_uid=' . urlencode($this->s_uid),
            's_key=' . $this->s_key,
            's_email=' . $email,
            's_encoded=' . $this->s_encoded,
            's_status=8',
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
        return parent::HOST . '/acq.php?' . $requestString;
    }

}
