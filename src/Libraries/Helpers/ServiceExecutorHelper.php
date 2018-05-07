<?php

namespace Libraries\Helpers;

use Libraries\Helpers\ServiceRequestHelper;

class ServiceExecutorHelper
{
	private $params;
	private $headers;
	private $httpMethod;
	private $requestData;


	public function call($url)
	{
		$this->requestData = new ServiceRequestHelper();
        $this->requestData->httpMethod = $this->httpMethod;
        $this->requestData->params = $this->params;
        $this->requestData->headers = $this->headers;
        $this->requestData->url = $url;

        $response = $this->requestData->send();
  		    
        return $response;
	}

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        return null;
    }	
}