<?php

namespace Marcinmatras\InisApi\Response;

use Marcinmatras\InisApi\Exception;

class Response {

    private $responseCode = null;
    private $mkey = null;
    private $actionTypes = [
        'add', 'update', 'check', 'remove'
    ];
    private $codes = [
        'add' => [
            0 => 'ok',
            1 => 'adres dopisany pomyślnie',
            4 => 'adres istnieje w bazie, ale nie został potwierdzony',
            7 => 'adres istnieje w bazie, ale jest zablokowany przez operatora',
            8 => 'adres istnieje w bazie i jest już potwierdzony',
            -1 => 'brak któregoś z wymaganych parametrów',
            -2 => 'adres e-mail niepoprawny składniowo',
            -3 => 'numer UID niepoprawny składniowo',
            -4 => 'niepoprawny klucz do dopisywania',
            -5 => 'numer GSM niepoprawny składniowo',
            -97 => 'ustawiony limit API',
            -98 => 'niewłaściwy UID',
            -99 => 'błąd połączenia z bazą danych',
        ],
        'update' => [
            0 => 'ok',
            1 => 'adres zaktualizowany pomyślnie',
            7 => 'adres istnieje w bazie, ale jest zablokowany przez operatora',
            -1 => 'brak któregoś z wymaganych parametrów',
            -2 => 'adres e-mail niepoprawny składniowo',
            -3 => 'numer UID niepoprawny składniowo',
            -4 => 'niepoprawny klucz adresu',
            -5 => 'numer GSM niepoprawny składniowo',
            -97 => 'ustawiony limit API',
            -98 => 'niewłaściwy UID',
            -99 => 'błąd połączenia z bazą danych',
        ],
        'check' => [
            0 => 'dane poprawne',
            6 => 'adres istnieje w bazie, ale nie został potwierdzony',
            7 => 'adres istnieje w bazie, ale jest zablokowany przez operatora',
            8 => 'adres istnieje w bazie i jest już potwierdzony',
            -1 => 'brak któregoś z wymaganych parametrów',
            -2 => 'adres e-mail niepoprawny składniowo',
            -3 => 'numer UID niepoprawny składniowo',
            -4 => 'niepoprawny klucz do dopisywania',
            -97 => 'ustawiony limit API',
            -98 => 'niewłaściwy UID',
            -99 => 'błąd połączenia z bazą danych',
        ],
        'general' => [
            0 => 'ok',
            1 => 'wykonano poprawnie',
            -100 => 'wystapił nieznany błąd',
            -200 => 'niepoprawny typ operacji',
        ]
    ];

    public function __construct($code, $actionType = 'add') {
        if (in_array($actionType, $this->actionTypes)) {
            $this->actionType = $actionType;
        } else {
            throw new Exception($this->codes['general'][-200], -200);
        }
        if (false === strpos($code, 'key')) {
            $this->responseCode = $code;
        } else {
            $this->responseCode = 0;
            $this->mkey = str_replace('key=', '', $code);
        }
    }

    public function code() {
        return $this->responseCode;
    }

    public function key() {
        return $this->mkey;
    }

    public function message() {
        if (array_key_exists($this->responseCode, $this->codes[$this->actionType])) {
            return $this->codes[$this->actionType][$this->responseCode];
        } else {
            return null;
        }
    }

    public function status() {
        return ($this->responseCode >= 0 ? 'success' : 'error');
    }

}
