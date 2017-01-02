<?php

namespace Marcinmatras\InisApi\Request;

use Marcinmatras\InisApi\Response\Response;

class Send {

    private $url;
    private $actionType;

    public function __construct($url, $actionType) {
        $this->url = $url;
        $this->actionType = $actionType;
    }

    public function execute() {
        $result = $this->executeCall();
        return new Response($result, $this->actionType);
    }

    private function executeCall() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
