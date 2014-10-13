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

$ret = $api->getEndpoint('games_wot');
var_dump($ret);
/**
 * array(5) {
 *  ["id"]=>
 *      string(9) "games_wot"
 *  ["title"]=>
 *      string(14) "World Of Tanks"
 *  ["section"]=>
 *      array(2) {
 *          ["title"]=>
 *              string(21) "Онлайн-игры"
 *          ["id"]=>
 *              string(5) "games"
 *          }
 *  ["active"]=>
 *      bool(true)
 *  ["atoms"]=>
 *      array(2) {
 *          [0]=>
 *              array(6) {
 *                  ["id"]=>
 *                      string(6) "amount"
 *                  ["type"]=>
 *                      string(5) "money"
 *                  ["title"]=>
 *                      string(10) "Сумма"
 *                  ["description"]=>
 *                      NULL
 *                  ["placeholder"]=>
 *                      NULL
 *                  ["currency"]=>
 *                      string(12) "Золото"
 *                  }
 *          [1]=>
 *               array(6) {
 *                  ["id"]=>
 *                      string(13) "gamelogin.wot"
 *                  ["type"]=>
 *                      string(6) "scalar"
 *                  ["title"]=>
 *                      NULL
 *                  ["description"]=>
 *                      NULL
 *                  ["placeholder"]=>
 *                      NULL
 *                  ["regexp"]=>
 *                      string(5) ".+@.+"
 *                  }
 *          }
 * }
 */
$ret = $api->prepayment('games_wot', $purse, [
    'amount'        => '80', //Golds
    'gamelogin.wot' => 'odesskij1992@gmail.com'
]);

var_dump($ret);

if (!isset($ret['hash'])) {
    throw new \RuntimeException('Wrong response.');
}

$ret = $api->payment($ret['hash']);

var_dump($ret);