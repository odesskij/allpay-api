<?php
namespace Allpay;

use Guzzle\Service\Client;

/**
 * Api.
 *
 * @author Vladimir Odesskij <odesskij1992@gmail.com>
 */
class Api
{
    CONST HOST = 'https://allpay.test';
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @param string $key
     * @param string $secret
     */
    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * @param string $action
     * @param array $data
     * @return array
     */
    public function api($action, array $data = null)
    {
        $response = $this->request($action, $data ? $data : []);
        var_dump($response);
        return $response;
    }

    /**
     * @param $action
     * @param $data
     * @return array
     */
    protected function request($action, $data)
    {
        $client = new Client(static::HOST);
        $request = $client->post('/action', null,
            ['action' => $action,
             'data'   => $data,
             'key'    => $this->key
            ], ['verify' => false]);

        $response = $request->send();
        return json_decode($response->getBody(true), true);
    }


} 