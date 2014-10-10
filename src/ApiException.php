<?php
namespace Allpay;

use Exception;

class ApiException extends \Exception
{
    /**
     * Json server response
     * @param string $response
     */
    public function __construct($response)
    {
        parent::__construct($response['message'], 0, null);
    }
} 