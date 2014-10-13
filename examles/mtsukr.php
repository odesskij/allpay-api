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

$ret = $api->getEndpoint('telephony_mts_ukr');
var_dump($ret);
/**
 * array(5) {
    'id' =>
        string(17) "telephony_mts_ukr"
    'title' =>
        string(21) "МТС Украина"
    'section' =>
        array(2) {
            'title' =>
                string(29) "Мобильная связь"
            'id' =>
                string(9) "telephony"
        }
    'active' =>
        bool(true)
    'atoms' =>
        array(2) {
            [0] =>
                array(6) {
                    'id' =>
                        string(13) "phone.ukr.mts"
                    'type' =>
                        string(6) "scalar"
                    'title' =>
                        NULL
                    'description' =>
                        NULL
                    'placeholder' =>
                        string(12) "38066XXXXXXX"
                    'regexp' =>
                        string(26) "\+380(66|95|50|99)[0-9]{7}"
                }
            [1] =>
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
        }
  }
 */

$ret = $api->prepayment('telephony_mts_ukr', $purse, [
    'amount'        => '10', //UAH
    'phone.ukr.mts' => '+380661514852'
]);

var_dump($ret);

if (!isset($ret['hash'])) {
    throw new \RuntimeException('Wrong response.');
}

$ret = $api->payment($ret['hash']);

var_dump($ret);