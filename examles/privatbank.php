<?php
/*
 * This is an example of using of Allpay's api library
 */
use Allpay\Api;

require __DIR__ . '/../vendor/autoload.php';

/* example key & secret  */
$key = '21c4612f4e';
$secret = 'f318bca79c4db376c6e9a0875af4b681b732fe6d';

$api = new Api($key, $secret);

$ret = $api->getPurses();
var_dump($ret);

if (!isset($ret[0]['class'])) {
    throw new \RuntimeException('Wrong response.');
}

$purse = $ret[0]['class'];

$ret = $api->getEndpoint('finances_privat');
var_dump($ret);
/**
array(5) {
    'id' =>
        string(15) "finances_privat"
    'title' =>
        string(20) "ПриватБанк"
    'section' =>
        array(2) {
            'title' =>
                string(14) "Финансы"
            'id' =>
                string(8) "finances"
        }
    'active' =>
        bool(true)
    'atoms' =>
        array(2) {
            [0] =>
                array(6) {
                    'id' =>
                        string(6) "amount"
                    'type' =>
                        string(5) "money"
                    'title' =>
                        string(10) "Сумма"
                    'description' =>
                        NULL
                    'placeholder' =>
                        NULL
                    'currency' =>
                        string(12) "Гривны"
                }
            [1] =>
                array(6) {
                    'id' =>
                        string(11) "card.privat"
                    'type' =>
                        string(6) "scalar"
                    'title' =>
                        NULL
                    'description' =>
                        NULL
                    'placeholder' =>
                        NULL
                    'regexp' =>
                        string(12) "[0-9]{13,19}"
                }
        }
}
 */
$ret = $api->prepayment('finances_privat', $purse, [
    'amount'        => '10', //UAH
    'card.privat' => '4627055003096491'
]);

var_dump($ret);

if (!isset($ret['hash'])) {
    throw new \RuntimeException('Wrong response.');
}

$ret = $api->payment($ret['hash']);

var_dump($ret);