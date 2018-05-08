<?php

namespace Controller;


use DebugBar\JavascriptRenderer;
use Libraries\Helpers\OrderResponse;
use Libraries\Helpers\ServiceExecutorHelper;

use Libraries\Traits\Sorter;

class OrderController {

    use Sorter;

	private $request;
	private $url = 'https://api.staging.lbcx.ph/v1/orders/';
    public $orderId = ['0077-6495-AYUX','0077-6491-ASLK','0077-6490-VNCM','0077-6478-DMAR',
                        '0077-1456-TESV','0077-0836-PEFL','0077-0526-EBDW','0077-0522-QAYC',
                        '0077-0516-VBTW','0077-0424-NSHE'];
    private $response;

	public function __construct()
	{
		$this->request = new ServiceExecutorHelper();
        $this->response = new OrderResponse();

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

        $orders = $this->request->call($this->url);

        usort($orders, $this->sort('created_at'));
        $arr = [];
        $total = 0;
        $sales = 0;
        for($i = 0; $i < count($orders); $i++)
        {
            $arr[$i]['tracking_number'] = $orders[$i]['tracking_number'];
            $arr[$i]['status'] = $orders[$i]['status'];

            foreach ($orders[$i]['tat'] as $key => $value) {
                $tat[$key] = $value['date'];
            }

            asort($tat);

            $arr[$i]['history'] = $tat;
            
            $arr[$i]['breakdown'] = array(
                                        'subtotal' => $orders[$i]['subtotal'],
                                        'shipping' => $orders[$i]['shipping'],
                                        'tax' => $orders[$i]['tax'],
                                        'fee' => $orders[$i]['fee'],
                                        'insurance' => $orders[$i]['insurance'],
                                        'discount' =>$orders[$i]['discount'],
                                        'total' => $orders[$i]['total']
                                    );

            $arr[$i]['fees'] = array(
                                    'shipping_fee' => $orders[$i]['shipping_fee'],
                                    'insurance_fee' => $orders[$i]['insurance_fee'],
                                    'transaction_fee' => $orders[$i]['transaction_fee'],
                                );               
            

            $total += ($orders[$i]['total']);
            $sales += ($orders[$i]['shipping_fee'] + $orders[$i]['insurance_fee'] + $orders[$i]['transaction_fee']);    

            
        }
        $arr['total'] = $total;
        $arr['sales'] = $sales;

        $resp = $this->response->format($arr);

        return $resp;

	}

  


}