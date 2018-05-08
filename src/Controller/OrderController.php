<?php

namespace Controller;

use Libraries\Helpers\PrintResponseFormat;
use Libraries\Helpers\ServiceExecutorHelper;

use Libraries\Traits\Sorter;

class OrderController {

    use Sorter;

	private $request;
	private $url = 'https://api.staging.lbcx.ph/v1/orders/';
	private $orderId = ['0077-6495-AYUX','0077-0424-NSHE','0077-6491-ASLK'];
    private $response;    
    private $arrayKey = ['tat'];

	public function __construct()
	{
		$this->request = new ServiceExecutorHelper();
        $this->response = new PrintResponseFormat();
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

        usort($profiles, $this->sort('created_at'));

        for($i = 0; $i < count($profiles); $i++)
        {
            var_dump($profiles[$i]['tracking_number'],$profiles[$i]['created_at']);
        }
        //var_dump(count($profiles));
        //$this->response->format($profiles);
        
	}

	
}