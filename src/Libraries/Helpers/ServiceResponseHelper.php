<?php

namespace Libraries\Helpers;

class ServiceResponseHelper
{

    public $contentType;
    public $httpStatus;
    public $length;
    public $body;
    public $error;
    public $headers;
    public $microserviceRequestId;
    public $protocolVersion;
    public $reasonPhrase;
    public $rawBody;

    public function contentType($contentType)
    {

        $this->contentType = $contentType;
        return $this;
    }

    public function httpStatus($httpStatus)
    {

        $this->httpStatus = $httpStatus;
        return $this;
    }

    public function httpLength($length)
    {

        $this->length = $length;
        return $this;
    }

    public function rawBody($rawBody)
    {

        $this->rawBody = $rawBody;
        return $this;
    }

    public function body($body)
    {

        $body = json_decode((string) $body, true);
        $this->body = $body;
        
        return $this;
    }

    public function headers($headers)
    {

        $this->headers = $headers;
        return $this;
    }

    public function microserviceRequestId($microserviceRequestId)
    {

        $this->microserviceRequestId = $microserviceRequestId;
        return $this;
    }

    public function protocolVersion($protocolVersion)
    {

        $this->protocolVersion = $protocolVersion;
        return $this;
    }

    public function reasonPhrase($reasonPhrase)
    {

        $this->reasonPhrase = $reasonPhrase;
        return $this;
    }

    public function isError()
    {
        return ($this->error ? true : false);
    }

    public function getError()
    {
        return $this->error;
    }
}