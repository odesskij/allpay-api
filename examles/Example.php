<?php
/*
 * This is an example of using of Allpay's api library
 */
use Allpay\Api;

require __DIR__ . '/../vendor/autoload.php';

/* For example  */
$key = 'f9d74c76c1';
$secret = '36ec981fd315dedf44aa43aac8732f089d5fa466';

$api = new Api($key, $secret);
/*foreach ($api->api('endpoints-list') as $endpoint) {
    echo $endpoint['title'] . PHP_EOL;
}*/

//var_dump($api->api('endpoint-info', ['endpoint' => 'games_botva']));


var_dump($api->api('prepayment', [
    'endpoint' => 'games_botva',
    'atoms'    => [
        'amount'            => '10',
        'gamelogin.botva'   => 'odesskij1992@gmail.com',
        'game.botva.server' => 'server1'
    ]
]));
