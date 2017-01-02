<?php

namespace Marcinmatras\InisApi;

use Marcinmatras\InisApi\Action\AddEmail;
use Marcinmatras\InisApi\Action\UpdateEmail;
use Marcinmatras\InisApi\Action\CheckEmail;
use Marcinmatras\InisApi\Action\RemoveEmail;
use Marcinmatras\InisApi\Exception;

class Inis {

    const HOST = 'http://s.inis.pl';

    protected $s_uid = null;
    protected $s_key = null;
    protected $s_encoded = 'ISO-8859-2';
    protected $s_no_send = 0;
    private $config = null;
    private $requiredParams = [
        's_uid', 's_key', 's_group'
    ];

    public function __construct($config) {
        if ($this->checkConfig($config)) {
            $this->config = $config;
            $this->processConfig($config);
        }
    }

    public function add($email, $name = null, array $options = []) {
        $config = array_merge($this->config, $options);
        $obj = new AddEmail($config);
        return $obj->execute($email, $name);
    }

    public function update($email, $name = null) {
        $obj = new UpdateEmail($this->config);
        return $obj->execute($email, $name);
    }

    public function check($email) {
        $obj = new CheckEmail($this->config);
        return $obj->execute($email);
    }

    public function remove($email) {
        $obj = new RemoveEmail($this->config);
        return $obj->execute($email);
    }

    protected function checkConfig(array $config) {
        $error = false;
        $msg = null;
        foreach ($this->requiredParams as $key) {
            if (!array_key_exists($key, $config)) {
                $error = true;
                $msg[] = $key;
            }
        }
        if (true === $error) {
            throw new Exception('Nieprawidłowa konfiguracja. Brak: ' . implode(', ', $msg), -200);
        } else {
            return true;
        }
    }

    protected function processConfig(array $config) {
        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
    }

}
