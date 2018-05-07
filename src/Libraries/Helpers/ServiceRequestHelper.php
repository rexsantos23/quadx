<?php

namespace Libraries\Helpers;

use Libraries\Helpers\ServiceResponseHelper;

class ServiceRequestHelper {

	public $params;
    public $httpMethod;
    public $headers;
    public $url;
    public $res;
    public $client;
    public function __construct()
    {
    	$this->client = new \GuzzleHttp\Client;
    }

	public function send()
	{

        $requestPromise = array();
        
		foreach ($this->params as $orderId) {

			$requestPromise[$orderId] = $this->client->requestAsync(
				$this->httpMethod,
				$this->url.$orderId,
				array('headers' => $this->headers)
			);

		
		}

		$results = \GuzzleHttp\Promise\settle($requestPromise)->wait();

		return $results;
	}
	
}