<?php

namespace Controller;

use DebugBar\JavascriptRenderer;
use GuzzleHttp\Promise\EachPromise;
use Zend\Diactoros\Response;

use Libraries\Helpers\ServiceExecutorHelper;

class OrderController {

	public $request;
 	private $jsRenderer;
	public $url = 'https://api.staging.lbcx.ph/v1/orders/';
	public $orderId = ['0077-6495-AYUX','0077-6491-ASLK','0077-6490-VNCM','0077-6478-DMAR',
						'0077-1456-TESV','0077-0836-PEFL','0077-0526-EBDW','0077-0522-QAYC',
						'0077-0516-VBTW','0077-0424-NSHE'];

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

        $promises = $this->request->call($this->url);

        (new EachPromise($promises, [
            'concurrency' => 4,
            'fulfilled' => function ($profile) use (&$profiles) {
                $profiles[] = $profile;
            },
        ]))->promise()->wait();

        $response = new Response();
        var_dump($response);
        die();
        return $data;
		//$promise = $this->request($this->orderId);
	}

    private function html(array $profiles)
    {
        $head = "<html><head>{$this->jsRenderer->renderHead()}</head>";
        $body = join('', array_map(function (array $profile) {
            return "<img src='{$profile['avatar_url']}' width='100px'><br>";
        }, $profiles));
        $footer = "</html>";
        return $head."<body>".$body."{$this->jsRenderer->render()}</body>".$footer;
    }	
}