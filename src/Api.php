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
     * @param array $data
     * @return string
     */
    public function signature(array $data)
    {
        return hash('sha256', json_encode($data) . $this->secret);
    }

    /**
     * @return array
     */
    public function getPurses()
    {
        return $this->api('purses-list');
    }

    /**
     * @param string $endpoint Id
     * @return array
     */
    public function getEndpoint($endpoint)
    {
        return $this->api('endpoint-info', [
            'endpoint' => $endpoint
        ]);
    }

    public function getEndpoints()
    {
        return $this->api('endpoints-list');
    }

    /**
     * @param string $endpoint
     * @param string $purse
     * @param array $atoms
     * @return array
     */
    public function prepayment($endpoint, $purse, array $atoms)
    {
        return $this->api('prepayment', [
            'endpoint' => $endpoint,
            'purse'    => $purse,
            'atoms'    => $atoms
        ]);
    }

    /**
     * @param string $hash operation hash
     * @return array
     */
    public function payment($hash)
    {
        return $this->api('payment', [
            'hash' => $hash,
        ]);
    }

    /**
     * @param string $action
     * @param array $data
     * @throws ApiException
     * @return array
     */
    public function api($action, array $data = null)
    {
        $response = $this->request($action, $data ? $data : []);
        if (isset($response['error']) && $response['error'] === true) {
            throw new ApiException($response);
        }
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
            ['action'    => $action,
             'data'      => json_encode($data),
             'key'       => $this->key,
             'signature' => $this->signature($data)
            ], ['verify' => false]);

        $response = $request->send();
        return json_decode($response->getBody(true), true);
    }


} 