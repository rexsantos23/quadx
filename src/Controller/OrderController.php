<?php

namespace Controller;

use DebugBar\JavascriptRenderer;
use GuzzleHttp\ClientInterface;
use Zend\Diactoros\Response;

use Libraries\Helpers\ServiceExecutorHelper;

class OrderController {

	public $request;
 	private $jsRenderer;
	public $url = 'https://api.staging.lbcx.ph/v1/orders/';
	public $orderId = ['0077-6495-AYUX','0077-0424-NSHE'];

	public function __construct(JavascriptRenderer $jsRenderer)
	{
		$this->request = new ServiceExecutorHelper();
        $this->jsRenderer = $jsRenderer;
	}

	public function index()
	{	

        $this->request->params = $this->orderId;
        $this->request->headers = [
                'content-type' => 'application/json',
                'accept' => 'application/json',
                'X-Time-Zone' => 'Asia/Manila'
            ];
        $this->request->httpMethod = 'get';

        $profiles = $this->request->call($this->url);

        $response = new Response();

        $response->getBody()->write($this->html($profiles));

        return $response
            ->withHeader('Content-type', 'text/json');
        
	}

    private function html(array $profiles)
    {
        $head = "<html><head>{$this->jsRenderer->renderHead()}</head>";
        $body = join('', array_map(function (array $profile) {
            
            return $profile['id'];
        }, $profiles));
        $footer = "</html>";
        return $head."<body>".$body."{$this->jsRenderer->render()}</body>".$footer;
    }	
}