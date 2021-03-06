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

$ret = $api->getEndpoint('telephony_kievstar');
var_dump($ret);

$ret = $api->prepayment('telephony_kievstar', $purse, [
    'amount'             => '10', //UAH
    'phone.ukr.kievstar' => '380671233456'
]);

var_dump($ret);

if (!isset($ret['hash'])) {
    throw new \RuntimeException('Wrong response.');
}

$ret = $api->payment($ret['hash']);

var_dump($ret);