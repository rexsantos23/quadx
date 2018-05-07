<?php

namespace Libraries\Helpers;

use GuzzleHttp\Promise\EachPromise;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

use Libraries\Helpers\ServiceResponseHelper;


class ServiceRequestHelper {

	public $params;
    public $httpMethod;
    public $headers;
    public $url;
    public $client;

    public function __construct()
    {
    	$this->client = new \GuzzleHttp\Client;
    }

	public function send()
	{

        $promises = array();
        $profiles = arraY();

		foreach ($this->params as $orderId) {
			$promises[$orderId] = $this->client->requestAsync(
					$this->httpMethod,
					$this->url.$orderId,
					array('headers' => $this->headers)
				)->then(function (ResponseInterface $response) {
					return json_decode($response->getBody(), true);
				});
					
		}

        (new EachPromise($promises, [
            'concurrency' => 4,
            'fulfilled' => function ($profile) use (&$profiles) {

                $profiles[] = $profile;
            },
        ]))->promise()->wait();

		return $profiles;
	}
	
}